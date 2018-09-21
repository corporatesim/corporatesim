<?php
include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(30000);

$funObj = new Functions();
$userid = $_SESSION['userid'];

	// print_r($_POST); exit;

if(isset($_POST['action']) && $_POST['action']=='updateInput')
{
	$sublinkid = ($_POST['sublinkid']);
	$key       = ($_POST['key']);
	$value     = ($_POST['value']);
	

	$sql      = "SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
	$strfirst.= "COMP -- ".$sql . "</br>";
	$object   = $funObj->ExecuteQuery($sql);

	if ($object->num_rows > 0)
	{
		$res   = $funObj->FetchObject($object);
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
			'input_user'      => $userid,
			'input_sublinkid' => $sublinkid,
			'input_current'   => $value,
			'input_key'       => $key
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
	$timer  = ($_POST['timer'] - 1);
	

	$sqltt    = "SELECT id,timer FROM `GAME_LINKAGE_TIMER` WHERE linkid= ".$linkid." and userid = ".$userid;
	$objecttt = $funObj->ExecuteQuery($sqltt);

	if ($objecttt->num_rows > 0) {
		$restt   = $funObj->FetchObject($objecttt);
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
			'timer'  => $timer
		);
		
		$result = $funObj->InsertData ( 'GAME_LINKAGE_TIMER', $array, 0, 0 );
		
	}
	
}	

if(isset($_POST['runquery']) && $_POST['runquery']=='fetchrecord')
{
	$formula   = $funObj->ExecuteQuery($_POST['query']);
	if($formula->num_rows > 0)
	{
		$result       = $funObj->FetchObject($formula);
		echo $result->input_current;
	}
	else
		echo 'no';
}

if(isset($_POST['runquery']) && $_POST['runquery']=='check_existance')
{
	$object    = $funObj->ExecuteQuery($_POST['query']);
	$inputKey  = $_POST['inputKey'];
	$value     = $_POST['value'];
	$SublinkID = $_POST['SublinkID'];
	
	// echo $sqlreplace."<br>";
	if($object->num_rows > 0)
	{
		$current = eval('return '.$value.';');
		$res     = $funObj->FetchObject($object);
		if(!empty($current) && !empty($SublinkID))
		{
			$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
			INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
			WHERE Rep_SublinkID=".$SublinkID." AND Rep_Start<= ".$current."
			AND Rep_End>=".$current." AND (ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";

			$objreplace  = $funObj->ExecuteQuery($sqlreplace);
			if ($objreplace->num_rows > 0) 
			{
				$resreplace = $funObj->FetchObject($objreplace);
				$current    = $resreplace->Rep_Value;
			}
		}
		// $array = array (
		// 	'input_current' => $current
		// );
		$query_array = array(
			// 'input_id'        => $res->input_id,
			// 'input_user'      => $userid,
			// 'input_sublinkid' => $SublinkID,
			// 'input_key'       => $inputKey,
			'input_current'   => $current
		);
		// echo json_encode($query_array);
		$result    = $funObj->UpdateData ( 'GAME_INPUT', $query_array, 'input_id', $res->input_id );
	}
	else
	{
		if (!empty($value))
		{
			$current = eval('return '.$value.';');
								//check for REPLACE condition
			if(!empty($current) && !empty($SublinkID))
			{
				$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
				INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
				WHERE Rep_SublinkID=".$SublinkID." AND Rep_Start<= ".$current."
				AND Rep_End>=".$current." AND (ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";

				$objreplace  = $funObj->ExecuteQuery($sqlreplace);
				if ($objreplace->num_rows > 0) 
				{
					$resreplace = $funObj->FetchObject($objreplace);
					$current    = $resreplace->Rep_Value;
				}
			}				
			// $array = array(
			// 	'input_user'      => $userid,
			// 	'input_sublinkid' => $SublinkID,
			// 	'input_key'       => $str[0]."_comp_". $str[2],
			// 	'input_current'   => $current
			// );

			$query_array = array(
				// 'input_id'        => '',
				'input_user'      => $userid,
				'input_sublinkid' => $SublinkID,
				'input_key'       => $inputKey,
				'input_current'   => $current
			);
			// echo json_encode($query_array);
			$funObj->InsertData('GAME_INPUT', $query_array, 0, 0);
		}
	}
}

// putting this condition for execute2 button to work

// if(!isset($_POST['action']))
// // else
// {
// 	$updateArr = array();
// 	// print_r($_POST); 
// 	foreach ($_POST as $row => $row_value)
// 	{
// 		if($row_value['value'] == ''){$row_value['value'] = 0; }

// 		// if($row_value['sublinkid'] > 0)
// 		// {
// 		// 	$updateArr[] = "('".$row_value['input_id']."','".$userid."','".$row_value['sublinkid']."','".$row_value['value']."','".$row_value['key']."')" ;
// 		// }
// 		// print_r($row_value);

// 		$query = " SELECT * FROM GAME_INPUT WHERE input_user=".$userid." and input_sublinkid=".$row_value['sublinkid']." and input_key='".$row_value['key']."'";

// 		$query_object = $funObj->ExecuteQuery($query);

// 		if(!$query_object->num_rows>0)
// 		{
// 			$updateArr[] = "('".$row_value['input_id']."','".$userid."','".$row_value['sublinkid']."','".$row_value['value']."','".$row_value['key']."')" ;
// 		}
// 	}

// 	$fieldName = ['input_id','input_user','input_sublinkid','input_current','input_key'];
// 	// print_r($updateArr);
// 	if(count($updateArr) > 0)
// 	{
// 		$updateArr = implode(',',$updateArr);
// 	// echo $updateArr;
// 	$result    = $funObj->BulkInsertUpdateData('GAME_INPUT', $fieldName, $updateArr,'');
// 	}
// 	else
// 	{
// 		$result = true;
// 	}

// 	echo ($result)?'Yes':'No';
// }
