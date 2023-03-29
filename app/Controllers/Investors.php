<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Users_model;
use App\Models\Investor_model;
use App\Models\Payout_model;

class Investors extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->user = new Users_model($db);
		$this->investor = new Investor_model($db);
		$this->payout = New Payout_model($db);
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
	}

	public function index()
	{
		$this->data['title'] = 'Investor';
		$this->data['users'] = array();
		return view('investors/dashboard', $this->data);
	}

	public function investment_details()
	{
		$this->data['title'] = 'Investment Details';
		$this->data['payments'] = $this->investor->getPayments($this->session->userData['id']);
		return view('investors/investment-list', $this->data);
	}

	public function my_profile()
	{
		$this->data['title'] = 'My profile';
		$this->data['details'] = $details =  $this->user->getUserById($this->session->userData['id']);
		$this->data['documents'] = $this->user->getDocuments($this->session->userData['id']);		
		return view('investors/my-profile', $this->data);
	}

	public function monthly_interest()
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
			$this->data['title'] = 'Monthly Payout';
			$this->data['filter'] = $this->payout->getInterestFilter();
			$this->data['interests'] = $interests =  $this->investor->getmonthlyInterest($month, $year, $this->session->userData['id']);
			return view('investors/monthly-interest', $this->data);
		}else{

		}
	}
}