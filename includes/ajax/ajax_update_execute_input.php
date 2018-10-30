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
	$sql       = "SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
	$strfirst  .= "COMP -- ".$sql . "</br>";
	$object    = $funObj->ExecuteQuery($sql);

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
	$linkid   = ($_POST['linkid']);
	$userid   = ($_POST['userid']);
	$timer    = ($_POST['timer'] - 1);
	
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

// on click of save button evaluate json formula
if($_POST['action']=='updateFormula')
{
	$formula_json_expcomp = $_POST['formula_json_expcomp'];
	$formula_json_expsubc = $_POST['formula_json_expsubc'];
	$input_field_values   = $_POST['input_field_values'];
	$query                = "INSERT into `GAME_INPUT`(input_id,input_user,input_sublinkid,input_key,input_current) VALUES ";
	// print_r($formula_json_expcomp);
	// print_r($formula_json_expsubc);
	// print_r($input_field_values);
	// die('here');
	// creating component array
	foreach ($formula_json_expcomp as $expcomp_key => $expcomp_value)
	{
		// breaking the express from space and getting the value from inputs
		$cvalue        = [];
		$expcomp_array = explode(' ',$expcomp_value);
		// print_r($expcomp_array);
		foreach ($expcomp_array as $crow)
		{
			if((strpos($crow,'comp')!== false) || (strpos($crow,'subc')!== false))
			{
				// putting if input_key doesn't contain that value then find from database using the key
				if(array_key_exists($crow, $input_field_values))
				{
					$cvalue[]  = $input_field_values[$crow]['values'];
				}
				else
				{
					$tmp_key  = explode('_',$crow);
					$sql      = "select * from GAME_INPUT WHERE input_user=$userid and input_key like '%_".$tmp_key[1].'_'.$tmp_key[2]."%'";
					$object   = $funObj->ExecuteQuery($sql);
					$res      = $funObj->FetchObject($object);
					$cvalue[] = $res->input_current;
				}
			}
			else
			{
				$cvalue[]  = $crow;
			}
		}
		// echo $expcomp_key.' and '.implode('', $cvalue).'<br>';
		if(eval('return '.implode('',$cvalue).';'))
		{
			$expcomp_array_values[$expcomp_key]         = eval('return '.implode('',$cvalue).';');
			$input_field_values[$expcomp_key]['values'] = eval('return '.implode('',$cvalue).';');
		}
		// echo $expcomp_key.'<br>';
	}
	// creating for subcomponent
	foreach ($formula_json_expsubc as $expsubc_key => $expsubc_value)
	{
		// breaking the express from space and getting the value from inputs
		$cvalue        = [];
		$expsubc_array = explode(' ',$expsubc_value);
		// print_r($expsubc_array);
		foreach ($expsubc_array as $srow)
		{
			if((strpos($srow,'comp')!== false) || (strpos($srow,'subc')!== false))
			{
				// putting if input_key doesn't contain that value then find from database using the key
				if(array_key_exists($srow, $input_field_values))
				{
					$cvalue[]  = $input_field_values[$srow]['values'];
				}
				else
				{
					$tmp_key  = explode('_',$srow);
					$sql      = "select * from GAME_INPUT WHERE input_user=$userid and input_key like '%_".$tmp_key[1].'_'.$tmp_key[2]."%'";
					$object   = $funObj->ExecuteQuery($sql);
					$res      = $funObj->FetchObject($object);
					$cvalue[] = $res->input_current;
				}
			}
			else
			{
				$cvalue[]  = $srow;
			}
		}
		if(eval('return '.implode('',$cvalue).';'))
		{
			$expsubc_array_values[$expsubc_key]         = eval('return '.implode('',$cvalue).';');
			$input_field_values[$expsubc_key]['values'] = eval('return '.implode('',$cvalue).';');
		}
	}

	foreach ($input_field_values as $query_key => $query_value)
	{
		if(!empty($query_value['input_sublinkid']))
		{
			if($query_value['input_id'] < 1)
			{
				$query_value['input_id'] = 0;
				$inserted_input_key[]    = "'".$query_value['input_key']."'";
			}
			$query_field_value [] = "(".$query_value['input_id'].",".$userid.",".$query_value['input_sublinkid'].",'".$query_value['input_key']."',".$query_value['values'].")";
		}
	}
	
	$query  .= implode(',',$query_field_value);
	$query  .= "ON DUPLICATE KEY UPDATE input_current=VALUES(input_current)";
	// making query to update input_id in the json of inserted record
	if(count($inserted_input_key) > 0)
	{
		$input_key_in      = implode(',', $inserted_input_key);
		$sql_query         = "SELECT input_id,input_key FROM GAME_INPUT WHERE input_user=$userid AND input_key IN ($input_key_in)";
		$update_json_query = $funObj->ExecuteQuery($sql_query); 
		// $res_update        = $funObj->mysqli_fetch_array($update_json_query);
		while ($res_update = mysqli_fetch_assoc($update_json_query))
		{
			// echo $res_update['input_id'].'<br>';
			foreach ($input_field_values as $update_key_json => $update_value_json)
			{
				if($update_value_json['input_key'] == $res_update['input_key'])
				{
					$input_field_values[$update_key_json]['input_id'] = $res_update['input_id'];
					// echo "json_key => $update_key_json ___ query_key => ".$res_update['input_key']." ___ input_id => ".$res_update['input_id']."<br>";
				}
			}
		}

	}
	
// print_r($input_field_values); exit;
	$object  = $funObj->ExecuteQuery($query);
	// echo $query;
	echo json_encode($input_field_values);
}

