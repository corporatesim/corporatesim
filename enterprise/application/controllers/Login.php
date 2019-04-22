<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loginData') != NULL)
		{
			redirect('dashboard');
		}
	}

	public function index()
	{
		// show login page
		$this->login();
	}

	public function login()
	{
		// show login page
		$content['subview'] = 'login';
		$this->load->view('components/login');
	}

	public function signUp()
	{
		// show signup page
		$this->session->set_flashdata('er_msg', 'You need to contact admin to crate account');
		redirect('login');
		$content['subview'] = 'signUp';
		$this->load->view('components/signUp');
	}

	public function requestPassword()
	{
		// save user details and go to login screen
		$content['subview'] = 'requestPassword';
		$this->load->view('components/requestPassword');
	}

	public function resetPassword()
	{
		// save user details and go to login screen
		$content['subview'] = 'resetPassword';
		$this->load->view('components/resetPassword');
	}

	public function verifyLogin()
	{
		// verify user details with our database
		// if logged in successfully then redirect to dashboard
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			$Users_Email    = $this->input->post('Users_Email');
			$Users_Password = $this->input->post('Users_Password');
			$result         = $this->Common_Model->verifyLogin($Users_Email,$Users_Password);
			// echo "<pre>"; print_r($result); exit;
			if($result != 'error')
			{
				// getting records from database and setting the sessions
				switch ($result->User_Role) {
					case 'superadmin':
					$loginData = array(
						'User_Id'       => $result->User_Id,
						'User_FullName' => $result->User_FullName,
						'User_Username' => $result->User_Username,
						'User_Email'    => $result->User_Email,
						'User_Mobile'   => $result->User_Mobile,
						'User_Role'     => $result->User_Role,
					);
					break;

					case 'enterprise':
					$loginData         = array(
						'User_Id'            => $result->Enterprise_ID,
						'User_FullName'      => $result->Enterprise_Name,
						'User_Username'      => $result->Enterprise_Name,
						'User_Email'         => $result->Enterprise_Email,
						'User_Mobile'        => $result->Enterprise_Number,
						'User_games'         => $result->Enterprise_Games,
						'User_ParentId'      => $result->Enterprise_ID,
						'User_SubParentId'   => $result->Enterprise_ID,
						'User_profile_pic'   => $result->Enterprise_Logo,
						'User_Role'          => 1,
						'Enterprise_Name'    => $result->Enterprise_Name,
						// 'SubEnterprise_Name' =>$result->SubEnterprise_Name,
						// 'User_lastlogin'     => $result->User_lastlogin,
					);
					break;

					case 'subenterprise':
					$loginData         = array(
						'User_Id'            => $result->SubEnterprise_ID,
						'User_FullName'      => $result->SubEnterprise_Name,
						'User_Username'      => $result->SubEnterprise_Name,
						'User_Email'         => $result->SubEnterprise_Email,
						'User_Mobile'        => $result->SubEnterprise_Number,
						'User_games'         => $result->SubEnterprise_Games,
						'User_ParentId'      => $result->SubEnterprise_EnterpriseID,
						'User_SubParentId'   => $result->SubEnterprise_ID,
						'User_profile_pic'   => $result->SubEnterprise_Logo,
						'User_Role'          => 2,
						// 'Enterprise_Name'    => $result->Enterprise_Name,
						'SubEnterprise_Name' => $result->SubEnterprise_Name,
						// 'User_lastlogin'     => $result->User_lastlogin,
					);
					break;
				}
				 // echo "<pre>"; print_r($loginData); exit;
				$this->session->set_userdata('loginData',$loginData);
				redirect('dashboard');
			}
			else
			{
				$this->session->set_flashdata('er_msg', 'Invalid Credintials');
				redirect('login');
			}
		}
		// if form is not submitted
		$this->session->set_flashdata('er_msg', 'Please Provide Login Details');
		redirect('login');
	}

	public function logOut()
	{
		session_destroy();
		redirect('Dashboard');
	}

}
