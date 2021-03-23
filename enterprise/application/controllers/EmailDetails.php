<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailDetails extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  // Show email Details
  public function index() {
    $query = "SELECT esd.ESD_ID, esd.ESD_To, esd.ESD_DateTime, esd.ESD_Status, ent.Enterprise_Name
    FROM GAME_EMAIL_SEND_DETAILS esd 
    LEFT JOIN GAME_ENTERPRISE ent ON ent.Enterprise_ID = esd.ESD_EnterprizeID
    ORDER BY esd.ESD_ID DESC";
    $details = $this->Common_Model->executeQuery($query);
    $content['details'] = $details;
  
    $content['subview'] = 'emailDetails';
    $this->load->view('main_layout',$content);
  } // end of index function
}
