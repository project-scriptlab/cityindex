<?php namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model
{
	protected $db;

	public function __construct($db){
		$this->db =& $db;
		$this->builder = $this->db->table('users');
		$this->bank = $this->db->table('bank_details');
		$this->inv = $this->db->table('investment');
		$this->invTracker = $this->db->table('investment_tracker');
		$this->rm = $this->db->table('relationship_manager');
		$this->upload = $this->db->table('investors_document');
	}
	

	function getUserByGroup($group_id){
		if (isset($group_id) && is_numeric($group_id)) {			
			$this->builder->select('users.*, bank.bank_name, bank.account_number');
			$this->builder->join('bank_details as bank', 'users.id = bank.user_id', "left");
			$this->builder->where('group_id', $group_id); 
			$this->builder->where('is_deleted', 1); 
			$this->builder->orderBy('users.id','desc'); 
			$data = $this->builder->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function getActiveUserByGroup($group_id){
		if (isset($group_id) && is_numeric($group_id)) {			
			$this->builder->select('users.*, bank.bank_name, bank.account_number');
			$this->builder->join('bank_details as bank', 'users.id = bank.user_id', "left");
			$this->builder->where('group_id', $group_id); 
			$this->builder->where('users.active', 1); 
			$this->builder->where('users.is_deleted', 1); 
			$this->builder->orderBy('users.id','desc'); 
			$data = $this->builder->get()->getResult();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function getUserById ($id){
		if (isset($id) && is_numeric($id)) {			
			$this->builder->select('users.*, bank.bank_name, bank.account_number, bank.branch_name, bank.ifsc_code, us.id as intro_id, us.name as intro_name, us.user_name as intro_user_name, us.mobile as intro_mobile, us.email as intro_email, us.address as intro_address');
			$this->builder->join('bank_details as bank', 'users.id = bank.user_id', "left");
			$this->builder->join('users as us', 'users.introducer_id = us.id', "left");
			$this->builder->where('users.id', $id); 
			$this->builder->groupBy('users.id'); 
			$this->builder->orderBy('users.id','desc'); 
			$this->builder->limit(1); 
			$data = $this->builder->get()->getRow();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}

	function getUserByMemberId ($id){
		if (isset($id)) {			
			$this->builder->select('users.*, bank.bank_name, bank.account_number, bank.branch_name, bank.ifsc_code, us.id as intro_id, us.name as intro_name, us.user_name as intro_user_name, us.mobile as intro_mobile, us.email as intro_email, us.address as intro_address');
			$this->builder->join('bank_details as bank', 'users.id = bank.user_id', "left");
			$this->builder->join('users as us', 'users.introducer_id = us.id', "left");
			$this->builder->where('users.member_id', $id); 
			$this->builder->groupBy('users.id'); 
			$this->builder->orderBy('users.id','desc'); 
			$this->builder->limit(1); 
			$data = $this->builder->get()->getRow();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}


	function getBankDetails ($ac_no = 0){			
		$this->bank->select('*');
		$this->bank->where('account_number', $ac_no);
		$data = $this->bank->get()->getRow();
		if (!empty($data)) {
			return $data;
		}else {
			return false;
		}
	}

	function insertPersonalDetails($data = array())
	{
		if (!empty($data)) {
			if ($this->builder->insert($data)) { 
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updatePersonalDetails($id = '', $data = array())
	{
		if (!empty($data) && is_numeric($id)) {
			$this->builder->where('id', $id);
			if ($this->builder->update($data)) {
				return true;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}


	function insertBankDetails($data = array())
	{
		if (!empty($data)) {
			if ($this->bank->insert($data)) {
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updateBankDetails($id = '', $data = array())
	{
		if (!empty($data) && is_numeric($id)) {
			$this->bank->where('user_id', $id);
			if ($this->bank->update($data)) {
				return true;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}

	function hasBankAccount($userId=0)
	{
		if ($userId && is_numeric($userId)) {
			$this->bank->select('*');
			$this->bank->where('user_id', $userId);
			$count = $this->bank->countAllResults();
			if ($count == 0) {
				return false;
			}else {
				return true;
			}
		}
	}

	function insertInvestmentDetails($data = array())
	{
		if (!empty($data)) {
			if ($this->inv->insert($data)) {
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updateInvestmentDetails($id = '', $investor_id = '', $data = array())
	{
		if (!empty($data) && is_numeric($id)) {
			$this->inv->where('id', $id);
			if ($investor_id) {
				$this->inv->where('investor_id', $investor_id);
			}
			if ($this->inv->update($data)) {
				return true;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}




	function insertInvestmentTrackerDetails($data = array())
	{
		if (!empty($data)) {
			if ($this->invTracker->insert($data)) {
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updateInvestmentTrackerDetails($investment_id = '', $data = array())
	{
		if (!empty($data && is_numeric($investment_id))) {
			$this->invTracker->where('investment_id', $investment_id);
			if ($this->invTracker->update($data)) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}


	function getAllRm(){			
		$this->rm->select('*');
		$this->rm->orderBy('id','desc'); 
		$data = $this->rm->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function getRmById ($id){
		if (isset($id) && is_numeric($id)) {			
			$this->rm->select('*');
			$this->rm->where('id', $id); 
			$this->rm->orderBy('id','desc'); 
			$this->rm->limit(1); 
			$data = $this->rm->get()->getRow();
			if (!empty($data)) {
				return $data;
			}
		}else{
			return false;
		}
	}


	function insertRmDetails($data = array())
	{
		if (!empty($data)) {
			if ($this->rm->insert($data)) { 
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	function updateRmDetails($id = '', $data = array())
	{
		if (!empty($data) && is_numeric($id)) {
			$this->rm->where('id', $id);
			if ($this->rm->update($data)) {
				return true;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}

	function uploadInvestorDocs($data = array())
	{
		if (!empty($data)) {
			if ($this->upload->insert($data)) { 
				return $this->db->insertID();
			}else {
				return false;
			}
		}else {
			return false;
		}
	}


	function getIntroducersToExport(){			
		$this->builder->select('users.*, bank.bank_name, bank.account_number, bank.branch_name, bank.ifsc_code');
		$this->builder->join('bank_details as bank', 'users.id = bank.user_id', "left");
		$this->builder->where('group_id', 3); 
		$this->builder->where('is_deleted', 1); 
		$this->builder->orderBy('users.id','desc'); 
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function getInvestorsToExport(){			
		$this->builder->select('users.*, bank.bank_name, bank.account_number, bank.branch_name, bank.ifsc_code, us.id as intro_id, us.name as intro_name, us.user_name as intro_user_name, us.mobile as intro_mobile, us.email as intro_email, us.address as intro_address');
		$this->builder->join('bank_details as bank', 'users.id = bank.user_id', "left");
		$this->builder->join('users as us', 'users.introducer_id = us.id', "left");
		$this->builder->where('users.group_id', 2); 
		$this->builder->where('users.is_deleted', 1); 
		$this->builder->groupBy('users.id'); 
		$this->builder->orderBy('users.id','desc'); 
		$data = $this->builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function getInvestmentsToExport($id = 0, $firstDayOfMonth=0, $lastDayOfMonth=0 ){
		$this->inv->select('investment.*,users.name as introducer_name, us.name as investor_name');
		$this->inv->join('users','users.id=investment.introducer_id','left');
		$this->inv->join('users us','us.id=investment.investor_id','left');
		if ($id && is_numeric($id)) {
			$this->inv->where('investment.investor_id', $id);
		}
		if ($firstDayOfMonth) {
			$this->inv->where('investment.created_at >=', $firstDayOfMonth);
		}
		if ($lastDayOfMonth) {
			$this->inv->where('investment.created_at <=', $lastDayOfMonth);
		}
		$this->inv->orderBy('investment.id','desc'); 
		$data = $this->inv->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}

	function getDocuments($user_id = 0, $id = 0){		
		$this->upload->select('*');
		if ($user_id && is_numeric($user_id)) {	
			$this->upload->where('investor_id', $user_id);
		}
		if ($id && is_numeric($id)) {
			$this->upload->where('id', $id);
		}
		$data = $this->upload->get()->getResult();
		if (!empty($data)) {
			return $data;
		}
	}

	function deleteDoc($id = 0)
	{
		if ($id && is_numeric($id)) {
			$this->upload->where('id', $id);
			if ($this->upload->delete()) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function username_exist_in_database($name='', $id = 0)
	{
		$this->builder->select('user_name');
		$this->builder->where('user_name', $name);
		if ($id > 0 && is_numeric($id)) {
			$this->builder->where('id <>', $id);
		}
		$count = $this->builder->countAllResults();
		if ($count == 0) {
			return false;
		}else {
			return true;
		}
	}

}