<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$object = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), 'Scen_datetime DESC', '', '', '', 0);
$file = 'ScenarioList.php';

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$gamedetails = (object) array(
			'Scen_Name'		=>	$_POST['name'],
			'Scen_Comments'		=>	$_POST['comments'],
			'Scen_Datetime'	=>	date('Y-m-d H:i:s'),
			'Scen_Status' =>1
	);
	
	if( !empty($_POST['name']) && !empty($_POST['comments']))
	{
		$result = $functionsObj->InsertData('GAME_SCENARIO', $gamedetails, 0, 0);
		if($result)
		{
			$uid = $functionsObj->InsertID();
			
			$_SESSION['msg'] = "Scenario created successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageScenario");			
			exit(0);
						
		}else{
				$msg = "Error: ".$result;
				$type[0] = "inputError";
				$type[1] = "has-error";
		}
	}else{
		$msg = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}


if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$gamedetails = (object) array(
			'Scen_Name'		=>	$_POST['name'],
			'Scen_Comments'		=>	$_POST['comments'],
			'Scen_Datetime'	=>	date('Y-m-d H:i:s'),
			'Scen_Status' =>1
	);

	if( !empty($_POST['name']) && !empty($_POST['comments']) ){
		$uid = $_POST['id'];
		$result = $functionsObj->UpdateData('GAME_SCENARIO', $gamedetails, 'Scen_ID', $uid, 0);
		if($result === true){
			$_SESSION['msg'] = "Scenario updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageScenario");
			exit(0);
		}else{
			$msg = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}		
	}else{
		$msg = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

// Edit Siteuser
if(isset($_GET['edit'])){
	$header = 'Edit Scenario';
	$uid = base64_decode($_GET['edit']);
	$object = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_ID='.$uid), '', '', '', '', 0);
	$scendetails = $functionsObj->FetchObject($object);
	$url = site_root."ux-admin/ManageScenario";
	$file = 'addeditScenario.php';
}elseif(isset($_GET['add'])){
	// Add Siteuser
	$header = 'Add Scenario';
	$url = site_root."ux-admin/ManageScenario";
	
	$file = 'addeditScenario.php';

}elseif(isset($_GET['del'])){
	// Delete Siteuser
	$id = base64_decode($_GET['del']);
	//$file = 'manageScenario.php';
//	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ScenarioID='.$id), '', '', '', '', 0);
	$sql="SELECT g.Game_Name as Game FROM `GAME_LINKAGE` 
			INNER JOIN GAME_GAME g on Link_GameID=g.Game_ID where Link_ScenarioID=".$id;
	$sublink = $functionsObj->ExecuteQuery($sql);
		
//	echo $sublink->num_rows;
//	exit();
	if($sublink->num_rows > 0)
	{
//		$file = 'ScenarioList.php';
		while($row = $sublink->fetch_object()){
				$strresult = $strresult." '".$row->Game."' ";			
			}
		$msg 		= 'Cannot Delete Scenario. Is linked with '.$strresult;
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';		
	}
	else{
		//$result = $functionsObj->UpdateData('GAME_SCENARIO', array( 'Scen_Delete' => 1 ), 'Scen_ID', $id, 0);
		$result = $functionsObj->DeleteData('GAME_SCENARIO','Scen_ID',$id,0);

		//if($result === true){
			$_SESSION['msg'] = "Scenario Deleted";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageScenario");
			exit(0);
		//}else{
		//	$msg = "Error: ".$result;
		//	$type[0] = "inputError";
		//	$type[1] = "has-error";
		//}
	}
}elseif(isset($_GET['stat'])){
	// Enable disable siteuser account
	$id = base64_decode($_GET['stat']);
	$object = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_ID='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->Scen_Status == 1){
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_SCENARIO', array('Scen_Status'=> 0), 'Scen_ID', $id, 0);
	}else{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_SCENARIO', array('Scen_Status'=> 1), 'Scen_ID', $id, 0);
	}
	if($result === true){
		$_SESSION['msg'] = "Scenario ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/ManageScenario");
		exit(0);
	}else{
		$msg = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}else{
	// fetch siteuser list from db
	$object = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), 'Scen_datetime DESC', '', '', '', 0);
	$file = 'ScenarioList.php';
}

	
include_once doc_root.'ux-admin/view/Scenario/'.$file;
?>