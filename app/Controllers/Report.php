<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Report_model;
use App\Models\Users_model;

class Report extends BaseController
{
	public function __construct()
	{
		$db = db_connect();
		$this->report = new Report_model($db);
		$this->users = new Users_model($db);
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		helper('custom');
	}


	//auto generate
	private function proceed_payout_generate($lastDateOfMonth, $firstDayOfNextMonth, $investments = array())
	{
		$monthNum = date('m', $lastDateOfMonth);
		$yearNum = date('Y', $lastDateOfMonth);
		$maxDays=date('t', $lastDateOfMonth); //total days count of processing month
		
		if (!empty($investments)) {
			$introducerCount = 0; $investorCount = 0; $commissionPayout = 0; $interestPayout = 0; $totalPaybleInterest = 0; $totalTds = 0; $totalOtherCharges = 0;
			foreach ($investments as $inv) {

				$datediff = $lastDateOfMonth - $inv->created_at;
				$actualdiff = round($datediff / (60 * 60 * 24));
				$remainingAmount = 1; //dont make it zero
				if (!empty($withdrawl = $this->report->getWithdrawDetailsForTheMonth($monthNum, $yearNum, $inv->id))) {

					$totalInterest = 0; $totalCommission = 0; 
					if ($actualdiff >= $maxDays) {
						$totalDays = $maxDays;
					}else{
						$totalDays = $actualdiff;
					}
					$i = 0;
					foreach ($withdrawl as $wDraw) {

						if ($i == 0) { //get full month data using remaining amount
							$remainingAmount = ($wDraw->previous_amount - $wDraw->withdrawl_amount);

							#SET INTEREST DATA FOR INVESTORS
							$perDayInterest = $this->getDailyCommission($remainingAmount, $inv->interest, $maxDays);
							$totalInterest = round($perDayInterest * $totalDays);

							#SET COMMISSION DATA FOR INTRODUCERS
							$perDayCommission = $this->getDailyCommission($remainingAmount, $inv->introducer_commission, $maxDays);
							$totalCommission = round($perDayCommission * $totalDays);
						}

						
						$count = date('d', $wDraw->created_at);				

						#SET INTEREST DATA FOR INVESTORS
						$perDayInterest = $this->getDailyCommission($wDraw->withdrawl_amount, $inv->interest, $maxDays);
						$totalInterest += round($perDayInterest * $count);

						#SET COMMISSION DATA FOR INTRODUCERS
						$perDayCommission = $this->getDailyCommission($wDraw->withdrawl_amount, $inv->introducer_commission, $maxDays);
						$totalCommission += round($perDayCommission * $count);
						$i++;
						
					}
				}else{
					if ($actualdiff >= $maxDays) {
						$totalDays = $maxDays;
					}else{
						$totalDays = $actualdiff;
					}
					$updatedInvestmentAmount = (getTotalFutureWithdrawnAmount($monthNum, $yearNum, $inv->id) + $inv->updated_investment_amount);

					#SET COMMISSION DATA FOR INTRODUCERS
					$perDayCommission = $this->getDailyCommission($updatedInvestmentAmount, $inv->introducer_commission, $maxDays);
					$totalCommission = round($perDayCommission * $totalDays);
					$totalMonthCommission = round($perDayCommission * $totalDays);

					#SET INTEREST DATA FOR INVESTORS
					$perDayInterest = $this->getDailyCommission($updatedInvestmentAmount, $inv->interest, $maxDays);
					$totalInterest = round($perDayInterest * $totalDays);
					$totalMonthInterest = round($perDayInterest * $totalDays);
				}
				$insertedInterestId = 0;
				if ($totalDays > 0) {
					if ($inv->introducer_id > 0) {
						$bankDetails = $this->report->getBankDetails($inv->introducer_id);
						$commissionData = array(
							'introducer_id' => $inv->introducer_id,
							'investment_id' => $inv->id,
							'investor_id' => $inv->investor_id,
							'investment_amount' => $inv->investment_amount,
							'bank_details' => $bankDetails?serialize($bankDetails):'',
							'commission' => $inv->introducer_commission,
							'total_days' => $totalDays,
							'per_day_commission' => ($totalCommission / $totalDays),

							'total_commission' => $totalCommission,
							'curr_month' => date('m', $lastDateOfMonth),
							'curr_year' =>  date('Y', $lastDateOfMonth),
							'created_at' => strtotime('now'),
						);
						$insertedCommissionId = $this->report->insertCommissionData($commissionData);
						$introducerCount++; $commissionPayout += $totalCommission;
					}

					$tds = round($this->getTds($totalInterest, $inv->tds));
					$otherCharges = $inv->other_charges;
					$paybleInterest = $totalInterest - ($tds + $otherCharges);
					$interestData = array(
						'investor_id' => $inv->investor_id,
						'investment_id' => $inv->id,
						'bank_details' => $inv->bank_details,
						'investment_date' => $inv->created_at,
						'investment_amount' => $inv->investment_amount,
						'interest' => $inv->interest,
						'total_days' => $totalDays,
						'per_day_interest' => ($totalInterest / $totalDays),
						'total_interest' => $totalInterest,
						'tds_percentage' => $inv->tds,
						'tds' => $tds,
						'other_charges' => $otherCharges,
						'payble_interest' => $paybleInterest,
						'curr_month' => $monthNum,
						'curr_year' => $yearNum,
						'created_at' => strtotime('now'),
					);

					$insertedInterestId = $this->report->insertInterestData($interestData);

					$investorCount++; $interestPayout += $totalInterest; $totalPaybleInterest += $paybleInterest; $totalTds += $tds; $totalOtherCharges += $otherCharges;
				}
				

				
			}

			if ($insertedInterestId) {
				if ($details = $this->report->payoutWasprocessed($monthNum, $yearNum)) {
					$totalPayoutData = array(
						'total_commission' => ($commissionPayout + $details->total_commission),
						'total_interest' => ($interestPayout + $details->total_interest),
						'payble_interest' => ($totalPaybleInterest + $details->payble_interest),
						'tds_charges' => ($totalTds + $details->tds_charges),
						'other_charges' => ($totalOtherCharges + $details->other_charges),
						'total_investor' => ($investorCount + $details->total_investor),
						'total_introducer' => ($introducerCount + $details->total_introducer),
						'month' => $monthNum,
						'year' => $yearNum,
						'updated_at' => strtotime('now'),
					);
					$status = $this->report->updateTotalMonthlyPayout($details->id, $totalPayoutData);
				}else{
					$totalPayoutData = array(
						'total_commission' => $commissionPayout,
						'total_interest' => $interestPayout,
						'payble_interest' => $totalPaybleInterest,
						'tds_charges' => $totalTds,
						'other_charges' => $totalOtherCharges,
						'total_investor' => $investorCount,
						'total_introducer' => $introducerCount,
						'month' => $monthNum,
						'year' => $yearNum,
						'created_at' => strtotime('now'),
					);
					$status = $this->report->insertTotalMonthlyPayout($totalPayoutData);
				}
				

				if ($status) {
					$this->data['success'] = true;
					$this->data['message'] = 'Report has been successfully generated.';
					return $this->data; die;
				}
			}
		}else{
			$this->data['message'] = 'Something went Wrong!';
			return $this->data; die;
		}
	}



