<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlaySimulation extends My_Controller {

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

	public $botUserData;
	public $userID;
	public function __construct()
	{
		parent::__construct();
		$this->botUserData = $this->session->userdata('botUserData');
		$this->userID      = $this->botUserData->User_id;
	}

	public function index()
	{
		$this->session->set_flashdata('er_msg', "You don't have permission to access this page");
		redirect('SelectSimulation');
	}

	public function input($gameId=NULL)
	{
		$checkUserGame  = $this->checkUserGame($gameId);
		$checkKeyUpdate = true;
		//* in bot enabled(Game_Type=1) games, there must be only one area and there would be no game_description and scenario_description

		// creating/editing game linkage for users depending upon the scenario for scenario branching
		$userLinkageSql = "SELECT gl.Link_ID, gl.Link_GameID, gl.Link_ScenarioID, gl.Link_Hour, gl.Link_Min, gl.Link_Order, glu.UsScen_Id, glu.UsScen_GameId, glu.UsScen_ScenId, glu.UsScen_LinkId, glu.UsScen_UserId, glu.UsScen_Status FROM GAME_LINKAGE gl LEFT JOIN GAME_LINKAGE_USERS glu ON glu.UsScen_LinkId = gl.Link_ID AND glu.UsScen_UserId = $checkUserGame->UG_UserID WHERE gl.Link_GameID = $checkUserGame->UG_GameID AND gl.Link_Status = 1 ORDER BY gl.Link_Order";
		$userLinkageResult = $this->Common_Model->executeQuery($userLinkageSql);

		$gameID = $userLinkageResult[0]->Link_GameID;

		foreach ($userLinkageResult as $userLinkageResultRow)
		{
			// if it has only one row/linkage then this will be the end scenario, and scen_status will be played by default
			$endScenario = (count($userLinkageResult)>1)?0:1;
			if(empty($userLinkageResultRow->UsScen_Id))
			{
				// add this linkage, it may be possible that user is playing first time, or admin added new linkage
				$insertUserLinkage = array(
					'UsScen_UserId'        => $this->userID,
					'UsScen_ScenId'        => $userLinkageResultRow->Link_ScenarioID,
					'UsScen_GameId'        => $userLinkageResultRow->Link_GameID,
					'UsScen_LinkId'        => $userLinkageResultRow->Link_ID,
					'UsScen_Status'        => 0,
					'UsScen_IsEndScenario' => $endScenario,
				);
				$getUserLinkageId = $this->Common_Model->insert('GAME_LINKAGE_USERS',$insertUserLinkage);
			}
		}

		$whereStatus = array(
			'US_GameID' => $gameID,
			'US_UserID' => $this->userID,
		);
		$checkForFirstTime = $this->Common_Model->fetchRecords('GAME_USERSTATUS',$whereStatus);

		// if row exist then check that user has completed the game or in which scenario user is, there must be only one row for the selected game for the current user
		if(count($checkForFirstTime) > 0)
		{
			$checkForFirstTime = $checkForFirstTime[0];
			if($checkForFirstTime->US_LinkID == 1)
			{
				// it means user has completed the game, so redirect to result page
				$this->session->set_flashdata('tr_msg', 'You have successfully completed the simulation');
				redirect('PlaySimulation/result/'.$gameId);
			}

			if($checkForFirstTime->US_Output == 1)
			{
				// it means user is in the output page, but not submitted, so redirect to output page
				$this->session->set_flashdata('tr_msg', 'You have already provided inputs');
				redirect('PlaySimulation/output/'.$gameId);
			}
		}

		// from $checkForFirstTime, if game_userstatus has no row for user to the selected game, then it means user is playing this game first time, or reset everything, so insert game status row
		else
		{
			$insertUserGameStatus = array(
				'US_GameID'     => $gameID,
				'US_UserID'     => $this->userID,
				'US_ScenID'     => $userLinkageResult[0]->Link_ScenarioID,
				'US_Input'      => 1,
				'US_CreateDate' => date( 'Y-m-d h:i:s' ),
			);
			$getUserStatusId = $this->Common_Model->insert('GAME_USERSTATUS',$insertUserGameStatus);

			// also insert data from game_views to game_input, as user is fresh starting the game 
			$whereKeyUpdate = array(
				'views_Game_ID' => $gameID,
			);
			$getGameViews = $this->Common_Model->fetchRecords('GAME_VIEWS',$whereKeyUpdate);
			// if any changes or updation found, then update it for user
			if(count($getGameViews) > 0)
			{
				foreach($getGameViews as $getGameViewsRow)
				{
					$insertInputs = array(
						'input_user'      => $this->userID,
						'input_sublinkid' => $getGameViewsRow->views_sublinkid,
						'input_current'   => $getGameViewsRow->views_current,
						'input_key'       => $getGameViewsRow->views_key,
					);
					$getUserInputId = $this->Common_Model->insert('GAME_INPUT',$insertInputs);
				}
				$checkKeyUpdate = false;
			}
		}

		// check if admin update any comp or subcomp for the area that changes the key then update after login
		if($checkKeyUpdate)
		{
			$updateInputKey = $this->updateInputKey($gameID);
		}

		// echo "$userLinkageSql in input() <pre>"; print_r($checkForFirstTime[0]); echo "</pre>"; 

		// check every single thing/possiblity above, now writing query for finding the current scenario from game_userstatus, and set timer for the scenario
		$whereScen = array(
			'US_UserID' => $this->userID,
			'US_GameID' => $gameID,
		);
		$findScen = $this->Common_Model->fetchRecords('GAME_USERSTATUS',$whereScen);
		$findScen = $findScen[0];

		$whereLinkage = array(
			'Link_GameID'     => $gameID,
			'Link_ScenarioID' => $findScen->US_ScenID,
		);
		$findLinkage = $this->Common_Model->fetchRecords('GAME_LINKAGE',$whereLinkage);
		$findLinkage = $findLinkage[0];

		$whereScenario = array(
			'Scen_Delete' => 0,
			'Scen_ID'     => $findScen->US_ScenID,
		);
		$findScenario = $this->Common_Model->fetchRecords('GAME_SCENARIO',$whereScenario);
		$findScenario = $findScenario[0];
		// echo "<pre>"; print_r($findLinkage[0]); exit();

		// check that timer exist or not
		$checkTimer = array(
			'linkid' => $findLinkage->Link_ID,
			'userid' => $this->userID,
		);
		// insert timer for each linkage for logged in user
		$insertTimer = array(
			'linkid' => $findLinkage->Link_ID,
			'userid' => $this->userID,
			'timer'  => (($findLinkage->Link_Hour*60)+$findLinkage->Link_Min),
		);
		$insertTimerId = $this->Common_Model->insert('GAME_LINKAGE_TIMER',$insertTimer,$checkTimer);
		// check and insert of timer end here

		// after setting everything above, then finding game component/subcomponent 
		$findLinkageSubSql = "SELECT * FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID WHERE SubLink_LinkID=".$findLinkage->Link_ID;
		if($checkUserGame->Game_Type == 1)
		{
			// show only the first or unplayed component/subcomponent, which need to be shown to user

			// $findLinkageSubSql = "SELECT * FROM GAME_LINKAGE_SUB glss JOIN GAME_AREA gaa ON gaa.Area_ID = glss.SubLink_AreaID JOIN GAME_INPUT gii ON gii.input_sublinkid = glss.SubLink_ID WHERE gii.input_user =$this->userID AND glss.SubLink_CompID =( SELECT gls.SubLink_CompID FROM GAME_LINKAGE_SUB gls JOIN GAME_INPUT gi ON gi.input_sublinkid = gls.SubLink_ID WHERE SubLink_LinkID =".$findLinkage->Link_ID." AND gls.SubLink_SubCompID < 1 AND gi.input_showComp != 1 AND input_user =$this->userID ORDER BY gi.input_showComp DESC , gls.SubLink_Order ASC LIMIT 1 ) ORDER BY glss.SubLink_SubCompID";
			// above query will give the component and subcomponent together
			$findLinkageSubSql    .= " AND gls.SubLink_SubCompID<1 AND gi.input_showComp !=1 AND input_user=$this->userID ORDER BY gi.input_showComp DESC, gls.SubLink_Order ASC LIMIT 1 ";
			// $content['navigation'] = 'hide';
			$content['subview']    = 'botInput';
			$findLinkageSub        = $this->Common_Model->executeQuery($findLinkageSubSql);
		}
		else
		{
			$content['subview'] = 'input';
			$findLinkageSubSql .= " ORDER BY gls.SubLink_Order ";
			$findLinkageSub     = $this->Common_Model->executeQuery($findLinkageSubSql);
		}

		// $findLinkageSub = $this->Common_Model->executeQuery($findLinkageSubSql);
		// echo "$findLinkageSubSql<pre>"; print_r($findScenario); print_r($findLinkage); print_r($findLinkageSub); exit();

		$content['findScenario']   = $findScenario;
		$content['findLinkage']    = $findLinkage;
		$content['findLinkageSub'] = $findLinkageSub;
		$this->load->view('main_layout',$content);
	}

	public function output($gameId=NULL)
	{
		$checkUserGame         = $this->checkUserGame($gameId);
		// $content['navigation'] = 'hide';
		$userID                = $this->userID;
		// $gameId             = $checkUserGame->US_GameID;
		$scenId                = $checkUserGame->US_ScenID;

		if($checkUserGame->US_LinkID == 1)
		{
			// it means user has completed the game, so redirect to result page
			$this->session->set_flashdata('tr_msg', 'You have successfully completed the simulation');
			redirect('PlaySimulation/result/'.$gameId);
		}
		if(empty($checkUserGame->US_LinkID) && empty($checkUserGame->US_Output))
		{
			$this->session->set_flashdata('er_msg', 'Please submit inputs to see the output');
			redirect('PlaySimulation/input/'.$gameId);
		}

		// find linkage first and then fetch data from game_linkage_sub, also check for outcome images
		$outputSql = "SELECT gls.SubLink_ID, gls.SubLink_LinkID, gls.SubLink_AreaID, gls.SubLink_AreaName, ga.Area_BackgroundColor, ga.Area_TextColor, gs.Scen_Name, gs.Scen_Image  FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID= gls.SubLink_AreaID LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=".$userID." LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID=gls.SubLink_LinkID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID  WHERE gls.SubLink_LinkID IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$checkUserGame->US_GameID." AND Link_ScenarioID=".$checkUserGame->US_ScenID.") AND gls.SubLink_Type=1 GROUP BY SubLink_AreaID";

		$findLinkageSub = $this->Common_Model->executeQuery($outputSql);
		// echo $outputSql."<pre>"; print_r($findLinkageSub);
		if(count($findLinkageSub)<1)
		{
			$this->session->set_flashdata('er_msg', 'No output exist for the current scenario');
		}
		$content['findLinkageSub'] = $findLinkageSub;
		$content['gameId']         = base64_decode($gameId);
		$content['subview']        = 'botOutput';
		$this->load->view('main_layout',$content);
	}

	public function result($gameId=NULL)
	{
		$checkUserGame = $this->checkUserGame($gameId);
		if($checkUserGame->US_LinkID == 0 && $checkUserGame->US_Output == 1)
		{
			// it means user is in the output page, but not submitted, so redirect to output page
			$this->session->set_flashdata('er_msg', 'Please submit to see the reports');
			redirect('PlaySimulation/output/'.$gameId);
		}
		if($checkUserGame->US_LinkID == 0 && $checkUserGame->US_Output == 0)
		{
			// it means user is in the output page, but not submitted, so redirect to output page
			$this->session->set_flashdata('er_msg', 'Please submit/complete the game to see the reports');
			redirect('PlaySimulation/output/'.$gameId);
		}
		// echo "in result() <pre>"; print_r($checkUserGame); exit();
		$content['gameResult'] = $checkUserGame;
		$content['subview']    = 'result';
		$this->load->view('main_layout',$content);
	}

	private function checkUserGame($gameId=NULL)
	{		
		if(empty($gameId))
		{
			// no game selected, show error message
			$this->session->set_flashdata('er_msg', 'No game selected');
			redirect('SelectSimulation');
		}
		else
		{
			// to check that given string is valid string for base64_decode() or not
			if (!base64_decode($gameId, true))
			{
				$this->session->set_flashdata('er_msg', 'Invalid Game ID');
				redirect('SelectSimulation');
			}

			$gameId = base64_decode($gameId);
			// check that user has this game or not
			$checkGame = "SELECT gug.*, gus.*,gg.Game_Name, gg.Game_Type, gg.Game_Image, gg.Game_Comments, gg.Game_ID, UNIX_TIMESTAMP(gug.UG_GameStartDate) AS gameStartDate, UNIX_TIMESTAMP(gug.UG_GameEndDate) AS gameEndDate FROM GAME_USERGAMES gug LEFT JOIN GAME_USERSTATUS gus ON gug.UG_GameID = gus.US_GameID AND gus.US_UserID=".$this->userID." LEFT JOIN GAME_GAME gg ON gg.Game_ID=gug.UG_GameID WHERE gug.UG_UserID =".$this->userID." AND gg.Game_Type=1 AND gug.UG_GameID =".$gameId;
			$checkGameResult = $this->Common_Model->executeQuery($checkGame);
			// echo $checkGame."<pre>"; print_r($checkGameResult); exit();
			if(count($checkGameResult) < 1)
			{
				// this game is not assigned to user
				$this->session->set_flashdata('er_msg', 'This bot simulation either does not exist or not assigned to you');
				redirect('SelectSimulation');
			}
			else
			{
				$checkGameResult = $checkGameResult[0];
				// game is allocated to user, check the game start-date and end-date range, UG_GameStartDate, UG_GameEndDate
				if(! (time()>$checkGameResult->gameStartDate && time()<$checkGameResult->gameEndDate))
				{
					// user is not authorised to play simulation from today or till today
					$this->session->set_flashdata('er_msg', "You are allowed to play simulation from ".date('d-m-Y',strtotime($checkGameResult->UG_GameStartDate))." to ".date('d-m-Y',strtotime($checkGameResult->UG_GameEndDate)));
					redirect('SelectSimulation');
				}
				else
				{
					// echo "<pre>"; print_r($checkGameResult);
					// now check the different status of the game in the above declared functions i.e. input(), output(), result() and perform task accordingly
					// if user is playing simulation first time
					// if user is resuming the simulation
					// is user is playing simulation with different scenario
					return $checkGameResult;
				}
			}
		}
	}

	private function updateInputKey($gameID=NULL,$checkKeyUpdate=NULL)
	{
		$whereKeyUpdate = array(
			'views_Game_ID' => $gameID,
			'is_updated'    => 1,
		);
		$checkKeyUpdation = $this->Common_Model->fetchRecords('GAME_VIEWS',$whereKeyUpdate);
		// if any changes or updation found, then update it for user
		if(count($checkKeyUpdation) > 0)
		{
			foreach($checkKeyUpdation as $checkKeyUpdationRow)
			{
				$whereInput = array(
					'input_sublinkid' => $checkKeyUpdationRow->views_sublinkid,
					'input_user'      => $this->userID,
				);

				$updateInputKey = $this->Common_Model->updateRecords('GAME_INPUT',array('input_key' => $checkKeyUpdationRow->views_key),$whereInput);
			}
			return ["status" => "200"];
		}
		else
		{
			return ["status" => "201"];
		}
	}


}
