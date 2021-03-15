<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campus extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    $query = "SELECT guc.UC_ID, guc.UC_Name, guc.UC_Type, guc.UC_Address, guc.UC_Email, guc.UC_Contact FROM GAME_USER_CAMPUS guc ORDER BY guc.UC_Name ASC";
    $campus = $this->Common_Model->executeQuery($query);

    $content['campus'] = $campus;

    $content['subview'] = 'campus';
    $this->load->view('main_layout',$content);
  } //end of index function

  public function SelectCampus() {
    $query = "SELECT guc.UC_ID, guc.UC_Name, guc.UC_Type, guc.UC_Address, guc.UC_Email, guc.UC_Contact, gec.ECampus_CampusID, gec.ECampus_UpdatedOn, gec.ECampus_Selected FROM GAME_USER_CAMPUS guc LEFT JOIN GAME_ENTERPRISE_CAMPUS gec ON gec.ECampus_CampusID = guc.UC_ID ORDER BY gec.ECampus_CampusID DESC, guc.UC_Name ASC";
    $campus = $this->Common_Model->executeQuery($query);
    //echo "<pre>"; print_r($query); print_r($campus); exit();

    $content['campus'] = $campus;

    $content['subview'] = 'selectCampus';
    $this->load->view('main_layout',$content);
  } //end of SelectCampus function

  public function campusSelectedByEnterprise() {
    $RequestMethod = $this->input->server('REQUEST_METHOD');

    if ($RequestMethod == 'POST') {
      //echo "<pre>"; print_r($this->input->post()); exit();
      $enterpriseID     = $this->session->userdata('loginData')['User_ParentId'];
      $selectedCampus   = $this->input->post('selectCampus');
      $campusCount      = count($selectedCampus);
      //echo "<pre>"; print_r($selectedCampus); print_r($campusCount); exit();

      //setting all existing campus select value to 0-> not selected
      $updateWhere = array('ECampus_EnterpriseID' => $enterpriseID);
      $updateArray = array(
        'ECampus_Selected' => 0,
        'ECampus_UpdatedOn' => date('Y-m-d H:i:s')
      );
      $result      = $this->Common_Model->updateRecords('GAME_ENTERPRISE_CAMPUS', $updateArray, $updateWhere);

      if ($campusCount > 0) {
        // Insert New Selected Campus for enterprise
        for ($i=0; $i<$campusCount; $i++) {
          //selecting campuses data
          $query = "SELECT gec.ECAMPUS_ID FROM GAME_ENTERPRISE_CAMPUS gec WHERE gec.ECampus_CampusID = $selectedCampus[$i] AND gec.ECampus_EnterpriseID = $enterpriseID";
          $campusData = $this->Common_Model->executeQuery($query);
          //print_r($campusData[0]->ECAMPUS_ID); exit();

          //if campus found then update else insert new record
          if (!empty($campusData[0]->ECAMPUS_ID)) {
            $updateWhere = array('ECAMPUS_ID' => $campusData[0]->ECAMPUS_ID);
            $updateArray = array(
              'ECampus_Selected' => 1,
              'ECampus_UpdatedOn' => date('Y-m-d H:i:s')
            );
            $result = $this->Common_Model->updateRecords('GAME_ENTERPRISE_CAMPUS', $updateArray, $updateWhere);
          }
          else {
            $insertEnterpriseCampus = array(
              'ECampus_EnterpriseID' => $enterpriseID,
              'ECampus_CampusID'     => $selectedCampus[$i],
              'ECampus_CreatedOn'    => date('Y-m-d H:i:s'),
              'ECampus_UpdatedOn'    => date('Y-m-d H:i:s'),
              'ECampus_CreatedBy'    => $this->session->userdata('loginData')['User_Id'],
            );
            //print_r($insertEnterpriseCampus); exit();
            $result = $this->Common_Model->insert('GAME_ENTERPRISE_CAMPUS', $insertEnterpriseCampus);
          }
        } //end of loop
        $this->session->set_flashdata("tr_msg","Campus Selected Successfully." );
      }
      else {
        $this->session->set_flashdata('tr_msg', 'All Campus removed Successfully.');
      }
      redirect('Campus/myCampus');
    }
  } //end of function campusSelectedByEnterprise

  public function myCampus() {
    $query = "SELECT guc.UC_ID, guc.UC_Name, guc.UC_Type, guc.UC_Address, guc.UC_Email, guc.UC_Contact, gec.ECampus_CampusID, gec.ECampus_UpdatedOn FROM GAME_ENTERPRISE_CAMPUS gec LEFT JOIN GAME_USER_CAMPUS guc ON gec.ECampus_CampusID = guc.UC_ID WHERE gec.ECampus_Selected = 1 ORDER BY guc.UC_Name ASC";
    //$query = "SELECT guc.UC_ID, guc.UC_Name, guc.UC_Address, guc.UC_Email, guc.UC_Contact, gec.ECampus_CampusID FROM GAME_USER_CAMPUS guc LEFT JOIN GAME_ENTERPRISE_CAMPUS gec ON gec.ECampus_CampusID = guc.UC_ID ORDER BY guc.UC_Name ASC";
    $campus = $this->Common_Model->executeQuery($query);
    //echo "<pre>"; print_r($query); print_r($campus); exit();

    $content['campus'] = $campus;

    $content['subview'] = 'myCampus';
    $this->load->view('main_layout',$content);
  } //end of myCampus function

  public function deleteCampus($id=NULL, $redirect=NULL) {
    $campus_Id = base64_decode($id);

    if(empty($campus_Id)) {
      $this->session->set_flashdata('er_msg', 'No Campus Selected To Delete');
      redirect("Campus", "refresh");
    } 
    else {
      //deleting campus that is mapped with user
      $where  = array('ECampus_CampusID' => $campus_Id);
      $delete = $this->Common_Model->deleteRecords('GAME_ENTERPRISE_CAMPUS', $where);

      //deleting campus
      $where = array('UC_ID' => $campus_Id);
      $del = $this->Common_Model->deleteRecords('GAME_USER_CAMPUS', $where);
      $this->session->set_flashdata('tr_msg', 'Campus Deleted Successfully');
      redirect("Campus", "refresh");
    }
  }
  
}