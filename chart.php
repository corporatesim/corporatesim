<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
set_time_limit(300);

// if user is logout then redirect to login page as we're unsetting the username from session
// if($_SESSION['username'] == NULL)
// {
// 	header("Location:".site_root."login.php");
// }

$functionsObj = new Functions();

$userid = $_SESSION['userid'];
//$gameid = $_SESSION['Game_ID'];
//echo $userid."</br>";
//$linkid = $_GET['Link'];

$gameid =  $_GET['ID'];

//echo $gameid."</br>";



$sqlchart = "SELECT * FROM GAME_CHART WHERE Chart_Status=1 and Chart_GameID = ".$gameid;
$chartDetails = $functionsObj->ExecuteQuery($sqlchart);
//$ResultchartDetails= $functionsObj->FetchObject($chartDetails);

$countRow = $chartDetails->num_rows;

if($countRow > 0){
	$i=1;
	$data= '';
	while($ResultchartDetails= $chartDetails->fetch_object()){


		$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ". $ResultchartDetails->Chart_ScenarioID;
		$LinkId =  $functionsObj->ExecuteQuery($sqllink);
		$ResultLinkId = $functionsObj->FetchObject($LinkId);
		
		if(!empty($ResultLinkId))
		{
			$sqlexist="SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
			(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
			$object = $functionsObj->ExecuteQuery($sqlexist);


				//chart_component and subcomponent

			$comp = $ResultchartDetails->Chart_Components;
			$subcomp = $ResultchartDetails->Chart_Subcomponents;
			$chartname [$i]= $ResultchartDetails->Chart_Name;
			$charttype [$i]= $ResultchartDetails->Chart_Type;

			$arrayComp = explode(',',$comp);
			$arraysubcomp = explode(',',$subcomp);
				//print_r($arrayComp);

				//echo $object->num_rows;
			if($object->num_rows > 0){
				
				while($row= $object->fetch_object()){
					
					$compdata = $row->input_key;
					$allcompID = explode('_',$compdata);
					$compID = $allcompID[2];
					
					if (in_array($compID, $arrayComp) && $allcompID[1]=='comp')
					{
						$sqlcompName = "SELECT Comp_Name FROM GAME_COMPONENT WHERE Comp_ID = ".$compID;
						$compDetails = $functionsObj->ExecuteQuery($sqlcompName);
						$compName= $functionsObj->FetchObject($compDetails);
						
						$data[$i][$compName->Comp_Name]  = $row->input_current;
					}
					
					else if (in_array($compID, $arraysubcomp) && $allcompID[1]=='subc')
					{
						$sqlsubcompName = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
						$subcompDetails = $functionsObj->ExecuteQuery($sqlsubcompName);
						$subcompName= $functionsObj->FetchObject($subcompDetails);
						
						$data[$i][$subcompName->SubComp_Name]  .= $row->input_current;
					}
					
					
				}
			}
		}
		$i++;
		
	}
	
}

//echo $i++;

//print_r($data);

//$url = site_root."chart.php?Scenario=".$result->Link_ScenarioID;

include_once doc_root.'views/chart.php';




?>

