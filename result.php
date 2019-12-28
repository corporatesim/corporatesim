<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}

$functionsObj = new Functions();

//$linkid=$_GET['Link'];
//$scenid=$_GET['Scenario'];
$userid    = $_SESSION['userid'];
$gameid    = $_GET['ID'];
$companyid = $_SESSION['companyid'];
// echo $userid."</br>";
// echo $gameid."</br>";
//exit();

if (isset($_GET['ID']) && !empty($_GET['ID']))
{
	//get the actual link
	$where = array (
		"US_GameID = " . $gameid,
		"US_UserID = " . $userid
	);

	$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0 );
	//echo "US_GameID = " . $gameid." , US_UserID = " . $userid. " , Count = ".$obj->num_rows."</br>";
	//exit();
	
	if ($obj->num_rows > 0)
	{
		$result1 = $functionsObj->FetchObject ( $obj );
		$ScenID  = $result1->US_ScenID;
		
		if ($result1->US_LinkID == 0)
		{
			if($result1->US_ScenID == 0)
			{
				//goto game_description page
				header("Location:".site_root."game_description.php?Game=".$gameid);
				exit();
			}
			else
			{
				//get linkid				
				$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$result1->US_ScenID;
				
				//echo $sqllink;

				$link       = $functionsObj->ExecuteQuery($sqllink);
				$resultlink = $functionsObj->FetchObject($link);				
				$linkid     = $resultlink->Link_ID;
				//echo $linkid."</br>";
				//exit();
				if ($result1->US_Input == 0 && $result1->US_Output == 0 )
				{
					if($link->num_rows > 0){											
						$url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;
						//echo $url;
					}
					//goto scenario_description page
					
					//header("Location:".site_root."scenario_description.php?Link=".$resultlink->Link_ID);
					//exit();
				}
				elseif($result1->US_Input == 1 && $result1->US_Output == 0 )
				{
					//goto Input page
					
					//$url = site_root."input.php?Link=".$resultlink->Link_ID;
					header("Location:".site_root."input.php?ID=".$gameid);
					
					exit();
				}
				
				else
				{
					//goto output page
					
					//$url = site_root."output.php?Link=".$resultlink->Link_ID;
					
					//header("Location:".site_root."output.php?ID=".$gameID);
					//exit();
					//Goto next scenario	
					//update linkid
					$where = array (
						"US_GameID       = " . $gameid,
						"US_ScenID       = " . $result1->US_ScenID,
						"US_UserID       = " . $userid
					);
					
					$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, '', '', '', '', 0 );
					if ($obj->num_rows > 0)
					{
						$status       = $functionsObj->FetchObject($obj);
						$userstatusid = $status->US_ID;

						//exists
						$array = array (			
							'US_LinkID' => 1
						);
						$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
						// updating the game status to complete above, and now capturing the data of output for feedback/performance
						$leaderboardSql  = "SELECT * FROM GAME_LEADERBOARD WHERE Lead_BelongTo=0 AND Lead_Status=0 AND Lead_GameId=".$gameid;
						$leaderboardData = $functionsObj->RunQueryFetchObject($leaderboardSql);
						if(count($leaderboardData) > 0 && $result1->US_ScenID == $leaderboardData[0]->Lead_ScenId && $result)
						{
							// print_r($leaderboardData);
							$inputSql  = "SELECT input_current FROM GAME_INPUT WHERE input_user=".$userid." AND input_sublinkid=(SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_Status = 1 AND SubLink_LinkID =( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID =".$leaderboardData[0]->Lead_GameId." AND Link_ScenarioID =".$leaderboardData[0]->Lead_ScenId.") AND SubLink_CompID =".$leaderboardData[0]->Lead_CompId." AND SubLink_SubCompID < 1)";

							$inputData = $functionsObj->RunQueryFetchObject($inputSql);

							if(count($inputData) > 0)
							{
								$insertArray         = array(
									'Performance_UserId' => $userid,
									'Performance_GameId' => $gameid,
									'Performance_ScenId' => $leaderboardData[0]->Lead_ScenId,
									'Performance_CompId' => $leaderboardData[0]->Lead_CompId,
									'Performance_Value'  => $inputData[0]->input_current,
								);
								$addPerformanceData  = $functionsObj->InsertData( 'GAME_USER_PERFORMANCE', $insertArray, 0, 0 );
							}
						}
					}
				}
			}
		}
		else
		{

			$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$result1->US_ScenID;
			//echo $sqllink;
			$link       = $functionsObj->ExecuteQuery($sqllink);
			$resultlink = $functionsObj->FetchObject($link);				
			$linkid     = $resultlink->Link_ID;
			//goto result page
			
			//$url = site_root."result.php?Link=".$result1->US_LinkID;

			//header("Location:".site_root."result.php?Game=".$gameid);
			//exit();
		}
	}
	else
	{
		//goto game_description page
		header("Location:".site_root."game_description.php?Game=".$gameid);
		exit();
	}
}
else
{
	header("Location:".site_root."selectgame.php");
	exit();
}

