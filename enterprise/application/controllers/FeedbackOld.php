<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedbackOld extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    $content['backgroundColor'] = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)');

    $content['borderColor']     = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)');

    $years = array('2017', '2018', '2019', '2020', '2021', '2022');
    
    // graph data-set
    $titleArray = array('Enterprise', 'Sub-Enterprise', 'Enterprise-Users', 'SubEnterprise-Users');
    $colArray   = array('Enterprise_CreatedOn', 'SubEnterprise_CreatedOn', 'User_datetime', 'User_datetime');
    $tableArray = array('GAME_ENTERPRISE', 'GAME_SUBENTERPRISE', 'GAME_SITE_USERS', 'GAME_SITE_USERS');
    $chartData  = array();

    for ($i = 0; $i < count($titleArray); $i++) {
        $graphSql = "SELECT '" . $titleArray[$i] . "' AS Title, COUNT(*) AS Count, EXTRACT(YEAR FROM " . $colArray[$i] . ") AS Year FROM `" . $tableArray[$i] . "`";
        switch ($titleArray[$i]) {
          case 'Enterprise-Users':
            $graphSql .= " WHERE User_Role=1 ";
            break;
          case 'SubEnterprise-Users':
            $graphSql .= " WHERE User_Role=2 ";
            break;
        }
        $graphSql    .= " GROUP BY Year ORDER BY Year ASC";
        $dataChart    = $this->Common_Model->executeQuery($graphSql);
        $dataNotFound = array_search($dataChart[0]->Year, $years);
        // echo ($dataNotFound)?$dataNotFound.' and '.$dataChart[0]->Title.'<br>':'';
        switch ($dataNotFound) {
          case 1:
            array_unshift($dataChart, (object) array('Title' => $dataChart[0]->Title, 'Count' => 0, 'Year' => 2017));
            break;

          case 2:
            array_unshift($dataChart, (object) array('Title' => $dataChart[0]->Title, 'Count' => 0, 'Year' => 2018));
            array_unshift($dataChart, (object) array('Title' => $dataChart[0]->Title, 'Count' => 0, 'Year' => 2017));
            break;
        }

        $chartData[]  = $dataChart;
      }

      // echo "<pre>"; print_r($chartData); exit();
      $content['chartData'] = $chartData;

    $content['years']        = $years;

    $gameFeedback            = $this->Common_Model->fetchRecords('GAME_FEEDBACK', NULL, NULL, 'Feedback_id DESC', NULL);
    $content['gameFeedback'] = $gameFeedback;

    $content['subview']  = 'feedbackOld';
    $this->load->view('main_layout', $content);
  } // end of index function
} // end of FeedbackOld class 
