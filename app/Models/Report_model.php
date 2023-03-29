<?php namespace App\Models;

use CodeIgniter\Model;

class Report_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->inv = $this->db->table('investment');
		$this->comm = $this->db->table('commission');
		$this->int = $this->db->table('interest');
		$this->tots = $this->db->table('total_monthly_payout');
		$this->withdraw = $this->db->table('withdraw');
		$this->bank = $this->db->table('bank_details');
	}

	function getAllInvestments ($timestamp = 0, $month = 0, $year = 0)
	{
		$this->inv->select('investment.*, it.updated_investment_amount'); 
		$this->inv->join('investment_tracker as it','it.investment_id=investment.id','left');
		$this->inv->join('users as us','us.id=investment.investor_id','left');
		$this->inv->where("investment.id NOT IN (SELECT investment_id FROM interest WHERE curr_month=$month AND curr_year=$year)", NULL, FALSE);
		if ($timestamp) {
			$this->inv->where('investment.created_at <', $timestamp);
		}
		$this->inv->where('us.active', 1);
		$this->inv->where('investment.status', 1);
		$this->inv->orderBy('investment.id','desc'); 
		$this->inv->groupBy('investment.id'); 
		$data = $this->inv->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}

	function CheckIfDataAvailable ($timestamp = 0)
	{
		$this->inv->select('investment.*, it.updated_investment_amount'); 
		$this->inv->join('investment_tracker as it','it.investment_id=investment.id','left');
		$this->inv->join('users as us', 'us.id=investment.investor_id', 'left');
		if ($timestamp) {
			$this->inv->where('investment.created_at <', $timestamp);
		}
		$this->inv->where('us.active', 1);
		$this->inv->where('investment.status', 1);
		$this->inv->orderBy('investment.id','desc'); 
		$this->inv->groupBy('investment.id'); 
		$data = $this->inv->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}

	function insertCommissionData($data = array())
	{
		if (!empty($data)) {
			if ($this->comm->insert($data)) { 
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function insertInterestData($data = array())
	{
		if (!empty($data)) {
			if ($this->int->insert($data)) { 
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function insertTotalMonthlyPayout($data = array())
	{
		if (!empty($data)) {
			if ($this->tots->insert($data)) { 
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updateTotalMonthlyPayout($id = 0, $data = array())
	{
		if (!empty($data)) {
			$this->tots->where('id', $id);
			if ($this->tots->update($data)) { 
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function getPayoutReport($month = 0, $year = 0)
	{
		if (($month && is_numeric($month) && ($year && is_numeric($year)))) {
			$this->tots->select('*');
			$this->tots->where('month', $month);
			$this->tots->where('year', $year);
			$data = $this->tots->get()->getRow();
			if (!empty($data)) {
				return $data;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function getWithdrawDetailsForTheMonth($month, $year, $investment_id) {
		$this->withdraw->select('*');
		$this->withdraw->where('month', $month);
		$this->withdraw->where('year', $year);
		$this->withdraw->where('investment_id', $investment_id);
		$this->withdraw->orderBy('id','desc');
		$data = $this->withdraw->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}

	function getBankDetails($user_id = 0) {
		$this->bank->select('*');
		$this->bank->where('user_id', $user_id);
		$data = $this->bank->get()->getRow();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

	function payoutWasprocessed($month, $year){
		$this->tots->select('*');
		$this->tots->where('month', $month);
		$this->tots->where('year', $year);
		$data = $this->tots->get()->getRow();
		if (!empty($data)) {
			return $data;
		}else{
			return false;;
		}
	}

}