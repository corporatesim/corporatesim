<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$object = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_datetime DESC', '', '', '', 0);
$file   = 'GameList.php';

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	$gamedetails = (object) array(
		'Game_Name'     => $_POST['name'],
		'Game_Comments' => $_POST['comments'],
		'Game_Message'  => $_POST['message'],
		'Game_Datetime' => date('Y-m-d H:i:s'),
		'Game_Status'   => 1
	);
	
	if( !empty($_POST['name']) && !empty($_POST['comments']))
	{
		$result = $functionsObj->InsertData('GAME_GAME', $gamedetails, 0, 0);
		if($result)
		{
			$uid = $functionsObj->InsertID();
			
			$_SESSION['msg']     = "Game created successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageGame");
			exit(0);

		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

// if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
// {
// //echo $_POST['doctitle'];
// //echo $_POST['docname'];
// //exit();
// }

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	$gamedetails = (object) array(
		'Game_Name'     => $_POST['name'],
		'Game_Comments' => $_POST['comments'],
		'Game_Message'  => $_POST['message'],
		'Game_Datetime' => date('Y-m-d H:i:s'),
		'Game_Status'   => 1
	);

	if( !empty($_POST['name']) && !empty($_POST['comments']) )
	{
		$uid    = $_POST['id'];
		$result = $functionsObj->UpdateData('GAME_GAME', $gamedetails, 'Game_ID', $uid, 0);
		if($result === true)
		{
			$_SESSION['msg']     = "Game updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageGame");
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}		
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

// Edit Siteuser
if(isset($_GET['edit']))
{
	$header      = 'Edit Game';
	$uid         = base64_decode($_GET['edit']);
	$object      = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_ID='.$uid), '', '', '', '', 0);
	$gamedetails = $functionsObj->FetchObject($object);
	$url         = site_root."ux-admin/ManageGame";
	$file        = 'addeditGame.php';
	if(isset($_GET['tab']))
	{
		$tabid = base64_decode($_GET['tab']);
		switch($_GET['tab']){
			case '1':
			$file = 'GameDocument.php';
			break;
		}
	}	

}
elseif(isset($_GET['add']))
{
	// Add Siteuser
	$header = 'Add Game';
	$url    = site_root."ux-admin/ManageGame";	
	$file   = 'addeditGame.php';
}
elseif(isset($_GET['del']))
{
	// Delete Siteuser
	$id      = base64_decode($_GET['del']);
	
	$sql     = "SELECT s.Scen_Name as Scen FROM `GAME_LINKAGE` INNER JOIN GAME_SCENARIO s on link_ScenarioID = s.Scen_ID WHERE Link_GameID=".$id;
	$sublink = $functionsObj->ExecuteQuery($sql);

	if($sublink->num_rows > 0)
	{
		while($row = $sublink->fetch_object())
		{
			$strresult = $strresult." '".$row->Scen."' ";
		}
		$msg     = 'Cannot Delete Game. Is linked with '.$strresult;
		$type[0] = 'inputError';
		$type[1] = 'has-error';		
	}
	else
	{
		$result = $functionsObj->DeleteData('GAME_GAME','Game_ID',$id,0);

		//$result = $functionsObj->UpdateData('GAME_GAME', array( 'Game_Delete' => 1 ), 'Game_ID', $id, 0);
		//if($result === true){
		$_SESSION['msg']     = "Game Deleted";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";

		header("Location: ".site_root."ux-admin/ManageGame");
		exit(0);
		//}else{
		//	$msg = "Error: ".$result;
		//	$type[0] = "inputError";
		//	$type[1] = "has-error";
		//}
	}
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_ID='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->Game_Status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_GAME', array('Game_Status'=> 0), 'Game_ID', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_GAME', array('Game_Status'=> 1), 'Game_ID', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "Game ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/ManageGame");
		exit(0);
	}
	else
	{
		$msg     = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}
else
{
	// fetch siteuser list from db
	$object = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_datetime DESC', '', '', '', 0);
	$file   = 'GameList.php';
}

include_once doc_root.'ux-admin/view/Game/'.$file;