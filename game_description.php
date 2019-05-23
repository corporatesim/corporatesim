<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

//echo $_SESSION['userid'];
//echo $_SESSION['username'];
//echo $_GET['Game'];
//exit();
// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
$functionsObj = new Functions();
//$_SESSION['userpage'] ='game_description';
$gameid = $_GET['Game'];
$userid = $_SESSION['userid'];
// if user is not assigned this game then move to select game page
$checkGameSql = "SELECT * FROM GAME_SITE_USERS WHERE LOCATE($gameid,User_games) AND User_id=$userid";
$checkGameObj = $functionsObj->ExecuteQuery($checkGameSql);
if($checkGameObj->num_rows < 1)
{
	$_SESSION['er_msg'] = "You do not have permission to access that game description.";
	// echo "<pre>"; print_r($_SESSION); exit();
	header("Location:".site_root."selectgame.php");
}

if(isset($_GET['File'])){
	$fileid     = $_GET['File'];
	//$sql      ="SELECT * FROM `GAME_GAMEDOCUMENT` WHERE `GameDoc_ID`= ".$fileid;
	//$document = $functionsObj->ExecuteQuery($sql);
	$fields     = array();
	$where      = array('GameDoc_ID='.$fileid);
	$obj        = $functionsObj->SelectData($fields, 'GAME_GAMEDOCUMENT', $where, '', '', '');
	$resultdoc  = $functionsObj->FetchObject($obj);
	
	$file       = "ux-admin/upload/".$resultdoc->GameDoc_Name;
	//echo $file;
	//exit();
	if (file_exists($file)) {		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}
}

$sql    = "SELECT * FROM GAME_GAME WHERE Game_ID = ".$gameid;
$object = $functionsObj->ExecuteQuery($sql);

if($object->num_rows > 0){
	$game = $functionsObj->FetchObject($object);
}

$sql      = "SELECT * FROM `GAME_GAMEGENERAL` WHERE GameGen_Delete=0 and `GameGen_GameID` = ".$gameid;
$general  = $functionsObj->ExecuteQuery($sql);

$sql      = "SELECT * FROM `GAME_GAMEVIDEO` WHERE GameVdo_Delete=0 and `GameVdo_GameID` = ".$gameid;
$video    = $functionsObj->ExecuteQuery($sql);

$sql      = "SELECT * FROM `GAME_GAMEIMAGE` WHERE GameImg_Delete=0 and `GameImg_GameID`= ".$gameid;
$image    = $functionsObj->ExecuteQuery($sql);

$sql      = "SELECT * FROM `GAME_GAMEDOCUMENT` WHERE GameDoc_Delete=0 and `GameDoc_GameID`= ".$gameid;
$document = $functionsObj->ExecuteQuery($sql);

$sql      = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." ORDER BY `Link_Order` LIMIT 1";
$scenario = $functionsObj->ExecuteQuery($sql);

if($scenario->num_rows > 0){
	$result = $functionsObj->FetchObject($scenario);
	$url    = site_root."scenario_description.php?Link=".$result->Link_ID;
}

include_once doc_root.'views/game_description.php';

