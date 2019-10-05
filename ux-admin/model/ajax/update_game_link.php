<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';

$funObj = new Functions();

if(isset($_POST['Link_id']) && isset($_POST['Game_id']) && isset($_POST['Scen_id']) )
{
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
				$result = array(
					"msg"    => "Success",
					"status" => 1
				);
			}
			else{
				$result = array(
					"msg"    => "Error",
					"status" => 0
				);				
			}
		}
	}
	
	$result = array(
		"msg"    => "Success",
		"status" => 1
	);
	
	//echo $_POST['Scen_id'];
	echo json_encode($result);
}
?>