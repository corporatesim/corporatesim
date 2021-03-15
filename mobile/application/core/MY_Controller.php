<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	// to check and return the csrf tocken for multiple ajax request
	public $csrfHash;
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		error_reporting(0);
		ini_set('display_errors', 0);
		$this->csrfHash = $this->security->get_csrf_hash();
		if($this->session->userdata('botUserData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login');
		}
	}
}


