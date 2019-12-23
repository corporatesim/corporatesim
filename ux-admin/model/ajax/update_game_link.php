<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';

$funObj = new Functions();

if(isset($_POST['Link_id']) && isset($_POST['Game_id']) && isset($_POST['Scen_id']) )
{
	$count = 0;
	//echo $_POST['Scen_id'];
	
	$sql = "SELECT * FROM `GAME_LINKAGE_SUB` WHERE Sublink_linkid in 
	(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID= ".$_POST['Game_id']." and Link_ScenarioID=".$_POST['Scen_id'].")";
	//echo $sql; exit();
	$object = $funObj->ExecuteQuery($sql);
	//	$result1 = $functionsObj->FetchObject($object);
	
	while($row = $object->fetch_object())
	{
		$object1 = $funObj->SelectData ( array (), 'GAME_LINKAGE_SUB', array (
			'SubLink_LinkID=' . $_POST['Link_id'],
			'SubLink_CompID=' . $row->SubLink_CompID,
			'SubLink_SubCompID=' . $row->SubLink_SubCompID
		), '', '', '', '', 0 );
		
		if ($object1->num_rows > 0) 
		{
			//nothing to do
		}
		else
		{
			$count++;
			$linkdetails = (object) array(
				'SubLink_LinkID'             => $_POST['Link_id'],
				'SubLink_AreaID'             => $row->SubLink_AreaID,
				'SubLink_AreaName'           => $row->SubLink_AreaName,
				'SubLink_CompID'             => $row->SubLink_CompID,
				'SubLink_CompName'           => $row->SubLink_CompName,
				'SubLink_SubCompID'          => $row->SubLink_SubCompID,
				'SubLink_SubcompName'        => $row->SubLink_SubcompName,
				'SubLink_LinkIDcarry'        => $row->SubLink_LinkIDcarry,
				'SubLink_CompIDcarry'        => $row->SubLink_CompIDcarry,
				'SubLink_SubCompIDcarry'     => $row->SubLink_SubCompIDcarry,
				'SubLink_Roundoff'           => $row->SubLink_Roundoff,
				'SubLink_Order'              => $row->SubLink_Order,
				'SubLink_ShowHide'           => $row->SubLink_ShowHide,
				'SubLink_Charts'             => $row->SubLink_Charts,
				'SubLink_Type'               => $row->SubLink_Type,			
				'SubLink_FormulaID'          => $row->SubLink_FormulaID,
				'SubLink_FormulaExpression'  => $row->SubLink_FormulaExpression,
				'SubLink_AdminCurrent'       => $row->SubLink_AdminCurrent,
				'SubLink_AdminLast'          => $row->SubLink_AdminLast,
				'SubLink_User'               => $row->SubLink_User,
				'SubLink_InputMode'          => $row->SubLink_InputMode,
				'SubLink_InputModeType'      => $row->SubLink_InputModeType,
				'SubLink_InputModeTypeValue' => $row->SubLink_InputModeTypeValue,
				'SubLink_Condition'          => $row->SubLink_Condition,
				'SubLink_ChartID'            => $row->SubLink_ChartID,
				'SubLink_ChartType'          => $row->SubLink_ChartType,
				'SubLink_Details'            => $row->SubLink_Details,
				'SubLink_BackgroundColor'    => $row->SubLink_BackgroundColor,
				'SubLink_TextColor'          => $row->SubLink_TextColor,
				'SubLink_ViewingOrder'       => $row->SubLink_ViewingOrder,
				'SubLink_LabelCurrent'       => $row->SubLink_LabelCurrent,
				'SubLink_LabelLast'          => $row->SubLink_LabelLast,
				'SubLink_FontStyle'          => $row->SubLink_FontStyle,
				'SubLink_FontSize'           => $row->SubLink_FontSize,
				'SubLink_InputFieldOrder'    => $row->SubLink_InputFieldOrder,
				'SubLink_CreateDate'         => date('Y-m-d H:i:s'),
				'SubLink_Status'             => 1,
			);
			
			$result = $funObj->InsertData('GAME_LINKAGE_SUB', $linkdetails, 0, 0);
			if($result)
			{	
				$sublinkid  = $funObj->InsertID();
				$sqlreplace = "SELECT * FROM `GAME_LINK_REPLACE` WHERE Rep_SublinkID = ".$row->SubLink_ID;
				$objreplace = $funObj->ExecuteQuery($sqlreplace);
				
				while($rowrep = $objreplace->fetch_object())
				{
					$repdetails = (object) array(
						'Rep_Order'     => $rowrep->Rep_Order,
						'Rep_SublinkID' => $sublinkid,
						'Rep_Start'     => $rowrep->Rep_Start,
						'Rep_End'       => $rowrep->Rep_End,
						'Rep_Value'     => $rowrep->Rep_Value
					);
					
					$resultrep = $funObj->InsertData('GAME_LINK_REPLACE', $repdetails, 0, 0);
					
				}
				// adding area sequencing from GAME_AREA_SEQUENCE table
				$SequenceOrderSql = "SELECT Sequence_Order FROM GAME_AREA_SEQUENCE WHERE Sequence_LinkId =".$row->SubLink_LinkID." AND Sequence_AreaId=".$row->SubLink_AreaID;
				$Sequence_Order   = $funObj->RunQueryFetchObject($SequenceOrderSql);
				$funObj->AreaSequencing($_POST['Link_id'], $row->SubLink_AreaID, $Sequence_Order[0]->Sequence_Order);
				// $insertRowSql = "INSERT INTO GAME_AREA_SEQUENCE (Sequence_LinkId,Sequence_AreaId,Sequence_Order,Sequence_CreatedBy) SELECT ".$_POST['Link_id'].", Sequence_AreaId, Sequence_Order, ".$_SESSION['ux-admin-id']." FROM GAME_AREA_SEQUENCE WHERE Sequence_LinkId =".$row->SubLink_LinkID." AND Sequence_AreaId=".$row->SubLink_AreaID;
				 // VALUES ($linkid,$areaId,$Sequence_Order,".$_SESSION['ux-admin-id'].")";

				$result = array(
					"msg"    => "$count Success",
					"status" => 1
				);
			}
			else
			{
				$result = array(
					"msg"    => "Error",
					"status" => 0
				);				
			}
		}
	}
	
	$result = array(
		"msg"    => "$count rows added successfully",
		"status" => 1
	);
	
	//echo $_POST['Scen_id'];
	echo json_encode($result);
}

