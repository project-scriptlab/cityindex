<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Users_model;
use App\Models\Investor_model;

class Users extends BaseController
{


	public function __construct()
	{
		$db = db_connect();
		$this->user = new Users_model($db);
		$this->investor = new Investor_model($db);
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();

		//load helper
		helper('custom');
	}

	public function index()
	{
		$this->data['title'] = 'Admin';
		$this->data['users'] = $this->user->getUserByGroup(1);
		return view('users/list', $this->data);

	}

	public function introducer()
	{
		$this->data['title'] = 'Introducer';
		$this->data['users'] = $this->user->getUserByGroup(3);
		return view('users/introducer-list', $this->data);
	}

	public function investor()
	{
		$this->data['title'] = 'Investor';
		$this->data['users'] = $this->user->getUserByGroup(2);
		return view('users/investor-list', $this->data);
	}


	public function create_introducer()
	{
		$this->data['title'] = 'Add Introducer';
		$this->data['rms'] = $this->user->getAllRm();
		return view('users/add-introducer', $this->data);
	}

	public function create_investor()
	{
		$this->data['title'] = 'Add Investor';
		$this->data['introducers'] = $this->user->getActiveUserByGroup(3);
		$this->data['rms'] = $this->user->getAllRm();
		return view('users/add-investor', $this->data);
	}

	public function get_user_by_id($id = 0)
	{
		if ($id != 0 && is_numeric($id)) {
			$this->data['title'] = 'Edit User';
			$this->data['details'] = $details = $this->user->getUserById($id);
			if (!empty($details)) {
				if ($details->group_id == 1) {
					
				}elseif ($details->group_id == 2) {
					$this->data['rms'] = $this->user->getAllRm();
					$this->data['introducers'] = $this->user->getActiveUserByGroup(3);
					return view('users/edit-investor', $this->data);
				}elseif ($details->group_id == 3) {
					$this->data['rms'] = $this->user->getAllRm();
					return view('users/edit-introducer', $this->data);
				}
			}
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to($this->request->getUserAgent()->getReferrer());
		}
	}

