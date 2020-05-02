<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RunQuery extends MY_Controller {
  public function __construct() {
    parent::__construct();
    // if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
    //  $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"'.$this->router->fetch_class().'"</b> page');
    //  redirect('Dashboard');
    // }
    ini_set('display_errors', 'On');
    error_reporting(-1);
    define('MP_DB_DEBUG', true);
  }

  public function index() {
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }
    else {
      // query

      //$query1 = "";
      //$runQuery1 = $this->Common_Model->executeQuery($query1, 'noReturn'); 
      //print_r($runQuery1); exit();

      //$query2 = "";
      //$runQuery2 = $this->Common_Model->executeQuery($query2, 'noReturn'); 
      //print_r($runQuery2); exit();

      //$content['runQuery1'] = $runQuery1;
      //$content['runQuery2'] = $runQuery2;

      $content['subview']    = 'runQuery';
      $this->load->view('main_layout', $content);
    }
  }

  public function checkTables() {
    $tables = $this->db->list_tables();

    foreach ($tables as $table){
       echo $table;
       echo '<br />';
    }
  }

  public function checkTableColumns() {
    $fields = $this->db->field_data('GAME_ENTERPRISE_CAMPUS');

    foreach ($fields as $field){
       echo $field->name.'-';
       echo $field->type.'-';
       echo $field->max_length.'-';
       echo $field->primary_key;
       echo '<br />';
    }
  }
}
