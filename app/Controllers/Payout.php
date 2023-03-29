<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Payout_model;
use App\Models\Users_model;

class Payout extends BaseController
{
	public function __construct()
	{
		$db = db_connect();
		$this->payout = New Payout_model($db);
		$this->users = New Users_model($db);
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		//load helper
		helper('custom');
	}

	public function index()
	{
		$this->data['title'] = 'Generate Payout';
		return view('users/payout/generate-payout', $this->data);
	}

	public function monthly_commission($month = 0, $year = 0)
	{

		$month?$month:$month =  $this->request->getPost('month')?$this->request->getPost('month'):0;
		$year?$year:$year =  $this->request->getPost('year')?$this->request->getPost('year'):0;

		$currMonth = date('Y-m-d');
		$date = new \DateTime($currMonth);
		$date->modify("last day of previous month");
		$lastDateOfPrevMonth =  strtotime($date->format("Y-m-d"));

		$month?$month:$month = date('m', $lastDateOfPrevMonth);
		$year?$year:$year = date('Y', $lastDateOfPrevMonth);

		$dateObj   = \DateTime::createFromFormat('!m', $month);
		$this->data['monthName'] = $dateObj->format('F');
		$this->data['monthNum'] = $month;
		$this->data['year'] = $year;

		if (is_numeric($month) && is_numeric($year)) {
			$this->data['title'] = 'Monthly Payout';
			$this->data['filter'] = $this->payout->getCommissionFilter();
			$this->data['commissions'] = $commissions =  $this->payout->getmonthlyCommissions($month, $year);
			return view('users/payout/commission', $this->data);
		}else{

		}
	}

	public function monthly_interest($month = 0, $year = 0)
	{

		$month?$month:$month =  $this->request->getPost('month')?$this->request->getPost('month'):0;
		$year?$year:$year =  $this->request->getPost('year')?$this->request->getPost('year'):0;

		$currMonth = date('Y-m-d');
		$date = new \DateTime($currMonth);
		$date->modify("last day of previous month");
		$lastDateOfPrevMonth =  strtotime($date->format("Y-m-d"));

		$month?$month:$month = date('m', $lastDateOfPrevMonth);
		$year?$year:$year = date('Y', $lastDateOfPrevMonth);

		$dateObj   = \DateTime::createFromFormat('!m', $month);
		$this->data['monthName'] = $dateObj->format('F');
		$this->data['monthNum'] = $month;
		$this->data['year'] = $year;

		if (is_numeric($month) && is_numeric($year)) {
			$this->data['title'] = 'Monthly Payout';
			$this->data['filter'] = $this->payout->getInterestFilter();
			$this->data['interests'] = $interests =  $this->payout->getmonthlyInterest($month, $year);
			return view('users/payout/interest', $this->data);
		}else{

		}
	}

	public function manual_generate($investment_id = 0, $date = 0)
	{
		$this->data['title'] = 'Generate Payout';
		$this->data['filter'] = $this->payout->getCommissionFilter();
		return view('users/payout/manual', $this->data);
	}

	public function withdraw()
	{
		$this->data['title'] = 'Withdraw';
		return view('users/withdraw', $this->data);
	}

	public function ajax_get_data_by_investment_id()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($this->request->getPost('id') && is_numeric($this->request->getPost('id'))) {
			$this->data['details'] = $details = $this->payout->getInvestmentData($this->request->getPost('id'));
			if ($details) {
				$this->data['success'] = true;
				echo json_encode($this->data);
			}else{
				$this->data['message'] = 'Enter a valid investment id';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Enter a valid investment id';
			echo json_encode($this->data); die;
		}
	}

