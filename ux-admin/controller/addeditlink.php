<?php
require_once doc_root.'ux-admin/model/model.php';

$functionsObj = new Model();
$object       = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename     = $functionsObj->FetchObject($object);
$file         = 'list.php';

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	//echo "in submit";	
	$linkdetails = (object) array(
		'Link_GameID'     =>	$_POST['game_id'],
		'Link_ScenarioID' =>	$_POST['scen_id'],
		'Link_Order'      =>	$_POST['order'],
		'Link_Mode'       =>	$_POST['Mode'],
		'Link_Enabled'    =>	isset($_POST['enabled']) ? 1 : 0,
		'Link_Status'     =>	1,			
		'Link_CreateDate' =>	date('Y-m-d H:i:s')
	);
	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['order']) )
	{
		$result = $functionsObj->InsertData('GAME_LINKAGE', $linkdetails, 0, 0);
		if($result)
		{
			$_SESSION['msg']     = "Link created successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/linkage");
			exit(0);	
		}
	}	
	else{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";		
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){	
	$linkdetails = (object) array(
		'Link_GameID'     =>	$_POST['game_id'],
		'Link_ScenarioID' =>	$_POST['scen_id'],
		'Link_Order'      =>	$_POST['order'],
		'Link_Mode'       =>	$_POST['Mode'],
		'Link_Enabled'    =>	isset($_POST['enabled']) ? 1 : 0,
		'Link_Status'     =>	1,			
		'Link_CreateDate' =>	date('Y-m-d H:i:s')
	);		

	echo $_POST['Mode'];
//	exit();

	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['order']) )
	{
		$linkid = $_GET['edit'];
		//echo $linkid;
		$result = $functionsObj->UpdateData('GAME_LINKAGE', $linkdetails, 'Link_id', $linkid, 0);
		//exit();
		if($result === true){
			$_SESSION['msg']     = "Link updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/linkage");
			exit(0);
		}else{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
	
}

// Edit Siteuser
if(isset($_GET['edit'])){
	$header      = 'Edit Links';
	$uid         = $_GET['edit'];
	$object      = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ID='.$uid), '', '', '', '', 0);
	$linkdetails = $functionsObj->FetchObject($object);
	$url         = site_root."ux-admin/linkage";
	$file        = 'addedit.php';
	
}elseif(isset($_GET['add'])){
	// Add Siteuser
	$header = 'Add Links';
	$url    = site_root."ux-admin/linkage";
	$file   = 'addedit.php';

}elseif(isset($_GET['del'])){
	// Delete Siteuser
	$id     = base64_decode($_GET['del']);

	$result = $functionsObj->UpdateData('GAME_SITE_USERS', array( 'User_Delete' => 1 ), 'User_id', $id, 0);
	if($result === true)
	{
		header("Location: ".site_root."ux-admin/siteusers");
		exit(0);
	}
	else
	{
		$msg     = "Error: ".$result;
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->User_status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_SITE_USERS', array('User_status'=> 0), 'User_id', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_SITE_USERS', array('User_status'=> 1), 'User_id', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "User account ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/siteusers");
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
	$sql="SELECT
	L.*,
	(SELECT `Game_Name`  FROM  GAME_GAME WHERE  `Game_ID` = L.Link_GameID) as Game,
	(SELECT `Scen_Name`  FROM  GAME_SCENARIO WHERE  `Scen_ID` = L.`Link_ScenarioID`) as Scenario
	FROM
	GAME_LINKAGE as L";
	$object = $functionsObj->ExecuteQuery($sql);
	$file   = 'addeditlink.php';
}

$linkdetails = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array(), '', '', '', '', 0);
// Fetch Services list
$game        = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
$scenario    = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Linkage/'.$file;