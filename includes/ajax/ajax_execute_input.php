<?php
include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(30000);

$funObj     = new Functions();
$userid     = $_SESSION['userid'];
$strresult  = "";
$strdata    = "";
$sublinkid  = "";
$current    = "";
$key        = "";
$array      = "";
$insertArr  = array();
$insertData = array();
$updateArr  = array();
$updateData = array();

if (!isset($_SESSION['userid']))
{
	//go to login page.
	
	unset($_SESSION['username']);
	//setcookie($cookie_name, "", 1);
	header("Location:".site_root."login.php");
	
	exit(0);
}

if( !empty($_POST) )
{
	$data   = array();
	$active = $_POST['active'];
	
	//print_r($_POST); exit;
	
	foreach($_POST as $key => $value)
	{
		//$strresult = $strresult.$key."->".$value." , ";
		$data[$key]  = $value;		
	}
	// print_r($data); exit;
	//calculation of formula
	$flag      = false;
	$cnt       = 1;
	$strresult = "false </br>";
	while(!$flag)
	{
		$strresult = $strresult ."In while loop </br>";
		
		$flag = true;
		foreach($data as $x => $x_value)
		{
			$str = explode("_",$x);		// breaking string by '_' and creating array	
			
			//if($str[0] == $_POST['active'])
			//{
			if($str[1] == 'expcomp')
			{
					//$strkey = explode("_",$x);
				$strresult = $strresult." strresult: x - ".$x.", x_value - ".$x_value."</br>";		
				$strvalue  = explode(" ",$x_value);
				$tmp       = $str[0]."_linkcomp_".$str[2];
				foreach($strvalue as $y => $y_value)
				{
						//echo $data[$str[0].'_link'.$y_value];
						//$sublinkid = $data[$str[0].'_sublink'.$y_value];
					$strresult.= "y : ".$y." y_value : ".$y_value."</br>";
					$strresult.= "str[0].'_link_'.y_value : ".$data[$str[0].'_link'.$y_value]." sublinkid : ".$data[$tmp]."</br>";

					if (strpos($y_value,'comp')!== false)
					{
						$strresult = $strresult." strvalue: y - ".$y.", y_value - ".$y_value."</br>";
							//$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_linkcomp_'.$str[2]]." and input_key='".$str[0]."_".$y_value."'";
							//$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_key='".$str[0]."_".$y_value."'";
						$strresult = $strresult." input_sublinkid= ".$data[$str[0].'_link'.$y_value]."</br>".$str[0]."</br>".$y_value."</br>";
						$sql       = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
						if (!empty($data[$str[0].'_link'.$y_value]))
						{
							$sql.= " and input_sublinkid=".$data[$str[0].'_link'.$y_value];
						}
							//else
							//{
							//	$sql.= " and input_sublinkid=0";
							//}
						$sql      .= " and input_key like ('%_".$y_value."%')";
						$strresult = $strresult." --expcomp comp sql : ".$sql."</br>";
						$formula   = $funObj->ExecuteQuery($sql);
						if($formula->num_rows > 0)
						{
							$result       = $funObj->FetchObject($formula);
							$strvalue[$y] = $result->input_current;
						}						
					}
					elseif(strpos($y_value,'subc')!== false)
					{
						$strresult = $strresult." strvalue: y - ".$y.", y_value - ".$y_value."</br>";

							//$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_linkcomp_'.$str[2]]." and input_key='".$str[0]."_".$y_value."'";
							//$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_key='".$str[0]."_".$y_value."'";
						$strresult = $strresult." input_sublinkid= ".$data[$str[0].'_link'.$y_value]."</br>".$str[0]."</br>".$y_value."</br>";
						$sql       = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
						if(!empty($data[$str[0].'_link'.$y_value]))
						{
							$sql .=" and input_sublinkid=".$data[$str[0].'_link'.$y_value];
						}
							//else
							//{
							//	$sql.= " and input_sublinkid=0";
							//}
						$sql      .=" and input_key like ('%_".$y_value."%')";
						$strresult = $strresult." --expcomp subc sql : ".$sql."</br>";
						$formula   = $funObj->ExecuteQuery($sql);
						if($formula->num_rows > 0)
						{
							$result       = $funObj->FetchObject($formula);
							$strvalue[$y] = $result->input_current;
						}						
					}
				}				
					//execute using eval
				$value     = implode(" ",$strvalue); // creating string from array ' ' seprated.
					//$tmp     =$str[0]."_linkcomp_".$str[2];
				$strresult = $strresult."value : ".$value." , tmp : ".$tmp." , data[tmp] : ".$data[$tmp]." sublinkid : ".$data[$str[0].'_link'.$y_value]."</br>";
					//Update

					//if $value contains comp or subc... do not eval and flag=false
				if( strpos( $value, 'comp' ) !== false || strpos( $value, 'subc' ) !== false )
				{
					$flag = false;
				}
				else
				{
					$sublinkid = $data[$str[0].'_link'.$y_value];
					if(empty($sublinkid)) {$sublinkid =0;}
					$object = $funObj->SelectData ( array (), 'GAME_INPUT', array (
						"input_sublinkid=" . $data[$tmp],
						"input_key='" . $str[0]."_comp_". $str[2]."'",
						"input_user =" . $userid 
					), '', '', '', '', 0 );

														// $array = array(
									// 'input_user'	=> $userid,
									// 'input_sublinkid'	=> $data[$tmp],
									// 'input_key' 		=> $str[0]."_comp_". $str[2],
									// 'input_current' 	=> $current
								// );

						// $object = $funObj->SelectData ( array (), 'GAME_INPUT', array (
							// "input_sublinkid=" . $sublinkid,
							// "input_key='" . $str[0]."_comp_". $str[2]."'",
							// "input_user =" . $userid 
						// ), '', '', '', '', 0 );

							//"input_sublinkid=" . $data[$str[0].'_link'.$y_value],
							//if(!empty($data[$str[0].'_link'.$y_value]))
							//{
							//	"input_sublinkid=".$data[$str[0].'_link'.$y_value],
							//}
					if ($object->num_rows > 0) 
					{
						$res     = $funObj->FetchObject($object);
						$current = eval('return '.$value.';');
							//check for REPLACE condition
						if(!empty($current) && !empty($data[$tmp]))
						{
							$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
							INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
							WHERE Rep_SublinkID=".$data[$tmp]." AND Rep_Start<= ".$current."
							AND Rep_End>=".$current." AND 
							(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
							$objreplace  = $funObj->ExecuteQuery($sqlreplace);
							if ($objreplace->num_rows > 0) 
							{
								$resreplace = $funObj->FetchObject($objreplace);
								$current    = $resreplace->Rep_Value;
							}
						}
							//$array = array (
							//	'input_current' => eval('return '.$value.';')
							//);
						$array = array (
							'input_current' => $current
						);

						// creating update array 
						$updateArr[] = array(
							'input_current' => $current,
							'input_id'      => $res->input_id,
						);

						// commenting this function to update bulk data in single query, function written down
						// $result    = $funObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
						$strresult = $strresult." Update for comp id ".$res->input_id."</br>";
							//$strdata = $strdata." Update for id ".$res->input_id;
					}
					else
					{
						if (!empty($value))
						{
							$current = eval('return '.$value.';');
								//check for REPLACE condition
							if(!empty($current) && !empty($data[$tmp]))
							{
								$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
								INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
								WHERE Rep_SublinkID=".$data[$tmp]." AND Rep_Start<= ".$current."
								AND Rep_End>=".$current." AND 
								(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
								$objreplace  = $funObj->ExecuteQuery($sqlreplace);
								if ($objreplace->num_rows > 0) 
								{
									$resreplace = $funObj->FetchObject($objreplace);
									$current    = $resreplace->Rep_Value;
								}
							}				
							$array = array(
								'input_user'      => $userid,
								'input_sublinkid' => $data[$tmp],
								'input_key'       => $str[0]."_comp_". $str[2],
								'input_current'   => $current
							);

							$insertArr[] = array(
								'input_user'      => $userid,
								'input_sublinkid' => $data[$tmp],
								'input_key'       => $str[0]."_comp_". $str[2],
								'input_current'   => $current
							);
							// commenting this function to insert bulk data in one time query new function wriiten down
							// $funObj->InsertData('GAME_INPUT', $array, 0, 0);
								//$strresult = $strresult." INSERT ".$data[$str[0].'_link'.$y_value]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
							$strresult = $strresult." INSERT ".$data[$tmp]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
						}
					}
				}
			}
			elseif($str[1] == 'expsubc')
			{
					//$strkey = explode("_",$x);
				$strresult = $strresult." strresult: x - ".$x.", x_value - ".$x_value."</br>";
				$strvalue  = explode(" ",$x_value);
				$tmp       = $str[0]."_linksubc_".$str[2];
				foreach($strvalue as $y=>$y_value)
				{						
					if (strpos($y_value,'comp')!== false)
					{
							//$tmp=$str[0]."_link_".$str[2];
						$strresult = $strresult." input_sublinkid= ".$data[$str[0].'_link'.$y_value]."</br>".$str[0]."</br>".$y_value."</br>";

						$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
						if (!empty($data[$str[0].'_link'.$y_value]))
						{
							$sql .= " and input_sublinkid=".$data[$str[0].'_link'.$y_value];
						}

						$sql      .= " and input_key like ('%".$y_value."%')";
						$strresult = $strresult." --expsubc comp sql : ".$sql."</br>";
						$formula   = $funObj->ExecuteQuery($sql);
						if($formula->num_rows > 0)
						{
							$result       = $funObj->FetchObject($formula);
							$strvalue[$y] = $result->input_current;
						}						
					}
					elseif(strpos($y_value,'subc')!== false)
					{
							//$tmp=$str[0]."_linksubc_".$str[2];

						$strresult = $strresult." input_sublinkid= ".$data[$str[0].'_link'.$y_value]."</br>".$str[0]."</br>".$y_value."</br>";

						$sql       = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
						if(!empty($data[$str[0].'_link'.$y_value]))
						{
							$sql .= " and input_sublinkid=".$data[$str[0].'_link'.$y_value];
						}

						$sql      .= " and input_key like ('%".$y_value."%')";
						$strresult = $strresult." --expsubc subc sql : ".$sql."</br>";
						$formula   = $funObj->ExecuteQuery($sql);
						if($formula->num_rows > 0)
						{
							$result       = $funObj->FetchObject($formula);
							$strvalue[$y] = $result->input_current;
						}						
					}
				}
					//execute using eval
				$value     = implode(" ",$strvalue);
				$strresult = $strresult."value : ".$value." , tmp : ".$tmp." , data[tmp] : ".$data[$tmp]." sublinkid : ".$data[$str[0].'_link'.$y_value]."</br>";

					// update current in Db for sublink and key

					//if $value contains comp or subc... do not eval and flag=false
				if( strpos( $value, 'comp' ) !== false || strpos( $value, 'subc' ) !== false )
				{
					$flag=false;
				}
				else
				{
					$sublinkid = $data[$str[0].'_link'.$y_value];
					if(empty($sublinkid)) {$sublinkid =0;}
					$object = $funObj->SelectData ( array (), 'GAME_INPUT', array (
						"input_sublinkid = ".$data[$tmp],
						"input_key='" . $str[0]."_subc_". $str[2]."'",
						"input_user =" . $userid 
					), '', '', '', '', 0 );

						// $object = $funObj->SelectData ( array (), 'GAME_INPUT', array (
							// "input_sublinkid = ".$sublinkid,
							// "input_key='" . $str[0]."_subc_". $str[2]."'",
							// "input_user =" . $userid 
						// ), '', '', '', '', 0 );

					if ($object->num_rows > 0) 
					{
						$res     = $funObj->FetchObject($object);
							//check for REPLACE condition
						$current = eval('return '.$value.';');
						if(!empty($current) && !empty($data[$tmp]))
						{
							$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
							INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
							WHERE Rep_SublinkID=".$data[$tmp]." AND Rep_Start<= ".$current."
							AND Rep_End>=".$current." AND 
							(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
							$objreplace  = $funObj->ExecuteQuery($sqlreplace);
							if ($objreplace->num_rows > 0) 
							{
								$resreplace = $funObj->FetchObject($objreplace);
								$current    = $resreplace->Rep_Value;
							}
						}
						$array = array (
							'input_current' => $current
						);

						$updateArr[] = array(
							'input_current' => $current,
							'input_id'      => $res->input_id,
						);

						// commenting this function to update bulk data in single query, function written down
						// $result    = $funObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
						$strresult = $strresult." Update for subc id ".$res->input_id."</br>";
					}
					else
					{
						if (!empty($value))
						{
								//check for REPLACE condition
							$current = eval('return '.$value.';');
							if(!empty($current) && !empty($data[$tmp]))
							{
								$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
								INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
								WHERE Rep_SublinkID=".$data[$tmp]." AND Rep_Start<= ".$current."
								AND Rep_End>=".$current." AND 
								(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
								$objreplace  = $funObj->ExecuteQuery($sqlreplace);
								if ($objreplace->num_rows > 0) 
								{
									$resreplace = $funObj->FetchObject($objreplace);
									$current    = $resreplace->Rep_Value;
								}
							}
							$array = array(
								'input_user'      => $userid,									
								'input_sublinkid' => $data[$tmp],
								'input_key'       => $str[0]."_subc_". $str[2],
								'input_current'   => $current
							);	
								//check for REPLACE condition			
							$insertArr[] = array(
								'input_user'      => $userid,									
								'input_sublinkid' => $data[$tmp],
								'input_key'       => $str[0]."_subc_". $str[2],
								'input_current'   => $current
							);

							// commenting this function to insert bulk data in one time query new function wriiten down
							// $funObj->InsertData('GAME_INPUT', $array, 0, 0);
								//$strresult = $strresult." INSERT ".$data[$str[0].'_link'.$y_value]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
							$strresult = $strresult." INSERT ".$data[$tmp]."  ".$str[0]."_subc_". $str[2]."  VALUE: ".$value."</br>";
						}
					}
				}
			}
				//bind 
			//}				
		}
		$cnt++;
		if($cnt>15)
		{
			$flag=true;
		}

		// if already exist data then update
		if (count($updateArr) > 0)
		{
			foreach ($updateArr as $row)
			{
				$updateData[] = "('".$row['input_id']."','".$row['input_current']."')";
			}
			$fieldName  = ['input_id','input_current'];
			$updateData = implode(',',$updateData);	
			$result     = $funObj->BulkInsertUpdateData('GAME_INPUT', $fieldName, $updateData,'update');
		}
		// if data not exist then insert data
		if (count($insertArr) > 0)
		{
			foreach ($insertArr as $wrow)
			{
				$insertData[] = "('".$wrow['input_user']."','".$wrow['input_sublinkid']."','".$wrow['input_key']."','".$wrow['input_current']."')";
			}
			$fieldName  = ['input_user','input_sublinkid','input_key','input_current'];
			$insertData = implode(',',$insertData);		
			$result     = $funObj->BulkInsertUpdateData('GAME_INPUT', $fieldName, $insertData,'insert');
		}
	}
	$msg = array(
		"status" =>	1,
		"msg"    =>	$active
		
		//$strresult	
		//" Array Data --> ".
		//$active
		
	);	
}
else
{
	$msg = array(
		"status" =>	0,
		"msg"    =>	"Error"
	);
}

echo json_encode( $msg );
?>
