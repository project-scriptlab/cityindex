<?php namespace App\Models;

use CodeIgniter\Model;

class Introducer_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('investment');
		$this->comm = $this->db->table('commission');
	}
	

	function getAllReceivedPayments($introducer_id = 0 ){
		if ($introducer_id && is_numeric($introducer_id)) {
			$this->builder->select('investment.*,users.name as investor_name, users.member_id as investor_member_id, it.updated_investment_amount as investment_amount');
			$this->builder->join('investment_tracker it','it.investment_id=investment.id','left');
			$this->builder->join('users','users.id=investment.investor_id','left');
			$this->builder->where('investment.introducer_id', $introducer_id);
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

	function getmonthlyCommissions($month, $year, $id){
		if (is_numeric($month) && is_numeric($year)) {			
			$this->comm->select('commission.*, us2.name as investor_name');
			$this->comm->join('users as us2', 'us2.id = commission.investor_id', "left");
			$this->comm->where('curr_month', $month); 
			$this->comm->where('curr_year', $year); 
			$this->comm->where('commission.introducer_id', $id); 
			$this->comm->orderBy('commission.total_commission','desc'); 
			$data = $this->comm->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}
}