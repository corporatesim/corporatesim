<?php

include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(300);

$funObj = new Functions();
$UserID = $_SESSION['userid'];

if($_POST['action'] == 'replay')
{
	$GameID    = $_POST['GameID'];
	$ScenID    = $_POST['ScenID'];
	$LinkID    = $_POST['LinkID'];
	// taking this query to set the default scenario which is the first scenario of the game
	$scenSql   = " SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_GameID=$GameID ORDER BY Link_Order ASC LIMIT 1";
	$resObj    = $funObj->ExecuteQuery($scenSql);
	$result    = $funObj->FetchObject($resObj);
	// delete from game inputs
	$deleteSql = " DELETE FROM GAME_INPUT WHERE input_user = $UserID AND input_sublinkid IN( SELECT SubLink_Id FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN ( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $GameID))";
	// die($deleteSql);
	$resultDelete = $funObj->ExecuteQuery($deleteSql);

	// delete from game_output
	$sqlOut = " DELETE FROM GAME_OUTPUT WHERE output_user =$UserID AND output_sublinkid IN(SELECT Sublink_ID FROM GAME_LINKAGE_SUB WHERE Sublink_LinkID IN (SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=$GameID) AND Sublink_Type=1)";
	$sqlOutDel = $funObj->ExecuteQuery($sqlOut);

	$updateSql = " DELETE FROM GAME_USERSTATUS WHERE US_UserID = $UserID AND US_GameID = $GameID AND US_ScenID = $ScenID ";
	// echo $sql.'<br>';
	$resultUpdate = $funObj->ExecuteQuery($updateSql);
	// also make game_linkage_users table unplayed
	$unplay       = " DELETE FROM GAME_LINKAGE_USERS WHERE UsScen_GameId =$GameID AND UsScen_UserId=".$UserID;
	$objectUnplay = $funObj->ExecuteQuery($unplay);
	
	$updTimer     = "UPDATE GAME_LINKAGE_TIMER glt SET glt.timer =( SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min ) FROM GAME_LINKAGE gl WHERE gl.Link_ID = glt.linkid) WHERE glt.userid = $UserID AND glt.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=$GameID)";
	$funObj->ExecuteQuery($updTimer);
  // die($updTimer);
	// print_r($resultUpdate);	print_r($resultDelete);	die('here');
	//echo $updateSql.'<br>'.$deleteSql; die();

 //to reduce the replaycount with 1
	$qry         = "SELECT UG_ReplayCount FROM GAME_USERGAMES WHERE UG_GameID = $GameID AND UG_UserID = $UserID";
	$execute     = $funObj->ExecuteQuery($qry);
	$fetch       = $funObj->FetchObject($execute);
	$replayCount = $fetch->UG_ReplayCount;
	//echo $replayCount;exit;
	if($replayCount == -1)
	{

	}
	elseif($replayCount>0)
	{
		$replayCount-=1;

		$qry = "UPDATE GAME_USERGAMES SET UG_ReplayCount = $replayCount WHERE UG_GameID = $GameID AND UG_UserID = $UserID";
		$updatedqry = $funObj->ExecuteQuery($qry);

	}
	else
	{

	}


	if($resultUpdate && $resultDelete)
	{
		echo 'redirect';
	}
	elseif($resultUpdate)
	{
		echo 'User Status Update';
	}
	elseif($resultDelete)
	{
		echo 'User Record Deleted';
	}
	else
	{
		echo 'Database Connection Error';
	}
}

