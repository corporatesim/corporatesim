<?php
include_once '../../../config/settings.php';
require_once doc_root.'ux-admin/model/model.php';


$funObj = new Model(); // Create Object

// print_r($_POST);
// to get the subenterprise add with the Enterprise
if($_POST['action'] == 'Subenterprise')
{
	//print_r($_POST);
	$Enterprise_ID = $_POST['Enterprise_ID'];
	$sql           = "SELECT * FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gs.SubEnterprise_EnterpriseID WHERE gs.SubEnterprise_EnterpriseID=$Enterprise_ID";
	 //die($sql);
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		while($result = mysqli_fetch_object($Object))
		{
			$SubEnterpriseData[] = $result;
		}
		
		echo json_encode($SubEnterpriseData);
	}
	else
	{
		echo "no link";
	}

}

// to get the site user list via ajax
if($_POST['action'] == 'siteusers')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
		$colName = 'User_id';
		break;

		case 2:
		$colName = 'User_fname';
		break;

		case 4:
		$colName = 'User_email';
		break;

		case 7:
		$colName = 'User_datetime';
		break;
		
		default:
		$colName   = 'User_id';
		$direction = 'desc';
		break;
	}

	$siteusersSql = "SELECT  u.User_id, u.User_fname, u.User_lname, u.User_Role, u.User_email, u.User_mobile, u.User_datetime, u.User_status, u.User_gameStatus, ua.Auth_password as pwd, (SELECT count(*) FROM GAME_USERGAMES WHERE UG_UserID = u.User_id) as gamecount,ge.Enterprise_Name,gs.SubEnterprise_Name FROM `GAME_SITE_USERS` u INNER JOIN GAME_USER_AUTHENTICATION ua on u.User_id=ua.Auth_userid LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=u.User_ParentId LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_ID=u.User_SubParentId WHERE User_Delete = 0 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($siteusersSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$siteusersSql .= " AND (User_fname LIKE '%".$search."%' OR User_lname LIKE '%".$search."%' OR User_email LIKE '%".$search."%' OR Enterprise_Name LIKE '%".$search."%' OR SubEnterprise_Name LIKE '%".$search."%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($siteusersSql);
	$filterCount    = $filterCountObj->num_rows;

	$siteusersSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$userDataObj = $funObj->ExecuteQuery($siteusersSql);

	while($siteusersDataRow = mysqli_fetch_object($userDataObj))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		// for user type
		if($siteusersDataRow->User_Role == 2)
		{ 
			$type = "<code>SubEnterpriseUser</code><br><b>Ent-</b> ".$siteusersDataRow->Enterprise_Name."<br><b>SubEnt-</b> ".$siteusersDataRow->SubEnterprise_Name;
		} 
		elseif ($siteusersDataRow->User_Role == 1)
		{
			$type = "<code>EnterpriseUser</code><br><b>Ent-</b> ".$siteusersDataRow->Enterprise_Name;
		} 
		else
		{
			$type = "HumanLinks User";
		}

		$gamecount = "<a href='".site_root."ux-admin/addUserGame/edit/".base64_encode($siteusersDataRow->User_id)."'>".$siteusersDataRow->gamecount."</a> ";

		// for user status
		if($siteusersDataRow->User_status == 1)
		{
			$edit .= '<a href="javascript:void(0);" class="cs_btn" id="'.$siteusersDataRow->User_id.'" title="Active"><span class="fa fa-check"></span></a> ';
		}
		else
		{
			$edit .= '<a href="javascript:void(0);" class="cs_btn" id="'.$siteusersDataRow->User_id.'" title="Deactive"><span class="fa fa-times"></span></a> ';
		}

		$edit .= '<a href="'.site_root."ux-admin/siteusers/edit/".base64_encode($siteusersDataRow->User_id).'" title="Edit"><span class="fa fa-pencil"></span></a> <a href="javascript:void(0);" class="dl_btn" id="'.$siteusersDataRow->User_id.'" title="Delete"><span class="fa fa-trash"></span></a> ';

		// for user replay and blok games
		$statusSql = "SELECT Game_Name FROM GAME_USERSTATUS LEFT JOIN GAME_GAME ON Game_ID=US_GameID WHERE US_UserID=$siteusersDataRow->User_id AND US_ReplayStatus=1";

		$resObject = $funObj->ExecuteQuery($statusSql);
		$count     = $resObject->num_rows;
		if($resObject->num_rows > 0) { 
			$gameName = [];
			while($nameGame = $resObject->fetch_object())
			{
				$gameName[] = $nameGame->Game_Name;
			}
			if(count($gameName) > 1)
			{
				$userGames = implode(', ',$gameName);
				$title     = 'Replay allowed for '.$userGames.' games';
			}
			else
			{
				$userGames = $gameName[0];
				$title     = 'Replay allowed only for '.$userGames;
			}
			$edit .= '<a href="javascript:void(0)" data-toggle="tooltip" title="'.$title.'" id="replay_'.$siteusersDataRow->User_id.'"><span class="glyphicon glyphicon-refresh"></span></a> ';
		}

		if($siteusersDataRow->User_gameStatus == 1)
		{
			$edit .= '<a href="javascript:void(0)" title="Disabled" id="disable_'.$siteusersDataRow->User_id.'"><span class="glyphicon glyphicon-ban-circle"></span></a>';
		}

		$data[] = array($i, $siteusersDataRow->User_id, $siteusersDataRow->User_fname.' '.$siteusersDataRow->User_lname, $type, $siteusersDataRow->User_email, $siteusersDataRow->pwd, $siteusersDataRow->User_mobile, date('d-m-Y', strtotime($siteusersDataRow->User_datetime)), $gamecount, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);

}
