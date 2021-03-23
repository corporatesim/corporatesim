<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportOne extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    // echo "<pre>"; print_r($this->session->userdata('loginData'));
    $loginId = $this->session->userdata('loginData')['User_Id'];

    // Setting user Role
    // superadmin, 1=Enterprize, 2=SubEnterprize, 3=Report Viewer
    $userRole = $this->session->userdata('loginData')['User_Role']; 

    if ($userRole == 1) {
      // if user is enterprise
      $where = array(
        'Enterprise_Status' => 0,
        'Enterprise_ID'     => $loginId
      );
      $subWhere = array(
        'SubEnterprise_Status'       => 0,
        'SubEnterprise_EnterpriseID' => $loginId
      );
      $gameQuery = "SELECT * FROM GAME_ENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID = ge.EG_GameID WHERE gg.Game_Delete = 0 AND ge.EG_EnterpriseID = ".$loginId." ORDER BY gg.Game_Name";
    }
    else if ($userRole == 2) {
      // if user is subenterprise
      $where = array(
        'Enterprise_Status' => 0,
        'Enterprise_ID'     => $this->session->userdata('loginData')['User_ParentId']
      );
      $subWhere = array(
        'SubEnterprise_Status'       => 0,
        'SubEnterprise_EnterpriseID' => $this->session->userdata('loginData')['User_ParentId'],
        'SubEnterprise_ID'           => $loginId
      );
      $gameQuery = "SELECT * FROM GAME_SUBENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID = ge.SG_GameID WHERE Game_Delete = 0 AND ge.SG_SubEnterpriseID = ".$loginId." ORDER BY gg.Game_Name";
    }
    else if ($userRole == 3) {
      // Setting report Viewer Enterprize ID
      $loginEnterprizeID = $this->session->userdata('loginData')['User_ParentId'];
      
      // if user is Report Viewer
      $where = array(
        'Enterprise_Status' => 0,
        'Enterprise_ID'     => $loginEnterprizeID
      );
      $subWhere = array(
        'SubEnterprise_Status'       => 0,
        'SubEnterprise_EnterpriseID' => $loginEnterprizeID
      );

      // $gameQuery = "SELECT * FROM GAME_ENTERPRISE_GAME ge 
      //   LEFT JOIN GAME_GAME gg ON gg.Game_ID = ge.EG_GameID 
      //   WHERE gg.Game_Delete = 0 AND ge.EG_EnterpriseID = ".$loginEnterprizeID." 
      //   ORDER BY gg.Game_Name";

      $gameQuery = "SELECT * 
      FROM GAME_ENTERPRISE_GAME ge 
      LEFT JOIN GAME_GAME gg ON gg.Game_ID = ge.EG_GameID 
      LEFT JOIN GAME_REPORT_VIEWER_CARD_ACCESS rvca ON rvca.RVCA_Game_ID = gg.Game_ID AND rvca.RVCA_RV_ID = $loginId
      WHERE gg.Game_Delete = 0 AND ge.EG_EnterpriseID = $loginEnterprizeID AND rvca.RVCA_RV_ID = $loginId
      ORDER BY gg.Game_Name";
      // print_r($gameQuery); exit();
    }
    else {
      // user is supperadmin
      $where = array(
        'Enterprise_Status' => 0,
      );
      $subWhere = array(
        'SubEnterprise_Status' => 0,
      );
      $gameQuery = "SELECT * FROM GAME_GAME WHERE Game_Delete = 0 ORDER BY Game_Name";
    }

    $EnterpriseName            = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $where, '', 'Enterprise_Name');
    $content['EnterpriseName'] = $EnterpriseName;
    $SubEnterprise             = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE', $subWhere, '', 'SubEnterprise_Name');
    $content['SubEnterprise']  = $SubEnterprise;
    $gameData                  = $this->Common_Model->executeQuery($gameQuery);
    $content['gameData']       = $gameData;

    $content['subview']        = 'reportOne';
    $this->load->view('main_layout',$content);
  }
}
