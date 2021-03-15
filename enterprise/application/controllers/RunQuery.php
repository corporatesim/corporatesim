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

      // $query1 = "";
      // $runQuery1 = $this->Common_Model->executeQuery($query1, 'noReturn'); 

      // $query2 = "";
      // $runQuery2 = $this->Common_Model->executeQuery($query2, 'noReturn'); 

      // $query3 = "";
      // $runQuery3 = $this->Common_Model->executeQuery($query2, 'noReturn'); 

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
    $fields = $this->db->field_data('GAME_EMAIL_SEND_DETAILS');

    foreach ($fields as $field){
       echo $field->name.'-';
       echo $field->type.'-';
       echo $field->max_length.'-';
       echo $field->primary_key;
       echo '<br />';
    }
  }

  public function checkTableData() {
    $query = "SELECT * FROM GAME_ITEM_REPORT";
    $queryResult = $this->Common_Model->executeQuery($query);
    // print_r($query); print_r(count($queryResult)); exit();
    // print_r($queryResult); exit();

    echo '<table><tr> <td>IR_ID</td>  <td>IR_Formula_Enterprize_ID</td>  <td>IR_Type_Choice</td>  <td>IR_Condition_Type</td>';
    foreach ($queryResult as $rows) {
       echo '<tr><td>'.$rows->IR_ID.'</td>';
       echo '<td>'.$rows->IR_Formula_Enterprize_ID.'</td>';
       echo '<td>'.$rows->IR_Type_Choice.'</td>';
       echo '<td>'.$rows->IR_Condition_Type.'</td></tr>';
    }
    echo '</table>';
  }
}
