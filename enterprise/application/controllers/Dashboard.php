<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	private $loginData;
	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
		if($this->loginData == NULL)
		{
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login/login');
		}
	}

	public function index()
	{
		// $activeEnterprise           = "";
		// $deactiveEnterprise         = "";
		// $activeSubEnterprise        = "";
		// $deactiveSubEnterprise      = "";
		// $activeEnterpriseUsers      = "";
		// $deactiveEnterpriseUsers    = "";
		// $activeSubEnterpriseUsers   = "";
		// $deactiveSubEnterpriseUsers = "";
		$content['totalEnterprise']         = $this->Common_Model->findCount('GAME_ENTERPRISE',array('Enterprise_Status' => 0));
		$content['totalSubEnterprise']      = $this->Common_Model->findCount('GAME_SUBENTERPRISE',array('SubEnterprise_Status' => 0));
		$content['totalEnterpriseUsers']    = $this->Common_Model->findCount('GAME_SITE_USERS',array('User_Role' => 1));
		$content['totalSubEnterpriseUsers'] = $this->Common_Model->findCount('GAME_SITE_USERS',array('User_Role' => 2));

		$content['backgroundColor'] = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)');

		$content['borderColor']     = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)');

		$years = array('2017', '2018', '2019', '2020', '2021', '2022');

		if($this->loginData['User_Role']=='superadmin')
		{
			// graph data-set
			$titleArray = array('Enterprise','Sub-Enterprise','Enterprise-Users','SubEnterprise-Users');
			$colArray   = array('Enterprise_CreatedOn','SubEnterprise_CreatedOn','User_datetime','User_datetime');
			$tableArray = array('GAME_ENTERPRISE','GAME_SUBENTERPRISE','GAME_SITE_USERS','GAME_SITE_USERS');
			$chartData  = array();

			for($i=0; $i<count($titleArray); $i++)
			{
				$graphSql = "SELECT '".$titleArray[$i]."' AS Title, COUNT(*) AS Count, EXTRACT(YEAR FROM ".$colArray[$i].") AS Year FROM `".$tableArray[$i]."`";
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
					array_unshift($dataChart, (object)array('Title' => $dataChart[0]->Title, 'Count' => 0, 'Year' => 2017));
					break;

					case 2:
					array_unshift($dataChart, (object)array('Title' => $dataChart[0]->Title, 'Count' => 0, 'Year' => 2018));
					array_unshift($dataChart, (object)array('Title' => $dataChart[0]->Title, 'Count' => 0, 'Year' => 2017));
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
			$gameResult              = $this->Common_Model->fetchRecords('GAME_GAME',$where,NULL, 'Game_Name ASC');
			$gameFeedback            = $this->Common_Model->fetchRecords('GAME_FEEDBACK',NULL,NULL,'Feedback_id DESC',NULL);
			$content['gameFeedback'] = $gameFeedback;
			$content['subview']      = 'adminDashboard';
		}
		else
		{
			// echo "<pre>"; print_r($this->loginData['User_Role']); exit();
			// for enterprise login
			if($this->loginData['User_Role'] == 1)
			{
				$gameSql    = "SELECT * FROM GAME_ENTERPRISE_GAME geg JOIN GAME_GAME gg ON gg.Game_ID = geg.`EG_GameID` WHERE geg.`EG_EnterpriseID` =".$this->loginData['User_Id']." ORDER BY gg.Game_Name";
				$gameResult = $this->Common_Model->executeQuery($gameSql);
				// echo "<pre>"; print_r($gameResult); exit();
				$profilePic = $this->loginData['User_profile_pic'];
			}
			// for subEnterprise login
			if($this->loginData['User_Role'] == 2)
			{
				$gameSql    = "SELECT * FROM GAME_SUBENTERPRISE_GAME gsg JOIN GAME_GAME gg ON gg.Game_ID = gsg.`SG_GameID` WHERE gsg.`SG_EnterpriseID`=".$this->loginData['User_ParentId']." AND SG_SubEnterpriseID=".$this->loginData['User_Id']." ORDER BY gg.Game_Name";
				$gameResult = $this->Common_Model->executeQuery($gameSql);
				// echo "<pre>"; print_r($gameResult); exit();
				$profilePic = $this->loginData['User_profile_pic'];
			}			
			$content['profilePic'] = $profilePic;
			$content['subview']    = 'dashboard';
		}

		$content['gameData'] = $gameResult;
		$this->load->view('main_layout',$content);
	}

	public function uploadLogo()
	{ 
		$EnterpriseId    = $this->loginData['User_ParentId'];
		$SubEnterpriseId = $this->loginData['User_SubParentId'];
		
		if($this->loginData['User_Role']==1)
		{  
			$EnterpriseLogo = array(
				'Enterprise_ID'   => $EnterpriseId,
				'Enterprise_Logo' => $_FILES['logo']['name'],
			);
       //print_r($EnterpriseData);
			$this->do_upload();
			$this->db->where('Enterprise_ID',$EnterpriseId);
			$this->db->update('GAME_ENTERPRISE',$EnterpriseLogo);
		   //print_r($this->db->last_query());exit();
		}
		else
		{
			$SubEnterpriselogo = array(
				'SubEnterprise_Logo'=>$_FILES['logo']['name']
			);
			$this->do_upload();
			$this->db->where('SubEnterprise_ID',$SubEnterpriseId);
			$updateLogo  = $this->db->update('GAME_SUBENTERISE',$SubEnterpriselogo);
		  //print_r($this->db->last_query());exit();
		}
    //$content['updateLogo'] = $updateLogo;
		$content['subview'] = 'homePage';
		$this->load->view('main_layout',$content);
	}

  //Upload Image On seleted Path
	public function do_upload(){
		//upload Image
		$config['upload_path']   = './common/Logo/';
		$config['allowed_types'] = 'gif|jpeg|jpg|png';
		$config['max_size']      = 1024;
		
		if ( ! is_dir($config['upload_path']) ) die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if (!$this->upload->do_upload('logo'))
		{ 
			$error = array('error' => $this->upload->display_errors());
			//echo $this->upload->display_errors();
		}
		else
		{
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
