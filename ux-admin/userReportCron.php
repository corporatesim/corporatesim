<?php 
error_reporting(0);
require '../config/settings.php';
require '../config/functions.php';

// Create object
$functionsObj = new Functions();
$reqcheck     = "SELECT * FROM GAME_SITE_USER_REPORT_REQUEST WHERE status=1 order by id desc";
$reqdaat      = $functionsObj->ExecuteQuery($reqcheck);
$req          = $reqdaat->fetch_object();

if($reqdaat->num_rows > 0)
{
	$linkid = $req->linkid;
	////DeleteData
	$result = $functionsObj->DeleteDataCron('GAME_SITE_USER_REPORT','linkid',$linkid,0);
	
	
	$sql = "SELECT g.Game_Name,g.Game_ID, s.Scen_Name FROM `GAME_LINKAGE` 
	INNER JOIN GAME_GAME g on Link_GameID= g.Game_ID
	INNER JOIN GAME_SCENARIO s on Link_ScenarioID = s.Scen_ID
	WHERE Link_ID=".$linkid;
	
	$object       = $functionsObj->ExecuteQuery($sql);
	$result       = $object->fetch_object();

	$gameID       = $result->Game_ID;
	$gameName     = $result->Game_Name;
	$ScenarioName = $result->Scen_Name;
	$str          = '2018-07-20';
	$dateStr      = "AND DATE_FORMAT(User_datetime, '%Y-%m-%d') >= '$str' ";
	$sql          = "SELECT User_id, CONCAT(User_fname,' ', User_lname) AS fullname ,User_fname , User_lname, User_username FROM `GAME_SITE_USERS` WHERE User_games like '%$gameID%' $dateStr";

	$objlink = $functionsObj->ExecuteQuery($sql);
	if($objlink->num_rows > 0)
	{
		while($row= $objlink->fetch_object())
		{
			$userName  = $row->fullname;
			$sqlComp12 = "SELECT ls.SubLink_ID,  CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
			FROM `GAME_LINKAGE_SUB` ls 
			LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
			LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
			WHERE SubLink_LinkID=".$linkid ." 
			ORDER BY SubLink_ID";

			$objcomp12 = $functionsObj->ExecuteQuery($sqlComp12);

			while($rowinput = $objcomp12->fetch_object()){

				$title  = $rowinput->Comp_Subcomp;					
				$check  = $functionsObj->SelectData(array(), 'GAME_INPUT', array("input_user='".$row->User_id."' AND  input_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);

				$check1 = $functionsObj->SelectData(array(), 'GAME_OUTPUT', array("output_user='".$row->User_id."' AND  output_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);

				if($check->num_rows > 0)
				{
					$result = $functionsObj->FetchObject($check);
					$userdate [$title]= $result->input_current;

				}
				elseif($check1->num_rows > 0)
				{

					$result1           = $functionsObj->FetchObject($check1);
					$userdate [$title] = $result1->output_current;
				}
				else
				{
					$userdate [$title] = '';
				}
			}

			$userreportdetails = (object) array(
				'uid'            =>	$row->User_id,
				'linkid'         =>	$linkid,
				'user_name'      =>	$userName,
				'game_name'      =>	$gameName,
				'secenario_name' =>	$ScenarioName,
				'user_data'      =>	json_encode($userdate),
				'date_time'      =>	date('Y-m-d H:i:s')
			);

			$result = $functionsObj->InsertData('GAME_SITE_USER_REPORT', $userreportdetails);
		}
	}
	$status = (object) array(
		'status'	=>	2
	);	
	$result = $functionsObj->UpdateData('GAME_SITE_USER_REPORT_REQUEST', $status, 'id', $req->id, 0);
	
}

//print_r($userreportdetails);	
