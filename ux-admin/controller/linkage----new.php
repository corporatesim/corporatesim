<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$object = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename = $functionsObj->FetchObject($object);

$file='list.php';
// include PHPExcel

//echo $_POST['chkround'];
//exit();

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	//echo "in submit";	
	if(isset($_GET['link'])){
		$file='addeditlink.php';	
		$linkid = $_GET['link'];
		
		$where ="SubLink_LinkID=" . $linkid."
			AND SubLink_CompID=" . $_POST['comp_id'];
		if(isset($_POST['subcomp_id']) && !empty($_POST['subcomp_id']))
		{	
			$where .= " AND SubLink_SubCompID=" . $_POST['subcomp_id'];
		}
		else{
			$where .= " AND SubLink_SubCompID=0";
		}
			
		$object = $functionsObj->SelectData ( array (), 'GAME_LINKAGE_SUB', array ($where), 
		'', '', '', '', 0 );

		if ($object->num_rows > 0) {
			$msg = 'Entered Link already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else 
		{
			if($_POST['inputType']=='formula')
			{
				$object = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array('f_id='.$_POST['formula_id']), '', '', '', '', 0);
				$details = $functionsObj->FetchObject($object);
				$strexp = $details->expression;
				
				//echo $strexp;
				
				if(isset($_POST['subcomp_id']) && !empty($_POST['subcomp_id']))
				{	$strcheck = "subc_".$_POST['subcomp_id'];
				}
				else{
					$strcheck = "comp_".$_POST['comp_id'];
				}
				
				if (strpos($strexp,$strcheck))
				{
					$error ="Error_Formula";
					//exit with error message
					$msg = "Error: Recursive Link found in the selected Formula ";
					$type[0] = "inputError";
					$type[1] = "has-error";
					//exit();
				}
			}
		
			if($error =="Error_Formula")
			{
				$msg = "Error: Recursive Link found in the selected Formula ";
					$type[0] = "inputError";
					$type[1] = "has-error";
			}
			else{
				//exit();
				
				$chartdisplay	=  array('chartdisplay' =>$_POST['chart']);
				$charttype 		=  array('charttype' =>$_POST['chartType']);
				$chartname 		=  array('chartname' =>$_POST['choose_chart_name']);
				$chartaxis 		=  array('chartaxis' =>$_POST['axis_placement']);
				
				$charts = $chartdisplay + $charttype + $chartname + $chartaxis;
				$chartsDetails = array('charts' => $charts);
				
				
				$linkdetails = (object) array(
					'SubLink_LinkID'	=> $linkid,
					'SubLink_CompID'	=> $_POST['comp_id'],
					'SubLink_SubCompID'	=> isset($_POST['subcomp_id']) ? $_POST['subcomp_id'] : null,
					'SubLink_Charts'	=> json_encode($chartsDetails),
					'SubLink_Type'		=> isset($_POST['Type']) && $_POST['Type']=='input' ? 0 : 1,
					'SubLink_Order'		=> $_POST['order'],
					'SubLink_ShowHide'	=> $_POST['ShowHide'],
					'SubLink_FormulaID'	=> $_POST['inputType']=='formula' ? $_POST['formula_id']: null,
					'SubLink_AdminCurrent'	=> $_POST['inputType']=='admin' ? $_POST['current']: null,
					'SubLink_AdminLast'	=> $_POST['inputType']=='admin' ? $_POST['last']: null,
					'SubLink_InputMode'	=> $_POST['inputType'],
					'SubLink_LinkIDcarry'	=> $_POST['inputType']=='carry' ? $_POST['carry_linkid']: null,
					'SubLink_CompIDcarry'	=> $_POST['inputType']=='carry' ? $_POST['carry_compid']: null,
					'SubLink_SubCompIDcarry'	=> $_POST['inputType']=='carry' ? $_POST['carry_subcompid']: null,
					'SubLink_Condition'	=> $_POST['conditionformulaid'],
					'SubLink_Roundoff'	=> isset($_POST['chkround']) ? 1:0,
					'SubLink_Details'	=> $_POST['details'],
					'SubLink_Status'	=> 1,
					'SubLink_CreateDate'	=> date('Y-m-d H:i:s')
				);
			
				$result = $functionsObj->InsertData('GAME_LINKAGE_SUB', $linkdetails, 0, 0);
				if($result)
				{
					$id = $functionsObj->InsertID();
					
					//exit();
					//check if any value exist for replace
					if(isset($_POST['start1']) && isset($_POST['end1']) && isset($_POST['value1']))
					{
						//echo empty($_POST['replaceid1']);
						//exit();
						if(empty($_POST['replaceid1']))
						{
							//insert into Replace table
							$replacearray1 = (object) array(
								'Rep_Order'		=> 1,
								'Rep_SublinkID' => $id,
								'Rep_Start'		=> $_POST['start1'],
								'Rep_End'		=> $_POST['end1'],
								'Rep_Value'		=> $_POST['value1']
							);
							$replaceresult1 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray1, 0, 0);
						}
						else					
						{
							//update into Replace table
						}
						if(isset($_POST['start2']) && isset($_POST['end2']) && isset($_POST['value2']))
						{
							if(empty($_POST['replaceid2']))
							{
								//insert into Replace table
								$replacearray2 = (object) array(
									'Rep_Order'		=> 2,
									'Rep_SublinkID' => $id,
									'Rep_Start'		=> $_POST['start2'],
									'Rep_End'		=> $_POST['end2'],
									'Rep_Value'		=> $_POST['value2']
								);
								$replaceresult2 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray2, 0, 0);
							}
							else					
							{
								//update into Replace table
							}
							if(isset($_POST['start3']) && isset($_POST['end3']) && isset($_POST['value3']))
							{
								if(empty($_POST['replaceid3']))
								{
									//insert into Replace table
									$replacearray3 = (object) array(
										'Rep_Order'		=> 3,
										'Rep_SublinkID' => $id,
										'Rep_Start'		=> $_POST['start3'],
										'Rep_End'		=> $_POST['end3'],
										'Rep_Value'		=> $_POST['value3']
									);
									$replaceresult3 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray3, 0, 0);
								}
								else					
								{
									//update into Replace table
								}
							}
						}					
					}
					
					$_SESSION['msg'] = "Link created successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location: ".site_root."ux-admin/linkage/link/".$linkid);
					exit(0);
				}					
			}
		}
	}
	else
	{
		//exit();
		$linkdetails = (object) array(
				'Link_GameID'		=>	$_POST['game_id'],
				'Link_ScenarioID'		=>	$_POST['scen_id'],
				'Link_Hour'		=>	$_POST['hour'],
				'Link_Min'		=>	$_POST['minute'],
				'Link_Order'	=>	$_POST['order'],
				'Link_Mode'		=>	$_POST['Mode'],
				'Link_Enabled'	=>	isset($_POST['enabled']) ? 1 : 0,
				'Link_Status'	=>	1,			
				'Link_CreateDate'	=>	date('Y-m-d H:i:s')
		);		
		if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['order']) )
		{
				$result = $functionsObj->InsertData('GAME_LINKAGE', $linkdetails, 0, 0);
				if($result){
					$_SESSION['msg'] = "Link created successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location: ".site_root."ux-admin/linkage");
					exit(0);	
				}
		}	
		else{
			$msg = "Field(s) can not be empty";
			$type[0] = "inputError";
			$type[1] = "has-error";
			
		}
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){	

	if(isset($_GET['linkedit'])){		
		$file='addeditlink.php';	
		$sublinkid= $_GET['linkedit'];
		$linkid = $_POST['link'];
		//echo "Linkid => ".$linkid." , SubLinkid => ". $sublinkid;
		//exit();
		$where ="SubLink_LinkID=" . $linkid." AND SubLink_ID!= ".$sublinkid."
		 AND SubLink_CompID=" . $_POST['comp_id'];
		if(isset($_POST['subcomp_id']) && !empty($_POST['subcomp_id']))
		{	
			$where .= " AND SubLink_SubCompID=" . $_POST['subcomp_id'];
		}
		else{
			$where .= " AND SubLink_SubCompID=0";
		}
			
		$object = $functionsObj->SelectData ( array (), 'GAME_LINKAGE_SUB', array ($where), 
		'', '', '', '', 0 );
//exit();
		if ($object->num_rows > 0) {
			$msg = 'Entered Link already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else 
		{
			
			if($_POST['inputType']=='formula')
			{
				$object = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array('f_id='.$_POST['formula_id']), '', '', '', '', 0);
				$details = $functionsObj->FetchObject($object);
				$strexp = $details->expression;
				
				echo $strexp;
				
				if(isset($_POST['subcomp_id']) && !empty($_POST['subcomp_id']))
				{	$strcheck = "subc_".$_POST['subcomp_id'];
				}
				else{
					$strcheck = "comp_".$_POST['comp_id'];
				}
				
				if (strpos($strexp,$strcheck))
				{
					$error ="Error_Formula";
					//exit with error message
					$msg = "Error: Recursive Link found in the selected Formula ";
					$type[0] = "inputError";
					$type[1] = "has-error";
					//exit();
				}
			}
		
			if($error =="Error_Formula")
			{
				$msg = "Error: Recursive Link found in the selected Formula ";
					$type[0] = "inputError";
					$type[1] = "has-error";
			}
			else{
				
				$chartdisplay	=  array('chartdisplay' =>$_POST['chart']);
				$charttype 		=  array('charttype' =>$_POST['chartType']);
				$chartname 		=  array('chartname' =>$_POST['choose_chart_name']);
				$chartaxis 		=  array('chartaxis' =>$_POST['axis_placement']);
				
				$charts = $chartdisplay + $charttype + $chartname + $chartaxis;
				$chartsDetails = array('charts' => $charts);
				
				$linkdetails = (object) array(
					'SubLink_CompID'	=> $_POST['comp_id'],
					'SubLink_SubCompID'	=> isset($_POST['subcomp_id']) ? $_POST['subcomp_id'] : null,
					'SubLink_Charts'	=> json_encode($chartsDetails),
					'SubLink_Type'		=> isset($_POST['Type']) && $_POST['Type']=='input' ? 0 : 1,
					'SubLink_Order'		=> $_POST['order'],
					'SubLink_ShowHide'		=> $_POST['ShowHide'],
					'SubLink_FormulaID'	=> $_POST['inputType']=='formula' ? $_POST['formula_id']: null,
					'SubLink_AdminCurrent'	=> $_POST['inputType']=='admin' ? $_POST['current']: null,
					'SubLink_AdminLast'	=> $_POST['inputType']=='admin' ? $_POST['last']: null,
					'SubLink_InputMode'	=> $_POST['inputType'],
					'SubLink_LinkIDcarry'	=> $_POST['inputType']=='carry' ? $_POST['carry_linkid']: null,
					'SubLink_CompIDcarry'	=> $_POST['inputType']=='carry' ? $_POST['carry_compid']: null,
					'SubLink_SubCompIDcarry'	=> $_POST['inputType']=='carry' ? $_POST['carry_subcompid']: null,
					'SubLink_Condition'	=> $_POST['conditionformulaid'],
					'SubLink_Roundoff'	=> isset($_POST['chkround']) ? 1:0,
					'SubLink_Details'	=> $_POST['details']
				);
				
				
				//echo $sublinkid;
			
				$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_id='.$sublinkid), '', '', '', '', 0);
				$details = $functionsObj->FetchObject($object);
				
				$linkid=$details->SubLink_LinkID;
				//exit();
				$result = $functionsObj->UpdateData('GAME_LINKAGE_SUB', $linkdetails, 'SubLink_id', $sublinkid, 0);
				//exit();
				if($result === true){
					if(isset($_POST['start1']) && isset($_POST['end1']) && isset($_POST['value1']))
					{
						//echo empty($_POST['replaceid1']);
						//exit();
						if(empty($_POST['replaceid1']))
						{
							//insert into Replace table
							$replacearray1 = (object) array(
								'Rep_Order'		=> 1,
								'Rep_SublinkID' => $sublinkid,
								'Rep_Start'		=> $_POST['start1'],
								'Rep_End'		=> $_POST['end1'],
								'Rep_Value'		=> $_POST['value1']
							);
							$replaceresult1 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray1, 0, 0);
						}
						else					
						{
							//update into Replace table
							$replacearray1 = (object) array(							
								'Rep_Start'		=> $_POST['start1'],
								'Rep_End'		=> $_POST['end1'],
								'Rep_Value'		=> $_POST['value1']
							);

							$resrep1 = $functionsObj->UpdateData('GAME_LINK_REPLACE', $replacearray1, 'Rep_ID', $_POST['replaceid1'], 0);
						}
						if(isset($_POST['start2']) && isset($_POST['end2']) && isset($_POST['value2']))
						{
							if(empty($_POST['replaceid2']))
							{
								//insert into Replace table
								$replacearray2 = (object) array(
									'Rep_Order'		=> 2,
									'Rep_SublinkID' => $sublinkid,
									'Rep_Start'		=> $_POST['start2'],
									'Rep_End'		=> $_POST['end2'],
									'Rep_Value'		=> $_POST['value2']
								);
								$replaceresult2 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray2, 0, 0);
							}
							else					
							{
								//update into Replace table
								$replacearray2 = (object) array(							
									'Rep_Start'		=> $_POST['start2'],
									'Rep_End'		=> $_POST['end2'],
									'Rep_Value'		=> $_POST['value2']
								);

								$resrep2 = $functionsObj->UpdateData('GAME_LINK_REPLACE', $replacearray2, 'Rep_ID', $_POST['replaceid2'], 0);
								
							}
							if(isset($_POST['start3']) && isset($_POST['end3']) && isset($_POST['value3']))
							{
								if(empty($_POST['replaceid3']))
								{
									//insert into Replace table
									$replacearray3 = (object) array(
										'Rep_Order'		=> 3,
										'Rep_SublinkID' => $sublinkid,
										'Rep_Start'		=> $_POST['start3'],
										'Rep_End'		=> $_POST['end3'],
										'Rep_Value'		=> $_POST['value3']
									);
									$replaceresult3 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray3, 0, 0);
								}
								else					
								{
									//update into Replace table
									$replacearray3 = (object) array(							
										'Rep_Start'		=> $_POST['start3'],
										'Rep_End'		=> $_POST['end3'],
										'Rep_Value'		=> $_POST['value3']
									);

									$resrep3 = $functionsObj->UpdateData('GAME_LINK_REPLACE', $replacearray3, 'Rep_ID', $_POST['replaceid3'], 0);
									
								}
							}
							else
							{
								//else delete 3 if exist
								// $array3 = (object) array(
										// 'Rep_Order'		=> 3,
										// 'Rep_SublinkID' => $sublinkid
									// );
									
								// $object3 = $functionsObj->SelectData(array(), 'GAME_LINK_REPLACE', $array3, '', '', '', '', 0);
								// if($object3->num_rows>0)
								// {
									////delete
									// $details3 = $functionsObj->FetchObject($object3);
									// $result3 = $functionsObj->DeleteData('GAME_LINK_REPLACE','Rep_ID',$details3->Rep_ID,0);
								// }
							}
						}
						else{
							//else delete 2 and 3 if exist
						}
					}
					else{
						//else delete all if exist
					}
					$_SESSION['msg'] = "Link updated successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location: ".site_root."ux-admin/linkage/link/".$linkid);
					exit(0);
				}else{
					$msg = "Error: ".$result;
					$type[0] = "inputError";
					$type[1] = "has-error";
				}
			}
		}
	}
	else{
		$linkdetails = (object) array(
				'Link_GameID'		=>	$_POST['game_id'],
				'Link_ScenarioID'	=>	$_POST['scen_id'],
				'Link_Hour'		=>	$_POST['hour'],
				'Link_Min'		=>	$_POST['minute'],
				'Link_Order'	=>	$_POST['order'],
				'Link_Mode'		=>	$_POST['Mode'],
				'Link_Enabled'	=>	isset($_POST['enabled']) ? 1 : 0,
				'Link_Status'	=>	1,			
				'Link_CreateDate'	=>	date('Y-m-d H:i:s')
		);		

		echo $_POST['Mode'];
	//	exit();

		if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['order']) )
		{
			$linkid= $_GET['edit'];
			//echo $linkid;
			$result = $functionsObj->UpdateData('GAME_LINKAGE', $linkdetails, 'Link_id', $linkid, 0);
			//exit();
			if($result === true)
			{
				$_SESSION['msg'] = "Link updated successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				header("Location: ".site_root."ux-admin/linkage");
				exit(0);
			}else{
				$msg = "Error: ".$result;
				$type[0] = "inputError";
				$type[1] = "has-error";
			}
		}
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Download'){
	if (isset($_POST['Link_ID']))
	{
		$linkid = $_POST['Link_ID'];
	}
	 
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat = '#,#0.##;[Red]-#,#0.##';
	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Linkage');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Game');
	$objSheet->getCell('B1')->setValue('Area');
	$objSheet->getCell('C1')->setValue('Comp ID');
	$objSheet->getCell('D1')->setValue('Comp Name');
	$objSheet->getCell('E1')->setValue('SubComp ID');
	$objSheet->getCell('F1')->setValue('SubComp Name');
	$objSheet->getCell('G1')->setValue('Input Type');
	$objSheet->getCell('H1')->setValue('Additional Input');
	$objSheet->getCell('I1')->setValue('Status');
	$objSheet->getCell('J1')->setValue('Expression');
	$objSheet->getCell('K1')->setValue('Expression String');
	$objSheet->getCell('L1')->setValue('Type');

	$sql = "select a.Area_Name AS AreaName,c.Comp_ID AS CompID,c.Comp_Name AS CompName, s.SubComp_ID AS SubCompID,
			s.SubComp_Name AS SubCompName,ls.SubLink_InputMode AS InputMode,ls.SubLink_AdminCurrent AS Current,
			f.expression AS expression,f.expression_string AS expression_string, 
			CASE ls.SubLink_Type WHEN 0 THEN 'Input' WHEN 1 THEN 'Output' END AS Type, 
			CASE ls.SubLink_ShowHide WHEN 0 THEN 'Show' WHEN 1 THEN 'Hide' END AS ShowHide 
		from ((((GAME_LINKAGE_SUB ls left join GAME_COMPONENT c 
			on((ls.SubLink_CompID = c.Comp_ID))) left join GAME_SUBCOMPONENT s 
			on((ls.SubLink_SubCompID = s.SubComp_ID))) join GAME_AREA a 
			on((c.Comp_AreaID = a.Area_ID))) left join GAME_FORMULAS f 
			on((ls.SubLink_FormulaID = f.f_id))) 
		where (ls.SubLink_LinkID = ".$linkid.") 
		order by a.Area_ID,ls.SubLink_Order";	
		
	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row= $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			$objSheet->getCell('B'.$i)->setValue($row->AreaName);
			$objSheet->getCell('C'.$i)->setValue($row->CompID);
			$objSheet->getCell('D'.$i)->setValue($row->CompName);
			$objSheet->getCell('E'.$i)->setValue($row->SubCompID);
			$objSheet->getCell('F'.$i)->setValue($row->SubCompName);
			$objSheet->getCell('G'.$i)->setValue($row->InputMode);
			$objSheet->getCell('H'.$i)->setValue($row->Current);
			$objSheet->getCell('I'.$i)->setValue($row->ShowHide);
			$objSheet->getCell('J'.$i)->setValue($row->expression);
			$objSheet->getCell('K'.$i)->setValue($row->expression_string);
			$objSheet->getCell('L'.$i)->setValue($row->Type);
			$i++;
		}
	}
	
	//$objPHPExcel->
	
	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	
	$objSheet->getColumnDimension('C')->setWidth(10); 
	$objSheet->getColumnDimension('D')->setWidth(30); 
	$objSheet->getColumnDimension('E')->setWidth(10);
	$objSheet->getColumnDimension('F')->setWidth(30);	
	$objSheet->getColumnDimension('G')->setWidth(15);
	$objSheet->getColumnDimension('H')->setWidth(10);
	$objSheet->getColumnDimension('I')->setWidth(10);
	$objSheet->getColumnDimension('J')->setWidth(30);
	$objSheet->getColumnDimension('K')->setWidth(30);
	$objSheet->getColumnDimension('L')->setWidth(10);
	
	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('J1:J100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('K1:K100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="linkage.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'UserDownload'){
	if (isset($_POST['Link_ID']))
	{
		$linkid = $_POST['Link_ID'];
	}
		
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat = '#,#0.##;[Red]-#,#0.##';
	
	$objSheet = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Linkage');
	$objSheet->getStyle('A2:L2')->getFont()->setBold(true)->setSize(12);

	$sql ="SELECT g.Game_Name, s.Scen_Name FROM `GAME_LINKAGE` 
	INNER JOIN GAME_GAME g on Link_GameID= g.Game_ID
    INNER JOIN GAME_SCENARIO s on Link_ScenarioID = s.Scen_ID
	WHERE Link_ID=".$linkid;
	
	$object = $functionsObj->ExecuteQuery($sql);
	$result = $object->fetch_object();
	
	$objSheet->getCell('A1')->setValue($result->Game_Name);
	$objSheet->getCell('D1')->setValue($result->Scen_Name);
	$objSheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(16);
	
	$objSheet->getCell('A2')->setValue('Sr. No.');
	$objSheet->getCell('B2')->setValue('Name of User');
	//$objSheet->getCell('C2')->setValue('Status');
	
	// $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	// for($col = 3; $col < $highestColumnIndex; $col++)
    // {
		// $cell = $worksheet->getCellByColumnAndRow($col, $row);
            // $val = $cell->getValue();
	// }
	
	
	
				
		$sqlComp = "SELECT ls.SubLink_ID, CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
				FROM `GAME_LINKAGE_SUB` ls 
				LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
					LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
				WHERE SubLink_LinkID=".$linkid ." 
				ORDER BY SubLink_ID";
				
	$objcomp = $functionsObj->ExecuteQuery($sqlComp);	
	
	$letter = "C";
	
	if($objcomp->num_rows > 0){
		while($rowcomp = $objcomp->fetch_object()){			
			$s = $letter . '2';
			$first = $letter . '1';

			$objSheet->setCellValue($s, strip_tags($rowcomp->Comp_Subcomp));
			$objSheet->getColumnDimension($s)->setWidth(20);	

			$letter++;
		}
	}
	
	$objSheet->getStyle('A2:'.$letter.'2')->getFont()->setBold(true)->setSize(12);
	
	$sql = "SELECT User_id, CONCAT(User_fname,' ', User_lname) AS fullname ,User_fname , User_lname, User_username 
		FROM `GAME_SITE_USERS` order by User_id desc limit 1,10";
	
	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=3;
		while($row= $objlink->fetch_object()){
			$objSheet->getCell('A'.$i)->setValue($i-2);
			$objSheet->getCell('B'.$i)->setValue($row->fullname);
			//$objSheet->getCell('C'.$i)->setValue($row->User_id);
			
			
			
			$sqlComp12 = "SELECT ls.SubLink_ID 
				FROM `GAME_LINKAGE_SUB` ls 
				LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
					LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
				WHERE SubLink_LinkID=".$linkid ." 
				ORDER BY SubLink_ID";
				
		$objcomp12 = $functionsObj->ExecuteQuery($sqlComp12);
			
			$letter = "C";
			
			while($rowinput = $objcomp12->fetch_object()){
				
				$s = $letter . $i;
				
				$check = $functionsObj->SelectData(array(), 'GAME_INPUT', array("input_user='".$row->User_id."' AND  input_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);
				$check1 = $functionsObj->SelectData(array(), 'GAME_OUTPUT', array("output_user='".$row->User_id."' AND  output_sublinkid='".$rowinput->SubLink_ID."'"), '', '', '', '', 0);
				if($check->num_rows > 0){
					$result = $functionsObj->FetchObject($check);
					$objSheet->setCellValue($s, $result->input_current);
					
				}elseif($check1->num_rows > 0){
					
					$result1 = $functionsObj->FetchObject($check1);
					$objSheet->setCellValue($s, $result1->output_current);
				}
				else
				{
					$objSheet->setCellValue($s, 0);
				}
				
				
				
				//$objSheet->setCellValue($s, $rowinput->Current);	
				//$objSheet->getColumnDimension($s)->setWidth(20);	
				$objSheet->getColumnDimension($letter)->setAutoSize(true);
				$letter++;
			}
						
				
			$i++;
		}
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	

	//exit();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="UserData.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');

}

// Edit Siteuser
if(isset($_GET['edit'])){
	$header = 'Edit Links';
	$uid = $_GET['edit'];

	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ID='.$uid), '', '', '', '', 0);
	$linkdetails = $functionsObj->FetchObject($object);
	$url = site_root."ux-admin/linkage";
	$file = 'addedit.php';
}elseif(isset($_GET['add'])){
	// Add Siteuser
	$header = 'Add Links';
	$url = site_root."ux-admin/linkage";
	
	$file = 'addedit.php';
}elseif(isset($_GET['del'])){
	// Delete Siteuser
	$id = base64_decode($_GET['del']);
	echo $id;
	//exit();
	$result = $functionsObj->DeleteData('GAME_LINKAGE','Link_ID',$id,0);

		$_SESSION['msg'] = "Link deleted successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/linkage");
		exit(0);

}elseif(isset($_GET['stat'])){
	// Enable disable siteuser account
	$id = base64_decode($_GET['stat']);
	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ID='.$id), '', '', '', '', 0);
	$details = $functionsObj->FetchObject($object);
	
	if($details->Link_Status == 1){
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE', array('Link_Status'=> 0), 'Link_ID', $id, 0);
	}else{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE', array('Link_Status'=> 1), 'Link_ID', $id, 0);
	}
	if($result === true){
		$_SESSION['msg'] = "Link ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/linkage");
		exit(0);
	}else{
		$msg = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}elseif(isset($_GET['link'])){
	$header = 'Add Links';
	$file='addeditlink.php';
	
	$linkid = $_GET['link'];
	$where= 'Link_ID='.$linkid;
	$url = site_root."ux-admin/linkage";	
	
	$sql="SELECT
			  L.*,
			  (SELECT `Game_Name`  FROM  GAME_GAME WHERE  `Game_ID` = L.Link_GameID) as Game,
			  (SELECT `Scen_Name`  FROM  GAME_SCENARIO WHERE  `Scen_ID` = L.`Link_ScenarioID`) as Scenario
			FROM
			  `GAME_LINKAGE`as L
			WHERE
				L.Link_ID=".$linkid;
	//echo $sql."</br>";
	$object = $functionsObj->ExecuteQuery($sql);
	$result = $functionsObj->FetchObject($object);

	$sqlscen = "SELECT Link_ID, Scen_ID , Scen_Name 
				FROM `GAME_LINKAGE` INNER JOIN GAME_SCENARIO s on s.Scen_ID = Link_ScenarioID 
				WHERE Link_GameID = ".$result->Link_GameID." and Link_ID in (SELECT Sublink_LinkID FROM GAME_LINKAGE_SUB) 
				AND Link_ScenarioID!=".$result->Link_ScenarioID;
					
	//echo $sqlscen;
	$linkscenario = $functionsObj->ExecuteQuery($sqlscen);
	// while($row = $scenario->fetch_object()){
	// echo $row->Scen_Name;
	// }	
	// exit();
	$linksql = "SELECT  L.*,LS.*,
					(SELECT `Game_Name` FROM GAME_GAME  WHERE `Game_ID` = L.Link_GameID) AS Game,
					(SELECT `Scen_Name` FROM GAME_SCENARIO WHERE `Scen_ID` = L.`Link_ScenarioID`) AS Scenario,
					(SELECT `Comp_Name` FROM GAME_COMPONENT WHERE `Comp_ID` = LS.SubLink_CompID) AS Component,
					(SELECT `SubComp_Name` FROM GAME_SUBCOMPONENT WHERE `SubComp_ID` = LS.SubLink_SubCompID) AS SubComponent
				FROM
					`GAME_LINKAGE` L INNER JOIN GAME_LINKAGE_SUB LS 
				ON L.`Link_ID` = LS.SubLink_LinkID
				WHERE
					`SubLink_LinkID`= ".$linkid;
	//echo $linksql;
	$object1 = $functionsObj->ExecuteQuery($linksql);
	
	$sqlcarry = "SELECT l.Link_ID, s.Scen_ID,s.Scen_Name
				FROM `GAME_LINKAGE` l INNER JOIN GAME_SCENARIO s on l.Link_ScenarioID=s.Scen_ID
				WHERE Link_GameID=".$result->Link_GameID." AND Link_Order < 
					(SELECT Link_Order FROM GAME_LINKAGE WHERE Link_ID = ".$linkid.")";
//echo $sqlcarry;
	$objcarry = $functionsObj->ExecuteQuery($sqlcarry);
	
}elseif(isset($_GET['linkedit'])){
	$header = 'Add Links';
	$file='addeditlink.php';
	
	$linkid = $_GET['linkedit'];
	
	$sql ="SELECT LS.*
		FROM GAME_LINKAGE_SUB as LS WHERE SubLink_ID=".$linkid;
	$object2 = $functionsObj->ExecuteQuery($sql);
	//echo $sql;
	if($object2->num_rows>0)
	{
		$linkdetails = $functionsObj->FetchObject($object2);
		//echo "Check RO ".$linkdetails->SubLink_Roundoff;
		$id = $linkdetails->SubLink_LinkID;
		
	}	
	
	$sqlreplace1 = "SELECT * FROM `GAME_LINK_REPLACE`
					WHERE Rep_Order = 1 AND Rep_SublinkID=".$linkid;
	$objreplace1 = $functionsObj->ExecuteQuery($sqlreplace1);
	//echo $sql;
	if($objreplace1->num_rows>0)
	{
		$linkreplace1 = $functionsObj->FetchObject($objreplace1);
	}

	$sqlreplace2 = "SELECT * FROM `GAME_LINK_REPLACE`
					WHERE Rep_Order = 2 AND Rep_SublinkID=".$linkid;
	$objreplace2 = $functionsObj->ExecuteQuery($sqlreplace2);
	//echo $sql;
	if($objreplace2->num_rows>0)
	{
		$linkreplace2 = $functionsObj->FetchObject($objreplace2);
	}
	
	$sqlreplace3 = "SELECT * FROM `GAME_LINK_REPLACE`
					WHERE Rep_Order = 3 AND Rep_SublinkID=".$linkid;
	$objreplace3 = $functionsObj->ExecuteQuery($sqlreplace3);
	//echo $sql;
	if($objreplace3->num_rows>0)
	{
		$linkreplace3 = $functionsObj->FetchObject($objreplace3);
	}
	
					
	$url = site_root."ux-admin/linkage/link/".$id;		
	$linksql = "SELECT  L.*,LS.*,
					(SELECT `Game_Name` FROM GAME_GAME  WHERE `Game_ID` = L.Link_GameID) AS Game,
					(SELECT `Scen_Name` FROM GAME_SCENARIO WHERE `Scen_ID` = L.`Link_ScenarioID`) AS Scenario,
					(SELECT `Comp_Name` FROM GAME_COMPONENT WHERE `Comp_ID` = LS.SubLink_CompID) AS Component,
					(SELECT `SubComp_Name` FROM GAME_SUBCOMPONENT WHERE `SubComp_ID` = LS.SubLink_SubCompID) AS SubComponent
				FROM
					`GAME_LINKAGE` L INNER JOIN GAME_LINKAGE_SUB LS 
				ON L.`Link_ID` = LS.SubLink_LinkID
				WHERE
					`SubLink_LinkID`= ".$id;
	//echo $linksql;
	$object1 = $functionsObj->ExecuteQuery($linksql);
	$object = $functionsObj->ExecuteQuery($linksql);
	$result = $functionsObj->FetchObject($object);
	$sqlcarry = "SELECT l.Link_ID, s.Scen_ID,s.Scen_Name
				FROM `GAME_LINKAGE` l INNER JOIN GAME_SCENARIO s on l.Link_ScenarioID=s.Scen_ID
				WHERE Link_GameID=".$result->Link_GameID." AND Link_Order < 
					(SELECT Link_Order FROM GAME_LINKAGE WHERE Link_ID = ".$id.")";

	$objcarry = $functionsObj->ExecuteQuery($sqlcarry);

}elseif(isset($_GET['linkdel'])){
	// Delete Siteuser
	$linkid = base64_decode($_GET['linkdel']);
	$sql = "SELECT LS.*	FROM GAME_LINKAGE_SUB as LS WHERE SubLink_ID=".$linkid;
	
	$object2 = $functionsObj->ExecuteQuery($sql);
	//echo $linksql;
	if($object2->num_rows>0)
	{
		$linkdetails = $functionsObj->FetchObject($object2);
		$id = $linkdetails->SubLink_LinkID;
	}	
	
	//exit();
	$result = $functionsObj->DeleteData('GAME_LINKAGE_SUB','SubLink_ID',$linkid,0);

		$_SESSION['msg'] = "Link deleted successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/linkage/link/".$id);
		exit(0);

}elseif(isset($_GET['linkstat'])){
	// Enable disable siteuser account
	$linkid = base64_decode($_GET['linkstat']);
	$sql = "SELECT LS.*	FROM GAME_LINKAGE_SUB as LS WHERE SubLink_ID=".$linkid;
	
	$object2 = $functionsObj->ExecuteQuery($sql);
	//echo $linksql;
	if($object2->num_rows>0)
	{
		$linkdetails = $functionsObj->FetchObject($object2);
		$id = $linkdetails->SubLink_LinkID;
	}	
	
	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_ID='.$linkid), '', '', '', '', 0);
	$details = $functionsObj->FetchObject($object);
	
	if($details->SubLink_Status == 1){
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE_SUB', array('SubLink_Status'=> 0), 'SubLink_ID', $linkid, 0);
	}else{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE_SUB', array('SubLink_Status'=> 1), 'SubLink_ID', $linkid, 0);
	}
	if($result === true){
		$_SESSION['msg'] = "Link ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/linkage/link/".$id);
		exit(0);
	}else{
		$msg = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}else{
	// fetch siteuser list from db
	$sql="SELECT
			  L.*,
			  (SELECT `Game_Name`  FROM  GAME_GAME WHERE  `Game_ID` = L.Link_GameID) as Game,
			  (SELECT `Scen_Name`  FROM  GAME_SCENARIO WHERE  `Scen_ID` = L.`Link_ScenarioID`) as Scenario
			FROM
			  `GAME_LINKAGE`as L";
	$object = $functionsObj->ExecuteQuery($sql);
	$file = 'list.php';
}


// Fetch Services list


$game = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);

$scenario = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), '', '', '', '', 0);

$component = $functionsObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_Delete=0'), 'Comp_Name', '', '', '', 0);

$subcomponent = $functionsObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_Delete=0'), 'SubComp_Name', '', '', '', 0);

$formula = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array(), 'formula_title', '', '', '', 0);

include_once doc_root.'ux-admin/view/Linkage/'.$file;