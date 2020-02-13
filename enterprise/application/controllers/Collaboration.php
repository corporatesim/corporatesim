<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collaboration extends CI_Controller {

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

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login/login');
		}
	}

	public function index()
	{
		// echo "<pre>"; print_r($this->session->userdata('loginData'));
		$loginId       = $this->session->userdata('loginData')['User_Id'];
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == 'POST')
		{
			// echo "<pre>"; print_r($this->input->post()); exit(); // game_collaboration game_collaboration_users_mapping
			$filtertype    = $this->input->post('filtertype');
			$Enterprise    = $this->input->post('Enterprise');
			$SubEnterprise = $this->input->post('SubEnterprise');
			$selectedGame  = $this->input->post('selectGame');
			$Group_Id      = $this->input->post('gameCollaboration');
			$siteUsers     = $this->input->post('siteUsers'); // this will be of array type
			$userId        = array();
			// if no user is selected then show error
			if(count($siteUsers)<1 || empty($selectedGame) || empty($Group_Id))
			{
				$this->session->set_flashdata('er_msg', 'Please select at least one user, Game and P2P');
				redirect(current_url());
			}
			else
			{
				for($i=0; $i<count($siteUsers); $i++)
				{
					$userId[] = $siteUsers[$i];
				}
			}

			$userId = json_encode($userId);
			// echo "<pre>"; print_r($this->input->post()); print_r($userId); print_r($this->session->userdata('loginData')); exit();
			$insertArray = array(
				'Map_UserId'    => $userId,
				'Map_CreatedOn' => date('Y-m-d H:i:s'),
				'Map_CraetedBy' => $this->session->userdata('loginData')['User_Id'],
				'Map_GroupId'   => $Group_Id,
				'Map_GameId'    => $selectedGame
			);

			$deleteWhere = array(
				'Map_GroupId' => $Group_Id,
				'Map_GameId'  => $selectedGame
			);

			$deleteExisting = $this->Common_Model->deleteRecords('GAME_COLLABORATION_USERS_MAPPING', $deleteWhere);
			$insertMapping  = $this->Common_Model->insert('GAME_COLLABORATION_USERS_MAPPING', $insertArray);

			$this->session->set_flashdata('tr_msg', "Users's added to group successfully");
			redirect(base_url('Collaboration'));
		}


		// if user is enterprise
		if($this->session->userdata('loginData')['User_Role']==1)
		{
			$where = array(
				'Enterprise_Status' => 0,
				'Enterprise_ID'     => $loginId
			);
			$subWhere = array(
				'SubEnterprise_Status'       => 0,
				'SubEnterprise_EnterpriseID' => $loginId
			);
			$gameQuery = "SELECT * FROM GAME_ENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.EG_GameID WHERE gg.Game_Delete=0 AND ge.EG_EnterpriseID=".$loginId." ORDER BY gg.Game_Name";
		}
		// if user is subenterprise
		else if($this->session->userdata('loginData')['User_Role']==2)
		{
			$where = array(
				'Enterprise_Status' => 0,
				'Enterprise_ID'     => $this->session->userdata('loginData')['User_ParentId']
			);
			$subWhere = array(
				'SubEnterprise_Status'       => 0,
				'SubEnterprise_EnterpriseID' => $this->session->userdata('loginData')['User_ParentId'],
				'SubEnterprise_ID'           => $loginId
			);
			$gameQuery = "SELECT * FROM GAME_SUBENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.SG_GameID WHERE Game_Delete=0 AND ge.SG_SubEnterpriseID=".$loginId." ORDER BY gg.Game_Name";
		}
		// user is supperadmin
		else
		{
			$where = array(
				'Enterprise_Status' => 0,
			);
			$subWhere = array(
				'SubEnterprise_Status' => 0,
			);
			$gameQuery = "SELECT * FROM GAME_GAME WHERE Game_Delete=0 ORDER BY Game_Name";
		}

		$EnterpriseName            = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);
		$content['EnterpriseName'] = $EnterpriseName;
		$SubEnterprise             = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$subWhere);
		$content['SubEnterprise']  = $SubEnterprise;
		$gameData                  = $this->Common_Model->executeQuery($gameQuery);
		$content['gameData']       = $gameData;
		$content['subview']        = 'collaboration';
		$this->load->view('main_layout',$content);
	}

	public function viewGroupReport($reportData=NULL)
	{
		// echo "<pre>"; print_r($this->session->userdata('loginData')); exit();
		// $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$subWhere);
		// $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$subWhere);

		// if enterprise is logged in
		if($this->session->userdata('loginData')['User_Role']==1)
		{
			$groupWhere = array(
				'Group_Delete'      => 0,
				'Group_ParentId'    => $this->session->userdata('loginData')['User_Id'],
				'Group_SubParentId' => -2,
				'Group_CreatedBy'   => $this->session->userdata('loginData')['User_Id'],
			);
			// fetch all the subenterprise data associated with enterprise
			$subEntWhere = array(
				'SubEnterprise_EnterpriseID' => $this->session->userdata('loginData')['User_Id'],
				'SubEnterprise_Status'       => 0,
			);
			$subEnterprise                = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$subEntWhere);
			$content['subEnterpriseData'] = $subEnterprise;
		}
		// if subenterprise is logged in
		else if($this->session->userdata('loginData')['User_Role']==2)
		{
			$groupWhere = array(
				'Group_Delete'      => 0,
				'Group_ParentId'    => $this->session->userdata('loginData')['User_ParentId'],
				'Group_SubParentId' => $this->session->userdata('loginData')['User_Id'],
				'Group_CreatedBy'   => $this->session->userdata('loginData')['User_Id'],
			);
		}
		// if superAdmin is logged in
		else
		{
			$groupWhere = array(
				'Group_Delete'      => 0,
				'Group_ParentId'    => -1,
				'Group_SubParentId' => -2,
				'Group_CreatedBy'   => $this->session->userdata('loginData')['User_Id'],
			);
			// fetch all the enterprise data
			$entWhere = array(
				'Enterprise_Status' => 0,
			);
			$enterprise                = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$entWhere,'','Enterprise_Name');
			$content['enterpriseData'] = $enterprise;
		}
		$groupData = $this->Common_Model->fetchRecords('GAME_COLLABORATION', $groupWhere, 'Group_Id, Group_Name, Group_Info', 'Group_Name');
		// echo "<pre>"; print_r($groupData); exit();
		$content['groupData'] = $groupData;
		$content['subview']   = 'viewGroupReport';
		$this->load->view('main_layout',$content);
	}

}