// to change the game status, from complete to in-progress or in-progress to complete
if(isset($_POST['Game_Complete']) && $_POST['Game_Complete']=='updateStatus')
{
	// print_r($_POST); exit();
	$status = $funObj->UpdateData("GAME_GAME",array('Game_Complete' => $_POST['gameStatus'], 'Game_UpdatedBy' => $_SESSION['ux-admin-id'], 'Game_UpdatedOn' => date('Y-m-d H:i:s')),'Game_ID',$_POST['Game_ID'],0);
	if($status)
	{
		die(json_encode(["status" => "200","message" => 'Game status has been changed.']));
	}
	else
	{
		die(json_encode(["status" => "201","message" => 'Some error occured, Please try later.']));
	}
}

// to get the game comments/messages
if(isset($_POST['game_comments']) && $_POST['game_comments']=='game_comments')
{
	// print_r($_POST); exit();
	$gameid       = base64_decode($_POST['gameid']);
	$userid       = $_POST['userid'];
	$commentSql   = "SELECT * FROM GAME_COMMENT_USER WHERE Comment_Delete=0 AND Comment_GameId=".$gameid;
	$gameComments = $funObj->RunQueryFetchObject($commentSql);
	// echo gettype($gameComments); exit();
	if(count($gameComments) > 0)
	{
		// print_r($gameComments);
		$message = '<table>';
		foreach ($gameComments as $gameCommentsRow)
		{
			// $gameCommentsRow->Comment_UpdatedOn;			$gameCommentsRow->Comment_CreatedOn;
			if($gameCommentsRow->Comment_UpdatedOn)
			{
				$title = "Created On: ".date('d-m-Y H:i:s',strtotime($gameCommentsRow->Comment_CreatedOn))." And Updated On: ".date('d-m-Y H:i:s',strtotime($gameCommentsRow->Comment_UpdatedOn));
			}
			else
			{
				$title = "Created On: ".date('d-m-Y H:i:s',strtotime($gameCommentsRow->Comment_CreatedOn));
			}

			$message .= '<tr class="textMessageRow" data-toggle="tooltip" title="'.$title.'"><td class="textMessage">'.$gameCommentsRow->Comment_Message.'</td> <td style="cursor:pointer; display:none;" class="actionIcon" data-creator="'.$gameCommentsRow->Comment_CreatedBy.'"> <a data-toggle="tooltip" title="Edit Comment" href="javascript:void(0);" class="editComment" data-modify="edit" data-gameid="'.$gameCommentsRow->Comment_GameId.'" data-commentid="'.$gameCommentsRow->Comment_Id.'"><i class="fa fa-pencil"></i></a> <a data-toggle="tooltip" title="Delete Comment" href="javascript:void(0);" class="deleteComment" data-modify="delete" data-gameid="'.$gameCommentsRow->Comment_GameId.'" data-commentid="'.$gameCommentsRow->Comment_Id.'"><i class="fa fa-trash"></i></a></td></tr>';
		}
		$message .= '</table>';
	}
	else
	{
		$message = "No comments for the current game.";
	}
	// echo $gameid.' and '.$userid;die();
	// $status = $funObj->UpdateData("GAME_GAME",array('Game_Complete' => $_POST['gameStatus'], 'Game_UpdatedBy' => $_SESSION['ux-admin-id'], 'Game_UpdatedOn' => date('Y-m-d H:i:s')),'Game_ID',$_POST['Game_ID'],0);
	if(gettype($gameComments) == 'array')
	{
		die(json_encode(["status" => "200", "message" => $message ]));
	}
	else
	{
		die(json_encode(["status" => "201", "message" => 'Some error occured, Please try later.']));
	}
}

