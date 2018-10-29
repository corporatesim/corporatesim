<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();
$url          = site_root."ux-admin/siteusers";

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	var_dump($_POST);
	exit();	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	//$uid = $_POST['id'];
	//var_dump($_POST['usergame']);
	$id = $_POST['usergame'];
	if(isset($_GET['edit']))
	{
		$uid = base64_decode($_GET['edit']);
	}
	
	$result = $functionsObj->DeleteData('GAME_USERGAMES','UG_UserID',$uid,0);
	
	for($i=0;$i<count($id);$i++)
	{
		//echo $id[$i]."</br>";
		$exp         = explode(',',$id[$i]);
		//echo $exp."</br>";
		$gameid      = $gameid. $id[$i].",";		
		$gamedetails = (object) array(
			'UG_UserID' => $uid,
			'UG_GameID'	=> $id[$i]
		);	
		$result = $functionsObj->InsertData('GAME_USERGAMES', $gamedetails, 0, 0);	
	}
	
	//exit();
	$gamedetails = (object) array(
		'User_games' =>	$gameid
	);

	$result = $functionsObj->UpdateData('GAME_SITE_USERS', $gamedetails, 'User_id', $uid, 0);
	if($result === true){
		$_SESSION['msg']     = "Games updated successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/siteusers");
		exit(0);
	}
}

	// fetch game list from db
$id     = base64_decode($_GET['edit']);
$object = $functionsObj->SelectData(array(), 'GAME_USERGAMES', array('UG_UserID='.$id), '', '', '', '', 0);
$file   = 'addGame.php';

include_once doc_root.'ux-admin/view/siteusers/'.$file;