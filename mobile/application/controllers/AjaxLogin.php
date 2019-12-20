<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxLogin extends CI_Controller {

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
		$this->load->model('Ajax_Model');
		// if($this->session->userdata('botUserData') != NULL)
		// {
		// 	redirect('SelectSimulation');
		// }
	}

	public function verifyLogin()
	{
		// echo $User_email.' and '.$Auth_password.'<br>';
		$User_email    = $this->input->post('User_email');
		$Auth_password = $this->input->post('Auth_password');
		$result        = $this->Ajax_Model->verifyLogin($User_email,$Auth_password);
		die(json_encode($result));
	}
}
