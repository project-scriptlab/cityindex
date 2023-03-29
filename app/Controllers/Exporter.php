<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

use ZipArchive;
use App\Models\Users_model;
use App\Models\Investor_model;
use App\Models\Exporter_model;

class Exporter extends BaseController
{

	public function __construct()
	{
		$db = db_connect();
		$this->user = new Users_model($db);
		$this->export = new Exporter_model($db);
        // $this->investor = new Investor_model($db);
		$this->session = \Config\Services::session();
		$this->zip = new ZipArchive();

        //load helper
		helper('custom');
	}

	function introducer()
	{
		if (is_admin() && $this->session->isLoggedIn) {

			$data = $this->user->getIntroducersToExport();
			$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '595959'),
					'size'  => 12,
					'name'  => 'Arial'
				)
			);

			$headingArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '595959'),
					'size'  => 14,
					'name'  => 'Arial'
				)
			);

			$file_name = 'Introducers.xlsx';

			$spreadsheet = new Spreadsheet();


			$sheet = $spreadsheet->getActiveSheet()->setTitle("Introducers");;

			$sheet->getRowDimension(1)->setRowHeight(35);
			$sheet->getRowDimension(2)->setRowHeight(25);
			$sheet->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');
			$sheet->getStyle('A2:P2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');

			foreach(range('A','O') as $columnID) {
				$sheet->getColumnDimension($columnID)->setAutoSize(true);
			}
			$sheet->getColumnDimension('P')->setWidth(30);

			$sheet->getStyle('A1:P2')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A1:P1')->applyFromArray($headingArray);
			$sheet->mergeCells('A1:I1');
			$sheet->mergeCells('J1:M1');
			$sheet->mergeCells('N1:P1');
			$sheet->setCellValue('A1', 'Personal Details');
			$sheet->setCellValue('J1', 'Bank Details');
			$sheet->setCellValue('N1', 'Relationship Manager Details');

			$sheet->getStyle('A2:P2')->applyFromArray($styleArray);
			$sheet->setCellValue('A2', 'Membership Id');
			$sheet->setCellValue('B2', 'Name');
			$sheet->setCellValue('C2', 'User Name');
			$sheet->setCellValue('D2', 'Mobile');
			$sheet->setCellValue('E2', 'E-Mail');
			$sheet->setCellValue('F2', 'Address');
			$sheet->setCellValue('G2', 'No. of investor introduced');
			$sheet->setCellValue('H2', 'Commision');
			$sheet->setCellValue('I2', 'Total amount recieved from investors');

			$sheet->setCellValue('J2', 'Bank Name');
			$sheet->setCellValue('K2', 'Branch');
			$sheet->setCellValue('L2', 'A/C No');
			$sheet->setCellValue('M2', 'IFSC Code');

			$sheet->setCellValue('N2', 'Relationship Manager');
			$sheet->setCellValue('O2', 'Meeting Date');
			$sheet->setCellValue('P2', 'Discussion Points');

			$count = 3;

			foreach($data as $row)
			{
				$sheet->setCellValue('A' . $count, $row->id);
				$sheet->setCellValue('B' . $count, $row->name);
				$sheet->setCellValue('C' . $count, $row->user_name);
				$sheet->setCellValue('D' . $count, $row->mobile);
				$sheet->setCellValue('E' . $count, $row->email);
				$sheet->setCellValue('F' . $count, $row->address);
				$sheet->setCellValue('G' . $count, totalInvestorIntroduced($row->id));
				$sheet->setCellValue('H' . $count, $row->introducer_commission.' %');
				$sheet->setCellValue('I' . $count, number_format(totalInvestmentAmount(2, $row->id)));

				$sheet->setCellValue('J' . $count, $row->bank_name);
				$sheet->setCellValue('K' . $count, $row->branch_name);
				$sheet->setCellValue('L' . $count, $row->account_number);
				$sheet->setCellValue('M' . $count, $row->ifsc_code);

				$sheet->setCellValue('N' . $count, $row->rm_name);
				$sheet->setCellValue('O' . $count, $row->rm_meeting_date?date('M j, Y', $row->rm_meeting_date):'');
				$sheet->setCellValue('P' . $count, str_replace("&nbsp;",' ',strip_tags($row->rm_discussion_points)));

				$count++;
			}

			$spreadsheet
			->getActiveSheet()
			->getStyle('A1:P'.($count-1).'')
			->getBorders()
			->getAllBorders()
			->setBorderStyle(Border::BORDER_THIN)
			->setColor(new Color('BF000000'));

			try {
				$writer = new Xlsx($spreadsheet);
				$writer->save($file_name);
				$content = file_get_contents($file_name);
			} catch(Exception $e) {
				exit($e->getMessage());
			}

			header("Content-Disposition: attachment; filename=".$file_name);

			unlink($file_name);
			exit($content);
		}else{
			header('Location: '.site_url('login')); die;
		}
	}

	function investor()
	{
		if (is_admin() && $this->session->isLoggedIn) {

			$data = $this->user->getInvestorsToExport();
			$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '595959'),
					'size'  => 12,
					'name'  => 'Arial'
				)
			);

			$headingArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '595959'),
					'size'  => 14,
					'name'  => 'Arial'
				)
			);

			$file_name = 'Investors.xlsx';

			$spreadsheet = new Spreadsheet();


			$sheet = $spreadsheet->getActiveSheet()->setTitle("Investors");;

			$sheet->getRowDimension(1)->setRowHeight(35);
			$sheet->getRowDimension(2)->setRowHeight(25);
			$sheet->getStyle('A1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');
			$sheet->getStyle('A2:T2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');

			foreach(range('A','T') as $columnID) {
				if ($columnID == 'N') {
					continue;
				}
				$sheet->getColumnDimension($columnID)->setAutoSize(true);
			}
			$sheet->getColumnDimension('N')->setWidth(30);

			$sheet->getStyle('A1:T2')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A1:T1')->applyFromArray($headingArray);
			$sheet->getStyle('A2:T2')->applyFromArray($styleArray);

			$sheet->mergeCells('A1:G1');
			$sheet->mergeCells('H1:K1');
			$sheet->mergeCells('L1:N1');
			$sheet->mergeCells('O1:T1');

			$sheet->setCellValue('A1', 'Personal Details');
			$sheet->setCellValue('H1', 'Bank Details');
			$sheet->setCellValue('L1', 'Relationship Manager Details');
			$sheet->setCellValue('O1', 'Introducer Details');

			$sheet->setCellValue('A2', 'Membership Id');
			$sheet->setCellValue('B2', 'Name');
			$sheet->setCellValue('C2', 'User Name');
			$sheet->setCellValue('D2', 'Mobile');
			$sheet->setCellValue('E2', 'E-Mail');
			$sheet->setCellValue('F2', 'Address');
			$sheet->setCellValue('G2', 'Total Investment Amount');

			$sheet->setCellValue('H2', 'Bank Name');
			$sheet->setCellValue('I2', 'Branch');
			$sheet->setCellValue('J2', 'A/C No');
			$sheet->setCellValue('K2', 'IFSC Code');

			$sheet->setCellValue('L2', 'Relationship Manager');
			$sheet->setCellValue('M2', 'Meeting Date');
			$sheet->setCellValue('N2', 'Discussion Points');

			$sheet->setCellValue('O2', 'ID');
			$sheet->setCellValue('P2', 'Name');
			$sheet->setCellValue('Q2', 'User Name');
			$sheet->setCellValue('R2', 'Mobile');
			$sheet->setCellValue('S2', 'E-Mail');
			$sheet->setCellValue('T2', 'Address');


			$count = 3;

			foreach($data as $row)
			{
				$sheet->setCellValue('A' . $count, $row->id);
				$sheet->setCellValue('B' . $count, $row->name);
				$sheet->setCellValue('C' . $count, $row->user_name);
				$sheet->setCellValue('D' . $count, $row->mobile);
				$sheet->setCellValue('E' . $count, $row->email);
				$sheet->setCellValue('F' . $count, $row->address);
				$sheet->setCellValue('G' . $count, number_format(totalInvestmentAmount(1, $row->id)));

				$sheet->setCellValue('H' . $count, $row->bank_name);
				$sheet->setCellValue('I' . $count, $row->branch_name);
				$sheet->setCellValue('J' . $count, $row->account_number);
				$sheet->setCellValue('K' . $count, $row->ifsc_code);

				$sheet->setCellValue('L' . $count, $row->rm_name);
				$sheet->setCellValue('M' . $count, $row->rm_meeting_date?date('M j, Y', $row->rm_meeting_date):'');
				$sheet->setCellValue('N' . $count, str_replace("&nbsp;",' ',strip_tags($row->rm_discussion_points)));

				$sheet->setCellValue('O' . $count, $row->intro_id);
				$sheet->setCellValue('P' . $count, $row->intro_name);
				$sheet->setCellValue('Q' . $count, $row->intro_user_name);
				$sheet->setCellValue('R' . $count, $row->intro_mobile);
				$sheet->setCellValue('S' . $count, $row->intro_email);
				$sheet->setCellValue('T' . $count, $row->intro_address);

				$count++;
			}

			$spreadsheet
			->getActiveSheet()
			->getStyle('A1:T'.($count-1).'')
			->getBorders()
			->getAllBorders()
			->setBorderStyle(Border::BORDER_THIN)
			->setColor(new Color('BF000000'));

			try {
				$writer = new Xlsx($spreadsheet);
				$writer->save($file_name);
				$content = file_get_contents($file_name);
			} catch(Exception $e) {
				exit($e->getMessage());
			}

			header("Content-Disposition: attachment; filename=".$file_name);

			unlink($file_name);
			exit($content);
		}else{
			header('Location: '.site_url('home')); die;
		}
	}

	function investments($id = 0, $month = 0, $year = 0)
	{
		if (is_admin() && $this->session->isLoggedIn) {

			$firstDayOfMonth =''; $lastDayOfMonth='';
			if (!empty($month) && !empty($year)) {
				$firstDayOfMonth = strtotime($year.'-'.$month.'-1');
				$lastDayOfMonth = date("Y-m-t", $firstDayOfMonth);
				$lastDayOfMonth = strtotime($lastDayOfMonth.' 11:59:59');
			}

			$data = $this->user->getInvestmentsToExport($id, $firstDayOfMonth, $lastDayOfMonth);
			if ($id && is_numeric($id)) {
				$details = $this->user->getUserById($id);
				$file_name = 'Investment list of '.$details->name.'( '.$id.' ).xlsx';
			}else{
				$file_name = 'Investments.xlsx';
			}
			$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '595959'),
					'size'  => 12,
					'name'  => 'Arial'
				)
			);

			$headingArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '595959'),
					'size'  => 14,
					'name'  => 'Arial'
				)
			);
			$spreadsheet = new Spreadsheet();


			$sheet = $spreadsheet->getActiveSheet()->setTitle("Investments");

			$sheet->getRowDimension(1)->setRowHeight(35);
			$sheet->getRowDimension(2)->setRowHeight(25);
			$sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');
			$sheet->getStyle('A2:K2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');

			foreach(range('A','K') as $columnID) {
				$sheet->getColumnDimension($columnID)->setAutoSize(true);
			}

			$sheet->getStyle('A1:K2')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A1:K1')->applyFromArray($headingArray);
			$sheet->getStyle('A2:K2')->applyFromArray($styleArray);

			$sheet->mergeCells('A1:G1');
			$sheet->mergeCells('H1:K1');

			$sheet->setCellValue('A1', 'INVESTMENT DETAILS');
			$sheet->setCellValue('H1', 'BANK DETAILS');

			$sheet->setCellValue('A2', 'INVESTMENT ID');
			$sheet->setCellValue('B2', 'INVESTOR NAME');
			$sheet->setCellValue('C2', 'INTRODUCER NAME');
			$sheet->setCellValue('D2', 'AMOUNT');
			$sheet->setCellValue('E2', 'INTEREST');
			$sheet->setCellValue('F2', 'INTRODUCER COMMISSION');
			$sheet->setCellValue('G2', 'DATE');

			$sheet->setCellValue('H2', 'BANK NAME');
			$sheet->setCellValue('I2', 'BRANCH');
			$sheet->setCellValue('J2', 'A/C NO');
			$sheet->setCellValue('K2', 'IFSC CODE');


			$count = 3;

			foreach($data as $row)
			{
				$bank = unserialize($row->bank_details);
				$bank_name = !empty($bank)?$bank->bank_name:'NA';
				$branch_name = !empty($bank)?$bank->branch_name:'NA';
				$account_number = !empty($bank)?$bank->account_number:'NA';
				$ifsc_code = !empty($bank)?$bank->ifsc_code:'NA';

				$sheet->setCellValue('A' . $count, $row->id);
				$sheet->setCellValue('B' . $count, $row->investor_name.' ('.$row->investor_id.' )');
				$sheet->setCellValue('C' . $count, $row->introducer_name?$row->introducer_name.' ('.$row->introducer_id.' )':'NA');
				$sheet->setCellValue('D' . $count, number_format($row->investment_amount));
				$sheet->setCellValue('E' . $count, number_format($row->interest).' %');
				$sheet->setCellValue('F' . $count, number_format($row->introducer_commission).' %');
				$sheet->setCellValue('G' . $count, date('M j, Y', $row->created_at));

				$sheet->setCellValue('H' . $count, $bank_name);
				$sheet->setCellValue('I' . $count, $branch_name);
				$sheet->setCellValue('J' . $count, $account_number);
				$sheet->setCellValue('K' . $count, $ifsc_code);

				$count++;
			}

			$spreadsheet
			->getActiveSheet()
			->getStyle('A1:K'.($count-1).'')
			->getBorders()
			->getAllBorders()
			->setBorderStyle(Border::BORDER_THIN)
			->setColor(new Color('BF000000'));

			try {
				$writer = new Xlsx($spreadsheet);
				$writer->save($file_name);
				$content = file_get_contents($file_name);
			} catch(Exception $e) {
				exit($e->getMessage());
			}

			header("Content-Disposition: attachment; filename=".$file_name);

			unlink($file_name);
			exit($content);
		}else{
			header('Location: '.site_url('home')); die;
		}
	}

	function download_all_documents($id='')
	{
		$data = $this->user->getDocuments($id); 
		$details = $this->user->getUserById($id);
		$filename = $details->name.".zip";

		if (!empty($data)) {
			$this->zip->open($filename, ZipArchive::CREATE);
			foreach ($data as $val) {
				$files[] = ('upload/documents/'.$val->file);
				$this->zip->addFile('upload/documents/'.$val->file, $val->file);
			}
			$this->zip->close();
			header("Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=$filename");
			header("Content-length: " . filesize($filename));
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			readfile("$filename");
			unlink($filename);
		}
	}

	function monthly_commission($month = 0, $year = 0){
		if (($month && is_numeric($month)) && ($year && is_numeric($year)) && is_admin()) {
			if (!empty($data = $this->export->getMonthlyCommission($month, $year))) {
				$date = strtotime($year.'-'.$month.'-1');
				$styleArray = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '595959'),
						'size'  => 10,
						'name'  => 'Arial'
					),
					'alignment' => [
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
				);

				$headingArray = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '595959'),
						'size'  => 14,
						'name'  => 'Arial'
					),
					'alignment' => [
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
				);

				$SubTotalStyle = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '5e5c5c'),
						'size'  => 16,
						'name'  => 'Arial'
					)
				);



				$file_name = 'monthly-commission-'.date('M', $date).'-'.date('Y', $date).'.xlsx';

				$spreadsheet = new Spreadsheet();


				$sheet = $spreadsheet->getActiveSheet()->setTitle(date('M', $date).'-'.date('Y', $date));

				$sheet->getRowDimension(1)->setRowHeight(35);
				$sheet->getRowDimension(2)->setRowHeight(25);
				$sheet->getStyle('A1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');
				$sheet->getStyle('A2:M2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');

				foreach(range('A','M') as $columnID) {
					$sheet->getColumnDimension($columnID)->setAutoSize(true);
				}

				$sheet->getStyle('A1:M2')->getAlignment()->setHorizontal('center');

				$sheet->getStyle('A2:M2')->applyFromArray($styleArray);

				$sheet->mergeCells('A1:M1');
				$sheet->getStyle('A1:M1')->applyFromArray($headingArray);
				$sheet->setCellValue('A1', strtoupper('Monthly Commission '.date('M', $date).'-'.date('Y', $date)));

				$sheet->mergeCells('A2:I2');
				$sheet->setCellValue('A2', 'COMMISSION DETAILS');
				$sheet->mergeCells('J2:M2');
				$sheet->setCellValue('J2', 'BANK DETAILS');

				$sheet->getStyle('A2:M3')->applyFromArray($styleArray);
				$sheet->setCellValue('A3', '#');
				$sheet->setCellValue('B3', 'INVESTMENT ID');
				$sheet->setCellValue('C3', 'INTRODUCER');
				$sheet->setCellValue('D3', 'INVESTOR');
				$sheet->setCellValue('E3', 'COMMISSION');
				$sheet->setCellValue('F3', 'PER DAY COMMISSION');
				$sheet->setCellValue('G3', 'TOTAL DAYS');
				$sheet->setCellValue('H3', 'PAYBLE COMMISSION');
				$sheet->setCellValue('I3', 'DATE');
				$sheet->setCellValue('J3', 'BANK NAME');
				$sheet->setCellValue('K3', 'BRANCH NAME');
				$sheet->setCellValue('L3', 'A/C NO.');
				$sheet->setCellValue('M3', 'IFSC');


				$count = 4;
				$i = 1;
				foreach($data as $row)
				{
					$bank = unserialize($row->bank_details);
					$sheet->setCellValue('A' . $count, $i++);
					$sheet->setCellValue('B' . $count, $row->investment_id);
					$sheet->setCellValue('C' . $count, $row->intro_name.' ('.$row->introducer_id.')');
					$sheet->setCellValue('D' . $count, $row->investor_name.' ('.$row->investor_id.')');
					$sheet->setCellValue('E' . $count, $row->commission.'%');
					$sheet->setCellValue('F' . $count, $row->per_day_commission);
					$sheet->setCellValue('G' . $count, $row->total_days);
					$sheet->setCellValue('H' . $count, $row->total_commission);
					$sheet->setCellValue('I' . $count, date('Y-m-d', $row->created_at));

					$sheet->setCellValue('J' . $count, !empty($bank)?$bank->bank_name:'NA');
					$sheet->setCellValue('K' . $count, !empty($bank)?$bank->branch_name:'NA');
					$sheet->setCellValue('L' . $count, !empty($bank)?$bank->account_number:'NA');
					$sheet->setCellValue('M' . $count, !empty($bank)?$bank->ifsc_code:'NA');

					$count++;
				}

				$SUMRANGE = 'H4:H'.($count-1);
				$sheet->mergeCells('A'.$count.':G'.$count);
				$sheet->getStyle('A'.$count)->getAlignment()->setHorizontal('center');
				$sheet->getRowDimension($count)->setRowHeight(25);
				$sheet->setCellValue('A' . $count, 'Total Payble Commission');
				$sheet->getStyle('A'.$count.':I'.$count)->applyFromArray($SubTotalStyle);
				$sheet->setCellValue('H'.$count++ , "=SUM($SUMRANGE)");

				

				$spreadsheet
				->getActiveSheet()
				->getStyle('A1:M'.($count-1).'')
				->getBorders()
				->getAllBorders()
				->setBorderStyle(Border::BORDER_THIN)
				->setColor(new Color('BF000000'));

				try {
					$writer = new Xlsx($spreadsheet);
					$writer->save($file_name);
					$content = file_get_contents($file_name);
				} catch(Exception $e) {
					exit($e->getMessage());
				}

				header("Content-Disposition: attachment; filename=".$file_name);

				unlink($file_name);
				exit($content);
			}else{
				$this->session->setFlashdata('message', 'There are no data available to export!');
				$this->session->setFlashdata('message_type', 'error');
				header('Location: '.site_url('payout/monthly-commission')); die;
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			header('Location: '.site_url('payout/monthly-commission')); die;
		}
	}

	function monthly_interest($month = 0, $year = 0){
		if (($month && is_numeric($month)) && ($year && is_numeric($year)) && is_admin()) {
			if (!empty($data = $this->export->getMonthlyInterest($month, $year))) {
				$date = strtotime($year.'-'.$month.'-1');

				$styleArray = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '595959'),
						'size'  => 10,
						'name'  => 'Arial'
					),
					'alignment' => [
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
				);

				$headingArray = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '595959'),
						'size'  => 14,
						'name'  => 'Arial'
					),
					'alignment' => [
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
				);

				$SubTotalStyle = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '5e5c5c'),
						'size'  => 16,
						'name'  => 'Arial'
					)
				);



				$file_name = 'monthly-interest-'.date('M', $date).'-'.date('Y', $date).'.xlsx';

				$spreadsheet = new Spreadsheet();


				$sheet = $spreadsheet->getActiveSheet()->setTitle(date('M', $date).'-'.date('Y', $date));

				$sheet->getRowDimension(1)->setRowHeight(35);
				$sheet->getRowDimension(2)->setRowHeight(25);
				$sheet->getStyle('A1:O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');
				$sheet->getStyle('A2:O2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFD9D9D9');

				foreach(range('A','O') as $columnID) {
					$sheet->getColumnDimension($columnID)->setAutoSize(true);
				}

				$sheet->getStyle('A1:O2')->getAlignment()->setHorizontal('center');

				$sheet->getStyle('A2:O3')->applyFromArray($styleArray);

				$sheet->mergeCells('A1:O1');
				$sheet->getStyle('A1:O1')->applyFromArray($headingArray);
				$sheet->setCellValue('A1', strtoupper('Monthly Interest '.date('M', $date).'-'.date('Y', $date)));

				$sheet->mergeCells('A2:K2');
				$sheet->setCellValue('A2', 'INTEREST DETAILS');
				$sheet->mergeCells('L2:O2');
				$sheet->setCellValue('L2', 'BANK DETAILS');

				$sheet->setCellValue('A3', '#');
				$sheet->setCellValue('B3', 'INVESTMENT ID');
				$sheet->setCellValue('C3', 'INVESTOR');
				$sheet->setCellValue('D3', 'INTEREST');
				$sheet->setCellValue('E3', 'PER DAY INTEREST');
				$sheet->setCellValue('F3', 'TOTAL DAYS');
				$sheet->setCellValue('G3', 'TOTAL INTEREST');
				$sheet->setCellValue('H3', 'TDS');
				$sheet->setCellValue('I3', 'OTHER CHARGES');
				$sheet->setCellValue('J3', 'PAYBLE INTEREST');
				$sheet->setCellValue('K3', 'DATE');

				$sheet->setCellValue('L3', 'BANK NAME');
				$sheet->setCellValue('M3', 'BRANCH NAME');
				$sheet->setCellValue('N3', 'A/C NO.');
				$sheet->setCellValue('O3', 'IFSC');

				$count = 4;
				$i = 1;
				foreach($data as $row)
				{
					$bank = unserialize($row->bank_details);
					$sheet->setCellValue('A' . $count, $i++);
					$sheet->setCellValue('B' . $count, $row->investment_id);
					$sheet->setCellValue('C' . $count, $row->investor_name.' ('.$row->investor_id.')');
					$sheet->setCellValue('D' . $count, $row->interest.'%');
					$sheet->setCellValue('E' . $count, $row->per_day_interest);
					$sheet->setCellValue('F' . $count, $row->total_days);
					$sheet->setCellValue('G' . $count, $row->total_interest);
					$sheet->setCellValue('H' . $count, $row->tds);
					$sheet->setCellValue('I' . $count, $row->other_charges);
					$sheet->setCellValue('J' . $count, $row->payble_interest);
					$sheet->setCellValue('K' . $count, date('Y-m-d', $row->created_at));

					$sheet->setCellValue('L' . $count, !empty($bank)?$bank->bank_name:'NA');
					$sheet->setCellValue('M' . $count, !empty($bank)?$bank->branch_name:'NA');
					$sheet->setCellValue('N' . $count, !empty($bank)?$bank->account_number:'NA');
					$sheet->setCellValue('O' . $count, !empty($bank)?$bank->ifsc_code:'NA');

					$count++;
				}

				$sumRangeTotalInterest = 'G4:G'.($count-1);
				$sumRangeTotalTds = 'H4:H'.($count-1);
				$sumRangeTotalOtherCharges = 'I4:I'.($count-1);
				$sheet->mergeCells('A'.$count.':F'.$count);
				$sheet->getStyle('A'.$count)->getAlignment()->setHorizontal('center');
				$sheet->getRowDimension($count)->setRowHeight(25);
				$sheet->setCellValue('A' . $count, 'SUBTOTAL');
				$sheet->setCellValue('G'.$count, "=SUM($sumRangeTotalInterest)");
				$sheet->setCellValue('H'.$count, "=SUM($sumRangeTotalTds)");
				$sheet->setCellValue('I'.$count , "=SUM($sumRangeTotalOtherCharges)");
				$sumRangePaybleInterest = 'G'.$count.'-(H'.$count.'+'.'I'.$count.')';
				$sheet->setCellValue('J'.$count, "=($sumRangePaybleInterest)");
				$sheet->getStyle('A'.$count.':O'.$count)->applyFromArray($SubTotalStyle);
				$count++;

				$spreadsheet
				->getActiveSheet()
				->getStyle('A1:O'.($count-1).'')
				->getBorders()
				->getAllBorders()
				->setBorderStyle(Border::BORDER_THIN)
				->setColor(new Color('BF000000'));

				try {
					$writer = new Xlsx($spreadsheet);
					$writer->save($file_name);
					$content = file_get_contents($file_name);
				} catch(Exception $e) {
					exit($e->getMessage());
				}

				header("Content-Disposition: attachment; filename=".$file_name);

				unlink($file_name);
				exit($content);
			}else{
				$this->session->setFlashdata('message', 'There are no data available to export!');
				$this->session->setFlashdata('message_type', 'error');
				header('Location: '.site_url('payout/monthly-interest')); die;
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			header('Location: '.site_url('payout/monthly-interest')); die;
		}
	}

}

