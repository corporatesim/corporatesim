<?php
include 'config/dbconnect.php';
include 'config/functions.php';
include 'config/settings.php';
require_once doc_root.'ux-admin/model/model.php';
$modelObj = new Model();
$_SESSION['userpage'] = 'gameCatalogue';
//include 'includes/header.php';
$FunctionsObj = new functions();

session_start();
$UserId= $_SESSION['userid'];

if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}

// if user is logged in then go to select game page
/*if($_SESSION['username'] != NULL)
{
	header("Location:".site_root."selectgame.php");
}*/
$gameId         = $_POST['gameId'];
$_SESSION['id'] = $gameId;

if(isset($_POST['submit']) && $_POST['submit'] == 'Enroll')
{
	echo ucwords("<h2>Currently you are not allowed to enroll by yourself.</h2> <h3>Please contact <a href='mailto:info@corporatesim.com'>info@corporatesim.com</a> </h3><a href='".site_root."'>Click Here</a> To go back."); exit();
    //reset game functionality....
	$qry = "SELECT * FROM GAME_USERSTATUS WHERE `US_UserID`=$UserId AND `US_GameID`=$gameId AND `US_LinkID`=1";
	$executeqry = $modelObj->ExecuteQuery($qry);
	// echo $executeqry->num_rows;exit;
	if($executeqry->num_rows > 0)
	{
		$deleteInput    = "DELETE FROM GAME_INPUT WHERE input_user = $UserId AND input_sublinkid IN (SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN (SELECT LInk_ID FROM GAME_LINKAGE WHERE Link_GameID = $gameId ) GROUP BY SubLink_LinkID) ";

			   //die($deleteSql);

		$inputDel = $modelObj->ExecuteQuery($deleteInput);

					//delete data from game_output table
		$deleteOutput   = "DELETE FROM GAME_OUTPUT WHERE output_user = $UserId AND output_sublinkid IN(SELECT
		SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN(SELECT LInk_ID FROM GAME_LINKAGE WHERE Link_GameID = $gameId) GROUP BY SubLink_LinkID)";

		$outputDel      = $modelObj->ExecuteQuery($deleteOutput);

					//  delete data from game linkage user
		$linkDel       = " DELETE FROM  GAME_LINKAGE_USERS WHERE  UsScen_GameId =$gameId AND UsScen_UserId=".$UserId;
		$linkUserDel   = $modelObj->ExecuteQuery($linkDel);
          //delete data from game_userstatus
		$delUserStatus = "DELETE FROM GAME_USERSTATUS WHERE US_UserID = $UserId AND US_GameID = $gameId ";

		$userDel       = $modelObj->ExecuteQuery($delUserStatus);

           //update game in geme_site_users table,which has been played...
	/*	$updateGame = "UPDATE GAME_SITE_USERS SET User_games = REPLACE(User_games,'$gameId,',' ') WHERE User_id=$UserId ";

		$gameDel = $modelObj->ExecuteQuery($updateGame);
*/
					  //delete from Game User Games...
	/*	$delt = "DELETE FROM GAME_USERGAMES WHERE UG_UserID=$UserId AND UG_GameID=$gameId";
		$delUserGames = $modelObj->ExecuteQuery($delt);
*/
      //update timer
		$Timer = " UPDATE  GAME_LINKAGE_TIMER  gt  SET  gt.timer = (
		SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min) FROM GAME_LINKAGE gl
		WHERE gl.Link_GameID = $gameId) WHERE
		gt.userid = $UserId ";

		$modelObj->ExecuteQuery($Timer);

		if($inputDel && $outputDel && $linkUserDel && $userDel  == true)
		{
			$result = "Game allocated successfully";
			echo $result;
		}

		else
		{
			$result = "Error";
			echo $result;
		}
	}
	
	//echo "<script>window.location='".site_root."user_registration.php?ID=".$gameId."'</script>";
	else
	{
		$where   = array("`User_id` ='".$UserId."'");
		$object  = $modelObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '','');
		$data    = $object->fetch_object();
      //echo $object->num_rows; exit;

		if($object->num_rows > 0)
		{				
			$user_game = $data->User_games;
	 //echo $UserId."<br>".$user_game; exit;
			$usersdata = (object) array(

				'User_games'         => $user_game.$gameId.',',
				'User_GameStartDate' => date('Y-m-d'),
				'User_GameEndDate'   => date('Y-m-d',strtotime("+3 days"))
			);

			$Result   = $modelObj->UpdateData('GAME_SITE_USERS', $usersdata, 'User_id', $UserId, 0);

			$UserData = (object) array(
				'UG_UserID'   => $UserId,
				'UG_GameID'   => $gameId,
			);
			$InsertDetail = $modelObj->InsertData('GAME_USERGAMES',$UserData);

					/*if($Result)
					{
						$password   = $modelObj->randomPassword();

						$loginDetail = array(

							'Auth_username'  => $username,
							'Auth_password'  => $password,
							'Auth_Date_time' => date('Y-m-d H:i:s')
						);

						$updatedata = $modelObj->UpdateData('GAME_USER_AUTHENTICATION',$loginDetail,'Auth_userid',$USERID);*/
						header("location:".site_root."selectgame.php");

					}
				}
			}

			/*$sql    = "SELECT * FROM GAME_GAME gg LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gg.Game_ID AND gus.US_UserID = $UserId WHERE gg.Game_ID NOT IN( SELECT gug.UG_GameID FROM game_usergames gug LEFT JOIN GAME_GAME gg ON gug.UG_GameID = gg.Game_ID WHERE gug.ug_userId = $UserId ) AND gg.Game_Delete = 0 ORDER BY gg.Game_ID ASC";*/

			/*$sql   ="SELECT * FROM GAME_GAME gg LEFT JOIN game_userstatus gus ON gus.US_GameID = gg.Game_ID AND gus.US_UserID = 6670 WHERE gg.Game_ID NOT IN( SELECT gug.UG_GameID FROM game_usergames gug LEFT JOIN `game_userstatus` gs ON gug.UG_UserID = gs.US_UserID WHERE gs.us_userId = 6670 AND gs.US_LinkID = 0 ) AND gg.Game_Delete = 0 ORDER BY `gg`.`Game_ID` ASC";*/

      //for simulation
			$simulationSql = "SELECT * FROM GAME_GAME gg WHERE gg.Game_Status = 1 AND gg.Game_Delete = 0 AND gg.Game_ID NOT IN( SELECT gug.UG_GameID FROM GAME_USERGAMES gug LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gug.UG_GameID AND gug.UG_UserID = gus.US_UserID WHERE gug.UG_UserID = $UserId AND( gus.US_LinkID < 1 OR gus.US_LinkID IS NULL ) ) AND gg.Game_Elearning = 0";
			$simulationGames = $FunctionsObj->ExecuteQuery($simulationSql);

			//for eLearning 
			$eLearningSql = "SELECT * FROM GAME_GAME gg WHERE gg.Game_Status = 1 AND gg.Game_Delete = 0 AND gg.Game_ID NOT IN( SELECT gug.UG_GameID FROM GAME_USERGAMES gug LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gug.UG_GameID AND gug.UG_UserID = gus.US_UserID WHERE gug.UG_UserID = $UserId AND( gus.US_LinkID < 1 OR gus.US_LinkID IS NULL ) ) AND gg.Game_Elearning = 1";
			$simulationElearning = $FunctionsObj->ExecuteQuery($eLearningSql);

				//for Assessment
			$assesmentSql = "SELECT * FROM GAME_GAME gg WHERE gg.Game_Status = 1 AND gg.Game_Delete = 0 AND gg.Game_ID NOT IN( SELECT gug.UG_GameID FROM GAME_USERGAMES gug LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gug.UG_GameID AND gug.UG_UserID = gus.US_UserID WHERE gug.UG_UserID = $UserId AND( gus.US_LinkID < 1 OR gus.US_LinkID IS NULL ) ) AND gg.Game_Elearning = 2";
			$simulationAssesment = $FunctionsObj->ExecuteQuery($assesmentSql);
			// echo $eLearningSql."<pre>"; print_r($simulationElearning); exit();

			include_once doc_root.'views/gameCatalogue.php';