	private function getDailyCommission($inv_amount = 0, $commission = 0, $days = 0)
	{
		$perDayCommission = ($inv_amount / 100) * $commission;
		$perDayCommission = $perDayCommission / $days;
		return $perDayCommission;
	}

	private function leapYearCheck($year)
	{
		if ($year && is_numeric($year)) {
			if ($year % 400 == 0){
				return true; die;
			}else if ($year % 4 == 0){
				return true; die;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	private function getTds($interest,$tdsPercentage)
	{
		$tds = ($interest / 100) * $tdsPercentage;
		return $tds;
	}

	private function getOtherCharges($interest,$otherChargesPercentage)
	{
		$otherCharges = ($interest / 100) * $otherChargesPercentage;
		return $otherCharges;
	}


	public function generate_payout()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();

		if (strlen($this->request->getPost('month')) == 0) {
			$this->data['message'] = 'Select month';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('year')) == 0) {
			$this->data['message'] = 'Select year';
			echo json_encode($this->data); die;
		}

		$timestamp = strtotime(date('Y-m-d'));
		$this->data['month'] = $month = $this->request->getPost('month');
		$this->data['year'] = $year = $this->request->getPost('year');
		$date = strtotime(date("Y-m-t", strtotime($year.'-'.$month.'-01')));
		if ($date < $timestamp) { //month and year validation
			//print_r($this->report->CheckIfDataAvailable(strtotime(date("Y-m-t", strtotime($year.'-'.$month.'-01'))))); die;
			if (!empty($this->report->CheckIfDataAvailable(strtotime(date("Y-m-t", strtotime($year.'-'.$month.'-01')))))) {
				if ($report = payoutGenerateDuplicateCheck($month, $year, strtotime(date("Y-m-t", strtotime($year.'-'.$month.'-01'))))) { //check if report was already generated or not
					$investments = $this->report->getAllInvestments($date, $month, $year);
					if (!empty($investments)) {
						$this->data[] = $this->proceed_payout_generate($date, strtotime($year.'-'.$month.'-01 +1 Month'), $investments);
						echo json_encode($this->data); die;
					}else{
						$this->data['message'] = 'There are no data available to generate payout for the month of '.date('M', $date).', '.$year;
						echo json_encode($this->data); die;
					}
				}else{
					$this->data['payoutReport'] = $this->report->getPayoutReport($month, $year);
					$this->data['monthName'] = date('M', $date);
					$this->data['message'] = "The report was already successfully generated for the month of ".date('M', $date).', '.$year;
					echo json_encode($this->data); die;
				}
			}else{
				$this->data['message'] = 'There are no data available to generate payout for the month of '.date('M', $date).', '.$year;
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'You can generate report of previous months of current year only.';
			echo json_encode($this->data); die;
		}
	}

}