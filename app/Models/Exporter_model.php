<?php namespace App\Models;

use CodeIgniter\Model;

class Exporter_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('commission');
		$this->interest = $this->db->table('interest');
	}

	function getMonthlyCommission($month = 0, $year = 0) {
		$this->builder->select('commission.*, u.name as intro_name, us.name as investor_name');
		$this->builder->join('users as us', 'us.id=commission.investor_id','left');
		$this->builder->join('users as u', 'u.id=commission.introducer_id','left');
		$this->builder->where('commission.curr_month', $month);
		$this->builder->where('commission.curr_year', $year);
		$this->builder->orderBy('commission.total_commission','desc');
		$this->builder->groupBy('commission.id');
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

	function getMonthlyInterest($month = 0, $year = 0) {
		$this->interest->select('interest.*, us.name as investor_name');
		$this->interest->join('users as us', 'us.id=interest.investor_id','left');
		$this->interest->where('interest.curr_month', $month);
		$this->interest->where('interest.curr_year', $year);
		$this->interest->orderBy('interest.payble_interest','desc');
		$this->interest->groupBy('interest.id');
		$data = $this->interest->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}
}