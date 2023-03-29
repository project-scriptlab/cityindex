<?php namespace App\Models;

use CodeIgniter\Model;

class Payout_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('interest');
		$this->comm = $this->db->table('commission');
		$this->tots = $this->db->table('total_monthly_payout');
		$this->user = $this->db->table('users');
		$this->inv = $this->db->table('investment');
		$this->withdraw = $this->db->table('withdraw');
	}

	function getmonthlyCommissions($month, $year){
		if (is_numeric($month) && is_numeric($year)) {			
			$this->comm->select('commission.*, us.name as intro_name, us2.name as investor_name');
			$this->comm->join('users as us', 'us.id = commission.introducer_id', "left");
			$this->comm->join('users as us2', 'us2.id = commission.investor_id', "left");
			$this->comm->where('curr_month', $month); 
			$this->comm->where('curr_year', $year);
			$this->comm->orderBy('commission.total_commission','desc'); 
			$data = $this->comm->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function getmonthlyInterest($month, $year){
		if (is_numeric($month) && is_numeric($year)) {			
			$this->builder->select('interest.*, us2.name as investor_name');
			$this->builder->join('users as us2', 'us2.id = interest.investor_id', "left");
			$this->builder->where('curr_month', $month); 
			$this->builder->where('curr_year', $year); 
			$this->builder->orderBy('interest.investment_amount','desc'); 
			$data = $this->builder->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function getCommissionFilter(){		
		$this->comm->select('curr_month, curr_year');
		$this->comm->groupBy(array("curr_year", "curr_month"));
		$data = $this->comm->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function getInterestFilter(){		
		$this->builder->select('curr_month, curr_year');
		$this->builder->groupBy(array("curr_year", "curr_month"));
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function getInvestmentData($investment_id = 0)
	{
		$this->inv->select('investment.*, it.updated_investment_amount, users.member_id, users.name');
		$this->inv->join('investment_tracker as it','it.investment_id=investment.id', 'left');
		$this->inv->join('users','users.id=investment.investor_id', 'left');
		$this->inv->where('investment.id', $investment_id);
		$data = $this->inv->get()->getRow();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}

	function proceedWithdraw($data = array())
	{
		if (!empty($data)) {
			if ($this->withdraw->insert($data)) {
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function limitOfWithdrawlPerDay($id='', $date = '')
	{
		$this->withdraw->select('*');
		$this->withdraw->where('investment_id', $id);
		$this->withdraw->where('created_at', $date);
		$count = $this->withdraw->countAllResults();
		if ($count > 0) {
			return false;
		}else{
			return true;
		}
	}

	function getWithdrawlList()
	{
		$this->withdraw->select('withdraw.*, inv.investment_amount as actual_investment_amount, it.updated_investment_amount, users.name as investorName, users.member_id');
		$this->withdraw->join('investment as inv','inv.id=withdraw.investment_id','left');
		$this->withdraw->join('investment_tracker as it','it.investment_id=withdraw.investment_id','left');
		$this->withdraw->join('users','users.id=inv.investor_id','left');
		$this->withdraw->orderBy('withdraw.id', 'desc');
		$this->withdraw->groupBy('withdraw.investment_id');
		$data = $this->withdraw->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

	function getWithdrawlListByInvestmentId($invid = 0)
	{
		$this->withdraw->select('withdraw.*, inv.investment_amount as actual_investment_amount, it.updated_investment_amount');
		$this->withdraw->join('investment as inv','inv.id=withdraw.investment_id','left');
		$this->withdraw->join('investment_tracker as it','it.investment_id=withdraw.investment_id','left');
		$this->withdraw->where('withdraw.investment_id', $invid);
		$this->withdraw->orderBy('withdraw.id', 'desc');
		$this->withdraw->groupBy('withdraw.id');
		$data = $this->withdraw->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

	function getTotalWithdrawlAount ($invId = 0)
	{
		$this->withdraw->selectSum('withdrawl_amount');
		$this->withdraw->where('investment_id', $invId);
		$query = $this->withdraw->get()->getRow();
		return $query;
	}

	function isPayoutGenerated($investment_id, $month, $year)
	{
		$this->builder->select('id');
		$this->builder->where('investment_id', $investment_id);
		$this->builder->where('curr_month', $month);
		$this->builder->where('curr_year', $month);
		$count = $this->builder->countAllResults();
		if ($count == 0) {
			return true;
		}else{
			return false;
		}
	}

	function validWithdrawRequest($investment_id, $now)
	{
		$this->withdraw->selectMax('created_at');
		$this->withdraw->where('investment_id', $investment_id);
		$data = $this->withdraw->get()->getRow();
		$date = $data->created_at;
		if (empty($date)) {
			return 1;
		}elseif ($now > $date) {
			return 1;
		}else{
			return $date;
		}
	}
}