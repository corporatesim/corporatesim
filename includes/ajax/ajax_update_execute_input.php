<?php
include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(30000);

$funObj       = new Functions();
$userid       = $_SESSION['userid'];
$linkid       = $_SESSION['user_report']['LinkId'];
$userName     = $_SESSION['user_report']['userName'];
$gameName     = $_SESSION['user_report']['gameName'];
$ScenarioName = $_SESSION['user_report']['ScenarioName'];

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

// calling this function from js\function.js file
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
	$carry_field_data     = $_POST['carry_field_data'];
	$inserted_input_key   = array();
	$query                = "INSERT INTO `GAME_INPUT`(input_id,input_user,input_sublinkid,input_key,input_current) VALUES ";
	// print_r($formula_json_expcomp);
	// print_r($formula_json_expsubc);
	// print_r($input_field_values);
	// print_r($carry_field_data); die('here');
	// creating component array
	if(count($formula_json_expcomp) > 0)
	{
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
				$expcomp_array_values[$expcomp_key]         = round(eval('return '.implode('',$cvalue).';'),2);
				$input_field_values[$expcomp_key]['values'] = round(eval('return '.implode('',$cvalue).';'),2);
			}
			// echo $expcomp_key.'<br>';
		}
	}
	// creating for subcomponent
	if(count($formula_json_expsubc) > 0)
	{
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
				$expsubc_array_values[$expsubc_key]         = round(eval('return '.implode('',$cvalue).';'),2);
				$input_field_values[$expsubc_key]['values'] = round(eval('return '.implode('',$cvalue).';'),2);
			}
		}
	}

	if(count($input_field_values) > 0)
	{
		foreach ($input_field_values as $query_key => $query_value)
		{
			if(!empty($query_value['input_sublinkid']) && $query_value['values'] != '')
			{
				// start of replacing value from game_link_replace table
				$sqlreplace = "SELECT Rep_Value FROM `GAME_LINK_REPLACE` 
				INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
				WHERE Rep_SublinkID=".$query_value['input_sublinkid']." AND Rep_Start<= ".$query_value['values']."
				AND Rep_End>=".$query_value['values']." AND 
				(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
				$objreplace  = $funObj->ExecuteQuery($sqlreplace);
				if ($objreplace->num_rows > 0) 
				{
					$resreplace = $funObj->FetchObject($objreplace);
					$current    = $resreplace->Rep_Value;
				}
				else
				{
					$current = $query_value['values'];
				}
				// end of replacing value

				if($query_value['input_id'] < 1)
				{
					$query_value['input_id'] = 0;
					$inserted_input_key[]    = "'".$query_value['input_key']."'";
				}
				$query_field_value [] = "(".$query_value['input_id'].",".$userid.",".$query_value['input_sublinkid'].",'".$query_value['input_key']."',".$current.")";
				$input_field_values[$query_key]['values'] = $current;
			}
		}

		$query  .= implode(',',$query_field_value);
		$query  .= "ON DUPLICATE KEY UPDATE input_current=VALUES(input_current)";
		// making query to update input_id in the json of inserted record
		$object  = $funObj->ExecuteQuery($query);
	}
	

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
	// $object  = $funObj->ExecuteQuery($query);
	// echo $query;
	// when everything updated then modify user report
	// delete the existing data for that particular user
	$delete_sql = "DELETE FROM GAME_SITE_USER_REPORT_NEW WHERE uid=$userid AND linkid=$linkid";
	$delete     = $funObj->ExecuteQuery($delete_sql);
	$sqlComp12  = "SELECT ls.SubLink_ID,  CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
	FROM `GAME_LINKAGE_SUB` ls 
	LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
	LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
	WHERE SubLink_LinkID=".$linkid ." 
	ORDER BY SubLink_ID";

	$objcomp12 = $funObj->ExecuteQuery($sqlComp12);

	while($rowinput = $objcomp12->fetch_object())
	{
		$title  = $rowinput->Comp_Subcomp;					
		$check  = $funObj->SelectData(array(), 'GAME_INPUT', array("input_user='".$userid."' AND  input_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);

		$check1 = $funObj->SelectData(array(), 'GAME_OUTPUT', array("output_user='".$userid."' AND  output_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);

		if($check->num_rows > 0)
		{
			$result            = $funObj->FetchObject($check);
			$userdate [$title] = $result->input_current;
		}
		elseif($check1->num_rows > 0)
		{
			$result1           = $funObj->FetchObject($check1);
			$userdate [$title] = $result1->output_current;
		}
		else
		{
			$userdate [$title] = '';
		}
	}

	$userreportdetails = (object) array(
		'uid'            =>	$userid,
		'user_name'      =>	$userName,
		'game_name'      =>	$gameName,
		'secenario_name' =>	$ScenarioName,
		'linkid'         =>	$linkid,
		'user_data'      =>	json_encode($userdate),
		'date_time'      =>	date('Y-m-d H:i:s')
	);
	$result = $funObj->InsertData('GAME_SITE_USER_REPORT_NEW', $userreportdetails);
	// report modification done

	// to update the carry forward values
	if(count($carry_field_data) > 0)
	{
		foreach ($carry_field_data as $id=>$query)
		{
			// echo $id.' and '.$query.'<br>';
			$val        = $funObj->ExecuteQuery($query);
			$rescarry   = $funObj->FetchObject($val);
			$carryValue = $rescarry->input_current;
			$input_field_values[$id]['values'] = $carryValue;
		}
	}
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

// for component branching
if($_POST['action']=='componentBranching')
{
	// print_r($_POST);
	// Array
	// (
	// 	[action] => componentBranching
	// 	[param]  => branchComp_6448
	// 	[name]   => mohit
	// )
	$param      = $_POST['param'];
	$idSublink  = explode('_',$param);
	$SubLink_ID = $idSublink[1];
	$branchSql = "SELECT gbc.*,gi.input_current FROM GAME_BRANCHING_COMPONENT gbc LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gbc.CompBranch_SublinkId AND input_user=".$userid." WHERE gbc.CompBranch_SublinkId=".$SubLink_ID." ORDER BY gbc.CompBranch_Order";
	// die($branchSql);
	$branchObj = $funObj->ExecuteQuery($branchSql);
	if($branchObj->num_rows > 0)
	{
		while($row=$branchObj->fetch_object())
		{
			if(($row->input_current >= $row->CompBranch_MinVal) && ($row->input_current <= $row->CompBranch_MaxVal))
			{
				$nextVisibleComp = 'branchComp_'.$row->CompBranch_NextCompSublinkId;
				$hideComp        = 'branchComp_'.$row->CompBranch_SublinkId;
				$hideOverlyDiv   = 'overlay_'.$row->CompBranch_SublinkId;
				// hiding the current component
				$statusSql       = "UPDATE GAME_INPUT SET input_showComp=1 WHERE input_user=".$userid." AND input_sublinkid=".$row->CompBranch_SublinkId;
				$statusObj       = $funObj->ExecuteQuery($statusSql);
				// showing the next component, to keep the status, if page reload then show from this component
				$statusSql       = "UPDATE GAME_INPUT SET input_showComp=2 WHERE input_user=".$userid." AND input_sublinkid=".$row->CompBranch_NextCompSublinkId;
				$statusObj       = $funObj->ExecuteQuery($statusSql);
				// echo $statusSql.'<br>';
				break;
			}
		}
		echo $hideComp.','.$hideOverlyDiv.','.$nextVisibleComp;
	}
	else
	{
		echo 'no';
	}

}

