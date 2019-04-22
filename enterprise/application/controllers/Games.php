<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends CI_Controller {

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
		$this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
		redirect('Login/login');
	}
}

//assign Games to Enterprise,Subenterprise and Users
public function assignGames($ID=NULL,$userType=NULL)
{
	//$ID will be EnterpriseID,SubEnterpriseID and UserID
	$ID       = base64_decode($ID);
	$userType = base64_decode($userType);
	$type     = '';
	//assign Game to user and Subenterprise, when enterprise is logged in
	if($this->session->userdata('loginData')['User_Role']==1)
	{ 
		$EnterpriseID    = $this->session->userdata('loginData')['User_ParentId'];
		// allocate/deallocate Games for Enterprise users
		if($userType == 'EnterpriseUsers')
		{
			$type       = $userType;
			$controller = 'Users';
			$query      = "SELECT gg.*,geg.*,gug.*,gsu.User_id,gsu.User_username,geg.EG_EnterpriseID FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON gg.Game_ID=geg.EG_GameID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_ParentId = geg.EG_EnterpriseID  LEFT JOIN GAME_USERGAMES gug ON gug.UG_GameID = geg.EG_GameID AND gug.UG_UserID = $ID  WHERE geg.EG_EnterpriseID= $EnterpriseID AND gsu.User_id=$ID";
		}   
		// allocate/deallocate Games for SUbEnterprise users
		else if($userType == 'SubEnterpriseUsers')
		{
			$type       = $userType;
			$controller = 'Users';
			$query      = "SELECT gg.Game_ID,gg.Game_Name,gg.Game_Elearning, gsg.*,gs.*,gse.SubEnterprise_StartDate,gse.SubEnterprise_EndDate,gsu.User_id,gsu.User_games,gsu.User_Role,gsu.User_username,gse.SubEnterprise_Name,gse.SubEnterprise_EnterpriseID,gse.SubEnterprise_ID FROM GAME_GAME gg LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gg.Game_ID = gsg.SG_GameID LEFT JOIN GAME_SUBENTERPRISE gse ON gse.SubEnterprise_ID=gsg.SG_SubEnterpriseID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_SubParentId = gsg.SG_SubEnterpriseID LEFT JOIN GAME_USERGAMES gs ON gs.UG_GameID = gg.Game_ID AND gs.UG_UserID=$ID WHERE gsg.SG_EnterpriseID = $EnterpriseID AND gsu.User_id=$ID  ";
		}
		// allocate/deallocate Games for Sub Enterprise
		else
		{
			$type       = 'SubEnterprise';
			$controller = 'SubEnterprise';
			$query      = "SELECT gg.Game_ID, gg.Game_Name,gg.Game_Elearning,gsg.SG_GameID, gsg.SG_ID, gsg.SG_Game_Start_Date, gsg.SG_Game_End_Date,geg.EG_GameID,geg.EG_Game_Start_Date,geg.EG_Game_End_Date,gs.SubEnterprise_Name,gs.SubEnterprise_EnterpriseID,gs.SubEnterprise_ID,gs.SubEnterprise_StartDate,gs.SubEnterprise_EndDate FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID=gg.Game_ID  LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_EnterpriseID=geg.EG_EnterpriseID  LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_GameID = gg.Game_ID AND gsg.SG_SubEnterpriseID = $ID WHERE gg.Game_Delete = 0 AND geg.EG_EnterpriseID=$EnterpriseID AND gs.SubEnterprise_ID=$ID ORDER BY gg.Game_ID ASC";
			//print_r($query);exit;
		}
	}	
	else if($this->session->userdata('loginData')['User_Role']==2)
	{
		$EnterpriseID    = $this->session->userdata('loginData')['User_ParentId'];
		$SubEnterpriseID = $this->session->userdata('loginData')['User_SubParentId'];
		//when subenterprise login, then only allocate/deallocate game for subenterprise users
		$type       = 'SubEnterpriseUsers';
		$controller = 'Users';
		$query      = "SELECT gg.Game_ID,gg.Game_Name,gg.Game_Elearning,gsg.*,gs.*,gsu.User_id,gsu.User_games,gse.SubEnterprise_Name,gsu.User_username,gse.SubEnterprise_EnterpriseID,gse.SubEnterprise_ID, gse.SubEnterprise_StartDate, gse.SubEnterprise_EndDate FROM GAME_GAME gg LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gg.Game_ID = gsg.SG_GameID LEFT JOIN GAME_SUBENTERPRISE gse ON gse.SubEnterprise_ID=gsg.SG_SubEnterpriseID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_SubParentId = gsg.SG_SubEnterpriseID LEFT JOIN GAME_USERGAMES gs ON gs.UG_GameID = gg.Game_ID AND gs.UG_UserID=$ID WHERE gsg.SG_EnterpriseID = $EnterpriseID AND gsg.SG_SubEnterpriseID = $SubEnterpriseID  AND gsu.User_id=$ID ";
	}
	else
	{
		//when admin login, then only allocate/deallocate game for Enterprise,Subenterprise and Users
		if($userType == 'Enterprise')
		{ 
			$type       = 'Enterprise';
			$controller = 'Enterprise';	
			$query = "SELECT gg.Game_ID,gg.Game_Name,gg.Game_Elearning,geg.EG_GameID,geg.EG_ID,geg.EG_Game_Start_Date,geg.EG_Game_End_Date,ge.Enterprise_Name,ge.Enterprise_ID,ge.Enterprise_StartDate,ge.Enterprise_EndDate FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID=gg.Game_ID AND geg.EG_EnterpriseID=$ID JOIN GAME_ENTERPRISE ge WHERE gg.Game_Delete = 0 AND ge.Enterprise_ID=$ID ORDER BY gg.Game_ID ASC";
		}
		elseif($userType == 'SubEnterprise')
		{
			$type       = 'SubEnterprise';
			$controller = 'SubEnterprise';
			$query = "SELECT gg.Game_ID, gg.Game_Name,gg.Game_Elearning,gsg.SG_GameID, gsg.SG_ID, gsg.SG_Game_Start_Date, gsg.SG_Game_End_Date,geg.EG_GameID,geg.EG_Game_Start_Date,geg.EG_Game_End_Date,gs.SubEnterprise_EnterpriseID,gs.SubEnterprise_ID,gs.SubEnterprise_Name, gs.SubEnterprise_StartDate, gs.SubEnterprise_EndDate FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID=gg.Game_ID LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_EnterpriseID=geg.EG_EnterpriseID  LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_GameID = gg.Game_ID AND gsg.SG_SubEnterpriseID = $ID WHERE gg.Game_Delete = 0 AND gs.SubEnterprise_ID=$ID ORDER BY gg.Game_ID ASC";
		}
		elseif($userType == 'EnterpriseUsers')
		{
			$type       = 'EnterpriseUsers';
			$controller = 'Users';
			$query      = "SELECT gg.*,geg.*,gug.*,gsu.User_username,gsu.User_id,geg.EG_EnterpriseID FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON gg.Game_ID=geg.EG_GameID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_ParentId = geg.EG_EnterpriseID  LEFT JOIN GAME_USERGAMES gug ON gug.UG_GameID = geg.EG_GameID AND gug.UG_UserID = $ID  WHERE gsu.User_id=$ID";
		}
		else
		{
			$type       = 'SubEnterpriseUsers';
			$controller = 'Users';
			$query      = "SELECT gg.Game_ID,gg.Game_Name, gsg.*,gs.*,gsu.User_id,gsu.User_games,gsu.User_Role,gsu.User_username,gse.SubEnterprise_Name,gse.SubEnterprise_EnterpriseID,gse.SubEnterprise_ID, gse.SubEnterprise_StartDate, gse.SubEnterprise_EndDate FROM GAME_GAME gg LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gg.Game_ID = gsg.SG_GameID LEFT JOIN GAME_SUBENTERPRISE gse ON gse.SubEnterprise_ID=gsg.SG_SubEnterpriseID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_SubParentId = gsg.SG_SubEnterpriseID LEFT JOIN GAME_USERGAMES gs ON gs.UG_GameID = gg.Game_ID AND gs.UG_UserID=$ID WHERE gsu.User_id=$ID  ";
		}
	}
	$assignGames  = $this->Common_Model->executeQuery($query);
	$content['assignGames'] = $assignGames;
	
	//show subenterprise name and user name when game not assigned
	if(count($assignGames)>0)
	{
		$content['Games'] = $assignGames[0];
	}
	else
	{
		if($type=='SubEnterprise')
		{
			$query = "SELECT SubEnterprise_Name,SubEnterprise_ID FROM GAME_SUBENTERPRISE WHERE SubEnterprise_ID = $ID";
		}
		elseif ($type=='EnterpriseUsers') {
			$query = "SELECT User_username,User_id FROM GAME_SITE_USERS WHERE User_id = $ID";
		}
		elseif($type=='SubEnterpriseUsers')
		{
			$query = "SELECT gsu.User_username,gsu.User_id,gse.SubEnterprise_Name FROM GAME_SITE_USERS gsu LEFT JOIN GAME_SUBENTERPRISE gse ON gsu.User_SubParentId=gse.SubEnterprise_ID WHERE gsu.User_id=".$ID;
		}
		$assignGames = $this->Common_Model->executeQuery($query);
		$content['Games'] = $assignGames[0];
	}
	$content['type'] = $type;

	$RequestMethod   = $this->input->server('REQUEST_METHOD');
	if($RequestMethod == 'POST')
	{
		 //echo "<pre>"; print_r($this->input->post());//exit();
		$assigngames    = $this->input->post('assigngames');
		$GameStartDate  = $this->input->post('gamestartdate');
		$GameEndDate    = $this->input->post('gameenddate');
		$UG_ReplayCount = $this->input->post('UG_ReplayCount');
		$gameID         = $this->input->post('gameID');
		$gamecount      = count($assigngames);
		$count          = count($gameID);
		$Usergameid     = ' ';
		
   //insert Game for Enterprise
		if($userType=='Enterprise')
		{
			//delete enterprise game 
			$where['EG_EnterpriseID'] = $ID ;
			$this->Common_Model->deleteRecords('GAME_ENTERPRISE_GAME',
				$where);
			$query = "DELETE GAME_SUBENTERPRISE_GAME,GAME_USERGAMES FROM GAME_SUBENTERPRISE_GAME INNER JOIN GAME_USERGAMES ON GAME_USERGAMES.UG_ParentId=GAME_SUBENTERPRISE_GAME.SG_EnterpriseID WHERE SG_EnterpriseID=$ID";
			$this->Common_Model->executeQuery($query,'noReturn');

			//update enterprise games
			$query = "UPDATE GAME_ENTERPRISE ge INNER JOIN GAME_SUBENTERPRISE gs on gs.SubEnterprise_EnterpriseID=ge.Enterprise_ID INNER JOIN GAME_SITE_USERS gu ON gu.User_ParentId=ge.Enterprise_ID SET ge.Enterprise_Games='',gs.SubEnterprise_Games='',gu.User_games='' WHERE ge.Enterprise_ID=$ID";
			$this->Common_Model->executeQuery($query,'noReturn');
			
			// manage array for game and date index count
			$Enterprisegameid = '';
			if($gamecount>0)
			{
				for($j=0; $j<$count; $j++)
				{
					if(in_array($gameID[$j],$assigngames))
					{
						$Enterprisegameid     = $Enterprisegameid.$gameID[$j].",";
						$insertEnterpriseGame = array(
							'EG_EnterpriseID'    => $ID,
							'EG_GameID'          => $gameID[$j],
							'EG_Game_Start_Date' => date('Y-m-d',strtotime($GameStartDate[$j])),
							'EG_Game_End_Date'   => date('Y-m-d',strtotime($GameEndDate[$j])),
							'EG_CreatedOn'       => date('Y-m-d H:i:s'),
							'EG_CreatedBy'       => $this->session->userdata('loginData')['User_Id']
						);
						 //print_r($insertEnterpriseGame);exit();
						$result = $this->Common_Model->insert('GAME_ENTERPRISE_GAME', 
							$insertEnterpriseGame);
					}
				}
				//Update Enterprise Games 
				$data = array(
					'Enterprise_Games' => $Enterprisegameid,
				);
				$where = array(
					'Enterprise_ID' => $ID
				);
				$Update = $this->Common_Model->updateRecords('GAME_ENTERPRISE',$data,$where);
				if($Update)
				{
					$this->session->set_flashdata("tr_msg","Details Insert/Update Successfully" );
					if($controller=='Enterprise')
					{
						redirect($controller);
					}
				}
			}
		}
		//insert Game for SubEnterprise
		elseif($userType=='SubEnterprise')
		{
			//Delete already existing data of SubEnterprise
			$where['SG_SubEnterpriseID'] = $ID ;
			$this->Common_Model->deleteRecords('GAME_SUBENTERPRISE_GAME',$where);

			$query = "DELETE FROM GAME_USERGAMES WHERE UG_SubParentId=$ID";
			$this->Common_Model->executeQuery($query,'noReturn');

			//update enterprise games
			$query = "UPDATE GAME_SUBENTERPRISE gs INNER JOIN GAME_SITE_USERS gu ON gu.User_ParentId=gs.SubEnterprise_EnterpriseID SET gs.SubEnterprise_Games='',gu.User_games='' WHERE gs.SubEnterprise_ID=$ID";
			$this->Common_Model->executeQuery($query,'noReturn');
				
			// manage array for game and date index count
			$SubEnterprisegameid = '';
			if($gamecount>0)
			{
				for($j=0; $j<$count; $j++)
				{
					if(in_array($gameID[$j],$assigngames))
					{
						$SubEnterprisegameid     = $SubEnterprisegameid.$gameID[$j].",";
						$insertSubEnterpriseGame = array(
							'SG_EnterpriseID'    => $this->input->post('EnterpriseID'),
							'SG_SubEnterpriseID' => $ID,
							'SG_GameID'          => $gameID[$j],
							'SG_Game_Start_Date' => date('Y-m-d',strtotime($GameStartDate[$j])),
							'SG_Game_End_Date'   => date('Y-m-d',strtotime($GameEndDate[$j])),
							'SG_CreatedOn'       => date('Y-m-d H:i:s'),
							'SG_CreatedBy'       => $this->session->userdata('loginData')['User_Id'],
						);
					// print_r($insertSubEnterpriseGame);exit();
						$result = $this->Common_Model->insert('GAME_SUBENTERPRISE_GAME', 
							$insertSubEnterpriseGame);
					}
				}
			//Update SubEnterprise Games 
				$data = array(
					'SubEnterprise_Games' => $SubEnterprisegameid,
				);
				$where = array(
					'SubEnterprise_ID' => $ID
				);
				$Update = $this->Common_Model->updateRecords('GAME_SUBENTERPRISE',$data,$where);
			//print_r($Update);exit();
				if($Update)
				{
					$this->session->set_flashdata("tr_msg","Details Insert/Update Successfully" );
					if($controller=='SubEnterprise')
					{
						redirect($controller);
					}
				}
			}
		}
		//insert Game for Enterprise and Subenterprise User
		else
		{
			if($this->input->post('Enterprise_ID')&&$this->input->post('SubEnterprise_ID'))
			{
				$UG_ParentId=$this->input->post('Enterprise_ID');
				$UG_SubParentId=$this->input->post('SubEnterprise_ID');
			}
			else
			{
				$UG_ParentId=$this->input->post('Enterprise_ID');
				$UG_SubParentId=-2;
			}
			//Delete already existing data of EnterpriseUser and SubenterpriseUser
			$where = array (
				'UG_UserID' => $ID,
			);
			$this->Common_Model->deleteRecords('GAME_USERGAMES',$where);
			//insert and manage array for game and date index count
			if($gamecount>0)
			{
				for($j=0; $j<$count; $j++)
				{
					if(in_array($gameID[$j],$assigngames))
					{
						$Usergameid      = $Usergameid.$gameID[$j].",";
						$insertUserGames = array(
							'UG_UserID'        => $ID,
							'UG_GameID'        => $gameID[$j],
							'UG_ParentId'      => $UG_ParentId,
							'UG_SubParentId'   => $UG_SubParentId,
							'UG_GameStartDate' => date('Y-m-d',strtotime($GameStartDate[$j])),
							'UG_GameEndDate'   => date('Y-m-d',strtotime($GameEndDate[$j])),
							'UG_ReplayCount'   => $UG_ReplayCount[$j]
						);
					 //echo "<pre>"; print_r($insertUserGames);
						$result = $this->Common_Model->insert('GAME_USERGAMES',$insertUserGames);
					}
				}
			//Update Game_Site_Users Games 
				$data  = array(
					'User_games' => $Usergameid,
				);
				$where = array(
					'User_id' => $ID
				);
				$Update = $this->Common_Model->updateRecords('GAME_SITE_USERS',$data,$where);
				if($Update)
				{
					$this->session->set_flashdata("tr_msg","Details Insert/Update Successfully" );
					redirect($controller.'/'.$type);
				}
			}	
		}
	}
	$content['subview'] = 'assignGames';
	$this->load->view('main_layout',$content);
}

}