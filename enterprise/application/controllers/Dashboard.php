<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	private $loginData;
	public function __construct() {
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
		if ($this->loginData == NULL) {
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login/login');
		}
	}

	public function index() {
    if ($this->session->userdata('loginData')['User_Role'] == 'superadmin' || $this->session->userdata('loginData')['User_Role'] == 2) {

		  $content['subview'] = 'dashboard';
    }
    else {
      //showing only for enterprise
      if ($this->session->userdata('loginData')['User_Role'] == 3) {
        // if report viewer login
        $enterprise_ID = $this->session->userdata('loginData')['User_ParentId'];
      }
      else {
        // if enterprize login
        $enterprise_ID = $this->session->userdata('loginData')['User_Id'];
      }

      //counting all cards assigned to enterprise
      $content['allCardAssigned'] = $this->Common_Model->findCount('GAME_ENTERPRISE_CARD', array('EC_EnterpriseID' => $enterprise_ID));

      //counting all cards chosen by enterprise
      $content['chosenCard'] = $this->Common_Model->findCount('GAME_ENTERPRISE_CARD', array('EC_EnterpriseID' => $enterprise_ID, 'EC_Enterprise_Selected' => 1));

      //counting all cards allocated to enterprise
      $content['allocatedCard'] = $this->Common_Model->findCount('GAME_ENTERPRISE_GAME', array('EG_EnterpriseID' => $enterprise_ID));

      // counting all Available Campus
      $content['availableCampus'] = $this->Common_Model->findCount('GAME_USER_CAMPUS', array());

      // counting all Campus Chosen By enterprise
      $content['chosenCampus'] = $this->Common_Model->findCount('GAME_ENTERPRISE_CAMPUS', array('ECampus_EnterpriseID' => $enterprise_ID, 'ECampus_Selected' => 1));

      // UC_Type => 1->Management 2-> Engineering 3-> Other
      $queryManagement = "SELECT COUNT(*) AS total 
          FROM GAME_ENTERPRISE_CAMPUS gec 
          LEFT JOIN GAME_USER_CAMPUS guc ON guc.UC_ID = gec.ECampus_CampusID
          WHERE gec.ECampus_EnterpriseID = $enterprise_ID AND gec.ECampus_Selected = 1 AND guc.UC_Type = 1";
      $countManagement = $this->Common_Model->executeQuery($queryManagement);
      // print_r($countManagement[0]->total); exit();
      $content['campusManagement'] = $countManagement[0]->total;

      // UC_Type => 1->Management 2-> Engineering 3-> Other
      $queryEngineering = "SELECT COUNT(*) AS total 
          FROM GAME_ENTERPRISE_CAMPUS gec 
          LEFT JOIN GAME_USER_CAMPUS guc ON guc.UC_ID = gec.ECampus_CampusID
          WHERE gec.ECampus_EnterpriseID = $enterprise_ID AND gec.ECampus_Selected = 1 AND guc.UC_Type = 2";
      $countEngineering = $this->Common_Model->executeQuery($queryEngineering);
      // print_r($countEngineering[0]->total); exit();
      $content['campusEngineering'] = $countEngineering[0]->total;

      // UC_Type => 1->Management 2-> Engineering 3-> Other
      $queryOther = "SELECT COUNT(*) AS total 
          FROM GAME_ENTERPRISE_CAMPUS gec 
          LEFT JOIN GAME_USER_CAMPUS guc ON guc.UC_ID = gec.ECampus_CampusID
          WHERE gec.ECampus_EnterpriseID = $enterprise_ID AND gec.ECampus_Selected = 1 AND guc.UC_Type = 3";
      $countOther = $this->Common_Model->executeQuery($queryOther);
      // print_r($countOther[0]->total); exit();
      $content['campusOther'] = $countOther[0]->total;

      //===========================================================
      // fetching all formula list for loged in enterprise
      $formulawhere = array('Items_Formula_Enterprise_Id' => $enterprise_ID);
      $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulawhere, 'Items_Formula_Id, Items_Formula_Title', 'Items_Formula_Title');
      $content['formulaDetails'] = $formulaDetails;

      $content['subview'] = 'processOwnerDashboard';
    }
		$this->load->view('main_layout', $content);
	}

	public function assignedCards()
	{
		// adding this new fuction to show allocated games/cards, instead of dashboard
		// $activeEnterprise           = "";
		// $deactiveEnterprise         = "";
		// $activeSubEnterprise        = "";
		// $deactiveSubEnterprise      = "";
		// $activeEnterpriseUsers      = "";
		// $deactiveEnterpriseUsers    = "";
		// $activeSubEnterpriseUsers   = "";
		// $deactiveSubEnterpriseUsers = "";
		$content['totalEnterprise']         = $this->Common_Model->findCount('GAME_ENTERPRISE', array('Enterprise_Status' => 0));
		$content['totalSubEnterprise']      = $this->Common_Model->findCount('GAME_SUBENTERPRISE', array('SubEnterprise_Status' => 0));
		$content['totalEnterpriseUsers']    = $this->Common_Model->findCount('GAME_SITE_USERS', array('User_Role' => 1));
		$content['totalSubEnterpriseUsers'] = $this->Common_Model->findCount('GAME_SITE_USERS', array('User_Role' => 2));

		$content['backgroundColor'] = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)');

		$content['borderColor']     = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)');

		$years = array('2017', '2018', '2019', '2020', '2021', '2022');

		if ($this->loginData['User_Role'] == 'superadmin') {
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

			$where = array(
				'Game_Delete' => 0,
			);
			$content['years']        = $years;
			$gameResult              = $this->Common_Model->fetchRecords('GAME_GAME', $where, NULL, 'Game_Name ASC');
			$gameFeedback            = $this->Common_Model->fetchRecords('GAME_FEEDBACK', NULL, NULL, 'Feedback_id DESC', NULL);
			$content['gameFeedback'] = $gameFeedback;
			$content['subview']      = 'adminCards';
		} else {
			// echo "<pre>"; print_r($this->loginData['User_Role']); exit();
			// for enterprise login
			if ($this->loginData['User_Role'] == 1) {
				$gameSql    = "SELECT * FROM GAME_ENTERPRISE_GAME geg JOIN GAME_GAME gg ON gg.Game_ID = geg.`EG_GameID` WHERE geg.`EG_EnterpriseID` =" . $this->loginData['User_Id'] . " ORDER BY gg.Game_Name";
				$gameResult = $this->Common_Model->executeQuery($gameSql);
				// echo "<pre>"; print_r($gameResult); exit();
				$profilePic = $this->loginData['User_profile_pic'];
			}
			// for subEnterprise login
			if ($this->loginData['User_Role'] == 2) {
				$gameSql    = "SELECT * FROM GAME_SUBENTERPRISE_GAME gsg JOIN GAME_GAME gg ON gg.Game_ID = gsg.`SG_GameID` WHERE gsg.`SG_EnterpriseID`=" . $this->loginData['User_ParentId'] . " AND SG_SubEnterpriseID=" . $this->loginData['User_Id'] . " ORDER BY gg.Game_Name";
				$gameResult = $this->Common_Model->executeQuery($gameSql);
				// echo "<pre>"; print_r($gameResult); exit();
				$profilePic = $this->loginData['User_profile_pic'];
			}
			$content['profilePic'] = $profilePic;
			$content['subview']    = 'assignedCards';
		}

		$content['gameData'] = $gameResult;
		$this->load->view('main_layout', $content);
	}

	public function uploadLogo()
	{
		$EnterpriseId    = $this->loginData['User_ParentId'];
		$SubEnterpriseId = $this->loginData['User_SubParentId'];

		if ($this->loginData['User_Role'] == 1) {
			$EnterpriseLogo = array(
				'Enterprise_ID'   => $EnterpriseId,
				'Enterprise_Logo' => $_FILES['logo']['name'],
			);
			//print_r($EnterpriseData);
			$this->do_upload();
			$this->db->where('Enterprise_ID', $EnterpriseId);
			$this->db->update('GAME_ENTERPRISE', $EnterpriseLogo);
			//print_r($this->db->last_query());exit();
		} else {
			$SubEnterpriselogo = array(
				'SubEnterprise_Logo' => $_FILES['logo']['name']
			);
			$this->do_upload();
			$this->db->where('SubEnterprise_ID', $SubEnterpriseId);
			$updateLogo  = $this->db->update('GAME_SUBENTERISE', $SubEnterpriselogo);
			//print_r($this->db->last_query());exit();
		}
		//$content['updateLogo'] = $updateLogo;
		$content['subview'] = 'homePage';
		$this->load->view('main_layout', $content);
	}

	//Upload Image On seleted Path
	public function do_upload()
	{
		//upload Image
		$config['upload_path']   = './common/Logo/';
		$config['allowed_types'] = 'gif|jpeg|jpg|png';
		$config['max_size']      = 1024;

		if (!is_dir($config['upload_path'])) die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('logo')) {
			$error = array('error' => $this->upload->display_errors());
			//echo $this->upload->display_errors();
		} else {
			$data = array('upload_data' => $this->upload->data());
			//$this->session->set_userdata('logo',$data);
		}
	}

	public function logOut()
	{
		session_destroy();
		$this->session->set_flashdata('tr_msg', 'You have been logged out successfully');
		redirect('Login');
	}
}