if(isset($_POST['addComment']) && $_POST['addComment']=='addComment')
{
	// print_r($_POST);
	$Comment_Message  = ($_POST['Comment_Message'])?'<b>'.$_SESSION['admin_fname'].' '.$_SESSION['admin_lname'].':-</b> '.$_POST['Comment_Message']:'';
	$Comment_GameId   = ($_POST['Comment_GameId'])?$_POST['Comment_GameId']:'';
	$Comment_Id       = ($_POST['Comment_Id'])?$_POST['Comment_Id']:'';
	$modificationType = ($_POST['modificationType'])?$_POST['modificationType']:'';
	$notificationTo   = ($_POST['notificationTo'])?$_POST['notificationTo']:'';
	$gamename         = ($_POST['gamename'])?$_POST['gamename']:'';

	if($Comment_Id)
	{
		if($modificationType == 'edit')
		{
			// edit existing comment
			$editObj = $funObj->UpdateData("GAME_COMMENT_USER",array('Comment_Message' => $Comment_Message, 'Comment_UpdatedBy' => $_SESSION['ux-admin-id'], 'Comment_UpdatedOn' => date('Y-m-d H:i:s')),'Comment_Id',$Comment_Id,0);

			if($editObj)
			{
				sendNotification($notificationTo,base64_decode($Comment_GameId),$gamename,'updated');
				die(json_encode(["status" => "200", "message" => 'Comment edited successfully to the game.']));
			}
			else
			{
				die(json_encode(["status" => "201", "message" => 'Error with database, while editing comments to the game.']));
			}
		}

		elseif($modificationType == 'delete')
		{
			// delete the existing comment
			$deleteObj = $funObj->UpdateData("GAME_COMMENT_USER",array('Comment_Delete ' => 1, 'Comment_UpdatedBy' => $_SESSION['ux-admin-id'], 'Comment_UpdatedOn' => date('Y-m-d H:i:s')),'Comment_Id',$Comment_Id,0);
			if($deleteObj)
			{
				die(json_encode(["status" => "200", "message" => 'Comment deleted successfully to the game.']));
			}
			else
			{
				die(json_encode(["status" => "201", "message" => 'Error with database, while deleting comments to the game.']));
			}
		}
		else
		{
			// show error message, to specify the modification type
			die(json_encode(["status" => "201", "message" => 'Unable to undestand that you want to edit or delete.']));
		}
	}
	else
	{
		// add record to database
		$insertArr = (object) array(
			'Comment_GameId'    => base64_decode($Comment_GameId),
			'Comment_Message'   => $Comment_Message,
			'Comment_CreatedBy' => $_SESSION['ux-admin-id'],
		);
		$addObj = $funObj->InsertData('GAME_COMMENT_USER', $insertArr, 0, 0);
		if($addObj)
		{
			sendNotification($notificationTo,base64_decode($Comment_GameId),$gamename,'added');
			die(json_encode(["status" => "200", "message" => 'Comment added successfully to the game']));
		}
		else
		{
			die(json_encode(["status" => "201", "message" => 'Error with database, while adding comments to the game.']));
		}
	}
}

