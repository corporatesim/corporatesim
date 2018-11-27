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
$object   = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameScenario[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// For Reset Input Value

if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
{
	// remove last element of post variable
	array_pop($_POST);
	// echo "<pre>";	print_r($_POST);

	$Game_ID         = $_POST['game_game'];
	$Scen_ID         = $_POST['game_scenario'];
	$User_ID         = $_POST['user_id'];
	$add_user_filter = $_POST['user_filter'];
	$replay          = $_POST['replay'];
	$reset           = $_POST['reset']; 

	// if user select some users
	if($add_user_filter == 'select_users' )
	{
		if(count($User_ID) > 0)
		{
			for ($i=0; $i < count($User_ID); $i++)
			{ 
				if($_POST['reset'])
				{
					$deleteSql = "DELETE FROM GAME_INPUT WHERE input_user = $User_ID[$i] AND input_sublinkid IN (SELECT SubLink_Id FROM GAME_LINKAGE_SUB  WHERE SubLink_LinkID = (SELECT Link_ID FROM GAME_LINKAGE where Link_GameID = $Game_ID And Link_ScenarioID = $Scen_ID))";
					$object    = $functionsObj->ExecuteQuery($deleteSql);
					// updating user status of game
					$updateArr = array(
						'US_LinkID' => 0,
						'US_Output' => 0,
					);
					// altering where condition as per the defined updaetdata function
					$FieldName = " US_GameID=$Game_ID AND US_ScenID=$Scen_ID AND US_UserID";
					$functionsObj->UpdateData('GAME_USERSTATUS',$updateArr,$FieldName,$User_ID[$i],0);

					if($object)
					{
						$tr_msg = "Records updated successfully";
					}
					else
					{
						$er_msg = "Database Connection Error";
					}
				}

				if($_POST['replay'])
				{
					$updateSql = " UPDATE GAME_USERSTATUS SET US_ReplayStatus=1 WHERE US_UserID=$User_ID[$i] AND US_GameID=$Game_ID AND US_ScenID=$Scen_ID";
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
			}
		}
	}
	// if user select all users
	else
	{
		if($_POST['reset'])
		{
			$sql = "DELETE FROM GAME_INPUT WHERE input_sublinkid IN (SELECT SubLink_Id FROM GAME_LINKAGE_SUB  WHERE SubLink_LinkID = (SELECT Link_ID FROM GAME_LINKAGE where Link_GameID = $Game_ID And Link_ScenarioID = $Scen_ID))";
			$object = $functionsObj->ExecuteQuery($sql);

			$updateArr = array(
				'US_LinkID' => 0,
				'US_Output' => 0,
			);
			// altering where condition as per the defined updaetdata function
			$FieldName = " US_GameID=$Game_ID AND US_ScenID";
			$functionsObj->UpdateData('GAME_USERSTATUS',$updateArr,$FieldName,$Scen_ID,0);

			if($object)
			{
				$tr_msg = "Records updated successfully";
			}
			else
			{
				$er_msg = "Database Connection Error";
			}
		}

		if($_POST['replay'])
		{
			$sql    = "UPDATE GAME_USERSTATUS SET US_ReplayStatus=1 WHERE US_GameID=$Game_ID AND US_ScenID=$Scen_ID";
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
	}
	// echo "<script>alert('Records updated successfully');</script>";
	// header("Location:".site_root."ux-admin/ReplayPermission");
}

include_once doc_root.'ux-admin/view/'.$file;