<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/header');
if(!empty($this->session->userdata('botUserData'))){
	if(!@$navigation)
	{
		// if $navigation is not defined then show naviation
		$this->load->view('includes/navigation');
	}
}
$this->load->view('components/'.$subview);
$this->load->view('includes/footer');
