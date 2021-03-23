<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportFive extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') {
      // fetching all Enterprise list
      $enterprisewhere = array(
        'Enterprise_Status' => 0,
      );
      $enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
      $content['enterpriseDetails'] = $enterpriseDetails;

      // fetching all formula list
      $formulawhere = array(
        //'Items_Formula_Enterprise_Id' => $enterprise_ID,
      );
      $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulawhere, 'Items_Formula_Id, Items_Formula_Title', 'Items_Formula_Title');
      $content['formulaDetails'] = $formulaDetails;
      
      $content['usersDetails']      = '';
    }
    else if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $enterprise_ID = $this->session->userdata('loginData')['User_Id'];

      $enterprisewhere = array(
        'Enterprise_ID'     => $enterprise_ID,
        'Enterprise_Status' => 0,
      );
      $enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
      $content['enterpriseDetails'] = $enterpriseDetails;

      // fetching all formula list for loged in enterprise
      $formulawhere = array(
        'Items_Formula_Enterprise_Id' => $enterprise_ID,
      );
      $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulawhere, 'Items_Formula_Id, Items_Formula_Title', 'Items_Formula_Title');
      $content['formulaDetails'] = $formulaDetails;

      //fetching all Users assigned to this enterprise
      $enterpriseUserQuery ="SELECT gu.User_id, CONCAT(gu.User_fname, ' ', gu.User_lname) AS User_fullName, gu.User_username FROM GAME_SITE_USERS gu WHERE gu.User_Role = 1 AND gu.User_Delete = 0 AND gu.User_ParentId = $enterprise_ID ORDER BY gu.User_fname, gu.User_lname ASC";
      $enterpriseUserList = $this->Common_Model->executeQuery($enterpriseUserQuery);
      //print_r($this->db->last_query()); exit();
      $content['usersDetails'] = $enterpriseUserList;
    }

    $content['subview']  = 'reportFive';
    $this->load->view('main_layout', $content);
  } // end of index function
} // end of ReportFive class 
