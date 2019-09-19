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
			$this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
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
		if($this->loginData['User_Role']=='superadmin')
		{
			$content['subview'] = 'homePage';
		}
		else
		{
			// echo "<pre>"; print_r($this->loginData['User_Role']); exit();
			// for enterprise login
			if($this->loginData['User_Role'] == 1)
			{
				$gameSql = "SELECT * FROM GAME_ENTERPRISE_GAME geg JOIN GAME_GAME gg ON gg.Game_ID = geg.`EG_GameID` WHERE geg.`EG_EnterpriseID` =".$this->loginData['User_Id'];
				$gameResult = $this->Common_Model->executeQuery($gameSql);
				// echo "<pre>"; print_r($gameResult); exit();
				$profilePic = $this->loginData['User_profile_pic'];
			}
			// for subEnterprise login
			if($this->loginData['User_Role'] == 2)
			{
				$gameSql = "SELECT * FROM GAME_SUBENTERPRISE_GAME gsg JOIN GAME_GAME gg ON gg.Game_ID = gsg.`SG_GameID` WHERE gsg.`SG_EnterpriseID`=".$this->loginData['User_ParentId']." AND SG_SubEnterpriseID=".$this->loginData['User_Id'];
				$gameResult = $this->Common_Model->executeQuery($gameSql);
				// echo "<pre>"; print_r($gameResult); exit();
				$profilePic = $this->loginData['User_profile_pic'];
			}
			
			$content['profilePic'] = $profilePic;
			$content['gameData']   = $gameResult;
			$content['subview']    = 'dashboard';
		}
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
