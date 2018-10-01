<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

$functionsObj = new Functions();
// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
//$_SESSION['userpage'] ='game_description';
if(isset($_GET['Link']))
{
	$linkid   = $_GET['Link'];
	//$scenid =$_GET['Scenario'];	
	$uid      = $_SESSION['userid'];	
	$sql      = "SELECT * FROM GAME_LINKAGE WHERE Link_ID = ".$linkid;
	$object   = $functionsObj->ExecuteQuery($sql);
	//echo $sql. " -- ".$object->num_rows;

	if($object->num_rows > 0)
	{
		$link = $functionsObj->FetchObject($object);
		if (isset($_COOKIE['hours']) && isset($_COOKIE['minutes']))
		{
			if($_COOKIE['hours']>0 || $_COOKIE['minutes']>0)
			{
				$hour = $_COOKIE['hours'];
				$min  = $_COOKIE['minutes'];
			}
			else
			{			
				$start = date('M d,y H:i:s');
				$hour  = $link->Link_Hour;
				$min   = $link->Link_Min;
				//setcookie(name,value,expire,path,domain,secure,httponly);
				setcookie('hours',$hours,time()+86400,"/");
				setcookie('minutes',$hours,time()+86400,"/");
				setcookie('date',date('M d,y H:i:s',strtotime($str,strtotime($start))),time()+86400,"/");				
				//$_COOKIE['hours'] = $hour ;
				//$_COOKIE['minutes'] = $min ;						
				$str              = "+".$hour." hour +".$min." minutes";
				//display the converted time
				$_SESSION['date'] = date('M d,y H:i:s',strtotime($str,strtotime($start)));
			}
		}

		$gameid = $link->Link_GameID;	
		$scenid = $link->Link_ScenarioID;
		$where  = array (
			"US_GameID = " . $gameid,
	//		"US_ScenID = " . $scenid,
			"US_UserID = " . $uid		
		);
		$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, '', '', '', '', 0);
		if ($obj->num_rows > 0)
		{
			//exists
			$status       = $functionsObj->FetchObject($obj);
			$userstatusid = $status->US_ID;
			//exists
			$array = array (			
				'US_ScenID' => $scenid,
				'US_Input'  => 1,
				'US_Output' => 0
			);
			$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
		}
		else
		{
			//insert
			$array = array (
				'US_GameID'     => $gameid,
				'US_ScenID'     => $scenid,
				'US_UserID'     => $uid,
				'US_Input'      => 1,
				'US_CreateDate' => date ( 'Y-m-d H:i:s' ) 
			);
			$result = $functionsObj->InsertData ( 'GAME_USERSTATUS', $array, 0, 0 );
		}

		$gameurl = site_root."game_description.php?Game=".$gameid;		
		$sql     = "SELECT * FROM GAME_GAME WHERE Game_ID = ".$gameid;
		$object  = $functionsObj->ExecuteQuery($sql);

		if($object->num_rows > 0)
		{
			$game             = $functionsObj->FetchObject($object);
			$game_description = $game->Game_Name;
		}
	}
}

if(isset($_GET['File']))
{
	$fileid = $_GET['File'];
	//$sql="SELECT * FROM `GAME_GAMEDOCUMENT` WHERE `GameDoc_ID`= ".$fileid;
	//$document = $functionsObj->ExecuteQuery($sql);
	$fields    = array();
	$where     = array('ScenDoc_ID='.$fileid);
	$obj       = $functionsObj->SelectData($fields, 'GAME_SCENDOCUMENT', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);	
	$file      = "ux-admin/upload/".$resultdoc->ScenDoc_Name;
	//echo $file;
	//exit();
	if (file_exists($file))
	{		
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

$sql    = "SELECT *FROM GAME_SCENARIO WHERE Scen_ID = ".$scenid;
$object = $functionsObj->ExecuteQuery($sql);
if($object->num_rows > 0)
{
	$scen = $functionsObj->FetchObject($object);
}
//echo $scenid;
//echo $scen->Scen_Name;
//exit();
$_SESSION['scenid'] = $scenid;
$sql                = "SELECT * FROM `GAME_SCENGENERAL` WHERE ScenGen_Delete=0 and `ScenGen_ScenID` = ".$scenid;
$general            = $functionsObj->ExecuteQuery($sql);
//echo $sql."</br>";

$sql                = "SELECT * FROM `GAME_SCENVIDEO` WHERE ScenVdo_Delete=0 and `ScenVdo_ScenID` = ".$scenid;
$video              = $functionsObj->ExecuteQuery($sql);
//echo $sql."</br>";

$sql                = "SELECT * FROM `GAME_SCENIMAGE` WHERE ScenImg_Delete=0 and `ScenImg_ScenID`= ".$scenid;
$image              = $functionsObj->ExecuteQuery($sql);
//echo $sql."</br>";

$sql                = "SELECT * FROM `GAME_SCENDOCUMENT` WHERE ScenDoc_Delete=0 and `ScenDoc_ScenID`= ".$scenid;
$document           = $functionsObj->ExecuteQuery($sql);
//echo $sql."</br>";

// $sql = "SELECT * FROM `game_linkage` WHERE `Link_GameID`=".$gameid." ORDER BY `Link_Order` LIMIT 1";
// $scenario = $functionsObj->ExecuteQuery($sql);
// if($scenario->num_rows > 0){
	// $result = $functionsObj->FetchObject($scenario);
	// $url = site_root."views/scenario_description.php?Scenario=".$result->Link_ScenarioID;
// }

//echo $linkid;
//echo " -- ".$gameid;
//echo " -- ".$scenid;

$sql = "SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$gameid." and Link_Order>
(SELECT Link_Order FROM `GAME_LINKAGE`
WHERE Link_GameID = ".$gameid." and Link_ScenarioID=".$scenid.")
ORDER BY Link_Order LIMIT 1";
//echo $sql."</br>";

$input = $functionsObj->ExecuteQuery($sql);
//echo $input->num_rows;

if($input->num_rows > 0){
	$result  = $functionsObj->FetchObject($input);
	$nexturl = site_root."scenario_description.php?Link=".$result->Link_ID;
	//echo $nexturl;
	//exit();
	//header("Location: ".site_root."scenario_description.php?Link=".$result->Link_ID);
}
else
{
	$nexturl = site_root."result.php?Link=".$linkid;
//	echo $nexturl;
	//exit();
	//header("Location: ".site_root."result.php?Link=".$linkid);
	//exit(0);
}	

$url = site_root."input.php?ID=".$gameid;
//echo $url;
include_once doc_root.'views/scenario_description.php';
