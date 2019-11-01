<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

// include PHPExcel
require('includes/PHPExcel.php');
//echo "Output";
// create new PHPExcel object
$objPHPExcel  = new PHPExcel;
$functionsObj = new Functions();
//$linkid     = $_GET['Link'];
//$scenid     = $_GET['Scenario'];
// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
$userid        = $_SESSION['userid'];
//echo $userid;
$gameid        = $_GET['ID'];
$query         = " SELECT gl.Link_ID,gg.Game_Name,gc.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID=gl.Link_ScenarioID WHERE gl.Link_GameID=".$gameid." AND gl.Link_ScenarioID=( SELECT gu.US_ScenID FROM GAME_USERSTATUS gu WHERE gu.US_UserID=".$userid." AND gu.US_GameID=".$gameid.")";

$queryExecute = $functionsObj->ExecuteQuery($query);
$resultObject = $queryExecute->fetch_object();
// print_r($resultObject); exit; 
$userName      = $_SESSION['userName'];
$gameName      = $resultObject->Game_Name;
$ScenarioName  = $resultObject->Scen_Name;
$linkidSession = $resultObject->Link_ID;

//echo $gameid."</br>";
//exit();
if (isset($_GET['ID']) && !empty($_GET['ID']))
{
	//get the actual link
	$where = array (
		"US_GameID = " . $gameid,
		"US_UserID = " . $userid
	);
	$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0 );
	
	if ($obj->num_rows > 0)
	{							
		$result1 = $functionsObj->FetchObject ( $obj );
		if ($result1->US_LinkID == 0)
		{
			// else finish the game and go to result.php
			if($result1->US_ScenID == 0)
			{
				//goto game_description page
				header("Location:".site_root."game_description.php?Game=".$gameid);
				exit();
			}
			else
			{
				//get linkid				
				$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$result1->US_ScenID;
				
				//echo $sqllink;
				$link       = $functionsObj->ExecuteQuery($sqllink);
				$resultlink = $functionsObj->FetchObject($link);				
				$linkid     = $resultlink->Link_ID;

				if ($result1->US_Input == 0 && $result1->US_Output == 0 )
				{
					if($link->num_rows > 0)
					{											
						$url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;
						//echo $url;
					}
					//goto scenario_description page
					
					header("Location:".site_root."scenario_description.php?Link=".$resultlink->Link_ID);
					exit();
				}
				elseif($result1->US_Input == 1 && $result1->US_Output == 0 )
				{
					//goto Input page
					//$url = site_root."input.php?Link=".$resultlink->Link_ID;
					header("Location:".site_root."input.php?ID=".$gameid);
					exit();
				}
				else
				{
					$skipSql = "SELECT gl.*,glu.UsScen_IsEndScenario as endScenario FROM GAME_LINKAGE gl INNER JOIN GAME_LINKAGE_USERS glu ON glu.UsScen_LinkId=gl.Link_ID WHERE gl.Link_ScenarioID=$result1->US_ScenID AND glu.UsScen_UserId=$userid";
					$skipSqlObj = $functionsObj->ExecuteQuery($skipSql);
					// if enabled then rout to next input by auto submitting
					$skipOutput = $functionsObj->FetchObject($skipSqlObj);
					// echo "<pre>"; print_r($skipOutput); die();
					//goto output page
					//$url = site_root."output.php?Link=".$resultlink->Link_ID;		
					//header("Location:".site_root."output.php?Link=".$resultlink->Link_ID);
					//Goto next scenario					
				}
			}
		}
		else{
			//goto result page
			$url = site_root."result.php?Link=".$result1->US_LinkID;
			header("Location:".site_root."result.php?ID=".$gameid);
			exit();
		}
	}
	else
	{
		//goto game_description page
		
		header("Location:".site_root."game_description.php?Game=".$gameid);
		exit();
	}
}
else{
	header("Location:".site_root."selectgame.php");
	exit();
}

$sql    = "SELECT * FROM GAME_LINKAGE WHERE Link_ID = ".$linkid;
$object = $functionsObj->ExecuteQuery($sql);