	public function add_admin()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if (strlen($this->request->getPost('name')) == 0 ) {
			$this->data['message'] = 'Enter Name';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('email')) == 0 ) {
			$this->data['message'] = 'Enter Email';
			echo json_encode($this->data); die;
		}elseif (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
			$this->data['message'] = 'Enter Valid Email';
			echo json_encode($this->data); die;
		}else {
			if (!duplicateUserEmailCheck($this->request->getPost('email'))) {
				$this->data['message'] = 'Duplicate Email found';
				echo json_encode($this->data); die;
			}
		}

		if (strlen($this->request->getPost('username')) == 0 ) {
			$this->data['message'] = 'Enter Username';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('mobile')) == 0 ) {
			$this->data['message'] = 'Enter Mobile Number';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('password')) == 0 ) {
			$this->data['message'] = 'Enter Password';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('confirm_pwd')) == 0 ) {
			$this->data['message'] = 'Enter Confirm Password';
			echo json_encode($this->data); die;
		}
		if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
			$this->data['message'] = "Password confirmation doesn't match Password";
			echo json_encode($this->data); die;
		}

		$data = array(
			'group_id' => 1,
			'email ' => $this->request->getPost('email'),
			'name' => $this->request->getPost('name'),
			'user_name' => $this->request->getPost('username'),
			'mobile' => $this->request->getPost('mobile'),
			'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
			'activate_hash' => random_string(32),
			'active' => 1,
			'created_at' => strtotime('now'),
		);

		if ($inserted_id = $this->user->insertPersonalDetails($data)) {
			$this->data['success'] = true;
			$this->data['message'] = 'Created Succesfully';
			echo json_encode($this->data);
		}else{
			$this->data['message'] = "Something went wrong!";
			echo json_encode($this->data); die;
		}
	}

	public function update_admin($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($id && is_numeric($id)) {
			
			if (strlen($this->request->getPost('name')) == 0 ) {
				$this->data['message'] = 'Enter Name';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('email')) == 0 ) {
				$this->data['message'] = 'Enter Email';
				echo json_encode($this->data); die;
			}elseif (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
				$this->data['message'] = 'Enter Valid Email';
				echo json_encode($this->data); die;
			}else {
				if (!duplicateUserEmailCheck($this->request->getPost('email'), $id)) {
					$this->data['message'] = 'Duplicate Email found';
					echo json_encode($this->data); die;
				}
			}

			if (strlen($this->request->getPost('username')) == 0 ) {
				$this->data['message'] = 'Enter Username';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('mobile')) == 0 ) {
				$this->data['message'] = 'Enter Mobile Number';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('password')) != 0 || strlen($this->request->getPost('confirm_pwd')) != 0) {
				if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
					$this->data['message'] = "Password confirmation doesn't match Password";
					echo json_encode($this->data); die;
				}
			}


			$data = array(
				'email ' => $this->request->getPost('email'),
				'name' => $this->request->getPost('name'),
				'user_name' => $this->request->getPost('username'),
				'mobile' => $this->request->getPost('mobile'),
				'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
				'updated_at' => strtotime('now'),
			);

			if (strlen($this->request->getPost('confirm_pwd')) == 0) {
				unset($data['password_hash']);
			}
			if ($this->user->updatePersonalDetails($id, $data)) {
				$this->data['success'] = true;
				$this->data['message'] = 'Updated Successfully';
				echo json_encode($this->data);
			}else{
				$this->data['message'] = "Something went wrong!";
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = "Something went wrong!";
			echo json_encode($this->data); die;
		}
	}

	public function save_introducer()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		
		if (strlen($this->request->getPost('full_name')) == 0 ) {
			$this->data['message'] = 'Enter Full Name';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('email')) != 0 ) {
			if (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
				$this->data['message'] = 'Enter Valid Email';
				echo json_encode($this->data); die;
			}else{
				if (!duplicateUserEmailCheck($this->request->getPost('email'))) {
					$this->data['message'] = 'Duplicate Email found';
					echo json_encode($this->data); die;
				}
			}
		}

		if (strlen($this->request->getPost('username')) == 0 ) {
			$this->data['message'] = 'Enter Username';
			echo json_encode($this->data); die;
		}else{
			if ($this->user->username_exist_in_database($this->request->getPost('username'))) {
				$this->data['message'] = 'Username should be unique';
				echo json_encode($this->data); die;
			}
		}
		
		if (strlen($this->request->getPost('password')) == 0 ) {
			$this->data['message'] = 'Enter Password';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('confirm_pwd')) == 0 ) {
			$this->data['message'] = 'Enter Confirm Password';
			echo json_encode($this->data); die;
		}
		if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
			$this->data['message'] = "Password confirmation doesn't match Password";
			echo json_encode($this->data); die;
		}

		if (strlen($this->request->getPost('account_number')) != 0 || strlen($this->request->getPost('confirm_account_number')) != 0 ) {
			if ($this->request->getPost('account_number') != $this->request->getPost('confirm_account_number')) {
				$this->data['message'] = "Confirm account number doesn't match Account number";
				echo json_encode($this->data); die;
			}
		}

		$data = array(
			'group_id' => 3,
			'email ' => $this->request->getPost('email'),
			'name' => $this->request->getPost('full_name'),
			'user_name' => $this->request->getPost('username'),
			'mobile' => $this->request->getPost('mobile'),
			'address' => $this->request->getPost('address'),
			'rm_name' => $this->request->getPost('rm_name'),
			'rm_meeting_date' => ($this->request->getPost('rm_meeting_date'))?strtotime($this->request->getPost('rm_meeting_date')):'',
			'rm_discussion_points' => $this->request->getPost('rm_discussion_points'),
			'introducer_commission ' => 0,
			'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
			'activate_hash' => random_string(32),
			'active' => 1,
			'created_at' => strtotime('now'),

		);

		if ($inserted_id = $this->user->insertPersonalDetails($data)) {
			$updateUser = array(
				'member_id' => 'INT'.sprintf("%04d", $inserted_id),
			);
			$this->user->updatePersonalDetails($inserted_id, $updateUser);
			$data = array();
			if ($this->request->getPost('confirm_account_number')) {
				$data = array(
					'user_id ' => $inserted_id,
					'bank_name ' => $this->request->getPost('bank_name'),
					'branch_name ' => $this->request->getPost('branch_name'),
					'account_number ' => $this->request->getPost('confirm_account_number'),
					'ifsc_code ' => $this->request->getPost('ifsc_code'),
					'created_at' => strtotime('now'),
				);

				$last_id = $this->user->insertBankDetails($data);
			}
			if ($inserted_id) {
				$this->data['success'] = true;
				$this->data['message'] = 'Created Succesfully';
				echo json_encode($this->data);
			}
		}
	}

	public function update_introducer($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		
		if ($id != 0 && is_numeric($id)) {
			if (strlen($this->request->getPost('full_name')) == 0 ) {
				$this->data['message'] = 'Enter Full Name';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('email')) != 0 ) {
				if (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
					$this->data['message'] = 'Enter Valid Email';
					echo json_encode($this->data); die;
				}else {
					if (!duplicateUserEmailCheck($this->request->getPost('email'), $id)) {
						$this->data['message'] = 'Duplicate Email found';
						echo json_encode($this->data); die;
					}
				}
			}

			if (strlen($this->request->getPost('username')) == 0 ) {
				$this->data['message'] = 'Enter Username';
				echo json_encode($this->data); die;
			}else{
				if ($this->user->username_exist_in_database($this->request->getPost('username'), $id)) {
					$this->data['message'] = 'Username should be unique';
					echo json_encode($this->data); die;
				}
			}
			

			if (strlen($this->request->getPost('password')) != 0 || strlen($this->request->getPost('confirm_pwd')) != 0) {
				if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
					$this->data['message'] = "Password confirmation doesn't match Password";
					echo json_encode($this->data); die;
				}
			}

			if (strlen($this->request->getPost('account_number')) != 0 || strlen($this->request->getPost('confirm_account_number')) != 0 ) {
				if ($this->request->getPost('account_number') != $this->request->getPost('confirm_account_number')) {
					$this->data['message'] = "Confirm account number doesn't match Account number";
					echo json_encode($this->data); die;
				}
			}

			$data = array(
				'email ' => $this->request->getPost('email'),
				'name' => $this->request->getPost('full_name'),
				'user_name' => $this->request->getPost('username'),
				'mobile' => $this->request->getPost('mobile'),
				'address' => $this->request->getPost('address'),
				'rm_name' => $this->request->getPost('rm_name'),
				'rm_meeting_date' => ($this->request->getPost('rm_meeting_date'))?strtotime($this->request->getPost('rm_meeting_date')):'',
				'rm_discussion_points' => $this->request->getPost('rm_discussion_points'),
				'introducer_commission ' => 0,
				'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
				'updated_at' => strtotime('now'),

			);
			if (strlen($this->request->getPost('confirm_pwd')) == 0) {
				unset($data['password_hash']);
			}
			if ($this->user->updatePersonalDetails($id, $data)) {
				$data = array();
				if ($this->request->getPost('confirm_account_number')) {
					$data = array(
						'user_id ' => $id,
						'bank_name ' => $this->request->getPost('bank_name'),
						'branch_name ' => $this->request->getPost('branch_name'),
						'account_number ' => $this->request->getPost('confirm_account_number'),
						'ifsc_code ' => $this->request->getPost('ifsc_code'),
						'updated_at' => strtotime('now'),
						'created_at' => strtotime('now'),
					);
					if ($this->user->hasBankAccount($id)) {
						unset($data['user_id']);
						unset($data['created_at']);
						$update = $this->user->updateBankDetails($id, $data);
					}else{
						unset($data['updated_at']);
						$this->user->insertBankDetails($data);
					}
				}
				
				$this->data['success'] = true;
				$this->data['message'] = 'Updated Succesfully';
				echo json_encode($this->data);
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
		}
	}

	public function save_investor()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		
		if (strlen($this->request->getPost('full_name')) == 0 ) {
			$this->data['message'] = 'Enter name';
			echo json_encode($this->data); die;
		}

		if (strlen($this->request->getPost('email')) != 0 ) {
			if (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
				$this->data['message'] = 'Enter Valid Email';
				echo json_encode($this->data); die;
			}else {
				if (!duplicateUserEmailCheck($this->request->getPost('email'))) {
					$this->data['message'] = 'Duplicate Email found';
					echo json_encode($this->data); die;
				}
			}
		}
		if (strlen($this->request->getPost('username')) == 0 ) {
			$this->data['message'] = 'Enter Username';
			echo json_encode($this->data); die;
		}else{
			if ($this->user->username_exist_in_database($this->request->getPost('username'))) {
				$this->data['message'] = 'Username should be unique';
				echo json_encode($this->data); die;
			}
		}


		if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
			$this->data['message'] = "Password confirmation doesn't match Password";
			echo json_encode($this->data); die;
		}

		if (strlen($this->request->getPost('account_number')) != 0 || strlen($this->request->getPost('confirm_account_number')) != 0 ) {
			if ($this->request->getPost('account_number') != $this->request->getPost('confirm_account_number')) {
				$this->data['message'] = "Confirm account number doesn't match Account number";
				echo json_encode($this->data); die;
			}
		}

		

		$data = array(
			'group_id' => 2,
			'email ' => $this->request->getPost('email'),
			'name' => $this->request->getPost('full_name'),
			'user_name' => $this->request->getPost('username'),
			'mobile' => $this->request->getPost('mobile'),
			'address' => $this->request->getPost('address'),
			'introducer_id' => $this->request->getPost('introducer')?$this->request->getPost('introducer'):'',
			'rm_name' => $this->request->getPost('rm_name'),
			'rm_meeting_date' => ($this->request->getPost('rm_meeting_date'))?strtotime($this->request->getPost('rm_meeting_date')):'',
			'rm_discussion_points' => $this->request->getPost('rm_discussion_points'),
			'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
			'activate_hash' => random_string(32),
			'active' => 1,
			'created_at' => strtotime('now'),

		);


		if ($inserted_id = $this->user->insertPersonalDetails($data)) {
			$updateUser = array(
				'member_id' => 'INV'.sprintf("%04d", $inserted_id),
			);
			$this->user->updatePersonalDetails($inserted_id, $updateUser);
			$data = array();
			if ($this->request->getPost('confirm_account_number')) {
				$data = array(
					'user_id' => $inserted_id,
					'bank_name' => $this->request->getPost('bank_name'),
					'branch_name' => $this->request->getPost('branch_name'),
					'account_number' => $this->request->getPost('confirm_account_number'),
					'ifsc_code' => $this->request->getPost('ifsc_code'),
					'created_at' => strtotime('now'),
				);
				$last_id = $this->user->insertBankDetails($data);
				$data['id'] = $last_id;
			}

			if ($this->request->getPost('investment_amount') > 0) {
				$data || $data = array();
				$inv_data = array(
					'investor_id' => $inserted_id,
					'introducer_id' => $this->request->getPost('introducer'),
					'investment_amount' => $this->request->getPost('investment_amount'),
					'interest' => $this->request->getPost('interest'),
					'introducer_commission' => $this->request->getPost('introducer_commission'),
					'tds' => $this->request->getPost('tds'),
					'other_charges' => $this->request->getPost('other_charges'),
					'reason_other_charges' => $this->request->getPost('reason_other_charges'),
					'bank_details' => !empty($data)?serialize((object)$data):'',
					'created_at' => strtotime($this->request->getPost('investment_date')),
				);

				if ($last_inv_id = $this->user->insertInvestmentDetails($inv_data)) {
					$inv_tracker_data = array(
						'investment_id' => $last_inv_id,
						'updated_investment_amount' => $this->request->getPost('investment_amount'),
						'created_at' => strtotime('now'),
					);
					$last_inv_tracker_id = $this->user->insertInvestmentTrackerDetails($inv_tracker_data);
				}
			}

			if ($inserted_id) {
				$this->data['success'] = true;
				$this->data['message'] = 'User Created Succesfully';
				echo json_encode($this->data);
			}

		}
	}

	public function add_new_investment($investor_id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();

		if ($investor_id && is_numeric($investor_id)) {

			if (strlen($this->request->getPost('account_number')) == 0 ) {
				$this->data['message'] = 'No Account number was given';
				echo json_encode($this->data); die;
			}else{
				if (!validAccountNumberCheck($this->request->getPost('account_number'))) {
					$this->data['message'] = 'Provide valid account number';
					echo json_encode($this->data); die;
				}
			}

			if (strlen($this->request->getPost('investment_amount')) == 0 ) {
				$this->data['message'] = 'Enter invest amount';
				echo json_encode($this->data); die;
			}
			if ($this->request->getPost('investment_amount') <= 0 ) {
				$this->data['message'] = 'Invest ammount should be greather than zero.';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('tds')) == 0 ) {
				$this->data['message'] = 'Enter tds';
				echo json_encode($this->data); die;
			}

			if (strlen($this->request->getPost('other_charges')) == 0 ) {
				$this->data['message'] = 'Enter other charges';
				echo json_encode($this->data); die;
			}

			if (strlen($this->request->getPost('reason_other_charges')) == 0 ) {
				$this->data['message'] = 'Enter reason of other charges';
				echo json_encode($this->data); die;
			}
			$bank_details = $this->user->getBankDetails($this->request->getPost('account_number'));

			$inv_data = array(
				'investor_id' => $investor_id,
				'bank_details' => serialize($bank_details),
				'introducer_id' => $this->request->getPost('introducer'),
				'investment_amount' => $this->request->getPost('investment_amount'),
				'interest' => $this->request->getPost('interest'),
				'introducer_commission' => $this->request->getPost('commission'),
				'tds' => $this->request->getPost('tds'),
				'other_charges' => $this->request->getPost('other_charges'),
				'reason_other_charges' => $this->request->getPost('reason_other_charges'),
				'created_at' => strtotime($this->request->getPost('investment_date')),
			);

			if ($last_inv_id = $this->user->insertInvestmentDetails($inv_data)) {
				$inv_tracker_data = array(
					'investment_id' => $last_inv_id,
					'updated_investment_amount' => $this->request->getPost('investment_amount'),
					'created_at' => strtotime('now'),
				);
				$last_inv_tracker_id = $this->user->insertInvestmentTrackerDetails($inv_tracker_data);

				$this->data['success'] = True;
				$this->data['message'] = 'Added Successfully';
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went Wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went Wrong!';
			echo json_encode($this->data); die;
		}
	}

	public function update_investor($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();

		if (strlen($this->request->getPost('full_name')) == 0 ) {
			$this->data['message'] = 'Enter Full Name';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('email')) != 0 ) {
			if (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
				$this->data['message'] = 'Enter Valid Email';
				echo json_encode($this->data); die;
			}else {
				if (!duplicateUserEmailCheck($this->request->getPost('email'), $id)) {
					$this->data['message'] = 'Duplicate Email found';
					echo json_encode($this->data); die;
				}
			}
		}
		if (strlen($this->request->getPost('username')) == 0 ) {
			$this->data['message'] = 'Enter Username';
			echo json_encode($this->data); die;
		}else{
			if ($this->user->username_exist_in_database($this->request->getPost('username'), $id)) {
				$this->data['message'] = 'Username should be unique';
				echo json_encode($this->data); die;
			}
		}
		

		if (strlen($this->request->getPost('password')) != 0 || strlen($this->request->getPost('confirm_pwd')) != 0) {
			if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
				$this->data['message'] = "Password confirmation doesn't match Password";
				echo json_encode($this->data); die;
			}
		}

		if (strlen($this->request->getPost('account_number')) != 0 || strlen($this->request->getPost('confirm_account_number')) != 0 ) {
			if ($this->request->getPost('account_number') != $this->request->getPost('confirm_account_number')) {
				$this->data['message'] = "Confirm account number doesn't match Account number";
				echo json_encode($this->data); die;
			}
		}

		$data = array(
			'email ' => $this->request->getPost('email'),
			'name' => $this->request->getPost('full_name'),
			'user_name' => $this->request->getPost('username'),
			'mobile' => $this->request->getPost('mobile'),
			'address' => $this->request->getPost('address'),
			'rm_name' => $this->request->getPost('rm_name'),
			'rm_meeting_date' => ($this->request->getPost('rm_meeting_date'))?strtotime($this->request->getPost('rm_meeting_date')):'',
			'rm_discussion_points' => $this->request->getPost('rm_discussion_points'),
			'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
			'updated_at' => strtotime('now'),

		);
		if (strlen($this->request->getPost('confirm_pwd')) == 0) {
			unset($data['password_hash']);
		}

		if ($update = $this->user->updatePersonalDetails($id, $data)) {

			$data = array();
			if ($this->request->getPost('confirm_account_number')) {
				$data = array(
					'user_id ' => $id,
					'bank_name ' => $this->request->getPost('bank_name'),
					'branch_name ' => $this->request->getPost('branch_name'),
					'account_number ' => $this->request->getPost('confirm_account_number'),
					'ifsc_code ' => $this->request->getPost('ifsc_code'),
					'updated_at' => strtotime('now'),
					'created_at' => strtotime('now'),
				);
				if ($this->user->hasBankAccount($id)) {
					unset($data['user_id']);
					unset($data['created_at']);
					$update = $this->user->updateBankDetails($id, $data);
				}else{
					unset($data['updated_at']);
					$this->user->insertBankDetails($data);
				}
			}
			
			if ($update) {
				$this->data['success'] = true;
				$this->data['message'] = 'Updated Succesfully';
				echo json_encode($this->data);
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}

		}
	}

	public function change_status($value = '', $id = 0)
	{
		if (($value >= 0 && $value <= 1 ) && (is_numeric($id))) {
			$data = array(
				'active' => $value,
				'updated_at' => strtotime('now')
			);
			if ($this->user->updatePersonalDetails($id, $data)) {
				$this->session->setFlashdata('message', 'Status changed.');
				$this->session->setFlashdata('message_type', 'success');
				return redirect()->to($this->request->getUserAgent()->getReferrer());
			}else {
				$this->session->setFlashdata('message', 'Something went wrong!');
				$this->session->setFlashdata('message_type', 'error');
				return redirect()->to($this->request->getUserAgent()->getReferrer());
			}
		}else {
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to($this->request->getUserAgent()->getReferrer());
		}
	}

	public function ajax_get_user_by_id($id = '')
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if (isset($id) && is_numeric($id)) {
			$details = $this->user->getUserById($id);
			if (!empty($details)) {
				$this->data['success'] = true;
				$this->data['details'] = $details;
				if ($details->introducer_id) {
					$this->data['introducer'] = $this->user->getUserById($details->introducer_id);
				}
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}

	public function investment_list()
	{
		$now = strtotime('now');
		$id = $this->request->getPost('investor');
		$month = $this->request->getPost('month');
		$year = $this->request->getPost('year');
		if (!empty($month) && empty($year)) {
			$year = date('Y', $now);
		}
		if (empty($month) && !empty($year)) {
			$month = date('m', $now);
		}
		$firstDayOfMonth = ''; $lastDayOfMonth = '';
		if (!empty($month) && !empty($year)) {
			$firstDayOfMonth = strtotime($year.'-'.$month.'-1');
			$lastDayOfMonth = date("Y-m-t", $firstDayOfMonth);
			$lastDayOfMonth = strtotime($lastDayOfMonth.' 11:59:59');
		}

		$this->data['monthNum'] = $month;
		$this->data['year'] = $year;
		$this->data['title'] = 'Investments';
		$this->data['filteId'] = $id;
		$this->data['users'] = $this->user->getActiveUserByGroup(2);
		$this->data['investments'] = $this->investor->getAllPayments($id, $firstDayOfMonth, $lastDayOfMonth); 
		if (is_numeric($id) && $id) {
			$this->data['details'] = $this->user->getUserById($id);
		}
		return view('users/investment/investments-list', $this->data);
	}


	public function delete_user_by_id()
	{
		$id = $this->request->getPost('id');
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($id && is_numeric($id) ) {
			$data = array(
				'active' => 0,
				'is_deleted' => 0
			);
			if ($this->user->updatePersonalDetails($id, $data)) {
				$this->data['success'] = true;
				$this->data['message'] = 'Deleted successfully';
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}

	public function details($id = 0)
	{
		if ($id && is_admin()) {
			$this->data['search_id'] = strtoupper($id);
			$this->data['details'] = $details = $this->user->getUserByMemberId($id);
			if (!empty($details)) {
				$this->data['head_title'] = 'Profile details of '.$details->name;
				if (is_investor($details->id)) {
					$this->data['title'] = 'Investor Details';
					$this->data['id'] = $id;
					$this->data['documents'] = $this->user->getDocuments($id);
					return view('users/profile/investor-profile', $this->data);
				}elseif (is_introducer($details->id)) {
					$this->data['title'] = 'Introducer Details';
					return view('users/profile/introducer-profile', $this->data);
				}elseif (is_admin($details->id)) {
					$this->data['title'] = 'Users Not Found';
					return view('errors/html/users-not-found', $this->data);
				}
			}else{
				$this->data['title'] = 'Users Not Found';
				return view('errors/html/users-not-found', $this->data);
			}
		}else {
			$this->data['title'] = 'Users Not Found';
			return view('errors/html/users-not-found', $this->data);
		}
	}


	public function relationship_manager_list()
	{
		$this->data['title'] = 'Relationship Manager';
		$this->data['rms'] = $this->user->getAllRm();

		return view('users/relationship-manager/rm-list', $this->data);
	}

	public function add_relationship_manager()
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();

		if (strlen($this->request->getPost('name')) == 0 ) {
			$this->data['message'] = 'Enter Name';
			echo json_encode($this->data); die;
		}
		if (strlen($this->request->getPost('email')) == 0 ) {
			$this->data['message'] = 'Enter Email';
			echo json_encode($this->data); die;
		}elseif (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
			$this->data['message'] = 'Enter Valid Email';
			echo json_encode($this->data); die;
		}else {
			if (!duplicateRmEmailCheck($this->request->getPost('email'))) {
				$this->data['message'] = 'Duplicate Email found';
				echo json_encode($this->data); die;
			}
		}
		if (strlen($this->request->getPost('mobile')) == 0 ) {
			$this->data['message'] = 'Enter mobile number';
			echo json_encode($this->data); die;
		}

		$data = array(
			'email ' => $this->request->getPost('email'),
			'name' => $this->request->getPost('name'),
			'phone' => $this->request->getPost('mobile'),
			'created_at' => strtotime('now'),

		);

		if ($inserted_id = $this->user->insertRmDetails($data)) {
			if ($inserted_id) {
				$this->data['success'] = true;
				$this->data['message'] = 'RM Created Succesfully';
				echo json_encode($this->data);
			}

		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}


	public function update_rm($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($id && is_numeric($id)) {
			if (strlen($this->request->getPost('name')) == 0 ) {
				$this->data['message'] = 'Enter Name';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('email')) == 0 ) {
				$this->data['message'] = 'Enter Email';
				echo json_encode($this->data); die;
			}elseif (!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
				$this->data['message'] = 'Enter Valid Email';
				echo json_encode($this->data); die;
			}else {
				if (!duplicateRmEmailCheck($this->request->getPost('email'), $id)) {
					$this->data['message'] = 'Duplicate Email found';
					echo json_encode($this->data); die;
				}
			}
			if (strlen($this->request->getPost('mobile')) == 0 ) {
				$this->data['message'] = 'Enter mobile number';
				echo json_encode($this->data); die;
			}

			$data = array(
				'email ' => $this->request->getPost('email'),
				'name' => $this->request->getPost('name'),
				'phone' => $this->request->getPost('mobile'),
				'updated_at' => strtotime('now'),
			);

			if ($this->user->updateRmDetails($id, $data)) {
				$this->data['success'] = true;
				$this->data['message'] = 'RM Updated Succesfully';
				echo json_encode($this->data);
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}

	}


	public function ajax_get_rm_by_id($id = '')
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if (isset($id) && is_numeric($id)) {
			$details = $this->user->getRmById($id);
			if (!empty($details)) {
				$this->data['success'] = true;
				$this->data['details'] = $details;
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}

	public function change_password($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if (isset($id) && is_numeric($id) && is_admin()) {
			if (strlen($this->request->getPost('password')) == 0 ) {
				$this->data['message'] = 'Enter Password';
				echo json_encode($this->data); die;
			}
			if (strlen($this->request->getPost('confirm_pwd')) == 0 ) {
				$this->data['message'] = 'Enter Confirm Password';
				echo json_encode($this->data); die;
			}
			if ($this->request->getPost('password') != $this->request->getPost('confirm_pwd')) {
				$this->data['message'] = "Password confirmation doesn't match Password";
				echo json_encode($this->data); die;
			}

			$data = array(
				'password_hash' => password_hash($this->request->getPost('confirm_pwd'), PASSWORD_DEFAULT),
			);
			if ($this->user->updatePersonalDetails($id, $data)) {
				$this->data['success'] = true;
				$this->data['message'] = 'Password has been changed successfully';
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}


	public function documents($id = 0)
	{
		if ($id && is_numeric($id) && is_investor($id)) {
			$this->data['title'] = 'Investor Documents';
			$this->data['id'] = $id;
			$this->data['documents'] = $this->user->getDocuments($id);
			return view('users/investor-docs', $this->data);
		}else{
			$this->session->setFlashdata('message', 'Something went wrong!');
			$this->session->setFlashdata('message_type', 'error');
			return redirect()->to('/users/investor');
		}
	}

	function upload_docs($id = 0)
	{
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if (isset($id) && is_numeric($id) && is_admin()) {
			$path = 'upload/documents';
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
				$name='';
				if (strlen($tmp_name) != 0 ) {
					$doc_title = $_POST['document_title'][$key];
					$doc_name = $_FILES['documents']['name'][$key];
					$doc_array = explode('.',$doc_name);
					$ext = end($doc_array);
					$name = preg_replace('/\s+/', '', $doc_title).'-'.time().'.'.$ext;
					if (move_uploaded_file($tmp_name, $path.'/'.$name)) {
						$data = array(
							'investor_id' => $id,
							'title' => $doc_title,
							'file' => $name,
							'created_at' => strtotime('now'),
						);

						$inserted_id = $this->user->uploadInvestorDocs($data);
					}
				}
			}

			if ($inserted_id) {
				$this->data['success'] = true;
				$this->data['message'] = 'Documents has been uploaded successfully.';
				echo json_encode($this->data); die;
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}


	public function delete_doc()
	{
		$id = $this->request->getPost('id');
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($id && is_numeric($id) ) {
			$details = $this->user->getDocuments('', $id);
			$path = 'upload/documents/';

			if (unlink($path.$details[0]->file)) {
				if ($this->user->deleteDoc($id)) {
					$this->data['success'] = true;
					$this->data['message'] = 'Deleted successfully';
					echo json_encode($this->data); die;
				}else{
					$this->data['message'] = 'Something went wrong!';
					echo json_encode($this->data); die;
				}
			}else{
				$this->data['message'] = 'Something went wrong!';
				echo json_encode($this->data); die;
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data); die;
		}
	}

	public function generateUniqueUserName(){
		$name = $this->request->getPost('name');
		$this->data['success'] = false;
		$this->data['hash'] = csrf_hash();
		if ($name != '') {
			$username = $this->generate_unique_username($name);
			if ($username) {
				$this->data['success'] = true;
				$this->data['username'] = $username;
				echo json_encode($this->data);
			}
		}else{
			$this->data['message'] = 'Something went wrong!';
			echo json_encode($this->data);
		}
	}


	function generate_unique_username($string_name="", $rand_no = 10000){
		while(true){
			$username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
			$username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

			$part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
			$part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
			$i = false;
			while ( $i == false ) {
				$part3 = ($rand_no)?rand(0, $rand_no):"";
				$username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters
				$username_exist_in_db = $this->user->username_exist_in_database($username); //check username in databas
				if(!$username_exist_in_db){
					$i = true;
				}
			}
			return $username;
		}
	}

}