	public function proceed_withdraw()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if (strlen($this->request->getPost('investment_id')) == 0) {
			$this->data['message'] = 'Kindly enter investment id';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('reason')) == 0) {
			$this->data['message'] = 'Enter reason of withdrawing.';
			echo json_encode($this->data); die;
		}
		$investment_id = $this->request->getPost('investment_id');
		$withdrawAmount = $this->request->getPost('withdraw_amount');
		$remainingAmount = $this->request->getPost('remaining_amount');
		$totalAmount = $this->request->getPost('total_amount');
		$now = strtotime($this->request->getPost('date'));

		$details = $this->payout->getInvestmentData($investment_id);
		


		if ($this->payout->limitOfWithdrawlPerDay($investment_id, $now)) {
			if ($details->created_at < $now) {
				if ($this->payout->isPayoutGenerated($investment_id, date('m', $now), date('Y', $now))) {
					$lastwithdrawDate = $this->payout->validWithdrawRequest($investment_id, $now);
					if ($lastwithdrawDate == 1) {
						$withdrawlData = array(
							'investment_id' => $investment_id,
							'withdrawl_amount' => $withdrawAmount,
							'previous_amount' => $totalAmount,
							'reason' => $this->request->getPost('reason'),
							'month' => date('m', $now),
							'year' => date('Y', $now),
							'created_at' => $now,
						);
						$investmentData = array(
							'updated_investment_amount' => $remainingAmount,
							'updated_at' => $now,
						);

						if ($this->payout->proceedWithdraw($withdrawlData) && $this->users->updateInvestmentTrackerDetails($investment_id, $investmentData)) {
							$this->data['success'] = true;
							$this->data['message'] = 'Processed successfully';
							echo json_encode($this->data);
						}else{
							$this->data['message'] = 'Something went Wrong!';
							echo json_encode($this->data);
						}
					}else{
						$this->data['message'] = 'Withdrawl date should be geater than last withdraw date '.date('Y-m-d', $lastwithdrawDate);
						echo json_encode($this->data);
					}
				}else{
					$this->data['message'] = 'You can not withdraw the amount from the month of '.date('M Y', $now).', as payout was sucessfully generated for the given investment id #'.$investment_id;
					echo json_encode($this->data);
				}
			}else{
				$this->data['message'] = 'Withdrawl date should be geater than date of investment.';
				echo json_encode($this->data);
			}
		}else{
			$this->data['message'] = 'You have exceeded the limit of withdrawing amount for the id #'.$investment_id.' and given date '.date('M j, Y', $now);
			echo json_encode($this->data);
		}
	}

	public function withdrawal_history()
	{
		$this->data['title'] = 'Withdrawl History';
		$data = $this->payout->getWithdrawlList();
		$this->data['withdrawls'] = '';
		if (!empty($data)) {
			foreach ($data as $val) {
				$withdrawls[] = array(
					'investment_id' => $val->investment_id,
					'investor_name' => $val->investorName,
					'member_id' => $val->member_id,
					'actual_investment_amount' => $val->actual_investment_amount,
					'total_withdrawl_amount' => $this->payout->getTotalWithdrawlAount($val->investment_id)->withdrawl_amount,
					'updated_investment_amount' => $val->updated_investment_amount
				);
			}
			$this->data['withdrawls'] = $withdrawls;
		}
		
		return view('users/payout/withdrawl-history', $this->data);
	}


	public function ajaxGetWithdrawlDetails($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($id && is_numeric($id)) {
			$details['details'] = $this->payout->getWithdrawlListByInvestmentId($id);
			if (!empty($details)) {
				$this->data['success'] = true;
				$this->data['view'] = view('users/payout/child-withdrawl-details', $details);
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went Wrong!';
				echo json_encode($this->data);
			}
		}else{
			$this->data['message'] = 'Something went Wrong!';
			echo json_encode($this->data); die;
		}
	}

	public function chage_investment_status($invId = 0, $type = 0)
	{
		if ($invId && is_numeric($invId)) {
			$updateInvestmentStatus = array(
				'status' => $type?1:0,
				'updated_at' => strtotime('now'),
			);
			if ($this->users->updateInvestmentDetails($invId, '', $updateInvestmentStatus)) {
				$this->session->setFlashdata('message', 'Status changed successfully');
				$this->session->setFlashdata('message_type', 'success');
			}
			header('Location: '.site_url('users/investment-list'));
		}else{
			$this->session->setFlashdata('message', 'Something went Wrong!');
			$this->session->setFlashdata('message_type', 'error');
			header('Location: '.site_url('users/investment-list'));
		}		
	}
}