<?php 
// Function: used to convert a string to revese in order
if (!function_exists("is_admin")) {
	function is_admin($id = 0)
	{
		$db = db_connect();
		$builder = $db->table('users');
		$session = \Config\Services::session();
		$id?$id:$id=$session->userData['id'];
		if ($session->isLoggedIn) {
			$builder->select('group_id');
			$builder->where('id', $id); 
			$builder->limit(1); 
			$data = $builder->get()->getRow();
			if ($data->group_id == 1) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

if (!function_exists("is_introducer")) {
	function is_introducer($id = 0)
	{
		$db = db_connect();
		$builder = $db->table('users');
		$session = \Config\Services::session();
		$id?$id:$id=$session->userData['id'];
		if ($session->isLoggedIn) {
			$builder->select('group_id');
			$builder->where('id', $id); 
			$builder->limit(1); 
			$data = $builder->get()->getRow();
			if ($data->group_id == 3) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

if (!function_exists("is_investor")) {
	function is_investor($id = 0)
	{
		$db = db_connect();
		$builder = $db->table('users');
		$session = \Config\Services::session();
		$id?$id:$id=$session->userData['id'];
		if ($session->isLoggedIn) {
			$builder->select('group_id');
			$builder->where('id', $id); 
			$builder->limit(1); 
			$data = $builder->get()->getRow();
			if ($data->group_id == 2) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}


if (!function_exists("random_string")) {
	function random_string(int $length = 0, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
		if ($length < 1) {
			return false; die;
		}
		$keyspace = str_shuffle($keyspace);
		$pieces = [];
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$pieces []= $keyspace[random_int(0, $max)];
		}
		return implode('', $pieces);
	}
}




if (!function_exists("duplicateUserEmailCheck")) {
	function duplicateUserEmailCheck($email = '', $id = 0) {
		if (!empty($email)) {
			$db = db_connect();
			$builder = $db->table('users');
			$builder->select('email');
			$builder->where('email', $email);
			if ($id > 0 && is_numeric($id)) {
				$builder->where('id <>', $id);
			}
			$count = $builder->countAllResults();
			if ($count == 0) {
				return true;
			}else{
				return false;
			}
		}else {
			return false;
		}
	}
}

if (!function_exists("duplicateRmEmailCheck")) {
	function duplicateRmEmailCheck($email = '', $id = 0) {
		if (!empty($email)) {
			$db = db_connect();
			$builder = $db->table('relationship_manager');
			$builder->select('email');
			$builder->where('email', $email);
			if ($id > 0 && is_numeric($id)) {
				$builder->where('id <>', $id);
			}
			$count = $builder->countAllResults();
			if ($count == 0) {
				return true;
			}else{
				return false;
			}
		}else {
			return false;
		}
	}
}

if (!function_exists("validAccountNumberCheck")) {
	function validAccountNumberCheck($ac_number = '') {
		if (!empty($ac_number) && is_numeric($ac_number)) {
			$db = db_connect();
			$builder = $db->table('bank_details');
			$builder->select('account_number');
			$builder->where('account_number', $ac_number);
			$count = $builder->countAllResults();
			if ($count >= 1) {
				return true;
			}else{
				return false;
			}
		}else {
			return false;
		}
	}
}

if (!function_exists("totalInvestmentAmount")) {
	function totalInvestmentAmount($type, $id = 0) {
		$db = db_connect();
		$builder = $db->table('investment');
		$session = \Config\Services::session();
		$id?$id:$id=$session->userData['id'];
		if ($session->isLoggedIn) {
			$builder->selectSum('it.updated_investment_amount');
			$builder->join('investment_tracker as it','it.investment_id=investment.id');
			if ($type == 1) {
				$builder->where('investor_id', $id);
			} elseif ($type == 2) {
				$builder->where('introducer_id', $id);
			}else{
				return false;
			}
			$data = $builder->get()->getRow();
			return $data->updated_investment_amount; die;
		}else{
			return false;
		}
	}
}

if (!function_exists("totalInvestorIntroduced")) {
	function totalInvestorIntroduced($id = 0){
		$db = db_connect();
		$builder = $db->table('users');
		$session = \Config\Services::session();
		$id?$id:$id=$session->userData['id'];
		if ($session->isLoggedIn) {
			$builder->select('id');
			$builder->where('introducer_id', $id);
			$builder->where('group_id', 2);
			$builder->groupBy("id");
			$count = $builder->countAllResults();
			return $count;
		}else{
			return false;
		}
	}
}

if (!function_exists("totalWithdrawalAmount")) {
	function totalWithdrawalAmount($id = 0){
		$db = db_connect();
		$builder = $db->table('withdraw');
		$session = \Config\Services::session();
		$id?$id:$id=$session->userData['id'];
		if ($session->isLoggedIn) {
			$builder->selectSum('withdrawl_amount');
			$builder->join('investment','investment.id=withdraw.investment_id');
			$builder->join('users','users.id=investment.investor_id');
			$builder->where('users.id', $id);
			$data = $builder->get()->getRow();
			if (!empty($data)) {
				return $data->withdrawl_amount; die;
			}else {
				return 0;
			}
			
		}else{
			return false;
		}
	}
}

if (!function_exists("usersCountByGroup")) {
	function usersCountByGroup($group = 0){
		if ($group && is_numeric($group)) {
			$db = db_connect();
			$session = \Config\Services::session();
			$builder = $db->table('users');
			if ($session->isLoggedIn) {
				$builder->selectSum('id');
				$builder->where('group_id', $group);
				$builder->where('active', 1);
				$builder->where('is_deleted', 1);
				$count = $builder->countAllResults();
				return $count;
			}else{
				return false;
			}
		}
		
	}
}

if (!function_exists("totalInvestmentReceived")) {
	function totalInvestmentReceived() {
		$db = db_connect();
		$builder = $db->table('investment');
		$session = \Config\Services::session();
		if ($session->isLoggedIn) {
			$builder->selectSum('investment_amount');
			$data = $builder->get()->getRow();
			return $data->investment_amount; die;
		}else{
			return false;
		}
	}
}

if (!function_exists("totalInvestmentThroughIntroducers")) {
	function totalInvestmentThroughIntroducers() {
		$db = db_connect();
		$builder = $db->table('investment');
		$session = \Config\Services::session();
		if ($session->isLoggedIn) {
			$builder->selectSum('investment_amount');
			$builder->where('introducer_id <>', 0);
			$data = $builder->get()->getRow();
			return $data->investment_amount; die;
		}else{
			return false;
		}
	}
}


if (!function_exists("payoutGenerateDuplicateCheck")) {
	function payoutGenerateDuplicateCheck($month, $year, $timestamp) {
		$db = db_connect();
		$builder = $db->table('investment');
		$builder->select('investment.*, it.updated_investment_amount'); 
		$builder->join('investment_tracker as it','it.investment_id=investment.id','left');
		$builder->join('users as us','us.id=investment.investor_id','left');
		$builder->where("investment.id NOT IN (SELECT investment_id FROM interest WHERE curr_month=$month AND curr_year=$year)", NULL, FALSE);
		if ($timestamp) {
			$builder->where('investment.created_at <', $timestamp);
		}
		$builder->where('us.active', 1);
		$builder->where('investment.status', 1);
		$builder->orderBy('investment.id','desc');
		$builder->groupBy('investment.id'); 
		$data = $builder->get()->getResult();
		if (!empty($data)) {
			return $data;
		}else{
			return false;
		}
	}
}

if (!function_exists("investmentIdValidityCheck")) {
	function investmentIdValidityCheck($id, $month, $year) {
		$db = db_connect();
		$builder = $db->table('investment');
		$builder->select('*');
		$builder->where('id', $id);
		$data = $builder->get()->getRow();
		$a_date = $year."-".$month."-23";
		if (!empty($data)) {
			if (strtotime(date("Y-m-t", strtotime($a_date))) >= $data->created_at) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	}
}

if (!function_exists("duplicateInterestPayout")) {
	function duplicateInterestPayout($investment_id = 0, $month = 0, $year = 0) {
		$db = db_connect();
		$builder = $db->table('interest');
		$builder->select('id');
		if ($investment_id) {
			$builder->where('investment_id', $investment_id);
		}
		$builder->where('curr_month', $month);
		$builder->where('curr_year', $year);
		$count = $builder->countAllResults();
		if ($count == 1) {
			return true;
		}else{
			return false;
		}
	}
}

if (!function_exists("duplicateCommissionPayout")) {
	function duplicateCommissionPayout($investment_id = 0, $month = 0, $year = 0) {
		$db = db_connect();
		$builder = $db->table('commission');
		$builder->select('id');
		$builder->where('investment_id', $investment_id);
		$builder->where('curr_month', $month);
		$builder->where('curr_year', $year);
		$count = $builder->countAllResults();
		if ($count == 1) {
			return true;
		}else{
			return false;
		}
	}
}

if (!function_exists("totalCommissionReceived")) {
	function totalCommissionReceived() {
		$db = db_connect();
		$session = \Config\Services::session();
		$id=$session->userData['id'];
		$builder = $db->table('commission');
		$builder->selectSum('total_commission');
		$builder->where('introducer_id', $id);
		$total = $builder->get()->getRow();
		return $total->total_commission;
	}
}

if (!function_exists("totalInterestReceived")) {
	function totalInterestReceived() {
		$db = db_connect();
		$session = \Config\Services::session();
		$id=$session->userData['id'];
		$builder = $db->table('interest');
		$builder->selectSum('payble_interest');
		$builder->where('investor_id', $id);
		$total = $builder->get()->getRow();
		return $total->payble_interest;
	}
}

if (!function_exists("totalDirectInvestment")) {
	function totalDirectInvestment() {
		$db = db_connect();
		$builder = $db->table('investment');
		$builder->selectSum('investment_amount');
		$builder->where('introducer_id', 0);
		$data = $builder->get()->getRow();
		return $data->investment_amount; die;
	}
}

if (!function_exists("getTotalFutureWithdrawnAmount")) {
	function getTotalFutureWithdrawnAmount($month, $year, $investmentId) {
		$db = db_connect();
		$builder = $db->table('withdraw');
		$builder->selectSum('withdrawl_amount');
		$builder->where('month >', $month);
		$builder->where('year >=', $year);
		$builder->where('investment_id', $investmentId);
		$data = $builder->get()->getRow();
		return $data->withdrawl_amount; die;
	}
}



?>