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
$userid  = $_SESSION['userid'];
//echo $userid; 
// echo "<pre>"; print_r($_REQUEST); exit();
$gameid  = $_GET['ID'];
$linkid  = $_GET['linkid'];
$sqlarea = "SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_BackgroundColor as BackgroundColor, a.Area_TextColor as TextColor, gas.Sequence_Order AS Area_Sequencing
FROM GAME_LINKAGE l 
INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
LEFT JOIN GAME_AREA_SEQUENCE gas on a.Area_ID=gas.Sequence_AreaId
LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
WHERE ls.SubLink_Type=1 AND gas.Sequence_LinkId=".$linkid." AND l.Link_ID=".$linkid." ORDER BY gas.Sequence_Order";
// echo $sqlarea; // exit();
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

include_once doc_root.'views/report.php';