if($_POST['action']=='element_not_found')
{
	// print_r($_POST);
	$key    = $_POST['key'];
	$sql    = "select * from GAME_INPUT WHERE input_user=$userid and input_key like '%_".$key."'";
	$object = $funObj->ExecuteQuery($sql);
	if($object->num_rows > 0)
	{
		$res = $funObj->FetchObject($object);
		$exp = $res->input_key;
		$res = explode('_',$res->input_key);
		$res = $res[0].'_link'.$res[1].'_'.$res[2];
		// die($sql);
		echo $res.','.$exp;
	}
	else
	{
		echo 'no';
	}
}

// on page load creating json 
// if($_POST['action']=='fetchInput')
// {
// 	// print_r($_POST); 

// 	$sql = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;

// 	if (!empty($_POST['input_sublinkid']) && $_POST['input_sublinkid'] != 'undefined')	
// 	{
// 		$sql .= " and input_sublinkid=".$_POST['input_sublinkid'];
// 	}

// 	$sql     .= " and input_key like ('%_".$_POST['key']."%')";
// 		// echo $sql.'<br>';
// 	$formula = $funObj->ExecuteQuery($sql);
// 	if($formula->num_rows > 0)
// 	{
// 		$result       = $funObj->FetchObject($formula);
// 			// $strvalue[$y] = $result->input_current;
// 		echo $result->input_current;
// 	}
// 	else
// 	{
// 		echo 'no';
// 	}
// }

// after each loop while replacing the current value
// if($_POST['action']=='fetchInput_tmp')
// {
// 	// print_r($_POST); 
// 	$current    = $_POST['current'];
// 	if($current == 'NaN')
// 	{
// 		echo 'no';
// 	}

// 	else
// 	{
// 		$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
// 		INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
// 		WHERE Rep_SublinkID=".$_POST['input_sublinkid']." AND Rep_Start <= '".$current."'
// 		AND Rep_End >='".$current."' AND 
// 		(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";

// 		$array = array(
// 			'main_input_key'  => $_POST['main_input_key'],
// 			'input_id'        => '',
// 			'input_user'      => $userid,
// 			'input_sublinkid' => $_POST['input_sublinkid'],
// 			'input_key'       => $_POST['key'],
// 			'input_current'   => $_POST['current']
// 		);

