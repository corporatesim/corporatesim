<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
set_time_limit(300);

$functionsObj = new Functions();
$userid       = $_SESSION['userid'];
$userName     = $_SESSION['username'];
$gameid       = $_GET['ID'];

include_once 'includes/lib/phpchartdir.php';

// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}

// if user is not assigned the game then redirect to home page ,game_site_users
$game_sql = "SELECT * FROM GAME_SITE_USERS WHERE LOCATE($gameid, User_games) AND User_id=$userid";
$res_game = $functionsObj->ExecuteQuery($game_sql);
// echo "<pre>"; print_r($res_game); exit;

if($res_game->num_rows < 1)
{
	// die($game_sql);
	header("Location:".site_root."selectgame.php");
}

if (isset($_GET['ID']) && !empty($_GET['ID']))
{
	// creating game linkage for users depending upon the scenario for scenario branching
	$updateValues   = array();
	$updateSql      = " INSERT INTO GAME_LINKAGE_USERS (UsScen_UserId,UsScen_GameId,UsScen_ScenId,UsScen_LinkId,UsScen_IsEndScenario) VALUES";
	$sqlQuery       = "SELECT gl.Link_ID, gl.Link_GameID, gl.Link_ScenarioID, gl.Link_Order, gu.UsScen_Id, gu.UsScen_GameId, gu.UsScen_ScenId,gu.UsScen_LinkId, gu.UsScen_UserId, gu.UsScen_Status FROM GAME_LINKAGE gl LEFT JOIN GAME_LINKAGE_USERS gu ON gu.UsScen_LinkId = gl.Link_ID AND gu.UsScen_UserId=".$userid." WHERE gl.Link_GameID =".$gameid." ORDER BY gl.Link_Order ASC";
	// die($sqlQuery);
	$sqlQuerObject  = $functionsObj->ExecuteQuery($sqlQuery);
	if($sqlQuerObject->num_rows == 1)
	{
		$endScenario = 1;
	}
	else
	{
		$endScenario = 0;
	}
	while ($sqlQueryResult = $sqlQuerObject->Fetch_object() )
	{
		// print_r($sqlQueryResult);
		if(empty($sqlQueryResult->UsScen_Status))
		{
			$checkSql = "SELECT * FROM GAME_LINKAGE_USERS WHERE UsScen_UserId=".$userid." AND UsScen_LinkId=".$sqlQueryResult->Link_ID;
			$checkObj = $functionsObj->ExecuteQuery($checkSql);
			if($checkObj->num_rows < 1)
			{
				$updateValues[]  = "($userid,$sqlQueryResult->Link_GameID,$sqlQueryResult->Link_ScenarioID,$sqlQueryResult->Link_ID,$endScenario)";
			}
		}
		// $updateSql      .= implode(',',$updateValues);
		// $updateValue  = "($userid,$sqlQueryResult->Link_GameID,$sqlQueryResult->Link_ScenarioID,$sqlQueryResult->Link_ID)";
		// $updateSql   .= $updateValue;
	}
	if(count($updateValues) > 0)
	{
		// echo "<pre>"; print_r($updateValues); exit;
		$updateValue  = implode(',',$updateValues);
		$updateSql   .= $updateValue;
		$functionsObj->ExecuteQuery($updateSql);
	}
	// echo $updateSql; exit();
	//get the actual link
	$where = array (
		"US_GameID = " . $gameid,
		"US_UserID = " . $userid
	);
	$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0 );
	//echo "US_GameID = " . $gameid." , US_UserID = " . $userid. " , Count = ".$obj->num_rows."</br>";
	// adding skip condition here for skipping the game and acenario description by inserting the record
	$skipSql           = "SELECT * FROM GAME_LINKAGE WHERE Link_GameID=".$gameid." ORDER BY Link_Order LIMIT 1";
	$skipObj           = $functionsObj->ExecuteQuery($skipSql);
	$skipRes           = $functionsObj->FetchObject ($skipObj);
	$Link_Introduction = $skipRes->Link_Introduction;
	$Link_Description  = $skipRes->Link_Description;
	$Link_ScenarioID   = $skipRes->Link_ScenarioID;
	// echo "<pre>"; print_r($skipRes); die($skipSql);
	if ($obj->num_rows > 0 || $Link_Introduction > 0)
	{		
		$array = array (
			'US_GameID'     => $gameid,
			'US_ScenID'     => $Link_ScenarioID,
			'US_UserID'     => $userid,
			'US_Input'      => 1,
			'US_CreateDate' => date ( 'Y-m-d H:i:s' ) 
		);
		if($obj->num_rows < 1)
		{
			$result = $functionsObj->InsertData ( 'GAME_USERSTATUS', $array, 0, 0 );					
		}
		// echo "<pre>"; print_r($obj); print_r($functionsObj->FetchObject ( $obj )); exit();
		$result1 = $functionsObj->FetchObject ( $obj );
		//echo "result1 -> US_LinkID  ".$result1->US_LinkID."  , Scen_ID  ".$result1->US_ScenID."</br>";
		//exit();
		if ($result1->US_LinkID == 0)
		{
			if($result1->US_ScenID == 0 && $Link_Introduction < 1)
			{
				//goto game_description page
				header("Location:".site_root."game_description.php?Game=".$gameid);
				exit();
			}
			else
			{
				//get linkid				
				// $sqllink    = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$result1->US_ScenID;
				// if intro/scenario skipped then result1->US_ScenID will be null, so our scen_ID will be the inserted record id
				if(!empty($result1->US_ScenID))
				{
					$scenarioID = $result1->US_ScenID;
				}
				else
				{
					$scenarioID = $Link_ScenarioID;
				}
				$sqllink = "SELECT gl.*, gm.Game_Name, gs.Scen_Name FROM `GAME_LINKAGE` gl LEFT JOIN GAME_GAME gm ON gm.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Link_ScenarioID WHERE gl.`Link_GameID` = $gameid AND gl.Link_ScenarioID=$scenarioID";
				// die($Link_ScenarioID.', '.$sqllink);
				$link         = $functionsObj->ExecuteQuery($sqllink);
				$resultlink   = $functionsObj->FetchObject($link);				
				$linkid       = $resultlink->Link_ID;
				// modified above query and adding these 2 vars for updating user reports, so that we don't need to run extra query there
				$gameName     = $resultlink->Game_Name;
				$ScenarioName = $resultlink->Scen_Name;
				$reports_var  = array(
					'LinkId'       => $linkid,
					'userid'       => $userid,
					'userName'     => $userName,
					'gameName'     => $gameName,
					'ScenarioName' => $ScenarioName,
				);
				$_SESSION['user_report'] = $reports_var;
				//echo "LinkID=>".$linkid."</br>";
				//echo $result1->US_Input ." ". $result1->US_Output."</br>";
				//exit();
				if ($result1->US_Input == 0 && $result1->US_Output == 0 )
				{
					// echo "Input=0 Output=0"."</br>";
					if($link->num_rows > 0){											
						$url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;
						//echo $url;						
						//header("Location:".site_root."scenario_description.php?Link=".$linkid);
						//exit();
					}
					//goto scenario_description page					
				}
				elseif($result1->US_Input == 1 && $result1->US_Output == 0 )
				{
					//echo "Input=1 Output=0"."</br>";
					//goto Input page
					
					//$url = site_root."input.php?Link=".$resultlink->Link_ID;
					
				}
				else
				{
					echo "Input=0 Output=1"."</br>";
					//goto output page
					
					//$url = site_root."output.php?Link=".$resultlink->Link_ID;
					
					header("Location:".site_root."output.php?ID=".$gameid);
					exit();
					//Goto next scenario					
				}
			}
		}
		else{
			//goto result page
			
			$url = site_root."result.php?Link=".$result1->US_LinkID;

			header("Location:".site_root."result.php?Game=".$gameid);
			exit();
		}
	}
	else
	{
		//goto game_description page
		// echo "first time user <pre>"; print_r($obj); print_r($functionsObj->FetchObject ( $obj )); exit();
		header("Location:".site_root."game_description.php?Game=".$gameid);
		exit();
	}
}
else
{
	header("Location:".site_root."selectgame.php");
	exit();
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'NOTSET';

if (!isset($_SESSION['userid']))
{
	//go to login page.
	unset($_SESSION['username']);
	//setcookie($cookie_name, "", 1);
	header("Location:".site_root."login.php");
	
	exit(0);
}

if (isset($_COOKIE['hours']) && isset($_COOKIE['minutes']))
{
	if($_COOKIE['hours']>0 || $_COOKIE['minutes']>0)
	{
		$hour = $_COOKIE['hours'];
		$min  = $_COOKIE['minutes'];
	}
	else
	{			
			/* $start = date('M d,y H:i:s');
			$hour = $link->Link_Hour;
			$min = $link->Link_Min;
			//setcookie(name,value,expire,path,domain,secure,httponly);
			setcookie('hours',$hours,time()+86400,"/");
			setcookie('minutes',$hours,time()+86400,"/");
			setcookie('date',date('M d,y H:i:s',strtotime($str,strtotime($start))),time()+86400,"/");
			
			//$_COOKIE['hours'] = $hour ;
			//$_COOKIE['minutes'] = $min ;			
			
			$str ="+".$hour." hour +".$min." minutes";
			//display the converted time
			$_SESSION['date'] = date('M d,y H:i:s',strtotime($str,strtotime($start))); */
		}
	}

	$sqlexist = "SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
	(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$linkid.")";
//echo $sqlexist;
	$object = $functionsObj->ExecuteQuery($sqlexist);
//echo $object->num_rows;
	if($object->num_rows > 0)
	{
		// die('if: '.$addedit);
		$addedit = "Edit";

		// if admin update any comp or subcom for the area that changes the key then update after login
		$updateQuery  = "SELECT * FROM GAME_VIEWS WHERE views_Game_ID = $gameid AND is_updated=1";
		$updateObject = $functionsObj->ExecuteQuery($updateQuery);
		if($updateObject->num_rows > 0)
		{
			while($updateRow = $updateObject->fetch_object())
			{
				$sqlUpdate = "UPDATE GAME_INPUT SET input_key = '".$updateRow->views_key."' WHERE input_sublinkid=$updateRow->views_sublinkid AND input_user=$userid";
				$rowUpdate = $functionsObj->UpdateData('GAME_INPUT', array('input_key' => $updateRow->views_key), 'input_sublinkid', $updateRow->views_sublinkid, 0);
				// commenting the below code so that other user can also see the changes, if we will set the status to 0 then after on user it won't detect the change
				// if($rowUpdate > 0)
				// {
				// update the game_views table is_updated field to 0
				// $update_update = $functionsObj->UpdateData('GAME_VIEWS', array('is_updated' => 0), 'views_id', $updateRow->views_id, 0);
				// }
			}
		}

		while($row = $object->fetch_object())
		{
			$data[$row->input_key]  = $row->input_current;
			//echo $row->key."-".$row->current.",";
		}
	}
	else
	{
		// die('else: '.$addedit);
		$sql = "SELECT views_sublinkid AS input_sublinkid, views_current AS input_current, views_key AS input_key FROM GAME_VIEWS WHERE views_Game_ID = $gameid";
		// $sql = "SELECT * FROM GAME_VIEWS gv INNER JOIN GAME_INPUT gi ON gi.input_sublinkid=gv.views_sublinkid WHERE views_Game_ID = $gameid AND gi.input_user=$userid";
		$view_object = $functionsObj->ExecuteQuery($sql);

		// delete all existing record from input table before inserting
		$delSql = "DELETE FROM GAME_INPUT WHERE input_user = $userid AND input_sublinkid IN( SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID IN( SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = $gameid ) ) ";
		$delObj = $functionsObj->ExecuteQuery($delSql);

		while($snap_view = mysqli_fetch_object($view_object))
		{
			$snapCurrent       = ($snap_view->input_current != '')?$snap_view->input_current:'NULL';
			$bulkInsertArray[] = "($userid,$snap_view->input_sublinkid,$snapCurrent,'".$snap_view->input_key."')";
		}
		// print_r($bulkInsertArray); echo "<br>";
		if(count($bulkInsertArray) > 0)
		{
			$bulkValues      = implode(',',$bulkInsertArray);
			$bulkInsertQuery = "INSERT INTO GAME_INPUT (input_user,input_sublinkid,input_current,input_key) VALUES $bulkValues";
			// die($bulkInsertQuery);
			$functionsObj->ExecuteQuery($bulkInsertQuery);
		}
		else
		{
			if($chekExist->num_rows < 1)
			{
				$addedit = "Add";
			}
		}
	}
//echo $addedit;
//foreach($data as $x=>$x_value)
//{	echo $x."=>".$x_value." ";
//}
//exit;

	$sql    = "SELECT * FROM GAME_LINKAGE WHERE Link_ID = ".$linkid;
	$object = $functionsObj->ExecuteQuery($sql);

	if($object->num_rows > 0){
		$link    = $functionsObj->FetchObject($object);
		$gameid  = $link->Link_GameID;
		$scenid  = $link->Link_ScenarioID;
		$gameurl = site_root."game_description.php?Game=".$gameid;
		$scenurl = site_root."scenario_description.php?Link=".$linkid;
		
		$where   = array (
			"US_GameID = " . $gameid,
			"US_ScenID = " . $scenid,
			"US_UserID = " . $userid
		);
		$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, '', '', '', '', 0 );
		if ($obj->num_rows > 0)
		{
			$status       = $functionsObj->FetchObject($obj);
			$userstatusid = $status->US_ID;
		//exists
			$array = array (			
				'US_Input'  => 1,
				'US_Output' => 0
			);
			$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
		}
		else
		{
		//insert
			$array = array (
				'US_GameID'     => $gameid,
				'US_ScenID'     => $scenid,
				'US_UserID'     => $userid,
				'US_Input'      => 1,
				'US_Output'     => 0,
				'US_CreateDate' => date ( 'Y-m-d H:i:s' ) 
			);
			$result = $functionsObj->InsertData ( 'GAME_USERSTATUS', $array, 0, 0 );
		}

	}
	// while user submit the page from input page by submit button
	if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
	{
		// echo "<pre>"; print_r($_POST);exit();
		if( !empty($_POST) )
		{
			$data =array();

			foreach($_POST as $key => $value)
			{
				$strresult  = $strresult.$key."->".$value." , ";
				$data[$key] = $value;		
			}

			foreach($data as $x=>$x_value)
			{	  
				$str = explode("_",$x);

			//if($str[0] == $_POST['active'])
			//{
				if($str[1] == 'comp')
				{
					$sublinkid = $data[$str[0].'_linkcomp_'.$str[2]];
					$compid    = $str[2];
					$subcompid = 0;
					$current   = $x_value;	//check for REPLACE condition
					$key       = $x;
					//echo "Comp".$compid."--".$current.",";
					if(!empty($current))
					{
						$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
						INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
						WHERE Rep_SublinkID=".$sublinkid." AND Rep_Start<= ".$current."
						AND Rep_End>=".$current." AND 
						(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
									//echo $sqlreplace;
						$objreplace  = $functionsObj->ExecuteQuery($sqlreplace);
						if ($objreplace->num_rows > 0) 
						{
							$resreplace = $functionsObj->FetchObject($objreplace);
							$current    = $resreplace->Rep_Value;
						}
					}
					//check if already exists				
					$sql = "SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
					//echo $sql;
					//exit();
					$object = $functionsObj->ExecuteQuery($sql);

					if ($object->num_rows > 0) 
					{
						$res   = $functionsObj->FetchObject($object);
						$array = array (
							'input_current' => $current
						);
						//check for REPLACE condition
						$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
					}
					else
					{
						$array = array(
							'input_user'      => $userid,
							'input_sublinkid' => $sublinkid,
							'input_current'   => $current,
							'input_key'       => $key
						);				
						$functionsObj->InsertData('GAME_INPUT', $array, 0, 0);
					}
				}
				elseif($str[1] == 'subc')
				{
					$sublinkid = $data[$str[0].'_linksubc_'.$str[2]];
					$compid    = 0;
					$subcompid = $str[2];
					$current   = $x_value;	//check for REPLACE condition
					$key       = $x;
					//echo "SubComp".$subcompid."--".$current.",";
					if(!empty($current) && isset($current))
					{
						$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
						INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
						WHERE Rep_SublinkID=".$sublinkid." AND Rep_Start<= ".$current."
						AND Rep_End>=".$current." AND 
						(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";

						$objreplace  = $functionsObj->ExecuteQuery($sqlreplace);

						if ($objreplace->num_rows > 0) 
						{
							$resreplace = $functionsObj->FetchObject($objreplace);
							$current    = $resreplace->Rep_Value;
						}
					}
					//update if already exists
					$sql    = "SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
					$object = $functionsObj->ExecuteQuery($sql);						
					
					if ($object->num_rows > 0) {
						$res   = $functionsObj->FetchObject($object);
						$array = array (
							'input_current' => $current
						);
						$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );					
					}
					else
					{
						$array = array(
							'input_user'      => $userid,
							'input_sublinkid' => $sublinkid,
							'input_current'   => $current,
							'input_key'       => $key
						);	
						
						$functionsObj->InsertData('GAME_INPUT', $array, 0, 0);
					}
				}
			//}		
			}
			
			$flag = false;
			$cnt  = 1;

			while(!$flag)
			{
				$flag = true;
				foreach($data as $x=>$x_value)
				{
					$str = explode("_",$x);

					if($str[1] == 'expcomp')
					{
						//$strkey = explode("_",$x);
						$strvalue = explode(" ",$x_value);
						$tmp      = $str[0]."_linkcomp_".$str[2];
						foreach($strvalue as $y=>$y_value)
						{
							if (strpos($y_value,'comp')!== false)
							{
								$sql = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
								if (!empty($data[$str[0].'_link'.$y_value]))
								{
									$sql .= " and input_sublinkid=".$data[$str[0].'_link'.$y_value];
								}
								$sql .= " and input_key like ('%_".$y_value."%')";

								$formula = $functionsObj->ExecuteQuery($sql);
								if($formula->num_rows > 0){
									$result       = $functionsObj->FetchObject($formula);
									$strvalue[$y] = $result->input_current;
								}						
							}
							elseif(strpos($y_value,'subc')!== false){
								$sql ="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
								if(!empty($data[$str[0].'_link'.$y_value]))
								{
									$sql .=" and input_sublinkid=".$data[$str[0].'_link'.$y_value];
								}
								$sql .=" and input_key like ('%_".$y_value."%')";

								$formula = $functionsObj->ExecuteQuery($sql);
								if($formula->num_rows > 0){
									$result       = $functionsObj->FetchObject($formula);
									$strvalue[$y] = $result->input_current;
								}						
							}
						}				
					//execute using eval
						$value = implode(" ",$strvalue);
						
					//Update
						
					//if $value contains comp or subc... do not eval and flag=false
						if( strpos( $value, 'comp' ) !== false || strpos( $value, 'subc' ) !== false )
						{
							$flag=false;
						}
						else{
						//echo "input_sublinkid=" . $data[$tmp]."input_key=" . $str[0]."_comp_". $str[2]."input_user =" . $userid ;
							$current = eval('return '.$value.';');
							
							if(!empty($current))
							{
								$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
								INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
								WHERE Rep_SublinkID=".$data[$tmp]." AND Rep_Start<= ".$current."
								AND Rep_End>=".$current." AND 
								(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
								$objreplace  = $functionsObj->ExecuteQuery($sqlreplace);
								if ($objreplace->num_rows > 0) 
								{
									$resreplace = $functionsObj->FetchObject($objreplace);
									$current    = $resreplace->Rep_Value;
								}
							}
							$object = $functionsObj->SelectData ( array (), 'GAME_INPUT', array (
								"input_sublinkid=" . $data[$tmp],
								"input_key='" . $str[0]."_comp_". $str[2]."'",
								"input_user =" . $userid 
							), '', '', '', '', 0 );
							
							if ($object->num_rows > 0) {
								$res   = $functionsObj->FetchObject($object);
								$array = array (
									'input_current' => $current
								);
							//check for REPLACE condition
								$result  = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
								$strdata = $strdata." Update for id ".$res->input_id;
							}
							else{
								if (!empty($value))
								{
									$array = array(
										'input_user'      => $userid,
										'input_sublinkid' => $data[$tmp],
										'input_key'       => $str[0]."_comp_". $str[2],
										'input_current'   => $current
									);
								//check for REPLACE condition
									$functionsObj->InsertData('GAME_INPUT', $array, 0, 0);
								//$strresult = $strresult." INSERT ".$data[$str[0].'_link'.$y_value]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
									$strresult = $strresult." INSERT ".$data[$tmp]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
								}
							}						
						}
					}
					elseif($str[1] == 'expsubc')
					{
						$strvalue = explode(" ",$x_value);
						foreach($strvalue as $y => $y_value)
						{
							if (strpos($y_value,'comp')!== false)
							{
								$tmp = $str[0]."_link_".$str[2];

								$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid;
								if (!empty($data[$str[0].'_link'.$y_value]))
								{
									$sql .= " and input_sublinkid=".$data[$str[0].'_link'.$y_value];
								}
								$sql    .= " and input_key like ('%".$y_value."%')";							
								$formula = $functionsObj->ExecuteQuery($sql);
								if($formula->num_rows > 0){
									$result       = $functionsObj->FetchObject($formula);
									$strvalue[$y] = $result->input_current;
								}						
							}
							elseif(strpos($y_value,'subc')!== false)
							{
								$tmp = $str[0]."_linksubc_".$str[2];

							//$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_linksubc_'.$str[2]]." and input_key='".$str[0]."_".$y_value."'";
								if(!empty($data[$str[0].'_link'.$y_value]))
								{
									$sql .= " and input_sublinkid=".$data[$str[0].'_link'.$y_value];
								}
								$sql    .= " and input_key like ('%".$y_value."%')";							
								$formula = $functionsObj->ExecuteQuery($sql);
								if($formula->num_rows > 0)
								{
									$result       = $functionsObj->FetchObject($formula);
									$strvalue[$y] = $result->input_current;
								}						
							}
						}
					//execute using eval
						$value   = implode(" ",$strvalue);
						$strdata = $strdata." ".$value." = ".eval('return '.$value.';');
						$tmp     = $str[0]."_linksubc_".$str[2];
						
					// update current in Db for sublink and key
						
					//if $value contains comp or subc... do not eval and flag=false
						if( strpos( $value, 'comp' ) !== false || strpos( $value, 'subc' ) !== false )
						{
							$flag=false;
						}
						else
						{
							$current = eval('return '.$value.';');
						//check for REPLACE condition
							if(!empty($current))
							{
								$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` 
								INNER JOIN GAME_LINKAGE_SUB ls on Rep_SublinkID =ls.SubLink_ID 
								WHERE Rep_SublinkID=".$data[$tmp]." AND Rep_Start<= ".$current."
								AND Rep_End>=".$current." AND 
								(ls.SubLink_InputMode ='user' OR ls.SubLink_InputMode ='formula')";
								$objreplace  = $functionsObj->ExecuteQuery($sqlreplace);
								if ($objreplace->num_rows > 0) 
								{
									$resreplace = $functionsObj->FetchObject($objreplace);
									$current    = $resreplace->Rep_Value;
								}
							}
							$object = $functionsObj->SelectData ( array (), 'GAME_INPUT', array (
								"input_sublinkid=" . $data[$tmp],						
								"input_key='" . $str[0]."_subc_". $str[2]."'",
								"input_user =" . $userid 
							), '', '', '', '', 0 );		
							
							if ($object->num_rows > 0) 
							{
								$res   = $functionsObj->FetchObject($object);
								$array = array (
									'input_current' => $current
								);
							//check for REPLACE condition
								$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
							}
							else
							{
								if (!empty($value))
								{
									$array = array(
										'input_user'      => $userid,
										'input_sublinkid' => $data[$tmp],
										'input_key'       => $str[0]."_comp_". $str[2],
										'input_current'   => $current
									);	
								//check for REPLACE condition								
									$functionsObj->InsertData('GAME_INPUT', $array, 0, 0);
								//$strresult = $strresult." INSERT ".$data[$str[0].'_link'.$y_value]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
									$strresult = $strresult." INSERT ".$data[$tmp]."  ".$str[0]."_comp_". $str[2]."  VALUE: ".$value."</br>";
								}
							}
						}
					}
				//bind 
			//}				
				}
				$cnt++;
				if($cnt>3)
				{
					$flag=true;
				}

			}	
			
		//echo("calculate output values from database values.");
			
		//get all formula for output fields
			$sql = "SELECT ls.SubLink_ID , ls.SubLink_FormulaExpression as expression
			FROM GAME_LINKAGE_SUB ls WHERE SubLink_type=1 and SubLink_LinkID=".$linkid;
		//echo "SQL - ".$sql."</br>";
		//exit();
			$formula = $functionsObj->ExecuteQuery($sql);
			if($formula->num_rows > 0)
			{
				while($row = mysqli_fetch_array($formula))
				{
					$expression = $row['expression'];
					$sublinkid  = $row['SubLink_ID'];
				//echo "expression".$expression."</br>";
				//exit();
					$strvalue = explode(" ",$expression);
					foreach($strvalue as $y=>$y_value)
					{					
						$strkey = explode("_",$y_value);
					//echo "strkey  ".$strkey[0]."</br>";
						if ($strkey[0]=='subc')
						{
							$sqlvalue = "SELECT input_current FROM GAME_INPUT 
							WHERE input_user=".$userid." AND input_sublinkid IN
							(SELECT ls.SubLink_ID FROM GAME_LINKAGE_SUB ls 
							WHERE SubLink_SubCompId=".$strkey[1]." and SubLink_LinkID=".$linkid." )";
							//AND SubLink_type=0
							
							//echo "sqlvalue- ".$sqlvalue."</br>";
							
							$value        = $functionsObj->ExecuteQuery($sqlvalue);
							$resultvalue  = $functionsObj->FetchObject($value);
							//echo "y - ".$y."  strvalue[y] - ".$strvalue[$y]."</br>";
							//echo $resultvalue->input_current."</br>";
							
							$strvalue[$y] = $resultvalue->input_current;
							
						}
						elseif($strkey[0]=='comp')
						{
							$sqlvalue = "SELECT input_current FROM GAME_INPUT 
							WHERE input_user=".$userid." AND input_sublinkid IN
							(SELECT ls.SubLink_ID FROM GAME_LINKAGE_SUB ls 
							WHERE SubLink_CompId=".$strkey[1]." AND SubLink_SubCompId=0 AND SubLink_type=0 and SubLink_LinkID=".$linkid." )";

							//echo "sqlvalue- ".$sqlvalue."</br>";
							
							$value        = $functionsObj->ExecuteQuery($sqlvalue);
							$resultvalue  = $functionsObj->FetchObject($value);
							//echo "y - ".$y."  strvalue[y] - ".$strvalue[$y]."</br>";
							//echo $resultvalue->input_current."</br>";
							
							$strvalue[$y] = $resultvalue->input_current;
							
						}					
					}
					
					$streval = implode(" ",$strvalue);
					//echo "sublinkid - ".$sublinkid."</br>";
					//echo "streval - ".$streval."</br>";
					//exit();
					$current = eval('return '.$streval.';');
					
					$sql     = "SELECT * FROM `GAME_OUTPUT` WHERE output_user=".$userid." and output_sublinkid=".$sublinkid;
					//echo $sql;
					//exit();
					$object  = $functionsObj->ExecuteQuery($sql);
					//echo $object->num_rows;
					
					if ($object->num_rows > 0)
					{
						$res   = $functionsObj->FetchObject($object);
						$array = array (
							'output_current' => $current
						);
						$result = $functionsObj->UpdateData ( 'GAME_OUTPUT', $array, 'output_id', $res->output_id );
						echo "UPDATE";
					}
					else
					{
						$array = array(
							'output_user'      => $userid,
							'output_sublinkid' => $sublinkid,
							'output_current'   => $current
						);				
						$functionsObj->InsertData('GAME_OUTPUT', $array, 0, 0);
						echo "INSERT";
					}
				//echo(implode(" ",$strvalue));
				//join implode
				}
			}
		}
		
		$where = array (
			"US_GameID = " . $gameid,
			"US_ScenID = " . $scenid,
			"US_UserID = " . $userid
		);
		$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, '', '', '', '', 0 );
		if ($obj->num_rows > 0)
		{
			$status       = $functionsObj->FetchObject($obj);
			$userstatusid = $status->US_ID;
		//exists
			$array        = array (			
				'US_Output' => 1
			);
			$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
		}
		else
		{
			//insert
			$array = array (
				'US_GameID'     => $gameid,
				'US_ScenID'     => $scenid,
				'US_UserID'     => $userid,
				'US_Input'      => 1,
				'US_Output'     => 1,
				'US_CreateDate' => date ( 'Y-m-d H:i:s' )
			);
			$result = $functionsObj->InsertData ( 'GAME_USERSTATUS', $array, 0, 0 );

		}
		// echo 'GameID: '.$gameid.', ScenID: '.$scenid.'<br>';
		// die('rout from here to input again if link enabled');

		header("Location: ".site_root."output.php?ID=".$gameid);
		exit(0);
	}

	$sql = "SELECT g.game_name as Game,sc.Scen_Name as Scenario, sc.Scen_Branching as Branching, ls.SubLink_AreaName as Area, 
	ls.SubLink_CompName as Component, ls.SubLink_SubcompName as Subcomponent, l.*,ls.* 
	FROM GAME_LINKAGE l 
	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
	INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
	WHERE l.Link_ID=".$linkid;
//" order by link_gameid,Link_ScenarioID,Link_Order";

	$input = $functionsObj->ExecuteQuery($sql);
	if($input->num_rows > 0)
	{
		$result = $functionsObj->FetchObject($input);
	//$url = site_root."scenario_description.php?Link=".$result->Link_ID;
	}

	$sqlarea="SELECT DISTINCT a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_BackgroundColor as BackgroundColor, a.Area_TextColor as TextColor
	, SUM(ls.SubLink_ShowHide) as ShowHide, COUNT(ls.SubLink_ShowHide) as countlnk 
	FROM GAME_LINKAGE l 
	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
	INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
	INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
	WHERE ls.SubLink_Type=0 AND l.Link_ID=".$linkid." GROUP BY a.Area_ID,a.Area_Name 
	ORDER BY a.Area_Sequencing";
//echo $sqlarea;
	$area          = $functionsObj->ExecuteQuery($sqlarea);	
	$sqlcompSanNew =  "SELECT distinct ls.SubLink_AreaID as AreaID, ls.SubLink_CompID as CompID, ls.SubLink_SubCompID as SubCompID, 
	ls.SubLink_AreaName as Area_Name, ls.SubLink_SubcompName as SubComp_Name, l.Link_Order as 'Order',  
	c.Comp_Name as Comp_Name, ls.SubLink_ChartID as ChartID, ls.SubLink_Details as Description, ls.SubLink_InputMode as Mode, 
	ls.SubLink_FormulaExpression as exp , ls.SubLink_ID as SubLinkID,ls.Sublink_AdminCurrent as AdminCurrent, 
	ls.Sublink_AdminLast as AdminLast, ls.Sublink_ShowHide as ShowHide , ls.Sublink_Roundoff as RoundOff,
	ls.SubLink_LinkIDcarry as CarryLinkID, ls.SubLink_CompIDcarry as CarryCompID, 
	ls.SubLink_SubCompIDcarry as CarrySubCompID, g.Game_ID as GameID, l.Link_ScenarioID as ScenID  
	FROM GAME_LINKAGE l 
	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID $charttypeComp
	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
	WHERE ls.SubLink_Type=0 AND ls.SubLink_SubCompID>0 and l.Link_ID=".$linkid." ORDER BY a.Area_Sequencing";

	$sqlcomp = "SELECT distinct ls.SubLink_AreaName as Area_Name, ls.SubLink_CompName as Comp_Name, ls.SubLink_Details as Description 
	FROM GAME_LINKAGE l 
	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
	WHERE ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid;
	$component = $functionsObj->ExecuteQuery($sqlcomp);

	function GetChartData($gameid,$userid,$ChartID)
	{
		$functionsObj       = new Functions();
		$sqlchart           = "SELECT * FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$ChartID;
		$chartDetails       = $functionsObj->ExecuteQuery($sqlchart);
		$ResultchartDetails = $functionsObj->FetchObject($chartDetails);
		$sqllink            = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$ResultchartDetails->Chart_ScenarioID;
		$LinkId             =  $functionsObj->ExecuteQuery($sqllink);
		$ResultLinkId       = $functionsObj->FetchObject($LinkId);
		$sqlexist           = "SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
		(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
		$object       = $functionsObj->ExecuteQuery($sqlexist);
		//chart_component and subcomponent
		$comp         = $ResultchartDetails->Chart_Components;
		$subcomp      = $ResultchartDetails->Chart_Subcomponents;
		$arrayComp    = explode(',',$comp);
		$arraysubcomp = explode(',',$subcomp);
		//print_r($arrayComp);

		//echo $object->num_rows;
		if($object->num_rows > 0)
		{
			while($row = $object->fetch_object())
			{
				$compdata  = $row->input_key;
				$allcompID = explode('_',$compdata);
				$compID    = $allcompID[2];
				
				if (in_array($compID, $arrayComp) && $allcompID[1]=='comp')
				{
					$sqlcompName = "SELECT Comp_Name FROM GAME_COMPONENT WHERE Comp_ID = ".$compID;
					$compDetails = $functionsObj->ExecuteQuery($sqlcompName);
					$compName    = $functionsObj->FetchObject($compDetails);
					
					$dataChart[$compName->Comp_Name]  = $row->input_current;
				}
				
				else if (in_array($compID, $arraysubcomp) && $allcompID[1]=='subc')
				{
					$sqlsubcompName = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
					$subcompDetails = $functionsObj->ExecuteQuery($sqlsubcompName);
					$subcompName    = $functionsObj->FetchObject($subcompDetails);
					
					$dataChart[$subcompName->SubComp_Name]  .= $row->input_current;
				}			
			}
		}
		return $dataChart;
		header("Content-type: image/png");
		print($c->makeChart2(PNG));
	}
	$url = site_root."input.php?Scenario=".$result->Link_ScenarioID;
	include_once doc_root.'views/input.php';