if(isset($_POST['notificationUpdate']) && $_POST['notificationUpdate']=='notificationUpdate')
{
	// print_r($_POST); Notification_Delete Notification_Seen
	$modify = $_POST['modify'];
	switch($modify)
	{
		case 'seen':
		$updateCol = 'Notification_Seen';
		$retMsg    = "Marked as seen.";
		break;

		case 'delete':
		$updateCol = 'Notification_Delete';
		$retMsg    = "Deleted.";
		break;
	}
	$Notification_Id = $_POST['Notification_Id'];
	$updtaeObj       = $funObj->UpdateData("GAME_NOTIFICATION",array($updateCol => 1, 'Notification_UpdatedOn' => date('Y-m-d H:i:s')),'Notification_Id',$Notification_Id,0);
	if($updtaeObj)
	{
		die(json_encode(["status" => "200", "message" => 'Successfully '.$retMsg]));
	}
	else
	{
		die(json_encode(["status" => "201", "message" => 'Error with database, while updating notifications.']));
	}
}

if(isset($_POST['branchingStatus']) && $_POST['branchingStatus']=='branchingStatus')
{
	// print_r($_POST); exit();
	$Game_ID = $_POST['Game_ID'];
	// check that game has multiple scenario and scenario branching done or not
	$scenSql = "SELECT gg.Game_Name, gcs.Scen_Name, gc.Comp_Name, gbs.Branch_MinVal AS minval, gbs.Branch_MaxVal AS maxval, gbs.Branch_Order AS ordering, gns.Scen_Name AS NextSceneName, gbs.Branch_IsEndScenario AS endScenario FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gcs ON gcs.Scen_ID = gl.Link_ScenarioID LEFT JOIN GAME_BRANCHING_SCENARIO gbs ON gbs.Branch_ScenId = gl.Link_ScenarioID AND gbs.Branch_IsActive = 0 LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gbs.Branch_ScenId LEFT JOIN GAME_SCENARIO gns ON gns.Scen_ID = gbs.Branch_NextScen LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gbs.Branch_CompId WHERE gl.Link_GameID =".$Game_ID." ORDER BY gcs.Scen_Name, gbs.Branch_Order ASC";
	$scenData = $funObj->RunQueryFetchObject($scenSql);
	// print_r($scenData);
	if(count($scenData) > 2)
	{
		$returnBranchingData = "<table class='table table-striped table-bordered table-hover'><thead><th>Scenario Name</th> <th>Component Name</th> <th>Min Value</th>  <th>Max Value</th> <th>Order</th> <th>Next Scenario Name</th> <th>End Scenario</th></thead><tbody>";
		$gameNameFlag = TRUE;

		foreach ($scenData as $scenDataRow)
		{
			if($gameNameFlag)
			{
				$gamename = $scenDataRow->Game_Name;
			}
			$gameNameFlag = FALSE;

			$endScen = ($scenDataRow->endScenario > 0)?'<span class="alert-danger">End Scenario</span>':(($scenDataRow->endScenario === NULL)?'<span class="alert-success">Linear</span>':'Not End Scenario');
			$returnBranchingData .= "<tr><td>".$scenDataRow->Scen_Name."</td> <td>".$scenDataRow->Comp_Name."</td> <td>".$scenDataRow->minval."</td> <td>".$scenDataRow->maxval."</td> <td>".$scenDataRow->ordering."</td> <td>".$scenDataRow->NextSceneName."</td> <td>".$endScen."</td> </tr>";
		}

		$returnBranchingData .= "</tbody></table>";

		die(json_encode(["status" => "200", "message" => $returnBranchingData, 'gamename' => $gamename]));
	}
	else
	{
		die(json_encode(["status" => "201", "message" => 'No branching exist for the selected game.']));
	}
}


// add custom functions here
function sendNotification($notificationTo=NULL,$gameid=NULL,$gamename=NULL,$modificationType=NULL)
{
	$funObj = new Functions();
	if(isset($notificationTo) && !empty($notificationTo))
	{
		$notificationTo   = explode(',',$notificationTo);
		$notificationTo[] = 1;
		$notificationTo   = array_unique($notificationTo);
		if(count($notificationTo) > 0)
		{
			for($i=0; $i<count($notificationTo); $i++)
			{
				if($notificationTo[$i] == $_SESSION['ux-admin-id'])
				{
					// don't send the notification to current logged in user
					continue;
				}
				$msg = '<b>'.$_SESSION['admin_fname'].' '.$_SESSION['admin_lname'].'</b> has '.$modificationType.' comment for <b>'.$gamename.'</b>';
				$notifyInsertArr = (object) array(
					'Notification_From'    => $_SESSION['ux-admin-id'],
					'Notification_To'      => $notificationTo[$i],
					'Notification_Message' => $msg,
				);
				$addNotificationObj = $funObj->InsertData('GAME_NOTIFICATION', $notifyInsertArr, 0, 0);
			}
		}
	}
}


?>