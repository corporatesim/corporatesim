<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

// $object   = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
// $sitename = $functionsObj->FetchObject($object);
$file   = 'ReplayPermission.php';
$header = 'Replay Permission';

// selcting all games for dropdown
$object   = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), 'Game_Name', '', '', '', 0);
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameName[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// selcting all scenario linked with the games for dropdown
/*$object   = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameScenario[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}*/

// For Reset Input Value

if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
{
	// remove last element of post variable
	array_pop($_POST);
	//echo "<pre>";	print_r($_POST);

	$Game_ID         = $_POST['game_game'];
	$Scen_ID         = $_POST['game_scenario'];
	$User_ID         = $_POST['user_id'];
	$add_user_filter = $_POST['user_filter'];
	$replay          = $_POST['replay'];
	$reset           = $_POST['reset'];
	$linkid          = $_POST['linkid']; 

	// if admin select some users
	if($add_user_filter == 'select_users' )
	{
		if(count($User_ID) > 0)
		{
			for ($i=0; $i < count($User_ID); $i++)
			{ 
				if($_POST['reset'])
				{
					$deleteSql    = "DELETE FROM GAME_INPUT WHERE input_user = $User_ID[$i] AND input_sublinkid IN (SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN (SELECT LInk_ID FROM GAME_LINKAGE WHERE Link_GameID = $Game_ID ) GROUP BY SubLink_LinkID) ";
					
					$object       = $functionsObj->ExecuteQuery($deleteSql);
					// also make game_linkage_users table unplayed
					$unplay       = " UPDATE GAME_LINKAGE_USERS SET UsScen_IsEndScenario=0, UsScen_Status=0 WHERE  UsScen_GameId =$Game_ID AND UsScen_UserId=".$User_ID[$i];
					$objectUnplay = $functionsObj->ExecuteQuery($unplay);
					// taking this query to set the default scenario which is the first scenario of the game
					$scenSql      = " SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_GameID=$Game_ID ORDER BY Link_Order ASC LIMIT 1";
					$resObj       = $functionsObj->ExecuteQuery($scenSql);
					$result       = $functionsObj->FetchObject($resObj);
					$updateArr    = array(
						'US_LinkID' => 0,
						'US_Output' => 0,
						'US_Input'  => 0,
						'US_ScenID' => $result->Link_ScenarioID,
					);
					// altering where condition as per the defined updaetdata function
					$FieldName = " US_GameID=$Game_ID AND US_UserID";
					$functionsObj->UpdateData('GAME_USERSTATUS',$updateArr,$FieldName,$User_ID[$i],0);
					
           //update timer
					
					$updTimer = " UPDATE  GAME_LINKAGE_TIMER  gt  SET  gt.timer = (
					SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min) FROM GAME_LINKAGE gl
					WHERE gl.Link_GameID = $Game_ID ) WHERE
					gt.userid = $User_ID[$i] ";
					
					$functionsObj->ExecuteQuery($updTimer);
					
					if($object)
					{
						$tr_msg = "Records updated successfully";
					}
					else
					{
						$er_msg = "Database Connection Error";
					}
				}

        //execute only 1 from replay and stopReplay
				if($_POST['radio'] == 1)
				{
					$updateSql = " UPDATE GAME_USERSTATUS SET US_ReplayStatus=1 WHERE US_UserID=$User_ID[$i] AND US_GameID=$Game_ID ";
					//print_r($updateSql)  ;
					$object = $functionsObj->ExecuteQuery($updateSql);
					if($object)
					{
						$tr_msg = "Records updated successfully";
					}
					else
					{
						$er_msg = "Database Connection Error";
					}
				}

				if($_POST['radio'] == 0)
				{
					$stopSql = " UPDATE GAME_USERSTATUS SET US_ReplayStatus=0 WHERE US_UserID=$User_ID[$i] AND US_GameID=$Game_ID ";
					//echo $updateSql ;
					$object = $functionsObj->ExecuteQuery($stopSql);
					if($object)
					{
						$tr_msg = "Records updated successfully";
					}
					else
					{
						$er_msg = "Database Connection Error";
					}
				}
			}
		}
	}
	// if admin select all users
	else
	{
		if($_POST['reset'])
		{
			$sql          = "DELETE FROM GAME_INPUT WHERE input_sublinkid IN (SELECT SubLink_Id FROM GAME_LINKAGE_SUB  WHERE SubLink_LinkID IN (SELECT Link_ID FROM GAME_LINKAGE where Link_GameID = $Game_ID ) GROUP BY SubLink_LinkID )";
			$sql1         = "DELETE FROM GAME_INPUT gi WHERE gi.input_sublinkid IN( SELECT gl.SubLink_ID FROM GAME_LINKAGE_SUB gl WHERE gl.SubLink_LinkID = IN (SELECT Link_ID FROM GAME_LINKAGE where Link_GameID = $Game_ID ) )";
			// echo $sql .'<br>'. $sql1; die();
			$object       = $functionsObj->ExecuteQuery($sql);
			// also make game_linkage_users table unplayed
			$unplay       = " UPDATE GAME_LINKAGE_USERS SET UsScen_IsEndScenario=0, UsScen_Status=0 WHERE  UsScen_GameId =".$Game_ID;
			$objectUnplay = $functionsObj->ExecuteQuery($unplay);
			// taking this query to set the default scenario which is the first scenario of the game
			$scenSql      = " SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_GameID=$Game_ID ORDER BY Link_Order ASC LIMIT 1";
			$resObj       = $functionsObj->ExecuteQuery($scenSql);
			$result       = $functionsObj->FetchObject($resObj);
			$updateArr    = array(
				'US_LinkID' => 0,
				'US_Output' => 0,
				'US_Input'  => 0,
				'US_ScenID' => $result->Link_ScenarioID,
			);
			// altering where condition as per the defined updaetdata function
			$FieldName = " US_GameID";
			$updateRes = $functionsObj->UpdateData('GAME_USERSTATUS',$updateArr,$FieldName,$Game_ID);
			// print_r($updateRes); exit;
			$updTimer = " UPDATE  GAME_LINKAGE_TIMER  gt  SET  gt.timer = (
			SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min) FROM GAME_LINKAGE gl
			WHERE gl.Link_GameID = $Game_ID )";
			$functionsObj->ExecuteQuery($updTimer);

			if($object)
			{
				$tr_msg = "Records updated successfully";
			}
			else
			{
				$er_msg = "Database Connection Error";
			}
		}

		if($_POST['radio'] == 1)
		{
			$sql    = "UPDATE GAME_USERSTATUS SET US_ReplayStatus=1 WHERE US_GameID=$Game_ID ";
			$object = $functionsObj->ExecuteQuery($sql);

			if($object)
			{
				$tr_msg = "Records updated successfully";
			}
			else
			{
				$er_msg = "Database Connection Error";
			}
		}

		if($_POST['radio'] == 0)
		{
			$stopSql = " UPDATE GAME_USERSTATUS SET US_ReplayStatus=0 WHERE US_GameID=$Game_ID ";
			$object = $functionsObj->ExecuteQuery($stopSql);
			if($object)
			{
				$tr_msg = "Records updated successfully";
			}
			else
			{
				$er_msg = "Database Connection Error";
			}
		}
	}
	// echo "<script>alert('Records updated successfully');</script>";
	// header("Location:".site_root."ux-admin/ReplayPermission");
}

include_once doc_root.'ux-admin/view/'.$file;