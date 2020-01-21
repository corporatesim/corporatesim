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
		if($this->session->userdata('botUserData') != NULL)
		{
			redirect('SelectSimulation');
		}
		// echo "<pre>";  print_r($this->config); exit();
	}

	public function index()
	{
		$content['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		// fetch the logo of the ent or subent, according to base url ('http://'.$_SERVER['SERVER_NAME'].'/mobile/')
		$current_url        = 'https://'.$_SERVER['SERVER_NAME'];
		$logo               = $this->Common_Model->fetchLogo($current_url);
		$content['logo']    = $logo;
		$content['subview'] = 'login';
		$this->load->view('main_layout',$content);
	}

	public function logOut()
	{
		session_destroy();
		$this->session->set_flashdata('tr_msg', 'Logged out successfully');
		redirect('Login');
	}
}
