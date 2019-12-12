<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

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
	// public function __construct()
	// {
	// 	parent::__construct();
	// 	if($this->session->userdata('botUserData') != NULL)
	// 	{
	// 		redirect('SelectSimulation');
	// 	}
	// }

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ajax_Model');
		$this->botUserData = $this->session->userdata('botUserData');
	}

	public function updateTimerWhilePlaying($linkid=NULL)
	{
		$UserID         = $this->botUserData->User_id;
		$updateTimerSql = "UPDATE GAME_LINKAGE_TIMER SET timer=timer-1 WHERE linkid=$linkid AND userid=$UserID";
		$updateTimer    = $this->Ajax_Model->executeQuery($updateTimerSql,'noReturn');
		die(json_encode(["status" => "200","csrfHash" => $this->csrfHash]));
	}

	public function resetGameData($GameID=NULL)
	{
		// print_r($this->botUserData); die($this->botUserData->User_id);
		if($GameID)
		{
			$UserID = $this->botUserData->User_id;
			// Delete user data from these tables GAME_INPUT, GAME_OUTPUT, GAME_USERSTATUS, GAME_LINKAGE_USERS, then update GAME_LINKAGE_TIMER and reduce replay count by 1 from GAME_USERGAMES, if have some replay count not unlimited(-1)
			$this->db->trans_start();
			// perform all the query b/w transactions

			$deleteSql = " DELETE FROM GAME_INPUT WHERE input_user = $UserID AND input_sublinkid IN( SELECT SubLink_Id FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN ( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $GameID))";
			$this->Ajax_Model->executeQuery($deleteSql,'noReturn');

			$sqlOut = " DELETE FROM GAME_OUTPUT WHERE output_user =$UserID AND output_sublinkid IN(SELECT Sublink_ID FROM GAME_LINKAGE_SUB WHERE Sublink_LinkID IN (SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=$GameID) AND Sublink_Type=1)";
			$this->Ajax_Model->executeQuery($sqlOut,'noReturn');

			$updateSql = " DELETE FROM GAME_USERSTATUS WHERE US_UserID = $UserID AND US_GameID = $GameID";
			$this->Ajax_Model->executeQuery($updateSql,'noReturn');

			$unplay = " DELETE FROM GAME_LINKAGE_USERS WHERE UsScen_GameId =$GameID AND UsScen_UserId=".$UserID;
			$this->Ajax_Model->executeQuery($unplay,'noReturn');

			// updating scenario timer
			$updTimer = "UPDATE GAME_LINKAGE_TIMER glt SET glt.timer =( SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min ) FROM GAME_LINKAGE gl WHERE gl.Link_ID = glt.linkid) WHERE glt.userid = $UserID AND glt.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=$GameID)";
			$this->Ajax_Model->executeQuery($updTimer,'noReturn');

			// updating the replay count
			$reduceReplay = "UPDATE GAME_USERGAMES SET UG_ReplayCount =CASE WHEN UG_ReplayCount > 0 THEN UG_ReplayCount -1 WHEN UG_ReplayCount < 0 THEN -1 END WHERE UG_UserID=$UserID AND UG_GameID=$GameID";
			// die($reduceReplay);			
			$this->Ajax_Model->executeQuery($reduceReplay,'noReturn');

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				die(json_encode(["status" => "201","csrfHash" => $this->csrfHash]));
			}
			else
			{
				die(json_encode(["status" => "200","csrfHash" => $this->csrfHash]));
			}
		}
		else
		{
			// no game selected
			die(json_encode(["status" => "201","csrfHash" => $this->csrfHash]));
		}
	}

	public function showNextComponent($sublinkid=NULL,$value=NULL)
	{
		$UserID          = $this->botUserData->User_id;
		$nextVisibleComp = '';
		$linkId          = '';
		$returnHtmlFlag  = false;
		// echo $sublinkid.' and '.$value;
		// die(json_encode(["status" => "200","csrfHash" => $this->csrfHash]));
		if($sublinkid)
		{
			// update the value to database and then check, starts here
			$whereUpdateInput = array(
				'input_sublinkid' => $sublinkid,
				'input_user'      => $UserID,
			);

			$updateInputData = array(
				'input_current' => $value,
			);
			$updateInputResult = $this->Ajax_Model->updateRecords('GAME_INPUT',$updateInputData,$whereUpdateInput);

			$branchSql = "SELECT gbc.*,gi.input_current FROM GAME_BRANCHING_COMPONENT gbc LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gbc.CompBranch_SublinkId AND input_user=".$UserID." WHERE gbc.CompBranch_SublinkId=".$sublinkid." ORDER BY gbc.CompBranch_Order";

			$branchObj = $this->Ajax_Model->executeQuery($branchSql);
			// user value updated to database successfully, ends here

			// echo $branchSql.'<br><pre>'; print_r($branchObj);
			// if branching exist
			if(count($branchObj) > 0)
			{
				foreach ($branchObj as $branchObjRow)
				{
					// print_r($branchObjRow);
					if(($branchObjRow->input_current >= $branchObjRow->CompBranch_MinVal) && ($branchObjRow->input_current <= $branchObjRow->CompBranch_MaxVal))
					{
						// hiding the current component
						$whereHide = array(
							'input_sublinkid' => $branchObjRow->CompBranch_SublinkId,
							'input_user'      => $UserID,
						);
						$updateHide = array(
							'input_showComp' => 1,
						);
						$updateInputResult = $this->Ajax_Model->updateRecords('GAME_INPUT',$updateHide,$whereHide);

						// showing the next component, to keep the status, if page reload then show from this component
						$whereShow = array(
							'input_sublinkid' => $branchObjRow->CompBranch_NextCompSublinkId,
							'input_user'      => $UserID,
						);
						$updateShow = array(
							'input_showComp' => 2,
						);
						$updateInputResult = $this->Ajax_Model->updateRecords('GAME_INPUT',$updateShow,$whereShow);

						// echo $statusSql.'<br>';
						$nextVisibleComp = $branchObjRow->CompBranch_NextCompId;
						$linkId          = $branchObjRow->CompBranch_LinkId;
						$returnHtmlFlag  = true;
						break;
					}
					// else
					// {
					// 	// no branching exist for this, so move next i.e. linearly
					// 	echo 'no branching condition matched ';
					// }
				}
				// return the html for the next component to show
				if($returnHtmlFlag)
				{
					$getHtml = $this->createHtmlForComponent($linkId,$nextVisibleComp);
					die(json_encode(["status" => "200", "csrfHash" => $this->csrfHash, "appendHtml" => $getHtml]));
				}
			}
			else
			{
				// no branching exist for this, so move next i.e. linearly, write code below to find the liner movement
				echo 'no branching exist';
			}
		}

		else
		{
			// invalid sublink id
			die(json_encode(["status" => "201","csrfHash" => $this->csrfHash]));
		}

	}

	public function getAllOutputComponentsOfArea($linkid=NULL, $areaId=NULL)
	{

		$whereLinkArea = array(
			'SubLink_LinkID'     => $linkid,
			'SubLink_AreaID'     => $areaId,
			'SubLink_SubCompID<' => 1,
			'SubLink_Type'       => 1,
		);
		$getComponent  = $this->Ajax_Model->fetchRecords('GAME_LINKAGE_SUB',$whereLinkArea,'','SubLink_Order');
		// echo "<pre>"; print_r($getComponent);
		// return $getComponent;
		$returnComponent = '';
		foreach ($getComponent as $getComponentRow)
		{
			$returnComponent .= $this->createHtmlForComponent($getComponentRow->SubLink_LinkID,$getComponentRow->SubLink_CompID);
		}
		// print_r($getComponent);
		die(json_encode(["status" => "200","csrfHash" => $this->csrfHash, "returnHtml" => $returnComponent]));
	}

	public function getAllComponentsOfArea($linkid=NULL, $areaId=NULL)
	{

		$whereLinkArea = array(
			'SubLink_LinkID'     => $linkid,
			'SubLink_AreaID'     => $areaId,
			'SubLink_SubCompID<' => 1,
		);
		$getComponent  = $this->Ajax_Model->fetchRecords('GAME_LINKAGE_SUB',$whereLinkArea,'','SubLink_Order');
		// echo "<pre>"; print_r($getComponent);
		// return $getComponent;
		$returnComponent = '';
		foreach ($getComponent as $getComponentRow)
		{
			$returnComponent .= $this->createHtmlForComponent($getComponentRow->SubLink_LinkID,$getComponentRow->SubLink_CompID);
		}
		// print_r($getComponent);
		die(json_encode(["status" => "200","csrfHash" => $this->csrfHash, "returnHtml" => $returnComponent]));
	}

	public function createHtmlForComponent($linkId=NULL,$componentId=NULL,$printNotReturn=NULL)
	{
		// this function will return HTML for single component and it's subcomponent
		// die('componentFunction:- '.$linkId.' '.$componentId);
		// getting gameid for charts
		$whereLink  = array('Link_ID' => $linkId);
		$getLink    = $this->Ajax_Model->fetchRecords('GAME_LINKAGE',$whereLink);
		$gameId     = $getLink[0]->Link_GameID;
		$returnHtml = "";
		$UserID     = $this->botUserData->User_id;
		$getCompSql = "SELECT * FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID WHERE SubLink_LinkID=$linkId AND gls.SubLink_SubCompID<1 AND gi.input_showComp !=1 AND input_user=$UserID ";
		// if we know the next visible component, it means, not comming from page load, calling via ajax above 
		if($componentId)
		{
			$getCompSql .= " AND gls.SubLink_CompID=".$componentId;
		}
		$getCompSql  .= " ORDER BY gi.input_showComp DESC, gls.SubLink_Order ASC LIMIT 1";
		$getComponent = $this->Ajax_Model->executeQuery($getCompSql);

		// generating html starts here
		foreach($getComponent as $findLinkageSubRow)
		{
			$hideByAdmin = "";
			$current     = "";
			$last        = "";
			$fontStyle   = "";
      // check if the component is hide by admin
			if($findLinkageSubRow->SubLink_ShowHide == 1)
			{
				$hideByAdmin = 'd-none';
			}
      // setting the viewingOrder accordingly
			switch ($findLinkageSubRow->SubLink_ViewingOrder)
			{
        // Name - Details/Chart - InputFields
				case 1:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
				$CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
				$CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
				break;

        // Name - InputFields - Details/Chart 
				case 2:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
				$CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
				$CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
				break;

        // Details/Chart - InputFields - Name
				case 3:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
				$CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
				$CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
				break;

        // Details/Chart - Name - InputFields
				case 4:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
				$CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
				$CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
				break;

        // InputFields - Details/Chart - Name
				case 5:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
				$CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
				$CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
				break;

        // InputFields - Name - Details/Chart
				case 6:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
				$CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
				$CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
				break;

        // InputFields - Name - FullLength
				case 7:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-right";
				$CompDetailsChart = "d-none";
				$CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-left";
				break;

        // InputFields - Details/Chart - FullLength
				case 8:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "d-none";
				$CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-right";
				$CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-left";
				break;

        // Name - Details/Chart - FullLength
				case 9:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
				$CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
				$CompInputFields  = "d-none";
				break;

        // Name - InputFields - FullLength
				case 10:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
				$CompDetailsChart = "d-none";
				$CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
				break;

        // Details/Chart - Name - FullLength
				case 11:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-right";
				$CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-left";
				$CompInputFields  = "d-none";
				break;

        // Details/Chart - InputFields - FullLength
				case 12:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "d-none";
				$CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
				$CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
				break;

        // Name - InputFields - HalfLength
				case 13:
				$ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
				$ComponentName    = "col-md-6 col-xl-6 col-xs-12 col-sm-6";
				$CompDetailsChart = "d-none";
				$CompInputFields  = "col-md-6 col-xl-6 col-xs-12 col-sm-6";
				break;

        // InputFields - Name - HalfLength
				case 14:
				$ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
				$ComponentName    = "col-md-6 col-xl-6 col-xs-12 col-sm-6 float-right";
				$CompDetailsChart = "d-none";
				$CompInputFields  = "col-md-6 col-xl-6 col-xs-12 col-sm-6 float-left";
				break;

        // CkEditor - FullLength
				case 15:
				$ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
				$ComponentName    = "d-none";
				$CompDetailsChart = "col-md-12 col-xl-12 col-xs-12 col-sm-12";
				$CompInputFields  = "d-none";
				break;

        // CkEditor - HalfLength
				case 16:
				$ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
				$ComponentName    = "d-none";
				$CompDetailsChart = "col-md-12 col-xl-12 col-xs-12 col-sm-12";
				$CompInputFields  = "d-none";
				break;

        // ckEditor - InputFields - HalfLength
				case 17:
				$ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
				$ComponentName    = "d-none";
				$CompDetailsChart = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
				$CompInputFields  = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
				break;

        // InputFields - ckEditor - HalfLength
				case 18:
				$ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
				$ComponentName    = "d-none";
				$CompDetailsChart = "col-md-3 col-xl-3 col-xs-12 col-sm-3 float-right";
				$CompInputFields  = "col-md-3 col-xl-3 col-xs-12 col-sm-3 float-left";
				break;

        //Name - Detailchart - HalfLength
				case 19:
				$ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
				$ComponentName    = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
				$CompDetailsChart = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
				$CompInputFields  = "d-none";
				break;

				default:
				$ComponentLength  = "";
				$ComponentName    = "";
				$CompDetailsChart = "";
				$CompInputFields  = "";
				break;
			}
      // setting background-color, text-color, font-size and font-style if set by admin
			if($findLinkageSubRow->SubLink_FontSize || $findLinkageSubRow->SubLink_FontStyle)
			{
				$fontStyle = "style='width:auto; font-size:".$findLinkageSubRow->SubLink_FontSize."px; font-family:".$findLinkageSubRow->SubLink_FontStyle."; background-color:".$findLinkageSubRow->SubLink_BackgroundColor."; color:".$findLinkageSubRow->SubLink_TextColor."; '";
			}
			$returnHtml = "<div class='row clearfix componentDiv ".$ComponentLength.' '.$hideByAdmin."' id='removeCompDiv' $fontStyle><div class='row componentNameDiv ".$ComponentName."'>$findLinkageSubRow->SubLink_CompName</div><div class='row ckEditorDiv ".$CompDetailsChart."'>";

			// if there is chart then show chart, else show ckEditor details
			if($findLinkageSubRow->SubLink_ChartID && $findLinkageSubRow->SubLink_ChartType)
			{
				$returnHtml .= "<img id='chart_".$findLinkageSubRow->SubLink_ID."' class='graph_chart comp_chart col-md-12' src='".base_url('../')."chart/".$findLinkageSubRow->SubLink_ChartType.".php?gameid=".$gameId."&userid=".$UserID."&ChartID=".$findLinkageSubRow->SubLink_ChartID."' alt='".$findLinkageSubRow->SubLink_ChartType." Chart For Component' style='border-radius: 0; max-width: fit-content;' onclick='return showImageOnFullScreen(this.id);' data-toggle='tooltip' title='Chart For ".$findLinkageSubRow->SubLink_CompName."'>";
			}
			else
			{
				$returnHtml .= $findLinkageSubRow->SubLink_Details;
			}

			$returnHtml .= "</div>";

			// <!-- if mode is not none then only show the inputFields values (carry admin formula) -->
			if($findLinkageSubRow->SubLink_InputMode != 'none')
			{
				$returnHtml .= "<div class='row inputFieldDiv ".$CompInputFields."' id=''>";

				// check that personalize outcome exist or not only for o/p components i.e. SubLink_Type=1, if yes then show outcome, and hide input value
				$showOtucome = '';

				if($findLinkageSubRow->SubLink_Type ==1)
				{
					$outComeSql = "SELECT gpo.Outcome_MinVal, gpo.Outcome_MaxVal, gpo.Outcome_Order, gpo.Outcome_FileName, gpo.Outcome_FileType, gpo.Outcome_Description, gi.input_current, gi.input_sublinkid, gls.SubLink_CompName FROM GAME_PERSONALIZE_OUTCOME gpo LEFT JOIN GAME_LINKAGE_SUB gls ON gls.SubLink_LinkID = gpo.Outcome_LinkId AND gls.SubLink_CompID = gpo.Outcome_CompId AND gls.SubLink_Type = 1 LEFT JOIN GAME_INPUT gi ON gi.input_user =".$UserID." AND gi.input_sublinkid = gls.SubLink_ID WHERE gpo.Outcome_LinkId =".$linkId." AND gpo.Outcome_CompId =".$componentId." AND gpo.Outcome_IsActive = 0 ORDER BY gpo.Outcome_Order ASC";

					$getOutcome = $this->Ajax_Model->executeQuery($outComeSql);
					if(count($getOutcome) > 0)
					{
						foreach ($getOutcome as $getOutcomeRow)
						{
							if($getOutcomeRow->input_current>=$getOutcomeRow->Outcome_MinVal && $getOutcomeRow->input_current<=$getOutcomeRow->Outcome_MaxVal)
							{
								$showOtucome = 'd-none';
								$returnHtml .= "<img src='".base_url('../ux-admin/upload/Badges/'.$getOutcomeRow->Outcome_FileName)."' alt='Outcome image for ".$getOutcomeRow->SubLink_CompName." not found' id='outcome_".$getOutcomeRow->input_sublinkid."' class='' data-toggle='tooltip' title='".$getOutcomeRow->Outcome_Description."' onclick='return showImageOnFullScreen(this.id);'><div class='row'>$getOutcomeRow->Outcome_Description</div>";
								break;
							}
						}
					}
				}
				// personalize outcome ends here

				if($findLinkageSubRow->SubLink_InputMode == 'carry')
				{
					$returnHtml .= "<div class='".$showOtucome."' $fontStyle><label>".$findLinkageSubRow->SubLink_LabelCurrent."</label><input type='text' data-sublinkid='".$findLinkageSubRow->SubLink_ID."' value='".$findLinkageSubRow->input_current."' readonly></div>";
				}

				elseif($findLinkageSubRow->SubLink_InputMode == 'admin')
				{
          // check for SubLink_InputFieldOrder, it means show only current or last values
					switch ($findLinkageSubRow->SubLink_InputFieldOrder)
					{
						case 1:
            // label current - label last
						$current = "";
						$last    = "";
						break;

						case 2:
            // label current - label last
						$current = "float-right";
						$last    = "float-left";
						break;

						case 3:
            // label current
						$current = "";
						$last    = "d-none";
						break;

						case 4:
            // label last
						$current = "d-none";
						$last    = "";
						break;
					}
					$returnHtml .= "<div class='".$current." ".$showOtucome."' $fontStyle><input type='text' data-sublinkid='".$findLinkageSubRow->SubLink_ID."' value='".$findLinkageSubRow->SubLink_AdminCurrent."' readonly></div><div class='".$last." ".$showOtucome."' $fontStyle><input type='text' data-sublinkid='".$findLinkageSubRow->SubLink_ID."' value='".$findLinkageSubRow->SubLink_AdminLast."' readonly></div>";
				}

				elseif($findLinkageSubRow->SubLink_InputMode == 'formula')
				{
					$returnHtml .= "<div class='".$showOtucome."' $fontStyle><label>".$findLinkageSubRow->SubLink_LabelCurrent."</label><input type='text' data-sublinkid='".$findLinkageSubRow->SubLink_ID."' value='".$findLinkageSubRow->input_current."' readonly></div>";
				}

				// if none of the above then user mode, it can have mChoice, range or normal text box
				else
				{
					//<!-- show user inputs here "$findLinkageSubRow->SubLink_InputModeTypeValue"-->
					$returnHtml .= "<div class='userInputsDiv ".$showOtucome."' $fontStyle>";
					if($findLinkageSubRow->SubLink_InputModeType == 'mChoice')
					{
						$SubLink_InputModeTypeValue = json_decode($findLinkageSubRow->SubLink_InputModeTypeValue,true);

            // echo $findLinkageSubRow->input_current."<pre>"; print_r($SubLink_InputModeTypeValue); echo "</pre>";

						$question       = $SubLink_InputModeTypeValue['question'];
						$defaultChecked = $SubLink_InputModeTypeValue['makeDefaultChecked'];
						$questionFlag   = false;
            // if default checked is selected from admin, then remove last element from array
						if($defaultChecked)
						{
							array_pop($SubLink_InputModeTypeValue);
						}
            // print question in a row
						$returnHtml .= "<div class=''>".$question."</div><br>";
						foreach(($SubLink_InputModeTypeValue) as $optionText => $optionValue)
						{
              // as first is question, so skip this,
							if($questionFlag)
							{
                // hiding the default, selected from admin end
								$hideDefault = ($defaultChecked==$optionText)?'d-none':'';
                // check the value and make it checked
								$checkedDefault = ($findLinkageSubRow->input_current==$optionValue)?'checked':'';
								$returnHtml    .= '<div class="custom-control custom-radio mb-3 '.$hideDefault.'"><input type="radio" data-sublinkid="'.$findLinkageSubRow->SubLink_ID.'" class="custom-control-input" id="'.$optionText.$optionText.'" name="radio-stacked" value="'.$optionValue.'" required '.$checkedDefault.'><label class="custom-control-label" for="'.$optionText.$optionText.'">'.$optionText.'</label><div class="invalid-feedback">More example invalid feedback text</div></div>';
							}
							$questionFlag = true;
						}
					}
					elseif($findLinkageSubRow->SubLink_InputModeType == 'range')
					{
						// show range type inputs here
						$SubLink_InputModeTypeValue = explode(',',$findLinkageSubRow->SubLink_InputModeTypeValue);
						$returnHtml .= "<label for='range_".$findLinkageSubRow->SubLink_ID."'>$findLinkageSubRow->SubLink_LabelCurrent</label>";

						$returnHtml .= "<input type='range' data-sublinkid='".$findLinkageSubRow->SubLink_ID."' class='typeRange custom-range' id='range_".$findLinkageSubRow->SubLink_ID."' value='".$findLinkageSubRow->input_current."' min='".$SubLink_InputModeTypeValue[0]."' max='".$SubLink_InputModeTypeValue[1]."' step='".$SubLink_InputModeTypeValue[2]."' required>";

						$returnHtml .= "<center><span class='rangeValue badge badge-pill badge-primary' style='font-size: 100%;'>$findLinkageSubRow->input_current</span></center>";
					}
					else
					{
						// show normal input box here for taking user input, show it like wsp input
						$returnHtml .= "<div class='bottom-row col-md-12 float-left' style='left:1px; background:#ffffff;'><div class='' style='display: inline-block;'>".$findLinkageSubRow->SubLink_LabelCurrent."</div><div class='float-right' style='display: inline-block;'><input type='text' data-sublinkid='".$findLinkageSubRow->SubLink_ID."' id='userInput' class='form-control' aria-describedby='userInput' value='".$findLinkageSubRow->input_current."' style='color: #000000; font-weight: bolder; width: 100px;' required></div></div>";
					}
					$returnHtml .= "</div>";
				}


				$returnHtml .= "</div>";
			}
			// else
			// {
			// 	echo "<script>console.log('Component ".$findLinkageSubRow->SubLink_ID." mode is none.')</script>";
			// }
			// get all subcomponents here by calling the function createHtmlForSubComponent()

			$returnHtml .= "</div>";
		}
		// for loop and generating html ends here
		if($printNotReturn)
		{
			// this means, we are calling this function via ajax from view page to get componentHtml i.e. from i/p or o/p
			die(json_encode(["status" => "200","csrfHash" => $this->csrfHash, "returnHtml" => $returnHtml]));
		}
		return $returnHtml;

	}

	public function createHtmlForSubComponent($linkId=NULL,$componentId=NULL)
	{
		// this function will return HTML for single component and it's subcomponent
		$UserID = $this->botUserData->User_id;
		die('subComponentFunction:- '.$linkId.' '.$componentId);
		echo "<div class='subcomponentDiv'>// put all the subComponents here</div>";
	}

	public function getScenarioTime($linkid=NULL)
	{
		$UserID = $this->botUserData->User_id;

		if($linkid)
		{
			$whereTimer = array(
				'linkid' => $linkid,
				'userid' => $UserID,
			);
			$getTime = $this->Ajax_Model->fetchRecords('GAME_LINKAGE_TIMER',$whereTimer,'timer');
			// print_r($getTime);
			die(json_encode(["status" => "200", "csrfHash" => $this->csrfHash, "timer" => $getTime[0]->timer]));
		}
		else
		{
			die(json_encode(["status" => "201","csrfHash" => $this->csrfHash]));
		}
	}

	public function submitInput($linkid=NULL,$gameid=NULL)
	{
		// return next url to play simulation SubLink_LinkIDcarry SubLink_CompIDcarry SubLink_SubCompIDcarry
		$formulaArray     = array();
		$carryArray       = array();
		$UserID           = $this->botUserData->User_id;
		$formulaReplace   = array();
		$replaceSublinkId = array();
		// likely selected all the components, some to form and calcuate formula, some for carryforward purpose, and also taken user type as well, to update the carryForward values if forwarded any from user actual values
		$findFormulaCompSubcomp = "SELECT * FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=$UserID WHERE gls.SubLink_LinkID=$linkid AND (gls.SubLink_InputMode='formula' OR gls.SubLink_InputMode='carry' OR gls.SubLink_InputMode='user')";
		$getFormulaCompSubcomp  = $this->Ajax_Model->executeQuery($findFormulaCompSubcomp);
		// find formula expression and calculate
		foreach ($getFormulaCompSubcomp as $getFormulaCompSubcompRow)
		{
			// if type is formula then calculate the formula
			if($getFormulaCompSubcompRow->SubLink_FormulaID > 1 || $getFormulaCompSubcompRow->SubLink_InputMode == 'formula')
			{
				$formulaArray[$getFormulaCompSubcompRow->SubLink_ID] = eval('return '.$this->formulaExpressionCalculate($linkid,$getFormulaCompSubcompRow->SubLink_ID,$getFormulaCompSubcompRow->SubLink_FormulaExpression).';');
			}
			else
			{
				// if SubLink_InputMode is either admin or user, so get the values as it is and put it into array, it may possible that some comp/subComp are carry forwarded from these values as well
				if($getFormulaCompSubcompRow->SubLink_InputMode == 'carry' || $getFormulaCompSubcompRow->SubLink_InputMode == 'user' || $getFormulaCompSubcompRow->SubLink_InputMode == 'admin')
				{
					if($getFormulaCompSubcompRow->SubLink_InputMode=='user' || $getFormulaCompSubcompRow->SubLink_InputMode=='admin')
					{
						// adding user values as it is to formula array as well
						$formulaArray[$getFormulaCompSubcompRow->SubLink_ID] = $getFormulaCompSubcompRow->input_current;
					}
					else
					{
						$getSublinkIdSql = "SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID=$getFormulaCompSubcompRow->SubLink_LinkIDcarry AND SubLink_CompID=$getFormulaCompSubcompRow->SubLink_CompIDcarry";
						if($getFormulaCompSubcompRow->SubLink_SubCompIDcarry>0)
						{
							$getSublinkIdSql .= " AND SubLink_SubCompID=$getFormulaCompSubcompRow->SubLink_SubCompIDcarry";
						}
						else
						{
							$getSublinkIdSql .= " AND SubLink_SubCompID<1 ";
						}
						$getSublinkId = $this->Ajax_Model->executeQuery($getSublinkIdSql);
						$carryArray[$getFormulaCompSubcompRow->SubLink_ID] = $getSublinkId[0]->SubLink_ID;
					}
					continue;
				}
			}

		}

		// echo count($formulaArray)."<pre>"; print_r($formulaArray);
		if(count($formulaArray)>0)
		{
			$replaceSql = "SELECT Rep_SublinkID, Rep_Start, Rep_End, Rep_Value FROM GAME_LINK_REPLACE WHERE Rep_SublinkID IN (".implode(',', array_keys($formulaArray)).") AND (Rep_Start!=0 OR Rep_End!=0 ) ORDER BY Rep_SublinkID ASC, Rep_Order";
			if(count($this->Ajax_Model->executeQuery($replaceSql)) > 0)
			{
				$formulaReplace[] = $this->Ajax_Model->executeQuery($replaceSql);
			}
		}

		if(count($formulaReplace)>0)
		{
			// taking these variable to avoid the repetation check for the same sublinkID, as there would be 2 row for same sublinkID
			$check_replace_subLink_id = '';
			$check_replace_flag       = false;
			foreach ($formulaReplace as $formulaReplaceRow)
			{
				// print_r($formulaReplaceRow);
				if($check_replace_subLink_id == $formulaReplaceRow->Rep_SublinkID && $check_replace_flag)
				{
					continue;
				}
				else
				{
					$check_replace_subLink_id = $formulaReplaceRow->Rep_SublinkID;
					$actualValue              = $formulaArray[$formulaReplaceRow->Rep_SublinkID];
					$minValue                 = $formulaReplaceRow->Rep_Start;
					$maxValue                 = $formulaReplaceRow->Rep_End;

					if($actualValue >= $minValue && $actualValue <= $maxValue)
					{
						// echo "<br>Replaced:- $formulaReplaceRow->Rep_SublinkID<br>";
						$formulaArray[$formulaReplaceRow->Rep_SublinkID] = $formulaReplaceRow->Rep_Value;
						$check_replace_flag = true;
						continue;
					}
					else
					{
						// echo "<br>Not Replaced:- $formulaReplaceRow->Rep_SublinkID<br>";
						$check_replace_flag = false;
					}
				}
			}
		}
		
		// check for carry forward values
		if(count($carryArray) > 0)
		{
			foreach ($carryArray as $carryArrayKey => $carryArrayValues)
			{
				// check if formula array has the value for the $carryArrayValues(sublink_id), if not then it means that check/verify from the game_input table or it may be default (0);
				// $carryArray[$carryArrayKey]   = $formulaArray[$carryArrayValues];
				// $formulaArray[$carryArrayKey] = $formulaArray[$carryArrayValues];
				
				// if key exist, i.e. if carry forwarded from same scenario
				if(array_key_exists($carryArrayValues, $formulaArray))
				{
					$carryArray[$carryArrayKey]   = $formulaArray[$carryArrayValues];
					$formulaArray[$carryArrayKey] = $formulaArray[$carryArrayValues];
				}
				else
				{
					$where_sublink_id = array(
						'input_sublinkid' => $carryArrayValues,
						'input_user'      => $UserID,
					);
					$input_current = $this->Ajax_Model->fetchRecords('GAME_INPUT',$where_sublink_id);
					if(count($input_current)>0)
					{
						$carryArray[$carryArrayKey]   = $input_current[0]->input_current;
						$formulaArray[$carryArrayKey] = $input_current[0]->input_current;
					}
					else
					{
						$carryArray[$carryArrayKey]   = 0;
						$formulaArray[$carryArrayKey] = 0;
					}
				}
			}

			// checking for replace values again, for carry forwarded values
			$replaceSql = "SELECT Rep_SublinkID, Rep_Start, Rep_End, Rep_Value FROM GAME_LINK_REPLACE WHERE Rep_SublinkID IN (".implode(',', array_keys($carryArray)).") AND (Rep_Start!=0 OR Rep_End!=0 ) ORDER BY Rep_SublinkID ASC, Rep_Order";
			if(count($this->Ajax_Model->executeQuery($replaceSql)) > 0)
			{
				$replaceSublinkId[] = $this->Ajax_Model->executeQuery($replaceSql);
			}

			if(count($replaceSublinkId)>0)
			{
				// taking these variable to avoid the repetation check for the same sublinkID, as there would be 2 row for same sublinkID
				$check_replace_subLink_id = '';
				$check_replace_flag       = false;
				foreach ($replaceSublinkId as $replaceSublinkIdRow)
				{
					// print_r($replaceSublinkIdRow);
					if($check_replace_subLink_id == $replaceSublinkIdRow->Rep_SublinkID && $check_replace_flag)
					{
						continue;
					}
					else
					{
						$check_replace_subLink_id = $replaceSublinkIdRow->Rep_SublinkID;
						$actualValue              = $carryArray[$replaceSublinkIdRow->Rep_SublinkID];
						$minValue                 = $replaceSublinkIdRow->Rep_Start;
						$maxValue                 = $replaceSublinkIdRow->Rep_End;

						if($actualValue >= $minValue && $actualValue <= $maxValue)
						{
							// echo "<br>Replaced:- $replaceSublinkIdRow->Rep_SublinkID<br>";
							$carryArray[$replaceSublinkIdRow->Rep_SublinkID]   = $replaceSublinkIdRow->Rep_Value;
							$formulaArray[$replaceSublinkIdRow->Rep_SublinkID] = $replaceSublinkIdRow->Rep_Value;
							$check_replace_flag                                = true;
							continue;
						}
						else
						{
							// echo "<br>Not Replaced:- $replaceSublinkIdRow->Rep_SublinkID<br>";
							$check_replace_flag = false;
						}
					}
				}
			}
		}
		// echo $findFormulaCompSubcomp."<pre>"; print_r($formulaArray); print_r($carryArray);
		// now updating the values into the database and then set the user game status to o/p page and redirect to o/p
		foreach($formulaArray as $key => $value)
		{
			$whereInput = array(
				'input_user'      => $UserID,
				'input_sublinkid' => $key,
			);
			$dataInput  = array(
				'input_current' => $value,
			);
			$this->Ajax_Model->updateRecords('GAME_INPUT',$dataInput,$whereInput);
		}

		// updating the user game status US_Output, US_UserID, US_GameID
		$whereInput = array(
			'US_UserID' => $UserID,
			'US_GameID' => $gameid,
		);
		$dataInput  = array(
			'US_Output' => 1,
		);
		$this->Ajax_Model->updateRecords('GAME_USERSTATUS',$dataInput,$whereInput);
		die(json_encode(["status" => "200", "csrfHash" => $this->csrfHash, "redirect" => base_url('PlaySimulation/output/'.base64_encode($gameid))]));

	}

	public function submitOutput($gameid=NULL,$linkid=NULL)
	{
		$errMessage = "Database queries did not completed successfully.";
		$UserID     = $this->botUserData->User_id;
		$status     = 201;
		$this->db->trans_start();

		$whereDeleteReport = array(
			'uid'    => $UserID,
			'linkid' => $linkid,
		);
		// delete the existing data or report for that particular user, deleteRecords
		$deleteReport = $this->Ajax_Model->deleteRecords('GAME_SITE_USER_REPORT_NEW',$whereDeleteReport);
		$sqlComp12    = "SELECT ls.SubLink_ID,  CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
		FROM `GAME_LINKAGE_SUB` ls 
		LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
		LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
		WHERE SubLink_LinkID=".$linkid." 
		ORDER BY SubLink_ID";

		$objcomp12 = $this->Ajax_Model->executeQuery($sqlComp12);

		foreach ($objcomp12 as $rowinput)
		{
			$title = $rowinput->Comp_Subcomp;

			$checkWhere = array(
				'input_user'      => $UserID,
				'input_sublinkid' => $rowinput->SubLink_ID,
			);
			$check = $this->Ajax_Model->fetchRecords('GAME_INPUT', $checkWhere);

			$check1Where = array(
				'output_user'      => $UserID,
				'output_sublinkid' => $rowinput->SubLink_ID,
			);
			$check1 = $this->Ajax_Model->fetchRecords('GAME_OUTPUT', $check1Where);

			if(count($check) > 0)
			{
				$result            = $check[0];
				$userdate [$title] = $result->input_current;
			}
			elseif(count($check1) > 0)
			{
				$result1           = $check1[0];
				$userdate [$title] = $result1->output_current;
			}
			else
			{
				$userdate [$title] = '';
			}
		}

		$gameScenSql  = "SELECT gg.Game_ID, gg.Game_Name, gs.Scen_ID, gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID WHERE gl.Link_ID=".$linkid;
		$gameScenName = $this->Ajax_Model->executeQuery($gameScenSql);

		$userReportDetail = array(
			'uid'            =>	$UserID,
			'user_name'      =>	$this->botUserData->User_username,
			'game_name'      =>	$gameScenName[0]->Game_Name,
			'secenario_name' =>	$gameScenName[0]->Scen_Name,
			'linkid'         =>	$linkid,
			'user_data'      =>	json_encode($userdate),
			'date_time'      =>	date('Y-m-d H:i:s')
		);
		$result = $this->Ajax_Model->insert('GAME_SITE_USER_REPORT_NEW', $userReportDetail);
		// report modification done

		// make the current scenario to be played i.e. UsScen_Status=1
		$scenStatusWhere = array(
			'UsScen_UserId' => $UserID,
			'UsScen_GameId' => $gameid,
			'UsScen_ScenId' => $gameScenName[0]->Scen_ID,
		);
		$updateScenStatusData = array(
			'UsScen_Status' => 1,
		);
		$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_LINKAGE_USERS',$updateScenStatusData,$scenStatusWhere);

		// if there is only one scenario then it will be set to UsScen_IsEndScenario=1 by default from PlaySimulation->input() when user comes to i/p page
		$checkEndScenWhere = array(
			'UsScen_UserId'        => $UserID,
			'UsScen_GameId'        => $gameid,
			'UsScen_ScenId'        => $gameScenName[0]->Scen_ID,
			'UsScen_IsEndScenario' => 1,
		);
		$endScenStatus = $this->Ajax_Model->fetchRecords('GAME_LINKAGE_USERS',$checkEndScenWhere);

		if(count($endScenStatus) > 0)
		{
			// it means -> this is the end scenario, SO, redirect to result page and also setting game user status to completed
			$userStatusWher = array(
				'US_UserID' => $UserID,
				'US_GameID' => $gameid,
			);
			$userStatusData = array(
				'US_LinkID' => 1,
			);

			$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_USERSTATUS',$userStatusData,$userStatusWher);
			$redirectUrl      = base_url('PlaySimulation/result/'.base64_encode($gameid));
			$status           = 200;
		}

		else
		{
			$checkEndScenWhere = array(
				'UsScen_UserId' => $UserID,
				'UsScen_GameId' => $gameid,
			);
			$endScenStatus = $this->Ajax_Model->fetchRecords('GAME_LINKAGE_USERS',$checkEndScenWhere);

			if(count($endScenStatus) > 2)
			{
				// it means that multiple scenario for this game exist, i.e. more than 2, then only scenario branching is possible

				// check that branching for the current scenario exist or not in GAME_BRANCHING_SCENARIO table
				$branchWhere = array(
					'Branch_GameId'   => $gameid,
					'Branch_LinkId'   => $linkid,
					'Branch_IsActive' => 0,
				);
				$checkBranching = $this->Ajax_Model->fetchRecords('GAME_BRANCHING_SCENARIO',$branchWhere,'','Branch_Order');

				if(count($checkBranching) > 0)
				{
					$branchingFlag = true;
					$valueSql      = "SELECT input_current FROM GAME_INPUT WHERE input_user=".$UserID." AND input_key LIKE '%comp_".$checkBranching[0]->Branch_CompId."'";
					$getValue      = $this->Ajax_Model->executeQuery($valueSql);
					$inputValue    = ($getValue[0]->input_current)?$getValue[0]->input_current:0;
					// branching exist for the current scenario
					foreach ($checkBranching as $checkBranchingRow)
					{
						// check the min max conditions
						if($inputValue>=$checkBranchingRow->Branch_MinVal && $inputValue<=$checkBranchingRow->Branch_MaxVal)
						{
							// this means condition matched so break the loop, and set the $redirectUrl value
							$branchingFlag = false;
							$redirectUrl   = base_url('PlaySimulation/input/'.base64_encode($gameid));
							$status        = 200;
							// also update GAME_USERSTATUS according to next moving scenario
							$modifyUserStatusWher = array(
								'US_UserID' => $UserID,
								'US_GameID' => $gameid,
							);
							$modifyUserStatusData = array(
								'US_LinkID' => 0,
								'US_ScenID' => $checkBranchingRow->Branch_NextScen,
								'US_Output' => 0,
							);
							$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_USERSTATUS',$modifyUserStatusData,$modifyUserStatusWher);
							$redirectUrl      = base_url('PlaySimulation/input/'.base64_encode($gameid));
							$status           = 200;
							// if this is the end scenario, also mark this as end scenario in GAME_LINKAGE_USERS table
							if($checkBranchingRow->Branch_IsEndScenario == 1)
							{
								$userLinkageStatusWhere = array(
									'UsScen_UserId' => $UserID,
									'UsScen_GameId' => $gameid,
									'UsScen_LinkId' => $checkBranchingRow->Branch_NextLinkId,
								);
								$userLinkageStatusData  = array(
									'UsScen_IsEndScenario' => 1,
								);
								$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_LINKAGE_USERS',$userLinkageStatusData,$userLinkageStatusWhere);
							}
							break;
						}
					}
					if($branchingFlag)
					{
						// branching condition did not match // also $this->db->trans_rollback(); reset above executed queries
						$status     = 201;
						$errMessage = "There is gap in branching range. Please check the scenario branching ranges.";
						// also update GAME_USERSTATUS according to next moving scenario
					}
				}
				else
				{
					// discuss it, if branching doesn't exist for the current scenario // also $this->db->trans_rollback(); reset above executed queries
					$status     = 201;
					$errMessage = "There are multiple scenarios but branching doesn't exist for the current scenario.";
					// $redirectUrl = 'set url here, next scenario';
				}
				// also update GAME_USERSTATUS according to next moving scenario
			}
			else
			{
				// if there are only 2 scenarios
				$flagBranching = true;
				foreach ($endScenStatus as $endScenStatusRow)
				{
					if($endScenStatusRow->UsScen_LinkId != $linkid && $endScenStatusRow->UsScen_Status == 0)
					{
						// this is the next unplayed scenario
						$flagBranching        = false;
						$updateBranchingWhere = array(
							'UsScen_Id' => $endScenStatusRow->UsScen_Id,
						);
						$updateBranching = array(
							'UsScen_IsEndScenario' => 1,
							'UsScen_Status'        => 1,
						);
						// if only having 2 scenario then move to next unplayed scenario linearly, and make it end scenario
						$branchingStatus = $this->Ajax_Model->updateRecords('GAME_LINKAGE_USERS',$updateBranching,$updateBranchingWhere);
						// also update GAME_USERSTATUS according to next moving scenario
						$modifyUserStatusWhere = array(
							'US_UserID' => $UserID,
							'US_GameID' => $gameid,
						);
						$modifyUserStatusData = array(
							'US_LinkID' => 0,
							'US_ScenID' => $endScenStatusRow->UsScen_ScenId,
							'US_Output' => 0,
						);

						$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_USERSTATUS',$modifyUserStatusData,$modifyUserStatusWhere);
						$redirectUrl      = base_url('PlaySimulation/input/'.base64_encode($gameid));
						$status           = 200;
					}
				}
				// if no unplayed scenario found, then mark the current scenario as complete and end scenario, and redirect to result page
				if($flagBranching)
				{
					$scenStatusWhere = array(
						'UsScen_UserId' => $UserID,
						'UsScen_GameId' => $gameid,
						'UsScen_ScenId' => $gameScenName[0]->Scen_ID,
					);
					$updateScenStatusData = array(
						'UsScen_Status'        => 1,
						'UsScen_IsEndScenario' => 1,
					);
					$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_LINKAGE_USERS',$updateScenStatusData,$scenStatusWhere);
					// also update GAME_USERSTATUS according to next moving scenario
					$modifyUserStatusWhere = array(
						'US_UserID' => $UserID,
						'US_GameID' => $gameid,
					);
					$modifyUserStatusData = array(
						'US_LinkID' => 1,
					);
					
					$updateScenStatus = $this->Ajax_Model->updateRecords('GAME_USERSTATUS',$modifyUserStatusData,$modifyUserStatusWhere);
					$redirectUrl      = base_url('PlaySimulation/result/'.base64_encode($gameid));
					$status           = 200;
				}
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			die(json_encode(["status" => $status, "csrfHash" => $this->csrfHash, "message" => $errMessage]));
		}
		else
		{
			die(json_encode(["status" => $status, "csrfHash" => $this->csrfHash, "redirectUrl" => $redirectUrl]));
		}

	}

	public function formulaExpressionCalculate($linkid=NULL,$SubLink_ID=NULL,$formulaExpression=NULL)
	{
		$UserID = $this->botUserData->User_id;
		// find the comp, subcomp from the formula expression and calculate, also check for carryForward, and min-max limit
		// echo $linkid.' '.$SubLink_ID.' and expression:-'.$formulaExpression.'<br>';
		// print_r(explode(' ',$formulaExpression)); echo "<br><br>";
		// putting the formula expression into a loop to check that this is further dependent or not
		$returnFormula = '(';
		$formulaExpression = explode(' ',$formulaExpression);
		foreach ($formulaExpression as $formulaExpressionValue)
		{
			// check if component
			if(strpos($formulaExpressionValue,'comp') !== false)
			{
				$exp      = explode('_',$formulaExpressionValue);
				$checkSql = "SELECT * FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID=".$linkid." AND SubLink_FormulaID>1 AND SubLink_CompID=".$exp[1]." AND SubLink_SubCompID<1";
				$dependsOn = $this->Ajax_Model->executeQuery($checkSql);
				if(count($dependsOn) > 0)
				{
					// if found then return the value
					$returnFormula .= ' '.$this->formulaExpressionCalculate($dependsOn[0]->SubLink_LinkID,$dependsOn[0]->SubLink_ID,$dependsOn[0]->SubLink_FormulaExpression);
				}
				else
				{
					// if not found then return component as it is
					$inputSql = "SELECT * FROM GAME_LINKAGE_SUB gls INNER JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID WHERE SubLink_SubCompID<1 AND SubLink_LinkID=$linkid AND SubLink_CompID=".$exp[1]." AND gi.input_user=".$UserID;
					$inputValue     = $this->Ajax_Model->executeQuery($inputSql);
					$returnFormula .= ' '.$inputValue[0]->input_current.' ';
				}
			}
			// check if subcomponent
			elseif(strpos($formulaExpressionValue,'subc') !== false)
			{
				$exp      = explode('_',$formulaExpressionValue);
				$checkSql = "SELECT * FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID=$linkid AND SubLink_FormulaID>1 AND SubLink_SubCompID=".$exp[1];
				$dependsOn = $this->Ajax_Model->executeQuery($checkSql);
				if(count($dependsOn) > 0)
				{
					// if found then return the value
					$returnFormula .= ' '.$this->formulaExpressionCalculate($dependsOn[0]->SubLink_LinkID,$dependsOn[0]->SubLink_ID,$dependsOn[0]->SubLink_FormulaExpression);
				}
				else
				{
					// if not found then return subcomponent as it is
					$inputSql = "SELECT * FROM GAME_LINKAGE_SUB gls INNER JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID WHERE SubLink_LinkID=$linkid AND SubLink_SubCompID=".$exp[1]." AND gi.input_user=".$UserID;
					$inputValue     = $this->Ajax_Model->executeQuery($inputSql);
					$returnFormula .= ' '.$inputValue[0]->input_current.' ';
				}
			}
			else
			{
				// this is math sign
				$returnFormula .= ' '.$formulaExpressionValue;
			}
		}
		$returnFormula .= ')';
		return $returnFormula;
	}

	private function checkFormulaDependency($linkid=NULL,$SubLink_ID=NULL,$formulaExpression=NULL)
	{
		// check if, the component or subcomponent is further depending to any other comp/subComp or not
	}


}