$object      = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_id='.$gameid), '', '', '', '', 0);
$gamedetails = $functionsObj->FetchObject($object);


$sql ="SELECT g.game_name as Game,sc.Scen_Name as Scenario,a.Area_Name as Area, 
c.Comp_Name as Component, s.SubComp_Name as Subcomponent, l.*,ls.* 
FROM GAME_LINKAGE l 
INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE  l.Link_ID=".$linkid;
//" order by link_gameid,Link_ScenarioID,Link_Order";


$sql = "SELECT User_games FROM `GAME_SITE_USERS`
WHERE User_id=".$userid." and User_games in (SELECT US_Gameid FROM `GAME_USERSTATUS`
WHERE US_UserID = ".$userid.")";
//echo $sql;

$input = $functionsObj->ExecuteQuery($sql);

//$str = array();
if($input->num_rows > 0){
	$result = $functionsObj->FetchObject($input);
	//echo $result->User_games;
	$strgames = explode(",",$result->User_games);
	
	//$url = site_root."scenario_description.php?Link=".$result->Link_ID;
}


$url = site_root."input.php?Scenario=".$result->Link_ScenarioID;

// find user performance sql, show only user has played more than one time
$performanceSql  = "SELECT gp.Performance_Id, gp.Performance_Value, gc.Comp_NameAlias, gc.Comp_Name, gp.Performance_CreatedOn, (SELECT gi.input_current FROM GAME_INPUT gi WHERE gi.input_sublinkid =(SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID =( SELECT gll.Link_ID FROM GAME_LINKAGE gll WHERE gll.Link_GameID = gl.Lead_GameId AND gll.Link_ScenarioID = gl.Lead_ScenId) AND gls.SubLink_CompID = gl.Lead_CompId AND gls.SubLink_SubCompID < 1 ) ORDER BY gi.input_current DESC LIMIT 0,1) AS max_value FROM GAME_USER_PERFORMANCE gp LEFT JOIN GAME_LEADERBOARD gl ON gp.Performance_GameId = gl.Lead_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 0 AND gl.Lead_Status = 0 AND gl.Lead_GameId =".$gameid." AND gp.Performance_Delete = 0 AND gp.Performance_UserId =".$userid." ORDER BY gp.Performance_CreatedOn";

// $performanceSql  = "SELECT gp.Performance_Id, gp.Performance_Value, gc.Comp_NameAlias, gc.Comp_Name, gp.Performance_CreatedOn FROM GAME_USER_PERFORMANCE gp LEFT JOIN GAME_LEADERBOARD gl ON gp.Performance_GameId = gl.Lead_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 0 AND gl.Lead_Status = 0 AND gl.Lead_GameId =".$gameid." AND gp.Performance_Delete = 0 AND gp.Performance_UserId =".$userid." ORDER BY gp.Performance_Id";

$performanceData       = $functionsObj->RunQueryFetchObject($performanceSql);
// echo $performanceSql."<br><pre>"; print_r($performanceData); exit();
$performanceGraphTitle = ($performanceData[0]->Comp_NameAlias)?$performanceData[0]->Comp_NameAlias:$performanceData[0]->Comp_Name;
// $overAllBenchmark      = $performanceData[0]->max_value;
// echo $performanceSql; exit();
include_once doc_root.'views/result.php';
