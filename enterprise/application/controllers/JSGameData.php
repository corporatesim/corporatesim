<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JSGameData extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    $query = "SELECT ujsgd.JSDATA_Id, ujsgd.JSDATA_JsGameName, ujsgd.JSDATA_CreatedOn, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, jsg.Js_Name, gsce.Scen_Name, gg.Game_Name
    FROM GAME_USER_JSGAME_DATA ujsgd 
    LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = ujsgd.JSDATA_UserId
    LEFT JOIN GAME_JSGAME jsg ON jsg.Js_id = ujsgd.JSDATA_JsGameId
    LEFT JOIN GAME_GAME gg ON gg.Game_ID = jsg.Js_GameId
    LEFT JOIN GAME_SCENARIO gsce ON gsce.Scen_ID = ujsgd.JSDATA_ScenId
    ORDER BY ujsgd.JSDATA_Id DESC";
    $details = $this->Common_Model->executeQuery($query);

    $content['details'] = $details;

    $content['subview'] = 'jsGameData';
    $this->load->view('main_layout', $content);
  }

}
