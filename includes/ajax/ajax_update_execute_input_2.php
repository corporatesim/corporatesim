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

// on click of save button evaluate json formula
if($_POST['action']=='updateFormula')
{
	$formula_json_expcomp = $_POST['formula_json_expcomp'];
	$formula_json_expsubc = $_POST['formula_json_expsubc'];
	$input_field_values   = $_POST['input_field_values'];
	print_r($formula_json_expsubc);
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
					$cvalue[]  = $input_field_values[$crow];
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
		$expcomp_array_values[$expcomp_key] = eval('return'.implode(' ',$cvalue).';');
		$input_field_values[$expcomp_key] = eval('return'.implode(' ',$cvalue).';');
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
					$cvalue[]  = $input_field_values[$srow];
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
		$expsubc_array_values[$expsubc_key] = eval('return'.implode(' ',$cvalue).';');
		$input_field_values[$expsubc_key]   = eval('return'.implode(' ',$cvalue).';');
	}


	// echo "<br> expsubc ".count($expsubc_array_values)."<br>";
	// print_r($expsubc_array_values);
	// echo "<br> expcmp ".count($expcomp_array_values)."<br>";
	// print_r($expcomp_array_values);
	// echo "<br> input ".count($input_field_values)."<br>";
	// print_r($input_field_values);
	// print_r($formula_json_expsubc);
	// print_r($formula_json_expcomp);
	echo json_encode($input_field_values);
}

//  run query for execution
if($_POST['action']=='runQuery')
{
	// print_r($_POST);
	// print_r(json_decode($_POST['expcomp'],true));
	// print_r(json_decode($_POST['expsubc'],true));
	$query = "INSERT into `GAME_INPUT` (input_id,input_user,input_sublinkid,input_key,input_current) VALUES ";
	// for expcomp
	foreach (json_decode($_POST['expcomp'],true) as $row)
	{
		if(!empty($row))
		{
			$update_expcomp[] = "(".(($row['input_id'] == '')?0:$row['input_id']).','.$row['input_user'].','.$row['input_sublinkid'].',"'.$row['input_key'].'",'.$row['input_current'].")";
		}
	}

	// foreach ($result_expcomp as $update_key)
	// {
	// 	$update_expcomp[] = "(".$update_key['input_id'].','.$update_key['input_user'].','.$update_key['input_sublinkid'].',"'.$update_key['input_key'].'",'.$update_key['input_current'].")";
	// }

	$query .= implode(',',$update_expcomp).',';

// for expsubc
	foreach (json_decode($_POST['expsubc'],true) as $wrow)
	{
		if(!empty($wrow))
		{
			$update_expsubc[] = "(".(($wrow['input_id'] == '')?0:$wrow['input_id']).','.$wrow['input_user'].','.$wrow['input_sublinkid'].',"'.$wrow['input_key'].'",'.$wrow['input_current'].")";
		}
	}

	// foreach ($result_expsubc as $update_key)
	// {
	// 	$update_expsubc[] = "(".$update_key['input_id'].','.$update_key['input_user'].','.$update_key['input_sublinkid'].',"'.$update_key['input_key'].'",'.$update_key['input_current'].")";
	// }
	// print_r($result_expsubc);

	$query .= implode(',',$update_expsubc);
	$query .= "ON DUPLICATE KEY UPDATE input_current=VALUES(input_current)";
	// print_r($_POST);
	// echo $query;
	// die($query);
	$objectUpdate  = $funObj->ExecuteQuery($query);
	// print_r($objectUpdate);
	if($objectUpdate > 0)
	{
		echo 'yes';
	}
	else
	{
		echo 'no';
	}
}