if($object->num_rows > 0)
{
	$link    = $functionsObj->FetchObject($object);
	$gameid  = $link->Link_GameID;
	$scenid  = $link->Link_ScenarioID;
	$gameurl = site_root."game_description.php?Game=".$gameid;
	$scenurl = site_root."scenario_description.php?Link=".$linkid;	
}

$where = array (
	"US_GameID = " . $gameid,
	"US_ScenID = " . $scenid,
	"US_UserID = " . $userid
);

$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, '', '', '', '', 0 );

if ($obj->num_rows > 0)
{
	$status       = $functionsObj->FetchObject($obj);
	$userstatusid = $status->US_ID;
		//exists
	$array = array (			
		'US_Output' => 1
	);
	$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
}
else
{
		//insert
	$array = array (
		'US_GameID'     => $gameid,
		'US_ScenID'     => $scenid,
		'US_UserID'     => $userid,
		'US_Input'      => 1,
		'US_Output'     => 1,
		'US_CreateDate' => date ( 'Y-m-d H:i:s' ) 
	);
	$result = $functionsObj->InsertData ( 'GAME_USERSTATUS', $array, 0, 0 );
}
// when user submit page from next button
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	// echo "<pre>$userid,$gameid,".$_POST['ScenarioId'].",".$_POST['LinkId']; exit;
	// $deleteSql = "DELETE FROM GAME_LINKAGE_USERS WHERE UsScen_UserId=$userid AND UsScen_LinkId=".$_POST['LinkId'];
	$updateLinkId = $_POST['LinkId'];
	
	// removing newly added link and scenario id at the first of the array
	array_shift($_POST);
	array_shift($_POST);
	// removing element of array i.e. submit
	array_shift($_POST);
	// echo "<pre>"; print_r($_POST); exit();
	// echo "<pre>"; print_r($skipOutput);	die('here: '.$skipOutput->Link_Enabled);
	// if($skipOutput->Link_Enabled < 1 || $skipOutput->endScenario > 0){
		foreach ($_POST as $input_key => $input_current)
		{
			$output_sql = " SELECT * FROM GAME_INPUT WHERE input_user=$userid AND input_key LIKE '".$input_key."'";
			$output_res = $functionsObj->ExecuteQuery($output_sql);
			if($output_res->num_rows > 0)
			{
					// update output data to game_input table
				$update_array   = array(
					'input_current' => $input_current,
				);

				$where      = " input_user=$userid AND input_key";
				$update_res = $functionsObj->UpdateData( 'GAME_INPUT', $update_array, $where, $input_key  );
			}
			else
			{
				// find sublinkid from GAME_LINKAGE_SUB regarding comp or subc
				$SubLink_CompID =  explode('_',$input_key);
				$CompID         = end($SubLink_CompID);
				// $CompID      = $SubLink_CompID[2];
				$find_sublinkId = "SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID=".$linkidSession;
				if($SubLink_CompID[1] == 'comp')
				{
					$find_sublinkId .= " AND SubLink_CompID=$CompID";
				}
				else
				{
					$find_sublinkId .= " AND SubLink_SubCompID=$CompID";
				}
				$objectSublink   = $functionsObj->ExecuteQuery($find_sublinkId);
				$sublinkObject   = $functionsObj->FetchObject($objectSublink);
				$input_sublinkid = $sublinkObject->SubLink_ID;
					// insert output data to game_input table
				$insert_array    = array(
					'input_user'      => $userid,
					'input_sublinkid' => $input_sublinkid,
					'input_key'       => $input_key,
					'input_current'   => $input_current,
				);

				$insert_res = $functionsObj->InsertData( 'GAME_INPUT', $insert_array, 0, 0 );
			}
		}

		// delete the existing data or report for that particular user
		$delete_sql = "DELETE FROM GAME_SITE_USER_REPORT_NEW WHERE uid=$userid AND linkid=".$linkidSession;
		$delete     = $functionsObj->ExecuteQuery($delete_sql);
		$sqlComp12  = "SELECT ls.SubLink_ID,  CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
		FROM `GAME_LINKAGE_SUB` ls 
		LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
		LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
		WHERE SubLink_LinkID=".$linkidSession." 
		ORDER BY SubLink_ID";

		$objcomp12 = $functionsObj->ExecuteQuery($sqlComp12);

		while($rowinput = $objcomp12->fetch_object())
		{
			$title  = $rowinput->Comp_Subcomp;					
			$check  = $functionsObj->SelectData(array(), 'GAME_INPUT', array("input_user='".$userid."' AND  input_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);

			$check1 = $functionsObj->SelectData(array(), 'GAME_OUTPUT', array("output_user='".$userid."' AND  output_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);

			if($check->num_rows > 0)
			{
				$result            = $functionsObj->FetchObject($check);
				$userdate [$title] = $result->input_current;
			}
			elseif($check1->num_rows > 0)
			{
				$result1           = $functionsObj->FetchObject($check1);
				$userdate [$title] = $result1->output_current;
			}
			else
			{
				$userdate [$title] = '';
			}
		}

		$userreportdetails = (object) array(
			'uid'            =>	$userid,
			'user_name'      =>	$userName,
			'game_name'      =>	$gameName,
			'secenario_name' =>	$ScenarioName,
			'linkid'         =>	$linkidSession,
			'user_data'      =>	json_encode($userdate),
			'date_time'      =>	date('Y-m-d H:i:s')
		);
		$result = $functionsObj->InsertData('GAME_SITE_USER_REPORT_NEW', $userreportdetails);
		// report modification done
	// }
	// $sql = "SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$gameid." and Link_Order>
	// (SELECT Link_Order FROM `GAME_LINKAGE`
	// WHERE Link_GameID = ".$gameid." and Link_ScenarioID=".$scenid.")
	// ORDER BY Link_Order LIMIT 1";

	// check that this is end scenario or not
	$checkEndSql = "SELECT * FROM `GAME_LINKAGE_USERS` WHERE UsScen_UserId=".$userid." AND UsScen_GameId=".$gameid." AND UsScen_ScenId=".$scenid." AND UsScen_IsEndScenario=0";
	$checkEndObj = $functionsObj->ExecuteQuery($checkEndSql);
	if($checkEndObj->num_rows > 0)
	{
		// replacing upper query from this one coz this give the unplayed scenarios and upper sql gives the nex scenario only, if we will get the next then branching is not possible to redirect user into the previous scenarios
		$sql = "SELECT gl.Link_ID, gu.UsScen_IsEndScenario FROM GAME_LINKAGE gl LEFT JOIN GAME_LINKAGE_USERS gu ON gu.UsScen_GameId=gl.Link_GameID AND gu.UsScen_ScenId=gl.Link_ScenarioID AND gu.UsScen_UserId=".$userid." WHERE gl.Link_GameID = ".$gameid." AND (gl.Link_Order >( SELECT Link_Order FROM `GAME_LINKAGE` WHERE Link_GameID = ".$gameid." AND Link_ScenarioID = ".$scenid." ) AND gu.UsScen_Status=0) ORDER BY Link_Order LIMIT 1";
		$input    = $functionsObj->ExecuteQuery($sql);
		$inputObj = $functionsObj->FetchObject($input);
		//echo $input->num_rows;
		
		// if this is not the end scenario then go to if		
		if($input->num_rows > 0 && $inputObj->UsScen_IsEndScenario == 0)
		{
			// scenario branching $gameid $scenid $userid
			$sublinkSql = "SELECT gu.UsScen_Status, gl.SubLink_ID,gb.*,gi.input_key,gi.input_current FROM GAME_BRANCHING_SCENARIO gb LEFT JOIN GAME_LINKAGE_SUB gl ON gl.SubLink_CompID=gb.Branch_CompId AND gl.SubLink_LinkID=gb.Branch_LinkId LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gl.SubLink_ID LEFT JOIN GAME_LINKAGE_USERS gu ON gu.UsScen_LinkId=gb.Branch_LinkId AND gu.UsScen_UserId=$userid WHERE gb.Branch_GameId=$gameid AND gb.Branch_ScenId=$scenid AND gi.input_user=$userid AND gl.SubLink_Type=1 AND gl.SubLink_SubCompID=0 AND gb.Branch_IsActive=0 GROUP BY gb.Branch_Id ORDER BY gb.Branch_Order";
			// die($sublinkSql);
			$subRes = $functionsObj->ExecuteQuery($sublinkSql);
			// if scenario branching enabled
			if($subRes->num_rows > 0)
			{
				while ($subObj = $functionsObj->FetchObject($subRes))
				{
					// echo "<pre>"; print_r($subObj);
					if($subObj->input_current == '')
					{
						$subObj->input_current = 0;
					}
					if($subObj->input_current >= $subObj->Branch_MinVal && $subObj->input_current <= $subObj->Branch_MaxVal && $subObj->UsScen_Status<1)
					{
						// die('jumped to next scen '.$subObj->Branch_NextScen);
						// writing this query to update status of played scenario by user for scenario branching, deleting the row instead of updating
						$unplayScen = " UPDATE GAME_LINKAGE_USERS SET UsScen_Status=1 WHERE  UsScen_UserId=$userid AND UsScen_LinkId =".$updateLinkId;
						$functionsObj->ExecuteQuery($unplayScen);

						// updating end scenario 
						$unplayScenario = " UPDATE GAME_LINKAGE_USERS SET UsScen_IsEndScenario=".$subObj->Branch_IsEndScenario." WHERE  UsScen_UserId=$userid AND UsScen_LinkId =".$subObj->Branch_NextLinkId;
						$functionsObj->ExecuteQuery($unplayScenario);
						// echo "<pre>".$unplayScen.'<br>'.$unplayScenario; print_r($subObj); exit;
						// finding that in next scenario intro/description is skipped or not 
						$skipSql = "SELECT * FROM GAME_LINKAGE WHERE Link_ID=".$subObj->Branch_NextLinkId;
						$skipObj = $functionsObj->ExecuteQuery($skipSql);
						$skipRes = $functionsObj->FetchObject ($skipObj);
						// update the game_userstatus and skip scenario if enabled then redirect to i/p page
						if($skipRes->Link_Description > 0)
						{
							$array = array (			
								'US_ScenID' => $skipRes->Link_ScenarioID,
								'US_Input'  => 1,
								'US_Output' => 0
							);
							$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
							header("Location: ".site_root."input.php?ID=".$gameid);
						}
						// if intro/desc is not skipped then redirect to scenario_description page
						else
						{
							header("Location: ".site_root."scenario_description.php?Link=".$subObj->Branch_NextLinkId);
						}
						exit(0);
					}
					else
					{
						// if user submit from o/p page and come back to o/p page then locate to scenario or next step
						// echo "<pre>".$unplayScen.'<br>'.$unplayScenario; print_r($subObj->Branch_IsEndScenario); exit;
						header("Location: ".site_root."scenario_description.php?Link=".$subObj->Branch_NextLinkId);
					}
				}
			}
			else
			{
				// die('no result');
				$unplay = "UPDATE GAME_LINKAGE_USERS SET UsScen_Status=1 WHERE  UsScen_UserId=$userid AND UsScen_LinkId =".$updateLinkId;
				$functionsObj->ExecuteQuery($unplay);
				// $result = $functionsObj->FetchObject($input);
				$skipSql = "SELECT * FROM GAME_LINKAGE WHERE Link_ID=".$inputObj->Link_ID;
				$skipObj = $functionsObj->ExecuteQuery($skipSql);
				$skipRes = $functionsObj->FetchObject ($skipObj);
				// update the game_userstatus and skip scenario if enabled then redirect to i/p page
				if($skipRes->Link_Description > 0)
				{
					$array = array (			
						'US_ScenID' => $skipRes->Link_ScenarioID,
						'US_Input'  => 1,
						'US_Output' => 0
					);
					$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
					header("Location: ".site_root."input.php?ID=".$gameid);
				}
				else
				{
					header("Location: ".site_root."scenario_description.php?Link=".$inputObj->Link_ID);
				}
				// header("Location: ".site_root."result.php?ID=".$gameid);
				exit(0);
			}
		}
		else
		{
			// die('end scenario');
			$unplay = "UPDATE GAME_LINKAGE_USERS SET UsScen_Status=1 WHERE  UsScen_UserId=$userid AND UsScen_LinkId =".$updateLinkId;
			$functionsObj->ExecuteQuery($unplay);
			header("Location: ".site_root."result.php?ID=".$gameid);
			exit(0);
		}
	}
	
	else
	{
		// die('result');
		header("Location: ".site_root."result.php?ID=".$gameid);
		exit(0);
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Download'){
	//echo "Download code -- ".$linkid;
	//exit();

	// set default font
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');

	// set default font size
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	// create the writer
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

	/**

	 * Define currency and number format.

	 */

	// currency format, € with < 0 being in red color
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	// number format, with thousands separator and two decimal points.
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	// writer already created the first sheet for us, let's get it
	$objSheet       = $objPHPExcel->getActiveSheet();

	// rename the sheet
	$objSheet->setTitle('Output');

	// let's bold and size the header font and write the header
	// as you can see, we can specify a range of cells, like here: cells from A1 to A4
	$objSheet->getStyle('A1:D1')->getFont()->setBold(true)->setSize(12);
	
	// write header

	$objSheet->getCell('A1')->setValue('Component');
	$objSheet->getCell('B1')->setValue('Scenario One'); // replace by actual Scenario
	
	
	$sql = "SELECT c.Comp_Name, s.SubComp_Name, o.output_current 
	FROM `GAME_OUTPUT` o 
	INNER JOIN `GAME_LINKAGE_SUB` ls ON o.output_sublinkid = ls.SubLink_ID
	INNER JOIN GAME_COMPONENT c ON ls.SubLink_CompID= c.Comp_ID
	LEFT OUTER JOIN GAME_SUBCOMPONENT s ON ls.SubLink_SubCompID=s.SubComp_ID
	WHERE output_user=".$userid." AND ls.SubLink_LinkID=".$linkid." AND ls.SubLink_Type=1 AND ls.SubLink_ShowHide=0";
	//echo $sql;
	//exit();
	$objoutput = $functionsObj->ExecuteQuery($sql);
	//echo $objoutput->num_rows;
	if($objoutput->num_rows > 0){
		$i=2;
		while($row= $objoutput->fetch_object()){
			//echo $row->Comp_Name."  ". $row->output_current;
			$objSheet->getCell('A'.$i)->setValue($row->Comp_Name);
			$objSheet->getCell('B'.$i)->setValue($row->output_current);
			$i++;
		}
		//exit();
		// autosize the columns
		$objSheet->getColumnDimension('A')->setAutoSize(true);
		$objSheet->getColumnDimension('B')->setAutoSize(true);

		//Setting the header type
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Output.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter->save('php://output');
		//$objWriter->save('testoutput.xlsx');
	}
}

$sql = "SELECT g.game_name as Game,sc.Scen_Name as Scenario, sc.Scen_Image AS BackgroundImage, a.Area_Name as Area,
c.Comp_Name as Component, s.SubComp_Name as Subcomponent, l.*,ls.* 
FROM GAME_LINKAGE l 
INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE  l.Link_ID=".$linkid;
//" order by link_gameid,Link_ScenarioID,Link_Order";
//echo $sql;
$input = $functionsObj->ExecuteQuery($sql);
if($input->num_rows > 0){
	$result = $functionsObj->FetchObject($input);
	//$url = site_root."scenario_description.php?Link=".$result->Link_ID;
}

$sqlarea = "SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_BackgroundColor as BackgroundColor, a.Area_TextColor as TextColor
FROM GAME_LINKAGE l 
INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE ls.SubLink_Type=1 AND l.Link_ID=".$linkid;
////echo $sqlarea;
$area    = $functionsObj->ExecuteQuery($sqlarea);

$sqlcomp = "SELECT distinct a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, ls.SubLink_Details as Description 
FROM GAME_LINKAGE l 
INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid;
$component = $functionsObj->ExecuteQuery($sqlcomp);

$url       = site_root."input.php?Scenario=".$result->Link_ScenarioID;

include_once doc_root.'views/output.php';
