<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

$functionsObj = new Functions();

//$linkid=$_GET['Link'];
//$scenid=$_GET['Scenario'];
$userid = $_SESSION['userid'];
$gameid = $_GET['ID'];
//echo $userid."</br>";
//echo $gameid."</br>";
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
		//echo "US_LinkID = " . $result1->US_LinkID.
		//	" , US_GameID = " . $gameid. 
		//	" , US_ScenID = " . $result1->US_ScenID. 
		//	" , US_Input = ".$result1->US_Input.
		//	" , US_Output = ".$result1->US_Output.
		//	"</br>";
//exit();
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
							
				$link = $functionsObj->ExecuteQuery($sqllink);
				$resultlink = $functionsObj->FetchObject($link);				
				$linkid = $resultlink->Link_ID;
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
					header("Location:".site_root."input.php?Game=".$gameid);
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
						"US_GameID = " . $gameid,
						"US_ScenID = " . $result1->US_ScenID,
						"US_UserID = " . $userid
					);
					
					$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, '', '', '', '', 0 );
					if ($obj->num_rows > 0)
					{
						$status = $functionsObj->FetchObject($obj);
						$userstatusid = $status->US_ID;
						//exists
						$array = array (			
							'US_LinkID' => 1
						);
						$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
					}
				}
			}
		}
		else{
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
else{
	header("Location:".site_root."selectgame.php");
	exit();
}

$object = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_id='.$gameid), '', '', '', '', 0);
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

include_once doc_root.'views/result.php';


?>

				