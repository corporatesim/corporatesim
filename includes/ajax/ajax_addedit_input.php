<?php
include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(300);

$funObj    = new Functions();
$userid    = $_SESSION['userid'];
$strresult = "";
$strdata   = "";
$sublinkid = "";
$current   = "";
$key       = "";
$array     = "";

if (!isset($_SESSION['userid']))
{
	//go to login page.
	
	unset($_SESSION['username']);
	//setcookie($cookie_name, "", 1);
	header("Location:".site_root."login.php");
	
	exit(0);
}

if( !empty($_POST) ){
	$data   = array();
	$active = $_POST['active'];

	foreach($_POST as $key => $value)
	{
		//$strresult = $strresult.$key."->".$value." , ";
		$data[$key]  = $value;		
	}
	
	foreach($data as $x => $x_value)
	{	  
		$str = explode("_",$x);

		//if($str[0] == $_POST['active'])
		//{
		if($str[1] == 'comp'){
			$sublinkid = $data[$str[0].'_linkcomp_'.$str[2]];
			$compid    = $str[2];
			$subcompid = 0;				
			$key       = $x;
			$current   = $x_value;	
			//check for REPLACE condition				
			//$curobject = $funObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_id='.$sublinkid), '', '', '', '', 0);
			//$details = $functionsObj->FetchObject($surobject);
			//if ($details->SubLink_InputMode =='user' || $details->SubLink_InputMode =='formula')
			//{
			//$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
			//	WHERE Rep_SublinkID=".$sublinkid." AND Rep_Start<= ".$current." 
			//	AND Rep_End>=".$current;
			if(!empty($current))
			{
				$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
				INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
				WHERE Rep_SublinkID=".$sublinkid." AND Rep_Start<= ".$current."
				AND Rep_End>=".$current." AND 
				(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
				$objreplace  = $funObj->ExecuteQuery($sqlreplace);
				if ($objreplace->num_rows > 0) 
				{
					$resreplace = $funObj->FetchObject($objreplace);
					$current    = $resreplace->Rep_Value;
				}
			}
				//}
				//check if already exists				
			$sql="SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
			$strfirst .= "COMP -- ".$sql . "</br>";
			$object    = $funObj->ExecuteQuery($sql);

			if ($object->num_rows > 0) {
				$res   = $funObj->FetchObject($object);
				$array = array (
					'input_current' => $current
				);
				$result = $funObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
			}
			else{
				$array = array(
					'input_user'      => $userid,
					'input_sublinkid' => $sublinkid,
					'input_current'   => $current,
					'input_key'       => $key
				);				
				$funObj->InsertData('GAME_INPUT', $array, 0, 0);
			}
		}elseif($str[1] == 'subc'){
			$sublinkid = $data[$str[0].'_linksubc_'.$str[2]];
			$compid    = 0;
			$subcompid = $str[2];
			$current   = $x_value;	
			//check for REPLACE condition
			$key       = $x;
			if(!empty($current))
			{
				$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
				INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
				WHERE Rep_SublinkID=".$sublinkid." AND Rep_Start<= ".$current."
				AND Rep_End>=".$current." AND 
				(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
				$objreplace  = $funObj->ExecuteQuery($sqlreplace);
				if ($objreplace->num_rows > 0) 
				{
					$resreplace = $funObj->FetchObject($objreplace);
					$current    = $resreplace->Rep_Value;
				}
			}
				//update if already exists
			$sql      ="SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
			$strfirst .= "SUBC -- ".$sql . "</br>";
			$object    = $funObj->ExecuteQuery($sql);						

			if ($object->num_rows > 0) {
				$res   = $funObj->FetchObject($object);
				$array = array (
					'input_current' => $current
				);
				$result = $funObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );					
			}
			else{
				$array = array(
					'input_user'      => $userid,
					'input_sublinkid' => $sublinkid,
					'input_current'   => $current,
					'input_key'       => $key
				);	

				$funObj->InsertData('GAME_INPUT', $array, 0, 0);
			}
		}
		//}		
	}

	$msg = array(
		"status" =>	1,
		"msg"    =>	$active

		//$strresult	
		//" Array Data --> ".
		//$active

	);	
}
else{
	$msg = array(
		"status" =>	0,
		"msg"    =>	"Error"
	);
}
echo json_encode( $msg );
