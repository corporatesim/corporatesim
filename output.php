<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

// include PHPExcel
require('includes/PHPExcel.php');

//echo "Output";
// create new PHPExcel object
$objPHPExcel  = new PHPExcel;
$functionsObj = new Functions();
//$linkid     =$_GET['Link'];
//$scenid     =$_GET['Scenario'];
$userid       = $_SESSION['userid'];
//echo $userid;
$gameid       =  $_GET['ID'];

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
					header("Location:".site_root."input.php?Game=".$gameid);
					exit();
				}
				else
				{
					//goto output page
					//$url = site_root."output.php?Link=".$resultlink->Link_ID;		
					//header("Location:".site_root."output.php?Link=".$resultlink->Link_ID);
					//exit();
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

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	// removing last element of array i.e. submit
	array_pop($_POST);
	// echo "<pre>"; print_r($_POST);
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
			$where          = " input_user=$userid AND input_key";
			$update_res     = $functionsObj->UpdateData( 'GAME_INPUT', $update_array, $where, $input_key  );
			echo $update_res.'<br>';
		}
		// else
		// {
		// 	// find input_sublinkid from game id and scen id and then from game linkage find the sublink id
		// 	$input_sublinkid = '';
		// 	// insert output data to game_input table
		// 	$insert_array = array(
		// 		'input_user'      => $userid,
		// 		'input_sublinkid' => $input_sublinkid,
		// 		'input_key'       => $input_key,
		// 		'input_current'   => $input_current,
		// 	);
		// 	$insert_res   = $functionsObj->InsertData( 'GAME_INPUT', $insert_array, 0, 0 );
		// }
	} 
//	echo $linkid;
//	echo " -- ".$gameid;
//	echo " -- ".$scenid;
	//exit();
	$sql = "SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$gameid." and Link_Order>
	(SELECT Link_Order FROM `GAME_LINKAGE`
	WHERE Link_GameID = ".$gameid." and Link_ScenarioID=".$scenid.")
	ORDER BY Link_Order LIMIT 1";


	//exit();
	$input = $functionsObj->ExecuteQuery($sql);
	//echo $input->num_rows;
	
//		exit();
	
	//Update UserStatus
	
	if($input->num_rows > 0){
		$result = $functionsObj->FetchObject($input);
		header("Location: ".site_root."scenario_description.php?Link=".$result->Link_ID);
		exit(0);
	}
	else
	{
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
	WHERE output_user=".$userid." AND ls.SubLink_LinkID=".$linkid." AND ls.SubLink_Type=1";
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

$sql = "SELECT g.game_name as Game,sc.Scen_Name as Scenario,a.Area_Name as Area, 
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

$sqlarea = "SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name
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
