<?php
include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(30000);

$funObj = new Functions();
$userid = $_SESSION['userid'];


if(isset($_POST['action']) && $_POST['action']=='updateInput')
{
	$sublinkid = ($_POST['sublinkid']);
	$key = ($_POST['key']);
	$value = ($_POST['value']);
	

	$sql="SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
	$strfirst .= "COMP -- ".$sql . "</br>";
	$object = $funObj->ExecuteQuery($sql);
			
	if ($object->num_rows > 0) {
		$res = $funObj->FetchObject($object);
		$array = array (
			'input_current' => $value
		);
		$result = $funObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
		
		if($result)
		{
			echo 'Yes';
		}
	}
	else
	{
		$array = array (
			'input_user' => $userid,
			'input_sublinkid' => $sublinkid,
			'input_current' => $value,
			'input_key'=> $key
		);
		
		$result = $funObj->InsertData ( 'GAME_INPUT', $array, 0, 0 );
		
		if($result)
		{
			echo 'Yes';
		}
	}
	
}
	

if(isset($_POST['action']) && $_POST['action']=='SaveTimer')
{
	$linkid = ($_POST['linkid']);
	$userid = ($_POST['userid']);
	$timer = ($_POST['timer'] - 1);
	

	$sqltt = "SELECT id,timer FROM `GAME_LINKAGE_TIMER` WHERE linkid= ".$linkid." and userid = ".$userid;
	$objecttt = $funObj->ExecuteQuery($sqltt);
			
	if ($objecttt->num_rows > 0) {
		$restt = $funObj->FetchObject($objecttt);
		$arraytt = array (
			'timer' => $timer
		);
		$result = $funObj->UpdateData ( 'GAME_LINKAGE_TIMER', $arraytt, 'id', $restt->id );
		
		//echo $timer;
	}
	else
	{
		$array = array (
			'linkid' => $linkid,
			'userid' => $userid,
			'timer' => $timer
		);
		
		$result = $funObj->InsertData ( 'GAME_LINKAGE_TIMER', $array, 0, 0 );
		
	}
	
}	
?>