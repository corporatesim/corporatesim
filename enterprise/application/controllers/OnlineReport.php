<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OnlineReport extends CI_Controller {

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
		$this->load->library('PHPExcel');
	}

	public function index()
	{
		// echo "<pre>"; print_r($this->session->userdata('loginData'));
		$loginId       = $this->session->userdata('loginData')['User_Id'];
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == 'POST')
		{
			// echo "<pre>"; print_r($this->input->post()); exit();
			$loggedInAs    = ($this->input->post('loggedInAs'))?$this->input->post('loggedInAs'):NULL;
			$filtertype    = ($this->input->post('filtertype'))?$this->input->post('filtertype'):NULL;
			$Enterprise    = ($this->input->post('Enterprise'))?$this->input->post('Enterprise'):NULL;
			$SubEnterprise = ($this->input->post('SubEnterprise'))?$this->input->post('SubEnterprise'):NULL;
			$selectedGame  = ($this->input->post('selectGame'))?$this->input->post('selectGame'):NULL;
			$gamestartdate = ($this->input->post('gamestartdate'))?strtotime($this->input->post('gamestartdate')):NULL;
			$gameenddate   = ($this->input->post('gameenddate'))?strtotime($this->input->post('gameenddate')):NULL;
			$redirect      = '';

			if(empty($selectedGame) || empty($gamestartdate) || empty($gameenddate))
			{
				// these fields can't be left blank
				$this->session->set_flashdata('er_msg', 'Game And Date Fields Are Mandatory');
				redirect(current_url());
			}

			else
			{
				switch ($filtertype)
				{
					case 'superadminUsers':
					$redirect = base64_encode($selectedGame.'/'.$gamestartdate.'/'.$gameenddate.'/'.$Enterprise.'/'.$SubEnterprise);
					redirect(base_url('OnlineReport/viewReport/'.$redirect));
					break;

					case 'enterpriseUsers':
					$redirect = base64_encode($selectedGame.'/'.$gamestartdate.'/'.$gameenddate.'/'.$Enterprise);
					redirect(base_url('OnlineReport/viewReport/'.$redirect));
					break;

					case 'subEnterpriseUsers':
					$redirect = base64_encode($selectedGame.'/'.$gamestartdate.'/'.$gameenddate.'/'.$Enterprise.'/'.$SubEnterprise);
					redirect(base_url('OnlineReport/viewReport/'.$redirect));
					break;

					default:
					// add your code here
					break;
				}
			}
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

		$EnterpriseName            = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where,'','Enterprise_Name');
		$content['EnterpriseName'] = $EnterpriseName;
		$SubEnterprise             = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$subWhere,'','SubEnterprise_Name');
		$content['SubEnterprise']  = $SubEnterprise;
		$gameData                  = $this->Common_Model->executeQuery($gameQuery);
		$content['gameData']       = $gameData;
		$content['subview']        = 'onlineReport';
		$this->load->view('main_layout',$content);
	}

	public function viewReport($reportData=NULL)
	{
		if(empty($reportData))
		{
			$this->session->set_flashdata('er_msg', 'Please choose filter to get report');
			redirect(base_url('OnlineReport'));
		}
		// echo $reportData.'<br><pre>'.base64_decode($reportData); $reportData = explode('/',trim(base64_decode($reportData))); 
		// print_r($reportData); exit();
		// 
		$reportData    = explode('/',trim(base64_decode($reportData))); 
		$gameId        = (isset($reportData[0]))?$reportData[0]:NULL;
		$dateTo        = (isset($reportData[1]))?date('Y-m-d',$reportData[1]):NULL;
		$dateFrom      = (isset($reportData[2]))?date('Y-m-d',$reportData[2]):NULL;
		$Enterprise    = (isset($reportData[3]))?$reportData[3]:NULL;
		$SubEnterprise = (isset($reportData[4]))?$reportData[4]:NULL;
		$userId        = array();
		$userId        = implode(',',$userId);

		if(empty($gameId))
		{
			$this->session->set_flashdata('er_msg', 'No Game Selected');
			redirect(base_url('OnlineReport'));
		}

		$reportSql = 'SELECT gu.User_id AS user_game_id, gi.input_current, CONCAT( IF(gc.Comp_NameAlias != "" AND gc.Comp_NameAlias IS NOT NULL,gc.Comp_NameAlias,gc.Comp_Name), "/", IF( gs.SubComp_NameAlias != "" AND gs.SubComp_NameAlias IS NOT NULL, gs.SubComp_NameAlias, IF(gs.SubComp_Name IS NOT NULL,gs.SubComp_Name,"") ) ) AS Comp_SubComp, CONCAT( gu.User_fname, " ", gu.User_lname) AS FullName, gu.User_username AS userName, gu.User_email AS UserEmail, gus.US_LinkID AS gameStatus FROM GAME_INPUT gi INNER JOIN GAME_SITE_USERS gu ON gu.User_id = gi.input_user  INNER JOIN GAME_SITE_USER_REPORT_NEW gur ON gur.uid=gu.User_id AND (gur. date_time BETWEEN "'.$dateTo.'" AND "'.$dateFrom.'") INNER JOIN GAME_LINKAGE_SUB gls ON gi.input_sublinkid = gls.SubLink_ID AND gls.SubLink_ShowHide=0 AND gls.SubLink_InputMode !="none" LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID='.$gameId.' AND gus.US_UserID=gu.User_id LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID WHERE ( gls.SubLink_LinkID IN( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = '.$gameId.' ) AND gls.SubLink_Type = 1 ) ';

		if(!empty($Enterprise))
		{
			$reportSql .= " AND gu.User_ParentId=".$Enterprise;
		}
		if(!empty($SubEnterprise))
		{
			$reportSql .= " AND gu.User_SubParentId=".$SubEnterprise;
		}
		// $reportSql .= " AND (date_time BETWEEN '".$dateTo."' AND '".$dateFrom."') ";
		$reportSql .= " ORDER BY gls.SubLink_Order ASC ";

		// die($reportSql);
		$reportData = $this->Common_Model->executeQuery($reportSql);
		// create bulk array with user record
		$tableHeader   = array();
		$userData      = array();
		$tableHeader[] = 'FullName';
		$tableHeader[] = 'UserEmail';
		// echo $reportSql."<pre>"; print_r($reportData); exit();
		foreach($reportData as $reportDataRow)
		{
			if(!in_array($reportDataRow->Comp_SubComp, $tableHeader))
			{
				$tableHeader[] = $reportDataRow->Comp_SubComp;
			}
			if(array_key_exists($reportDataRow->UserEmail, $userData))
			{
				// if(!$userData[$reportDataRow->UserEmail][$reportDataRow->Comp_SubComp])
				// {
				// }
				$userData[$reportDataRow->UserEmail][$reportDataRow->Comp_SubComp] = $reportDataRow->input_current;
			}
			else
			{
				$userData[$reportDataRow->UserEmail]['FullName']                   = trim($reportDataRow->FullName);
				$userData[$reportDataRow->UserEmail]['UserEmail']                  = trim($reportDataRow->UserEmail);
				$userData[$reportDataRow->UserEmail]['user_game_id']               = $reportDataRow->user_game_id.'_'.$gameId.'_'.$reportDataRow->gameStatus;
				$userData[$reportDataRow->UserEmail][$reportDataRow->Comp_SubComp] = $reportDataRow->input_current;
			}
		}
		// echo "$reportSql<pre>";	print_r($tableHeader); print_r($userData); echo '<br>'.count($tableHeader); echo '<br>'.count($userData); exit();
		$gameWhere = array(
			'Game_ID'     => $gameId,
			'Game_Delete' => 0,
		);
		$gameName               = $this->Common_Model->fetchRecords('GAME_GAME',$gameWhere,'Game_Name');
		$content['gameName']    = $gameName[0];
		$content['tableHeader'] = $tableHeader;
		$content['userData']    = $userData;
		$content['subview']     = 'viewReport';
		$this->load->view('main_layout',$content);
	}
}
