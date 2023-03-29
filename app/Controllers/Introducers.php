<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Users_model;
use App\Models\Introducer_model;
use App\Models\Payout_model;

class Introducers extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->user = new Users_model($db);
		$this->intro = new Introducer_model($db);
		$this->payout = New Payout_model($db);
		$this->session = \Config\Services::session();
	}

	public function index()
	{
		$this->data['title'] = 'Introducer';
		$this->data['users'] = array();
		return view('introducer/dashboard', $this->data);

	}

	public function investor_list()
	{
		$this->data['title'] = 'Investor List';
		$this->data['payments'] = $this->intro->getAllReceivedPayments($this->session->userData['id']);
		return view('introducer/investor-list', $this->data);
	}

	public function my_profile()
	{
		$this->data['title'] = 'My profile';
		$this->data['details'] = $this->user->getUserById($this->session->userData['id']);
		return view('introducer/my-profile', $this->data);
	}

	public function monthly_commission()
	{
		$month =  $this->request->getPost('month')?$this->request->getPost('month'):0;
		$year =  $this->request->getPost('year')?$this->request->getPost('year'):0;

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
			$this->data['title'] = 'Monthly Commission';
			$this->data['filter'] = $this->payout->getCommissionFilter();
			$this->data['commissions'] =  $this->intro->getmonthlyCommissions($month, $year, $this->session->userData['id']);
			return view('introducer/monthly-commission', $this->data);
		}else{

		}
	}

	
}