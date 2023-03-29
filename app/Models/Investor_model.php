<?php namespace App\Models;

use CodeIgniter\Model;

class Investor_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('investment');
		$this->interest = $this->db->table('interest');
	}
	

	function getPayments($investor_id = 0 ){
		if ($investor_id && is_numeric($investor_id)) {
			$this->builder->select('investment.*,users.name as investor_name, it.updated_investment_amount');
			$this->builder->join('users','users.id=investment.investor_id','left');
			$this->builder->join('investment_tracker it','it.investment_id=investment.id','left');
			$this->builder->where('investment.investor_id', $investor_id);
			$this->builder->orderBy('investment.id','desc'); 
			$data = $this->builder->get()->getResult();

			if (!empty($data)) {
				return $data;
			}else{
				return false;
			}
		} else {
			return false;
		}		
	}

	function getAllPayments($investor_id = 0, $firstDayOfMonth=0, $lastDayOfMonth=0 ){
		$this->builder->select('investment.*,users.name as introducer_name, us.name as investor_name, it.updated_investment_amount, us.active as investorStatus, us.member_id as investorMemberId , users.active as intoStatus, users.member_id as introMemberId');
		$this->builder->join('users','users.id=investment.introducer_id','left');
		$this->builder->join('users us','us.id=investment.investor_id','left');
		$this->builder->join('investment_tracker it','it.investment_id=investment.id','left');

		if ($investor_id && is_numeric($investor_id)) {
			$this->builder->where('investment.investor_id', $investor_id);
		}
		if ($firstDayOfMonth) {
			$this->builder->where('investment.created_at >=', $firstDayOfMonth);
		}
		if ($lastDayOfMonth) {
			$this->builder->where('investment.created_at <=', $lastDayOfMonth);
		}

		$this->builder->orderBy('investment.id','desc'); 
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}

	function getmonthlyInterest($month, $year, $id){
		if (is_numeric($month) && is_numeric($year)) {			
			$this->interest->select('*');
			$this->interest->where('curr_month', $month); 
			$this->interest->where('curr_year', $year); 
			$this->interest->where('investor_id', $id); 
			$this->interest->orderBy('total_interest','desc'); 
			$data = $this->interest->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}
}