<?php
namespace Auth\Controllers;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use Auth\Models\UserModel;

class LoginController extends Controller
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Authentication settings.
	 */
	protected $config;


    //--------------------------------------------------------------------

	public function __construct()
	{
		// start session
		$this->session = Services::session();

		// load auth settings
		$this->config = config('Auth');
	}

    //--------------------------------------------------------------------

	/**
	 * Displays login form or redirects if user is already logged in.
	 */
	public function login()
	{
		if ($this->session->isLoggedIn) {
			if ($this->session->userData['group_id'] == 1) {
				return redirect()->to('dashboard');
			}elseif ($this->session->userData['group_id'] == 2) {
				return redirect()->to('investors');
			}elseif ($this->session->userData['group_id'] == 3) {
				return redirect()->to('introducers');
			}
			
		}

		return view($this->config->views['login'], ['config' => $this->config]);
	}

    //--------------------------------------------------------------------

	/**
	 * Attempts to verify user's credentials through POST request.
	 */
	public function attemptLogin()
	{
		// validate request
		// print_r($this->request->getVar());
		$rules = [
			'email'		=> 'required',
			'password' 	=> 'required|min_length[5]',
		];

		if (! $this->validate($rules)) {
			return redirect()->to('login')
			->withInput()
			->with('errors', $this->validator->getErrors());
		}

		// check credentials
		$users = new UserModel();
		$user = $users->where('email', $this->request->getPost('email'))->first();
		$user || $user = $users->where('user_name', $this->request->getPost('email'))->first();
		if (
			is_null($user) ||
			! password_verify($this->request->getPost('password'), $user['password_hash'])
		) {
			return redirect()->to('login')->withInput()->with('error', lang('Auth.wrongCredentials'));
		}

		// check activation
		if (!$user['active'] || !$user['is_deleted']) {
			return redirect()->to('login')->withInput()->with('error', lang('Auth.notActivated'));
		}

		// login OK, save user data to session
		$this->session->set('isLoggedIn', true);
		$this->session->set('userData', [
			'id' 			=> $user['id'],
			'group_id' 			=> $user['group_id'],
			'name' 			=> $user['name'],
			'email' 		=> $user['email'],
			'new_email' 	=> $user['new_email']
		]);
		if ($user['group_id'] == 3) {
			return redirect()->to('introducers');
		}elseif($user['group_id'] == 1){
			return redirect()->to('dashboard');
		}else{
			return redirect()->to('investors');
		}
		
	}

    //--------------------------------------------------------------------

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		$this->session->remove(['isLoggedIn', 'userData']);

		return redirect()->to('login');
	}

}
