<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AllocateDeallocateGame extends MY_Controller {

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

	public function index($gamedata=NULL,$allocateTo=NULL,$startDate=NULL,$endDate=NULL)
	{
		// echo "<pre>"; print_r($this->loginData['User_Role']);
		// $gamedata contains the value (gameid,gamename)
		// echo "allocateGame: <b>".base64_decode($gamedata)."</b> to <b>".base64_decode($allocateTo)."</b> from <b>".base64_decode($startDate)."</b> to <b>".base64_decode($endDate); exit();

		$content['gamedata']   = explode(',',base64_decode($gamedata));
		$content['allocateTo'] = base64_decode($allocateTo);
		$content['startDate']  = base64_decode($startDate);
		$content['endDate']    = base64_decode($endDate);
		$content['subview']    = 'allocateDeallocateGame';
		$content['loggedInAs'] = $this->loginData['User_Role'];
		$RequestMethod         = $this->input->server('REQUEST_METHOD');
		$entSql                = "SELECT ge.Enterprise_ID, ge.Enterprise_Name, ge.Enterprise_Email, ge.Enterprise_StartDate, ge.Enterprise_EndDate, geg.EG_Game_Start_Date, geg.EG_Game_End_Date FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_EnterpriseID=ge.Enterprise_ID AND geg.EG_GameID=".$content['gamedata'][0]." WHERE ge.Enterprise_Status = 0";

		// finding game category for it's url gameId = $content['gamedata'][0]
		$gameCategory = $this->Common_Model->fetchRecords('GAME_GAME',array('Game_ID' => $content['gamedata'][0]),'Game_Category');
		// echo "<pre>"; print_r($gameCategory[0]); exit();
		if (strpos($gameCategory[0]->Game_Category, 'Desktop') !== false)
		{
			$content['gameUrl'] = base_url('../');
		}
		else
		{
			$content['gameUrl'] = base_url('../mobile');
		}
		
		switch ($content['allocateTo'])
		{
			case 'enterprise':
			$select         = 'Enterprise';
			$entCheckBoxSql = "SELECT ge.Enterprise_ID, ge.Enterprise_Name, ge.Enterprise_Email, ge.Enterprise_StartDate, ge.Enterprise_EndDate, geg.EG_EnterpriseID, geg.EG_GameID, geg.EG_Game_Start_Date, geg.EG_Game_End_Date FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ENTERPRISE_GAME geg ON ge.Enterprise_ID = geg.EG_EnterpriseID AND geg.EG_GameID = ".$content['gamedata'][0]." WHERE ge.Enterprise_Status = 0 ORDER BY geg.EG_GameID DESC, ge.Enterprise_Name ASC";
			// die($entCheckBoxSql);
			$content['enterpriseCheckbox'] = $this->Common_Model->executeQuery($entCheckBoxSql);
			break;
			
			case 'subEnterprise':
			$select = 'Subenterprise';
			// if superadmin is logged in
			if($content['loggedInAs'] == 'superadmin')
			{
				$content['enterpriseDropdown'] = $this->Common_Model->executeQuery($entSql);
			}
			// if enterprise is logged in
			if($content['loggedInAs'] == '1')
			{
				$subEntCheckBoxSql = "SELECT gs.SubEnterprise_ID, gs.SubEnterprise_Name, gs.SubEnterprise_EnterpriseID, gs.SubEnterprise_Email, UNIX_TIMESTAMP(gs.SubEnterprise_StartDate) AS SubEnterprise_StartDate, UNIX_TIMESTAMP(gs.SubEnterprise_EndDate) AS SubEnterprise_EndDate, gsg.SG_GameID, UNIX_TIMESTAMP(gsg.SG_Game_Start_Date) AS SG_Game_Start_Date, UNIX_TIMESTAMP(gsg.SG_Game_End_Date) AS SG_Game_End_Date, UNIX_TIMESTAMP(geg.EG_Game_Start_Date) AS EG_Game_Start_Date, UNIX_TIMESTAMP(geg.EG_Game_End_Date) AS EG_Game_End_Date FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID = gs.SubEnterprise_ID AND gsg.SG_GameID =".$content['gamedata'][0]." JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_EnterpriseID = gs.SubEnterprise_EnterpriseID AND geg.EG_GameID =".$content['gamedata'][0]." WHERE gs.SubEnterprise_EnterpriseID =".$this->loginData['User_Id']." AND gs.SubEnterprise_Status = 0";
				// echo "<pre>"; print_r($this->Common_Model->executeQuery($subEntCheckBoxSql)); exit();
				$content['subEnterpriseCheckbox'] = $this->Common_Model->executeQuery($subEntCheckBoxSql);
			}
			break;

			case 'entErpriseUsers':
			$select = 'Enterprise Users';
			if($content['loggedInAs'] == 'superadmin')
			{
				$content['enterpriseDropdown'] = $this->Common_Model->executeQuery($entSql);
			}
			// if enterprise is logged in
			if($content['loggedInAs'] == '1')
			{
				// $entUserCheckBoxSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS userName, gsu.User_GameStartDate, UNIX_TIMESTAMP(gsu.User_GameStartDate) AS UserStartDate, UNIX_TIMESTAMP(gsu.User_GameEndDate) AS UserEndDate, gug.UG_GameID, UNIX_TIMESTAMP(gug.UG_GameStartDate) AS UG_GameStartDate, UNIX_TIMESTAMP(gug.UG_GameEndDate) AS UG_GameEndDate, gug.UG_ReplayCount, gsu.User_email FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID = 60 AND gug.UG_ParentId =".$this->loginData['User_Id']." WHERE gsu.User_ParentId =".$this->loginData['User_Id']." AND gsu.User_Role = 1 AND gsu.User_GameEndDate >= DATE(NOW()) AND gsu.User_Delete = 0";
				// // die($entUserCheckBoxSql);
				// $content['EnterpriseUserCheckbox'] = $this->Common_Model->executeQuery($entUserCheckBoxSql);
				$logEntSql = "SELECT ge.Enterprise_ID, ge.Enterprise_Name, ge.Enterprise_Email, ge.Enterprise_StartDate, ge.Enterprise_EndDate, UNIX_TIMESTAMP(geg.EG_Game_Start_Date) AS EG_Game_Start_Date, UNIX_TIMESTAMP(geg.EG_Game_End_Date) AS EG_Game_End_Date, geg.EG_Game_Start_Date AS EG_Start_Date_Game, geg.EG_Game_End_Date AS EG_End_Date_Game FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_EnterpriseID=ge.Enterprise_ID AND geg.EG_GameID=".$content['gamedata'][0]." WHERE ge.Enterprise_Status = 0 AND ge.Enterprise_ID=".$this->loginData['User_Id'];
				$resultData                     = $this->Common_Model->executeQuery($logEntSql);
				$content['enterpriseData']      = $resultData[0];
				$content['showEnterpriseUsers'] = 'showEnterpriseUsers';
				// echo "<pre>"; print_r($content['enterpriseData']); die($logEntSql);
			}
			break;

			case 'subEnterpriseUsers':
			$select = 'Subenterprise Users';
			// if superadmin is logged in
			if($content['loggedInAs'] == 'superadmin')
			{
				$content['enterpriseDropdown'] = $this->Common_Model->executeQuery($entSql);
			}
			// if enterprise is logged in
			if($content['loggedInAs'] == '1')
			{
				$subEntSql = "SELECT gs.SubEnterprise_ID, gs.SubEnterprise_Name, gsg.SG_GameID, UNIX_TIMESTAMP(gs.SubEnterprise_StartDate) AS SubEnterprise_StartDate, UNIX_TIMESTAMP(gs.SubEnterprise_EndDate) AS SubEnterprise_EndDate, UNIX_TIMESTAMP(gsg.SG_Game_Start_Date) AS SG_Game_Start_Date, UNIX_TIMESTAMP(gsg.SG_Game_End_Date) AS SG_Game_End_Date, UNIX_TIMESTAMP(geg.EG_Game_Start_Date) AS EG_Game_Start_Date, UNIX_TIMESTAMP(geg.EG_Game_End_Date) AS EG_Game_End_Date, IF(gsg.SG_GameID, UNIX_TIMESTAMP(gsg.SG_Game_Start_Date), NULL) AS startDate, IF(gsg.SG_GameID, UNIX_TIMESTAMP(gsg.SG_Game_End_Date), NULL) AS endDate FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID = gs.SubEnterprise_ID AND gsg.SG_GameID=".$content['gamedata'][0]." JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_EnterpriseID = gs.SubEnterprise_EnterpriseID AND geg.EG_GameID =".$content['gamedata'][0]." WHERE gs.SubEnterprise_EnterpriseID =".$this->loginData['User_Id']." AND gs.SubEnterprise_Status = 0 ORDER BY gs.SubEnterprise_Name ASC";
				$content['subEnterpriseDropdown'] = $this->Common_Model->executeQuery($subEntSql);
				$content['entData']               = $this->loginData;
				// echo $subEntSql."<pre>"; print_r($content['subEnterpriseDropdown']); print_r($this->loginData); exit();
			}
			// if subEnterprise is logged in
			if($content['loggedInAs'] == '2')
			{
				// check if game allocated to subenterprise or not
				$subEntUsersSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS userName, gsu.User_GameStartDate, gsu.User_GameEndDate, UNIX_TIMESTAMP(gsu.User_GameStartDate) AS UserStartDate, UNIX_TIMESTAMP(gsu.User_GameEndDate) AS UserEndDate, gug.UG_GameID, UNIX_TIMESTAMP(gug.UG_GameStartDate) AS UG_GameStartDate, UNIX_TIMESTAMP(gug.UG_GameEndDate) AS UG_GameEndDate, gug.UG_ReplayCount, gsu.User_email FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID =".$content['gamedata'][0]." AND gug.UG_SubParentId = 4 WHERE gsu.User_Role = 2 AND gsu.User_GameEndDate >= DATE(NOW()) AND gsu.User_SubParentId =".$this->loginData['User_Id']." AND gsu.User_Delete = 0";
				$content['subEntErpriseUsersCheckbox'] = $this->Common_Model->executeQuery($subEntUsersSql);
				// getting the data of ent and subEnt in a single query, there must be only one row for a selected game of logged in subent
				$entSubEntSql = "SELECT ge.Enterprise_ID, gs.SubEnterprise_ID, UNIX_TIMESTAMP(gsg.SG_Game_Start_Date) AS SG_Game_Start_Date, UNIX_TIMESTAMP(gsg.SG_Game_End_Date) AS SG_Game_End_Date FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID = gs.SubEnterprise_ID AND gsg.SG_GameID =".$content['gamedata'][0]." LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gs.SubEnterprise_EnterpriseID WHERE gs.SubEnterprise_ID =".$this->loginData['User_Id'];
				$entSubEntData              = $this->Common_Model->executeQuery($entSubEntSql);
				$content['ent_subEnt_Data'] = $entSubEntData[0];
				// echo $subEntUsersSql."<pre>";print_r($content['ent_subEnt_Data']); print_r($content['subEntErpriseUsersCheckbox']); exit();
			}
			break;

			default:
			$select = '';
			break;
		}

		// when page is submitted // gamestartdate // gameenddate // replaycount
		if($RequestMethod == 'POST')
		{
			// echo "<pre>"; print_r($this->input->post()); var_dump($this->input->post('enterprise')); exit();
			$gameID     = $this->input->post('gameID');
			$allocateTo = $this->input->post('allocateTo');
			$insertArr  = array();
			$updateArr  = array();

			if($allocateTo == 'enterprise')
			{
				if($this->input->post('enterprise')==NULL || empty($this->input->post('enterprise')) )
				{
					$this->session->set_flashdata('er_msg', 'Please Select Enterprise');
					redirect(current_url());
				}
				// single game to multiple enterprise
				$tableName       = "GAME_ENTERPRISE_GAME";
				$enterpriseArray = $this->input->post('enterprise');
				$where_in[0]     = 'EG_EnterpriseID';
				$where_in[1]     = implode(',', $enterpriseArray);
				$deleteWhere     = array(
					'EG_GameID' => $gameID,
				);

				// creating insert array
				for($i=0; $i<count($enterpriseArray); $i++)
				{
					$EG_Game_Start_Date = date('Y-m-d',strtotime($this->input->post($enterpriseArray[$i].'_gamestartdate')));
					$EG_Game_End_Date   = date('Y-m-d',strtotime($this->input->post($enterpriseArray[$i].'_gameenddate')));
					$insertArr[]        = array(
						'EG_EnterpriseID'    => $enterpriseArray[$i],
						'EG_GameID'          => $gameID,
						'EG_Game_Start_Date' => $EG_Game_Start_Date,
						'EG_Game_End_Date'   => $EG_Game_End_Date,
						'EG_CreatedOn'       => date('Y-m-d h:i:s'),
						'EG_CreatedBy'       => $this->loginData['User_Id'],
					);

					// this is to update the games duration for subEnterprise according to enterprise game duration
					$updateSubEntSql = "SELECT gsg.*, gs.SubEnterprise_StartDate, gs.SubEnterprise_EndDate FROM GAME_SUBENTERPRISE_GAME gsg LEFT JOIN GAME_SUBENTERPRISE gs ON gsg.SG_SubEnterpriseID=gs.SubEnterprise_ID WHERE gsg.SG_EnterpriseID=".$enterpriseArray[$i]." AND SG_GameID=".$gameID;
					$updateSubEntResult = $this->Common_Model->executeQuery($updateSubEntSql);
					// there must be only one entry for associated subEnterprise and for selected game so we'll take result[0]
					if(count($updateSubEntResult) > 0)
					{
						$updateSubEntResult = $updateSubEntResult[0];
						$SG_Game_Start_Date = '';
						$SG_Game_End_Date   = '';
						// echo $EG_Game_Start_Date.' and '.$EG_Game_End_Date.'<br>'; print_r($updateSubEntResult);
						// creating query to update sueEnterprise game start and end date
						if(strtotime($EG_Game_Start_Date) <= strtotime($updateSubEntResult->SG_Game_Start_Date) && strtotime($EG_Game_End_Date) >= strtotime($updateSubEntResult->SG_Game_End_Date))
						{
							// game startDate and endDate for enterprise is b/w subEnterprise game_start and game_end Date then do nothing
							// echo 'do nothing';
							// commenting the above line, as it causes error while redirecting. when you have started outputting anything before header redirect in PHP code
						}
						else
						{
							// setting start date
							if(strtotime($EG_Game_Start_Date) <= strtotime($updateSubEntResult->SubEnterprise_StartDate))
							{
								$SG_Game_Start_Date = $updateSubEntResult->SubEnterprise_StartDate;
							}
							elseif(strtotime($EG_Game_Start_Date) <= strtotime($updateSubEntResult->SubEnterprise_EndDate))
							{
								$SG_Game_Start_Date = $EG_Game_Start_Date;
							}
							// setting end date
							if(strtotime($EG_Game_End_Date) <= strtotime($updateSubEntResult->SubEnterprise_EndDate))
							{
								$SG_Game_End_Date = $EG_Game_End_Date;
							}
							elseif(strtotime($EG_Game_End_Date) <= strtotime($updateSubEntResult->SubEnterprise_StartDate))
							{
								$SG_Game_End_Date = $updateSubEntResult->SubEnterprise_EndDate;
							}
							// start and end date setUp ends here 
							// echo 'SG_Game_Start_Date:- '.$SG_Game_Start_Date.' and SG_Game_End_Date:- '.$SG_Game_End_Date.'<br>';
							$updateArr[] = array(
								'SG_ID'              => $updateSubEntResult->SG_ID,
								'SG_Game_Start_Date' => $SG_Game_Start_Date,
								'SG_Game_End_Date'   => $SG_Game_End_Date,
							);
						}
					}

				}
				// where SG_EnterpriseID=$enterpriseArray[$i] AND SG_GameID=$gameID SG_Game_Start_Date SG_Game_End_Date
			}
			// print_r($updateArr); exit();

			if($allocateTo == 'subEnterprise')
			{
				if($this->input->post('subEnterprise')==NULL || empty($this->input->post('subEnterprise')))
				{
					$this->session->set_flashdata('er_msg', 'Please Select SubEnterprise');
					redirect(current_url());
				}
				// single game to multiple subenterprise, as Enterprise id is like entId_startDate_endDate
				$tableName          = "GAME_SUBENTERPRISE_GAME";
				$Enterprise         = explode('_',$this->input->post('Enterprise'));
				$SG_EnterpriseID    = $Enterprise[0];
				$subEnterpriseArray = $this->input->post('subEnterprise');
				$where_in[0]        = 'SG_SubEnterpriseID';
				$where_in[1]        = implode(',', $subEnterpriseArray);
				$deleteWhere        = array(
					'SG_EnterpriseID' => $SG_EnterpriseID,
					'SG_GameID'       => $gameID,
				);

				// creating insert array
				for($i=0; $i<count($subEnterpriseArray); $i++)
				{
					$insertArr[] = array(
						'SG_EnterpriseID'    => $SG_EnterpriseID,
						'SG_SubEnterpriseID' => $subEnterpriseArray[$i],
						'SG_GameID'          => $gameID,
						'SG_Game_Start_Date' => date('Y-m-d',strtotime($this->input->post($subEnterpriseArray[$i].'_gamestartdate'))),
						'SG_Game_End_Date'   => date('Y-m-d',strtotime($this->input->post($subEnterpriseArray[$i].'_gameenddate'))),
						'SG_CreatedOn'       => date('Y-m-d h:i:s'),
						'SG_CreatedBy'       => $this->loginData['User_Id'],
					);
				}
			}

			if($allocateTo == 'entErpriseUsers')
			{
				// echo "<pre>"; print_r($content['enterpriseData']); print_r($this->input->post()); die();
				// single game to multiple enterprise users, as Enterprise id is like entId_startDate_endDate
				$tableName           = "GAME_USERGAMES";
				$Enterprise          = explode('_',$this->input->post('Enterprise'));
				$UG_ParentId         = $Enterprise[0];
				$deleteWhere         = array(
					'UG_ParentId'    => $UG_ParentId,
					'UG_SubParentId' => -2,
					'UG_GameID'      => $gameID,
				);

				if($this->input->post('EnterpriseUser')==NULL || empty($this->input->post('EnterpriseUser')))
				{
					// this means de-allocate the game from all users
					$this->db->where($deleteWhere);
					$this->db->delete($tableName);
					$this->session->set_flashdata('tr_msg', 'Game De-Allocated Successfully.');
					redirect('Dashboard');
				}

				$EnterpriseUserArray = $this->input->post('EnterpriseUser');
				$where_in[0]         = 'UG_UserID';
				$where_in[1]         = implode(',', $EnterpriseUserArray);
				// creating insert array
				for($i=0; $i<count($EnterpriseUserArray); $i++)
				{
					$insertArr[] = array(
						'UG_UserID'        => $EnterpriseUserArray[$i],
						'UG_GameID'        => $gameID,
						'UG_ParentId'      => $UG_ParentId,
						'UG_SubParentId'   => -2,
						'UG_GameStartDate' => date('Y-m-d',strtotime($this->input->post($EnterpriseUserArray[$i].'_gamestartdate'))),
						'UG_GameEndDate'   => date('Y-m-d',strtotime($this->input->post($EnterpriseUserArray[$i].'_gameenddate'))),
						'UG_ReplayCount'   => $this->input->post($EnterpriseUserArray[$i].'_replaycount'),
						'UG_CratedOn'      => date('Y-m-d h:i:s'),
					);
				}
			}

			if($allocateTo == 'subEnterpriseUsers')
			{
				// single game to multiple sub-enterprise users, as Enterprise and subEnterprise id's are like entId_startDate_endDate
				$tableName              = "GAME_USERGAMES";
				$Enterprise             = explode('_',$this->input->post('Enterprise'));
				$UG_ParentId            = $Enterprise[0];
				$subEnterprise          = explode('_',$this->input->post('SubEnterpriseDropdown'));
				$UG_SubParentId         = $subEnterprise[0];
				$deleteWhere            = array(
					'UG_ParentId'    => $UG_ParentId,
					'UG_SubParentId' => $UG_SubParentId,
					'UG_GameID'      => $gameID,
				);

				if($this->input->post('subEnterpriseUser')==NULL || empty($this->input->post('subEnterpriseUser')))
				{
					// this means de-allocate the game from all users
					$this->db->where($deleteWhere);
					$this->db->delete($tableName);
					$this->session->set_flashdata('tr_msg', 'Game De-Allocated Successfully.');
					redirect('Dashboard');
				}

				$subEnterpriseUserArray = $this->input->post('subEnterpriseUser');
				$where_in[0]            = 'UG_UserID';
				$where_in[1]            = implode(',', $subEnterpriseUserArray);
				// creating insert array
				for($i=0; $i<count($subEnterpriseUserArray); $i++)
				{
					$insertArr[] = array(
						'UG_UserID'        => $subEnterpriseUserArray[$i],
						'UG_GameID'        => $gameID,
						'UG_ParentId'      => $UG_ParentId,
						'UG_SubParentId'   => $UG_SubParentId,
						'UG_GameStartDate' => date('Y-m-d',strtotime($this->input->post($subEnterpriseUserArray[$i].'_gamestartdate'))),
						'UG_GameEndDate'   => date('Y-m-d',strtotime($this->input->post($subEnterpriseUserArray[$i].'_gameenddate'))),
						'UG_ReplayCount'   => $this->input->post($subEnterpriseUserArray[$i].'_replaycount'),
						'UG_CratedOn'      => date('Y-m-d h:i:s'),
					);
				}
			}
			// echo "<pre>"; print_r($deleteWhere); print_r($where_in); print_r($insertArr); print_r($this->input->post()); exit();
			$updateGameRecords = $this->updateGameRecords($tableName,$deleteWhere,$where_in,$insertArr,$updateArr);
			// echo $this->session->flashdata('tr_msg'); exit();
			if($updateGameRecords == 'success')
			{
				$this->session->set_flashdata('tr_msg', 'Successfully updated games allocation/de-allocation');
			}
			else
			{
				$this->session->set_flashdata('er_msg', 'Database connection error. Please try later');
			}
			redirect(base_url('Dashboard'));
		}

		$content['select'] = $select;
		$this->load->view('main_layout',$content);
	}


	private function updateGameRecords($tableName=NULL,$deleteWhere=NULL,$where_in=NULL,$insertArr=NULL,$updateArr=NULL)
	{
		// put the queries in transactions
		// adding FALSE to remove quotes i.e. from ('6,1,17') to (6,1,17)
		$this->db->trans_start();
		// deleting all records and then updating the selected users only
		// $this->db->where_in($where_in[0], trim($where_in[1]), FALSE);
		$this->db->where($deleteWhere);
		$this->db->delete($tableName);
		// print_r($this->db->last_query()); exit();
		$this->db->insert_batch($tableName, $insertArr);
		if($updateArr)
		{
			$this->db->update_batch('GAME_SUBENTERPRISE_GAME', $updateArr, 'SG_ID');
		}
		$this->db->trans_complete();
		// print_r($this->db->last_query()); echo '<br><br>'; exit();
		if($this->db->trans_status() === FALSE)
		{
			// $this->db->error();
			return 'failed';
		}
		else
		{
			return 'success';
		}
	}

	public function logOut()
	{
		session_destroy();
		$this->session->set_flashdata('tr_msg', 'You have been logged out successfully');
		redirect('Login');
	}
}