// 		$object = $funObj->SelectData ( array (), 'GAME_INPUT', array (
// 			"input_sublinkid=".$_POST['input_sublinkid'],
// 			"input_key='" .$_POST['key']."'",
// 			"input_user =" . $userid 
// 		), '', '', '', '', 0 );
// 		// echo $sql.'<br>'; if(!empty($_POST['current']) && !empty($_POST['input_sublinkid']))
// 		if ($object->num_rows > 0)
// 		{
// 			$res      = $funObj->FetchObject($object);
// 			$input_id = $res->input_id;

// 			if(!empty($_POST['current']) && !empty($_POST['input_sublinkid']))
// 			{
// 				$objreplace  = $funObj->ExecuteQuery($sqlreplace);
// 				if ($objreplace->num_rows > 0) 
// 				{
// 					$resreplace = $funObj->FetchObject($objreplace);
// 					$current    = $resreplace->Rep_Value;
// 				}
// 			}
// 			$array['input_id']      = $input_id;
// 			$array['input_current'] = $current;
// 		}
// 		else
// 		{
// 			$input_id = '';
// 			if(!empty($_POST['current']) && !empty($_POST['input_sublinkid']))
// 			{
// 				$objreplace  = $funObj->ExecuteQuery($sqlreplace);
// 				if ($objreplace->num_rows > 0) 
// 				{
// 					$resreplace = $funObj->FetchObject($objreplace);
// 					$current    = $resreplace->Rep_Value;
// 				}
// 			}
// 			$array['input_id']      = $input_id;
// 			$array['input_current'] = $current;
// 		}
// 		if(count($array)<1)
// 		{
// 			echo 'no';
// 		}
// 		else
// 		{
// 			echo json_encode($array);
// 		}
// 	}
// }

//  run query for execution
// if($_POST['action']=='runQuery')
// {
// 	// print_r($_POST);
// 	// print_r(json_decode($_POST['expcomp'],true));
// 	// print_r(json_decode($_POST['expsubc'],true));
// 	$query = "INSERT into `GAME_INPUT` (input_id,input_user,input_sublinkid,input_key,input_current) VALUES ";
// 	// for expcomp
// 	foreach (json_decode($_POST['expcomp'],true) as $row)
// 	{
// 		if(!empty($row))
// 		{
// 			$update_expcomp[] = "(".(($row['input_id'] == '')?0:$row['input_id']).','.$row['input_user'].','.$row['input_sublinkid'].',"'.$row['input_key'].'",'.$row['input_current'].")";
// 		}
// 	}

// 	// foreach ($result_expcomp as $update_key)
// 	// {
// 	// 	$update_expcomp[] = "(".$update_key['input_id'].','.$update_key['input_user'].','.$update_key['input_sublinkid'].',"'.$update_key['input_key'].'",'.$update_key['input_current'].")";
// 	// }

// 	$query .= implode(',',$update_expcomp).',';

// // for expsubc
// 	foreach (json_decode($_POST['expsubc'],true) as $wrow)
// 	{
// 		if(!empty($wrow))
// 		{
// 			$update_expsubc[] = "(".(($wrow['input_id'] == '')?0:$wrow['input_id']).','.$wrow['input_user'].','.$wrow['input_sublinkid'].',"'.$wrow['input_key'].'",'.$wrow['input_current'].")";
// 		}
// 	}

// 	// foreach ($result_expsubc as $update_key)
// 	// {
// 	// 	$update_expsubc[] = "(".$update_key['input_id'].','.$update_key['input_user'].','.$update_key['input_sublinkid'].',"'.$update_key['input_key'].'",'.$update_key['input_current'].")";
// 	// }
// 	// print_r($result_expsubc);

// 	$query .= implode(',',$update_expsubc);
// 	$query .= "ON DUPLICATE KEY UPDATE input_current=VALUES(input_current)";
// 	// print_r($_POST);
// 	// echo $query;
// 	// die($query);
// 	$objectUpdate  = $funObj->ExecuteQuery($query);
// 	// print_r($objectUpdate);
// 	if($objectUpdate > 0)
// 	{
// 		echo 'yes';
// 	}
// 	else
// 	{
// 		echo 'no';
// 	}
// }