if($_POST['action'] == 'leaderboard')
{
	// print_r($_POST['gameid']);
	$gameid  = $_POST['gameid'];
	$message = "You have requested leaderboard for the game ".$_POST['gameid'];
	// die(json_encode(["status" => 200, "message" => $message]));
	// get data o/p data for particular game with refrence to gameid and create the leaderboard
	$leaderboardSql  = "SELECT * FROM GAME_LEADERBOARD WHERE Lead_BelongTo=0 AND Lead_Status=0 AND Lead_GameId=".$gameid;
	$leaderboardData = $funObj->RunQueryFetchObject($leaderboardSql);
	// print_r($leaderboardData);
	if(count($leaderboardData) > 0)
	{
		// coz there must be only one entry for per game for leaderboard
		$leadSql = "SELECT gi.input_user, gi.input_sublinkid, gi.input_current, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS NAME, gsu.User_profile_pic AS pic, gc.Comp_Name, gc.Comp_NameAlias FROM GAME_INPUT gi LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gi.input_user LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID =".$leaderboardData[0]->Lead_CompId." WHERE gi.input_sublinkid =( SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_Status = 1 AND SubLink_LinkID =( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID =".$leaderboardData[0]->Lead_GameId." AND Link_ScenarioID =".$leaderboardData[0]->Lead_ScenId.") AND SubLink_CompID =".$leaderboardData[0]->Lead_CompId." AND SubLink_SubCompID < 1 ) ORDER BY gi.input_current ".(($leaderboardData[0]->Lead_Order >0)?'DESC':'ASC');
		$leadData = $funObj->RunQueryFetchObject($leadSql);
		// echo $leadSql.'<br><br>'; print_r($leadData);
		// // die(json_encode(["status" => 200, "message" => $leadData]));
		$totalRecords = count($leadData);
		$userFlag     = false;
		// show only top 10 records
		// var_dump(array_search($UserID,$leadData));
		$returnData = "<table class='table table-bordered table-hover' style='font-size:14px;'><thead><th>Rank</th> <th>Name</th> <th>Image</th> <th>".((!empty($leadData[0]->Comp_NameAlias))?$leadData[0]->Comp_NameAlias:$leadData[0]->Comp_Name)."</th></thead><tbody>";

		for ($i=0; $i<$totalRecords; $i++)
		{
			$imgSrc = (empty($leadData[$i]->pic))?'avatar.png':$leadData[$i]->pic;
			switch(eval('return 1+'.$i.';'))
			{
				case 1:
				$j = "<img src='".site_root."images/1stWinner.png' width='30' data-toggle='tooltip' title='1st'>";
				break;

				case 2:
				$j = "<img src='".site_root."images/2ndWinner.png' width='30' data-toggle='tooltip' title='2nd'>";
				break;

				case 3:
				$j = "<img src='".site_root."images/3rdWinner.png' width='30' data-toggle='tooltip' title='3rd'>";
				break;

				default:
				$j = eval('return 1+'.$i.';');
				break;
			}
			// if user is in top 10
			if($leadData[$i]->input_user == $UserID && $i < 10)
			{
				$returnData .= "<tr class='alert-success'><td>".$j."</td> <td>You</td> <td><a href='javascript:void(0);' data-toggle='tooltip' title='You'><img src='".site_root."images/userProfile/".$imgSrc."' class='showImagePopUp' style='width:30px;'></a></td> <td>".$leadData[$i]->input_current."</td></tr>";
				$userFlag = true;
			}
			elseif($leadData[$i]->input_user != $UserID && $i < 10)
			{
				$returnData .= "<tr><td>".$j."</td> <td>".$leadData[$i]->NAME."</td> <td><a href='javascript:void(0);' data-toggle='tooltip' title='".$leadData[$i]->NAME."'><img src='".site_root."images/userProfile/".$imgSrc."' class='showImagePopUp' style='width:30px;'></a></td> <td>".$leadData[$i]->input_current."</td></tr>";
			}
			else
			{
				if($userFlag && $i==9)
				{
					// echo '<br><br>here in 121 <br><br>';
					break;
				}
				else
				{
					if($leadData[$i]->input_user == $UserID)
					{
						// is user is not in the top 10 then add the user at the bottom with his/her rank
						$returnData .= "<tr class='alert-danger'><td>".$j."</td> <td>You</td> <td><a href='javascript:void(0);' data-toggle='tooltip' title='You'><img src='".site_root."images/userProfile/".$imgSrc."' class='showImagePopUp' style='width:30px;'></a></td> <td>".$leadData[$i]->input_current."</td></tr>";
					}
					continue;
				}
			}
		}

		$returnData .= "</tbody> <tfoot> <tr><th colspan=4> <marquee> ".eval('return 2000+'.$totalRecords.';')." Users Played This Game </marquee></th></tr> </tfoot> </table>";
		die(json_encode(["status" => 200, "message" => $returnData]));
	}
	else
	{
		die(json_encode(["status" => 201, "message" => "Leaderboard will be available asap."]));
	}
}
