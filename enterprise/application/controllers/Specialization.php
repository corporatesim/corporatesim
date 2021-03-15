<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialization extends MY_Controller {

  public function __construct(){
    parent::__construct();
    if($this->session->userdata('loginData') == NULL){
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index(){
    if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    $query = "SELECT gus.US_ID, gus.US_Name FROM GAME_USER_SPECIALIZATION gus ORDER BY gus.US_Name ASC";
    $specialization = $this->Common_Model->executeQuery($query);

    $content['specialization'] = $specialization;

    $content['subview'] = 'specialization';
    $this->load->view('main_layout',$content);
  } //end of index function

  public function deleteSpecialization($id=NULL, $redirect=NULL){
    $specialization_Id = base64_decode($id);

    if(empty($specialization_Id)){
      $this->session->set_flashdata('er_msg', 'No Specialization Selected To Delete');
      redirect("Specialization", "refresh");
    } 
    else{
      $where = array('US_ID' => $specialization_Id);
      $del = $this->Common_Model->deleteRecords('GAME_USER_SPECIALIZATION', $where);
      $this->session->set_flashdata('tr_msg', 'Specialization Deleted Successfully');
      redirect("Specialization", "refresh");
    }
  }
  
}