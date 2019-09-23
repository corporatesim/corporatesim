<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');
$noSelect2    = 'dont';
$functionsObj = new Model();

$object   = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename = $functionsObj->FetchObject($object);
$file     = 'list.php';
// include PHPExcel

//echo $_POST['chkround'];
//exit();

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	// echo "<pre>"; print_r($_POST); exit();
	if(!isset($_GET['tab']))
	{
		if(isset($_POST['game_id']) && !empty($_POST['game_id']))
		{
			$id_game = $_POST['game_id'];
		}
		else
		{
			$findGameId = "SELECT * FROM GAME_LINKAGE WHERE Link_ID=".$_POST['link'];
			$exeSql     = $functionsObj->ExecuteQuery($findGameId);
			$gamedetail = $functionsObj->FetchObject($exeSql);
			$id_game    = $gamedetail->Link_GameID;
		}
		$statusCheckSql        = "SELECT * FROM GAME_GAME WHERE Game_ID=".$id_game;
		$runSql                = $functionsObj->ExecuteQuery($statusCheckSql);
		$gameSkipStatus        = $functionsObj->FetchObject($runSql);
		$Game_Description      = $gameSkipStatus->Game_Description;
		$Game_IntroductionLink = $gameSkipStatus->Game_IntroductionLink;
		$Game_DescriptionLink  = $gameSkipStatus->Game_DescriptionLink;
		$Game_BackToIntro      = $gameSkipStatus->Game_BackToIntro;
		$Game_Introduction     = $gameSkipStatus->Game_Introduction;

		$Link_Description      = isset($_POST['Link_Description'])?$_POST['Link_Description']:0;
		$Link_IntroductionLink = isset($_POST['Link_IntroductionLink'])?$_POST['Link_IntroductionLink']:0;
		$Link_DescriptionLink  = isset($_POST['Link_DescriptionLink'])?$_POST['Link_DescriptionLink']:0;
		$Link_BackToIntro      = isset($_POST['Link_BackToIntro'])?$_POST['Link_BackToIntro']:0;
		$Link_Introduction     = isset($_POST['Link_Introduction'])?$_POST['Link_Introduction']:0;
		// check wheather intro,scenario description or button or hide to intro button skip or not
		if($Game_Description > 0)
		{
			$Link_Description = 1;
		}
		if($Game_IntroductionLink > 0)
		{
			$Link_IntroductionLink = 1;
		}
		if($Game_DescriptionLink > 0)
		{
			$Link_DescriptionLink = 1;
		}
		if($Game_BackToIntro > 0)
		{
			$Link_BackToIntro = 1;
		}
		if($Game_Introduction > 0)
		{
			$Link_Introduction = 1;
		}
	}

	if(isset($_GET['link']))
	{
		$file   ='addeditlink.php';
		$linkid = $_GET['link'];
		$where  = "SubLink_LinkID=" . $linkid." AND SubLink_CompID=" . $_POST['comp_id'];

		if(isset($_POST['subcomp_id']) && !empty($_POST['subcomp_id']))
		{
			$where .= " AND SubLink_SubCompID=" . $_POST['subcomp_id'];
		}
		else{
			$where .= " AND SubLink_SubCompID=0";
		}

		$object = $functionsObj->SelectData ( array (), 'GAME_LINKAGE_SUB', array ($where),
			'', '', '', '', 0 );

		if ($object->num_rows > 0)
		{
			$msg      = 'Entered Link already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		}
		else 
		{
			if($_POST['inputType']=='formula')
			{
				$object  = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array('f_id='.$_POST['formula_id']), '', '', '', '', 0);
				$details = $functionsObj->FetchObject($object);
				$strexp  = $details->expression;
				
				//echo $strexp;
				
				if(isset($_POST['subcomp_id']) && !empty($_POST['subcomp_id']))
					{	$strcheck = "subc_".$_POST['subcomp_id'];
			}
			else{
				$strcheck = "comp_".$_POST['comp_id'];
			}

			if (strpos($strexp,$strcheck))
			{
				$error   = "Error_Formula";
					//exit with error message
				$msg     = "Error: Recursive Link found in the selected Formula ";
				$type[0] = "inputError";
				$type[1] = "has-error";
					//exit();
			}
		}
		
		if($error =="Error_Formula")
		{
			$msg     = "Error: Recursive Link found in the selected Formula ";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
		else{
				//exit();
			if($_POST['SubLink_InputModeType'] == 'range')
			{
				$SubLink_InputModeTypeValue = $_POST['SubLink_MinVal'].','.$_POST['SubLink_MaxVal'].','.$_POST['SubLink_RangeInterval'];
			}
			elseif($_POST['SubLink_InputModeType'] == 'mChoice')
			{
				$option   = array_combine($_POST['option'],$_POST['option_value']);
				$question = array(
					'question' => $_POST['question'],
				);
				$SubLink_InputModeTypeValue = $question + $option;
				// adding the default checked value for admin and user
				$makeDefaultChecked                               = $_POST['makeDefaultChecked'][0];
				$SubLink_InputModeTypeValue['makeDefaultChecked'] = ($makeDefaultChecked)?$makeDefaultChecked:'NoVal';
				if(count($option) > 1)
				{
					$SubLink_InputModeTypeValue = json_encode($SubLink_InputModeTypeValue);
				}
				else
				{
					$SubLink_InputModeTypeValue = '';
				}
			}
			else
			{
				$SubLink_InputModeTypeValue = '';
			}
			// adding chart type name into game_linkage_sub table, to remove chart query in input_page
			if(isset($_POST['chart_id']))
			{
				$chartSql            = "SELECT Chart_Type FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$_POST['chart_id'];
				$chartObj            = $functionsObj->ExecuteQuery($chartSql);
				$chartType           = $functionsObj->FetchObject($chartObj);
				$charttypeComp       = $chartType->Chart_Type; 
			}

			$linkdetails = (object) array(
				'SubLink_LinkID'             => $linkid,
				'SubLink_AreaID'             => $_POST['area_id'],
				'SubLink_CompID'             => $_POST['comp_id'],
				'SubLink_SubCompID'          => isset($_POST['subcomp_id']) ? $_POST['subcomp_id'] : null,			
				'SubLink_Type'               => isset($_POST['Type']) && $_POST['Type']=='input' ? 0 : 1,
				'SubLink_Order'              => $_POST['order'],
				'SubLink_ShowHide'           => $_POST['ShowHide'],
				'SubLink_FormulaID'          => $_POST['inputType']=='formula' ? $_POST['formula_id']: null,
				'SubLink_AdminCurrent'       => $_POST['inputType']=='admin' ? $_POST['current']: null,
				'SubLink_AdminLast'          => $_POST['inputType']=='admin' ? $_POST['last']: null,
				'SubLink_InputMode'          => $_POST['inputType'],
				'SubLink_InputModeType'      => $_POST['SubLink_InputModeType'],
				'SubLink_InputModeTypeValue' => $SubLink_InputModeTypeValue,
				'SubLink_LinkIDcarry'        => $_POST['inputType']=='carry' ? $_POST['carry_linkid']: null,
				'SubLink_CompIDcarry'        => $_POST['inputType']=='carry' ? $_POST['carry_compid']: null,
				'SubLink_SubCompIDcarry'     => $_POST['inputType']=='carry' ? $_POST['carry_subcompid']: null,
				'SubLink_Condition'          => $_POST['conditionformulaid'],
				'SubLink_Roundoff'           => isset($_POST['chkround']) ? 1:0,
				'SubLink_ChartID'            => $_POST['chart_id'],
				'SubLink_ChartType'          => ($charttypeComp)?$charttypeComp:null,
				'SubLink_Details'            => $_POST['details'],
				'SubLink_Status'             => 1,
				'SubLink_ViewingOrder'       => (!empty($_POST['SubLink_ViewingOrder'])) ? $_POST['SubLink_ViewingOrder']:1,
				'SubLink_BackgroundColor'    => $_POST['SubLink_BackgroundColor'],
				'SubLink_TextColor'          => $_POST['SubLink_TextColor'],
				'SubLink_LabelCurrent'       => $_POST['SubLink_LabelCurrent'],
				'SubLink_LabelLast'          => $_POST['SubLink_LabelLast'],
				'SubLink_FontSize'           => $_POST['SubLink_FontSize'],
				'SubLink_FontStyle'          => $_POST['SubLink_FontStyle'],
				'SubLink_InputFieldOrder'    => $_POST['SubLink_InputFieldOrder'],
				'SubLink_CreateDate'         => date('Y-m-d H:i:s')
			);
			
			$result = $functionsObj->InsertData('GAME_LINKAGE_SUB', $linkdetails, 0, 0);
			$id     = $functionsObj->InsertID();
			// adding the below query to updat the newly added fields liek Area, Comp, SubComp name and formula exp to reduce joins
			$updateSql = "UPDATE GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID = gls.SubLink_AreaID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID LEFT JOIN GAME_FORMULAS gf ON gf.f_id = gls.SubLink_FormulaID SET gls.SubLink_AreaName = ga.Area_Name, gls.SubLink_CompName = gc.Comp_Name, gls.SubLink_SubcompName = gs.SubComp_Name, gls.SubLink_FormulaExpression = gf.expression	WHERE gls.SubLink_AreaID =".$_POST['area_id'];
			$functionsObj->ExecuteQuery($updateSql);
			if($result)
			{
				// filling data in game_views table for snapshot
				$query         = "SELECT Link_GameID FROM GAME_LINKAGE WHERE Link_ID=$linkid";
				$game_object   = $functionsObj->ExecuteQuery($query);
				$views_Game_ID = mysqli_fetch_object($game_object);
				// $views_Game_ID $linkid
				$game_views_array = array(
					'views_sublinkid' => $id,
					'views_key'       => $_POST['input_key'],
					'views_Game_ID'   => $views_Game_ID->Link_GameID,
				);
				$snap_view = $functionsObj->InsertData('GAME_VIEWS', $game_views_array, 0, 0);
				// filling data to snap view end here for game views table
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
							'Rep_Order'     => 1,
							'Rep_SublinkID' => $id,
							'Rep_Start'     => $_POST['start1'],
							'Rep_End'       => $_POST['end1'],
							'Rep_Value'     => $_POST['value1']
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
								'Rep_Order'     => 2,
								'Rep_SublinkID' => $id,
								'Rep_Start'     => $_POST['start2'],
								'Rep_End'       => $_POST['end2'],
								'Rep_Value'     => $_POST['value2']
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
									'Rep_Order'     => 3,
									'Rep_SublinkID' => $id,
									'Rep_Start'     => $_POST['start3'],
									'Rep_End'       => $_POST['end3'],
									'Rep_Value'     => $_POST['value3']
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

				$_SESSION['msg']     = "Link created successfully";
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
	// echo "<pre>"; print_r($_REQUEST);	exit();
	// if component branching enabled
	if($_POST['Link_Branching'])
	{
		$Link_Branching = $_POST['Link_Branching'];
	}
	else
	{
		$Link_Branching = 0;
	}
	$linkdetails = (object) array(
		'Link_GameID'           =>	$_POST['game_id'],
		'Link_ScenarioID'       =>	$_POST['scen_id'],
		'Link_Hour'             =>	$_POST['hour'],
		'Link_Min'              =>	$_POST['minute'],
		'Link_Order'            =>	$_POST['order'],
		'Link_Mode'             =>	$_POST['Mode'],
		'Link_Enabled'          =>	isset($_POST['enabled']) ? 1 : 0,
		'Link_Branching'        =>	isset($_POST['Link_Branching'])?$_POST['Link_Branching']:0,
		'Link_Introduction'     =>	$Link_Introduction,
		'Link_IntroductionLink' =>	$Link_IntroductionLink,
		'Link_Description'      =>	$Link_Description,
		'Link_DescriptionLink'  =>	$Link_DescriptionLink,
		'Link_BackToIntro'      =>  $Link_BackToIntro,
		'Link_SaveStatic'       =>	isset($_POST['Link_Branching']) ? 0 : isset($_POST['Link_SaveStatic']) ? 1 : 0,
		'Link_SkipAlert'        =>	$_POST['Link_SkipAlert'],
		'Link_Status'           =>	1,			
		'Link_CreateDate'       =>	date('Y-m-d H:i:s')
	);
	//echo "<pre>";print_r($linkdetails);exit;	
	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['order']) )
	{
		$where = "Link_GameID=".$_POST['game_id']."	AND Link_ScenarioID=".$_POST['scen_id']."	AND Link_Branching=".$Link_Branching;
		$existSql = $functionsObj->SelectData( array (), 'GAME_LINKAGE', array ($where),'','','','',1);
		if($existSql->num_rows > 0)
		{
			$_SESSION['msg']     = "Link for game and scenario already exist";
			$_SESSION['type[0]'] = "inputError";
			$_SESSION['type[1]'] = "has-error";
			header("Location: ".site_root."ux-admin/linkage");
			exit(0);	
		}
		else
		{
			$result = $functionsObj->InsertData('GAME_LINKAGE', $linkdetails, 0, 0);
			if($result)
			{
				$_SESSION['msg']     = "Link created successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				header("Location: ".site_root."ux-admin/linkage");
				exit(0);	
			}
		}
	}	
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{	
	// echo "<pre>"; print_r($_POST); exit();
	// header('X-XSS-Protection:0');	echo "<pre>"; print_r($_POST); die('Update Linkage'); 
	if(isset($_POST['game_id']) && !empty($_POST['game_id']))
	{
		$id_game = $_POST['game_id'];
	}
	else
	{
		$findGameId = "SELECT * FROM GAME_LINKAGE WHERE Link_ID=".$_POST['link'];
		$exeSql     = $functionsObj->ExecuteQuery($findGameId);
		$gamedetail = $functionsObj->FetchObject($exeSql);
		$id_game    = $gamedetail->Link_GameID;
	}

	$statusCheckSql        = "SELECT * FROM GAME_GAME WHERE Game_ID=".$id_game;
	$runSql                = $functionsObj->ExecuteQuery($statusCheckSql);
	$gameSkipStatus        = $functionsObj->FetchObject($runSql);
	$Game_Description      = $gameSkipStatus->Game_Description;
	$Game_IntroductionLink = $gameSkipStatus->Game_IntroductionLink;
	$Game_DescriptionLink  = $gameSkipStatus->Game_DescriptionLink;
	$Game_BackToIntro      = $gameSkipStatus->Game_BackToIntro;
	$Game_Introduction     = $gameSkipStatus->Game_Introduction;

	$Link_Description      = isset($_POST['Link_Description'])?$_POST['Link_Description']:0;
	$Link_IntroductionLink = isset($_POST['Link_IntroductionLink'])?$_POST['Link_IntroductionLink']:0;
	$Link_DescriptionLink  = isset($_POST['Link_DescriptionLink'])?$_POST['Link_DescriptionLink']:0;
	$Link_BackToIntro      = isset($_POST['Link_BackToIntro'])?$_POST['Link_BackToIntro']:0;
	$Link_Introduction     = isset($_POST['Link_Introduction'])?$_POST['Link_Introduction']:0;
	// check wheather intro,scenario description or button or hide to intro button skip or not
	if($Game_Description > 0)
	{
		$Link_Description = 1;
	}
	if($Game_IntroductionLink > 0)
	{
		$Link_IntroductionLink = 1;
	}
	if($Game_DescriptionLink > 0)
	{
		$Link_DescriptionLink = 1;
	}
	if($Game_BackToIntro > 0)
	{
		$Link_BackToIntro = 1;
	}
	if($Game_Introduction > 0)
	{
		$Link_Introduction = 1;
	}
	if(isset($_GET['linkedit'])){		
		// echo "<pre>"; print_r($_POST); exit();
		// if component is disabled then take component from hidden field
		if(isset($_POST['comp_id']))
		{
			$compid = $_POST['comp_id'];
		}
		else
		{
			$compid = $_POST['dis_comp_id'];
		}

		if(isset($_POST['subcomp_id']))
		{
			$subcomp_id = $_POST['subcomp_id'];
		}
		else
		{
			$subcomp_id = $_POST['dis_subcomp_id'];
		}

		if(isset($_POST['SubLink_ViewingOrder']))
		{
			$ViewingOrder = $_POST['SubLink_ViewingOrder'];
		}
		else
		{
			$ViewingOrder = $_POST['dis_SubLink_ViewingOrder'];
		}

		$file      = 'addeditlink.php';	
		$sublinkid = $_GET['linkedit'];
		$linkid    = $_POST['link'];
		//echo "Linkid => ".$linkid." , SubLinkid => ". $sublinkid;
		//exit();
		$where = "SubLink_LinkID=" . $linkid." AND SubLink_ID!= ".$sublinkid."
		AND SubLink_CompID=" . $compid;

		if(isset($subcomp_id) && !empty($subcomp_id))
		{	
			$where .= " AND SubLink_SubCompID=" . $subcomp_id;
		}
		else{
			$where .= " AND SubLink_SubCompID=0";
		}

		$object = $functionsObj->SelectData ( array (), 'GAME_LINKAGE_SUB', array ($where), 
			'', '', '', '', 0 );
//exit();
		if ($object->num_rows > 0)
		{
			$msg      = 'Entered Link already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		}

		$compBranchSql = "SELECT * FROM GAME_BRANCHING_COMPONENT WHERE CompBranch_SublinkId=".$sublinkid." OR CompBranch_NextCompSublinkId=".$sublinkid;
		$compBranchObj = $functionsObj->ExecuteQuery($compBranchSql);
			// echo "<pre>"; print_r($compBranchObj); die('here');
		if($compBranchObj->num_rows > 0 && $_POST['ShowHide']>0 )
		{
			$msg      = 'This linkage is used in component branching so show/hide status can not be changed';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		}
		else 
		{
			if($_POST['inputType']=='formula')
			{
				$object  = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array('f_id='.$_POST['formula_id']), '', '', '', '', 0);
				$details = $functionsObj->FetchObject($object);
				$strexp  = $details->expression;
				
				// echo $strexp;
				
				if(isset($subcomp_id) && !empty($subcomp_id))
					{	$strcheck = "subc_".$subcomp_id;
			}
			else{
				$strcheck = "comp_".$compid;
			}

			if (strpos($strexp,$strcheck))
			{
				$error   = "Error_Formula";
					//exit with error message
				$msg     = "Error: Recursive Link found in the selected Formula ";
				$type[0] = "inputError";
				$type[1] = "has-error";
					//exit();
			}
		}
		
		if($error =="Error_Formula")
		{
			$msg     = "Error: Recursive Link found in the selected Formula ";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
		else{

			if($_POST['inputType'] == 'user')
			{
				if($_POST['SubLink_InputModeType'] == 'range')
				{
					$SubLink_InputModeTypeValue = $_POST['SubLink_MinVal'].','.$_POST['SubLink_MaxVal'].','.$_POST['SubLink_RangeInterval'];
				}
				elseif($_POST['SubLink_InputModeType'] == 'mChoice')
				{
					// mcq's question text
					$question = array(
						'question' => $_POST['question'],
					);
					// options for the questions i.e. mcq's responses
					$option                     = array_combine($_POST['option'],$_POST['option_value']);
					$SubLink_InputModeTypeValue = $question + $option;
					// adding the default checked value for admin and user
					$makeDefaultChecked                               = $_POST['makeDefaultChecked'][0];
					$SubLink_InputModeTypeValue['makeDefaultChecked'] = ($makeDefaultChecked)?$makeDefaultChecked:'NoVal';
					// print_r($question); print_r($option); print_r($SubLink_InputModeTypeValue);
					if(count($option) > 0)
					{
						$SubLink_InputModeTypeValue = json_encode($SubLink_InputModeTypeValue);
					}
					else
					{
						$SubLink_InputModeTypeValue = '';
					}
				}
			}
			else
			{
				$SubLink_InputModeTypeValue     = '';
				$_POST['SubLink_InputModeType'] = '';
			}

			// adding chart type name into game_linkage_sub table, to remove chart query in input_page
			if(isset($_POST['chart_id']))
			{
				$chartSql            = "SELECT Chart_Type FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$_POST['chart_id'];
				$chartObj            = $functionsObj->ExecuteQuery($chartSql);
				$chartType           = $functionsObj->FetchObject($chartObj);
				$charttypeComp       = $chartType->Chart_Type;
			}

			// print_r($SubLink_InputModeTypeValue); exit; 
			// if area is disabled then take area value from $_POST['dis_area_id'],
			$linkdetails = (object) array(
				'SubLink_AreaID'             => ($_POST['area_id'])?$_POST['area_id']:$_POST['dis_area_id'],
				'SubLink_CompID'             => $compid,
				'SubLink_SubCompID'          => isset($subcomp_id) ? $subcomp_id : null,
				'SubLink_Type'               => isset($_POST['Type']) && $_POST['Type']=='input' ? 0 : 1,
				'SubLink_Order'              => $_POST['order'],
				'SubLink_ShowHide'           => $_POST['ShowHide'],
				'SubLink_FormulaID'          => $_POST['inputType']=='formula' ? $_POST['formula_id']: null,
				'SubLink_AdminCurrent'       => $_POST['inputType']=='admin' ? $_POST['current']: null,
				'SubLink_AdminLast'          => $_POST['inputType']=='admin' ? $_POST['last']: null,
				'SubLink_InputMode'          => $_POST['inputType'],
				'SubLink_InputModeType'      => $_POST['SubLink_InputModeType'],
				'SubLink_InputModeTypeValue' => $SubLink_InputModeTypeValue,
				'SubLink_LinkIDcarry'        => $_POST['inputType']=='carry' ? $_POST['carry_linkid']: null,
				'SubLink_CompIDcarry'        => $_POST['inputType']=='carry' ? $_POST['carry_compid']: null,
				'SubLink_SubCompIDcarry'     => $_POST['inputType']=='carry' ? $_POST['carry_subcompid']: null,
				'SubLink_Condition'          => $_POST['conditionformulaid'],
				'SubLink_Roundoff'           => isset($_POST['chkround']) ? 1:0,
				'SubLink_ChartID'            => $_POST['chart_id'],
				'SubLink_ChartType'          => ($charttypeComp)?$charttypeComp:null,
				'SubLink_Details'            => $_POST['details'],
				'SubLink_ViewingOrder'       => (!empty($ViewingOrder)) ? $ViewingOrder:1,
				'SubLink_BackgroundColor'    => $_POST['SubLink_BackgroundColor'],
				'SubLink_TextColor'          => $_POST['SubLink_TextColor'],
				'SubLink_LabelCurrent'       => $_POST['SubLink_LabelCurrent'],
				'SubLink_LabelLast'          => $_POST['SubLink_LabelLast'],
				'SubLink_FontSize'           => $_POST['SubLink_FontSize'],
				'SubLink_FontStyle'          => $_POST['SubLink_FontStyle'],
				'SubLink_InputFieldOrder'    => $_POST['SubLink_InputFieldOrder'],
					//'SubLink_Details'	=> $_POST['details']
			);
			$object     = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_id='.$sublinkid), '', '', '', '', 0);
			$details    = $functionsObj->FetchObject($object);
			$linkid     = $details->SubLink_LinkID;
			$result     = $functionsObj->UpdateData('GAME_LINKAGE_SUB', $linkdetails, 'SubLink_id', $sublinkid, 0);
			// adding the below query to updat the newly added fields liek Area, Comp, SubComp name and formula exp to reduce joins
			$updateArea = ($_POST['area_id'])?$_POST['area_id']:$_POST['dis_area_id'];	
			$updateSql  = "UPDATE GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID = gls.SubLink_AreaID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID LEFT JOIN GAME_FORMULAS gf ON gf.f_id = gls.SubLink_FormulaID SET gls.SubLink_AreaName = ga.Area_Name, gls.SubLink_CompName = gc.Comp_Name, gls.SubLink_SubcompName = gs.SubComp_Name, gls.SubLink_FormulaExpression = gf.expression	WHERE gls.SubLink_AreaID =".$updateArea;
			$functionsObj->ExecuteQuery($updateSql);
			if($result === true){
				if(isset($_POST['start1']) && isset($_POST['end1']) && isset($_POST['value1']))
				{
						//echo empty($_POST['replaceid1']);
						//exit();
					if(empty($_POST['replaceid1']))
					{
							//insert into Replace table
						$replacearray1 = (object) array(
							'Rep_Order'     => 1,
							'Rep_SublinkID' => $sublinkid,
							'Rep_Start'     => $_POST['start1'],
							'Rep_End'       => $_POST['end1'],
							'Rep_Value'     => $_POST['value1']
						);
						$replaceresult1 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray1, 0, 0);
					}
					else					
					{
							//update into Replace table
						$replacearray1 = (object) array(							
							'Rep_Start' => $_POST['start1'],
							'Rep_End'   => $_POST['end1'],
							'Rep_Value' => $_POST['value1']
						);

						$resrep1 = $functionsObj->UpdateData('GAME_LINK_REPLACE', $replacearray1, 'Rep_ID', $_POST['replaceid1'], 0);
					}
					if(isset($_POST['start2']) && isset($_POST['end2']) && isset($_POST['value2']))
					{
						if(empty($_POST['replaceid2']))
						{
								//insert into Replace table
							$replacearray2 = (object) array(
								'Rep_Order'     => 2,
								'Rep_SublinkID' => $sublinkid,
								'Rep_Start'     => $_POST['start2'],
								'Rep_End'       => $_POST['end2'],
								'Rep_Value'     => $_POST['value2']
							);
							$replaceresult2 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray2, 0, 0);
						}
						else					
						{
								//update into Replace table
							$replacearray2 = (object) array(							
								'Rep_Start' => $_POST['start2'],
								'Rep_End'   => $_POST['end2'],
								'Rep_Value' => $_POST['value2']
							);

							$resrep2 = $functionsObj->UpdateData('GAME_LINK_REPLACE', $replacearray2, 'Rep_ID', $_POST['replaceid2'], 0);

						}
						if(isset($_POST['start3']) && isset($_POST['end3']) && isset($_POST['value3']))
						{
							if(empty($_POST['replaceid3']))
							{
									//insert into Replace table
								$replacearray3 = (object) array(
									'Rep_Order'     => 3,
									'Rep_SublinkID' => $sublinkid,
									'Rep_Start'     => $_POST['start3'],
									'Rep_End'       => $_POST['end3'],
									'Rep_Value'     => $_POST['value3']
								);
								$replaceresult3 = $functionsObj->InsertData('GAME_LINK_REPLACE', $replacearray3, 0, 0);
							}
							else					
							{
									//update into Replace table
								$replacearray3 = (object) array(							
									'Rep_Start' => $_POST['start3'],
									'Rep_End'   => $_POST['end3'],
									'Rep_Value' => $_POST['value3']
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
				$game_views_key = array(
					'views_key'       => $_POST['input_key'],
					'views_sublinkid' => $sublinkid,
					'is_updated'      => 1,
				);
				$updtae_table        = $functionsObj->UpdateData('GAME_VIEWS', $game_views_key, 'views_sublinkid', $sublinkid, 0);
				// die('here');
				$_SESSION['msg']     = "Link updated successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				header("Location: ".site_root."ux-admin/linkage/link/".$linkid);
				exit(0);
			}
			else
			{
				$msg = "Error: ".$result;
				$type[0] = "inputError";
				$type[1] = "has-error";
			}
		}
	}
}
else
{
	if($_POST['Link_Branching'])
	{
		$Link_Branching = $_POST['Link_Branching'];
	}
	else
	{
		$Link_Branching = 0;
	}

	$linkdetails = (object) array(
		'Link_GameID'           =>	$_POST['game_id'],
		'Link_ScenarioID'       =>	$_POST['scen_id'],
		'Link_Hour'             =>	$_POST['hour'],
		'Link_Min'              =>	$_POST['minute'],
		'Link_Order'            =>	$_POST['order'],
		'Link_Mode'             =>	$_POST['Mode'],
		'Link_Branching'        =>	isset($_POST['Link_Branching'])?$_POST['Link_Branching']:0,
		'Link_Introduction'     =>	$Link_Introduction,
		'Link_IntroductionLink' =>	$Link_IntroductionLink,
		'Link_Description'      =>	$Link_Description,
		'Link_DescriptionLink'  =>	$Link_DescriptionLink,
		'Link_BackToIntro'      =>  $Link_BackToIntro,
		'Link_Enabled'          =>	isset($_POST['enabled']) ? 1 : 0,
		'Link_SaveStatic'       =>	isset($_POST['Link_Branching']) ? 0 : isset($_POST['Link_SaveStatic']) ? 1 : 0,
		'Link_SkipAlert'        =>	$_POST['Link_SkipAlert'],
		'Link_Status'           =>	1,			
		'Link_CreateDate'       =>	date('Y-m-d H:i:s')
	);

	// check default/skip status from game and allow/disallow accordingly

	// echo '<pre>'; print_r($linkdetails);	exit();

	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['order']) )
	{
		$linkid = $_GET['edit'];
			//echo $linkid;
		$result = $functionsObj->UpdateData('GAME_LINKAGE', $linkdetails, 'Link_id', $linkid, 0);
			//exit();
		if($result === true)
		{
			$_SESSION['msg']     = "Link updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/linkage");
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
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
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();
	
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

if(isset($_POST['submit']) && $_POST['submit'] == 'RequestDownload'){
	if (isset($_POST['Link_ID']))
	{
		$linkid = $_POST['Link_ID'];
	}
	
	$reqdetails = (object) array(
		'linkid' =>	$linkid,
		'status' =>	1
	);

	$result = $functionsObj->InsertData('GAME_SITE_USER_REPORT_REQUEST', $reqdetails);


	echo '<script>window.open("../../userReportCron.php","_blank")</script>';

}

// adding this code to download data from game_site_user_report_new table
if(isset($_POST['submit']) && $_POST['submit'] == 'UserDownloadNew')
{

	$reportDateFrom = $_POST['reportDateFrom'];
	$reportDateTo   = $_POST['reportDateTo'];
	$reportDate     = array(
		'reportDateFrom' => $reportDateFrom,
		'reportDateTo'   => $reportDateTo,
	);
	
	// echo "<pre>"; print_r($_POST); die('<br>here');

	if (isset($_POST['Link_ID']))
	{
		$linkid = $_POST['Link_ID'];
	}
	
	$reportDate = $_POST['reportDate'];
	if(isset($_REQUEST['reportDate']) && $_REQUEST['reportDate']!='')
	{
		$str     = ($_REQUEST['reportDate']);
		$dateStr = "AND DATE_FORMAT(date_time, '%Y-%m-%d') = '$str' ";
	}

	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';	
	$objSheet       = $objPHPExcel->getActiveSheet();
	
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

	$sqlComp = "SELECT ls.SubLink_ID, CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
	FROM `GAME_LINKAGE_SUB` ls 
	LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
	LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
	WHERE SubLink_LinkID=".$linkid ." 
	ORDER BY SubLink_ID";
	
	$objcomp = $functionsObj->ExecuteQuery($sqlComp);	
	$letter  = "C";
	
	if($objcomp->num_rows > 0){
		while($rowcomp = $objcomp->fetch_object()){			
			$s     = $letter . '2';
			$first = $letter . '1';

			$objSheet->setCellValue($s, strip_tags($rowcomp->Comp_Subcomp));
			$objSheet->getColumnDimension($s)->setWidth(20);	

			$letter++;
		}
	}
	
	$objSheet->getStyle('A2:'.$letter.'2')->getFont()->setBold(true)->setSize(12);

	$sql     = "SELECT * FROM GAME_SITE_USER_REPORT_NEW WHERE linkid=".$linkid." $dateStr  order by id desc";
	// die($sql);
	$objlink = $functionsObj->ExecuteQuery($sql);
	if($objlink->num_rows > 0){
		$i=3;
		while($row = $objlink->fetch_object()){
			$objSheet->getCell('A'.$i)->setValue($i-2);
			$objSheet->getCell('B'.$i)->setValue($row->user_name);

			$userdata = json_decode($row->user_data, true);
			$letter   = "C";
			foreach($userdata as $keydata=>$valdata){
				$s = $letter . $i;
				$objSheet->setCellValue($s, $valdata);
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
	header('Content-Disposition: attachment;filename="UserDataNew.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter->save('php://output');
}
// end of report modification code

if(isset($_POST['submit']) && $_POST['submit'] == 'UserDownload'){
	if (isset($_POST['Link_ID']))
	{
		$linkid = $_POST['Link_ID'];
	}
	
	$reportDate = $_POST['reportDate'];
	if(isset($_REQUEST['reportDate']) && $_REQUEST['reportDate']!='')
	{
		$str = ($_REQUEST['reportDate']);
		
		$dateStr = "AND DATE_FORMAT(date_time, '%Y-%m-%d') = '$str' ";
	}

	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';	
	$objSheet       = $objPHPExcel->getActiveSheet();
	
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


	$sqlComp = "SELECT ls.SubLink_ID, CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
	FROM `GAME_LINKAGE_SUB` ls 
	LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
	LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
	WHERE SubLink_LinkID=".$linkid ." 
	ORDER BY SubLink_ID";
	
	

	$objcomp = $functionsObj->ExecuteQuery($sqlComp);	
	$letter  = "C";
	
	if($objcomp->num_rows > 0){
		while($rowcomp = $objcomp->fetch_object()){			
			$s     = $letter . '2';
			$first = $letter . '1';

			$objSheet->setCellValue($s, strip_tags($rowcomp->Comp_Subcomp));
			$objSheet->getColumnDimension($s)->setWidth(20);	

			$letter++;
		}
	}
	
	$objSheet->getStyle('A2:'.$letter.'2')->getFont()->setBold(true)->setSize(12);
	

	$sql     = "SELECT * FROM GAME_SITE_USER_REPORT WHERE linkid=".$linkid." $dateStr  order by id desc";
	$objlink = $functionsObj->ExecuteQuery($sql);
	if($objlink->num_rows > 0){
		$i=3;
		while($row = $objlink->fetch_object()){
			$objSheet->getCell('A'.$i)->setValue($i-2);
			$objSheet->getCell('B'.$i)->setValue($row->user_name);

			$userdata = json_decode($row->user_data, true);
			$letter   = "C";
			foreach($userdata as $keydata=>$valdata){
				$s = $letter . $i;
				$objSheet->setCellValue($s, $valdata);
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
	$header      = 'Edit Links';
	$uid         = $_GET['edit'];
	
	$object      = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ID='.$uid), '', '', '', '', 0);
	$linkdetails = $functionsObj->FetchObject($object);
	$url         = site_root."ux-admin/linkage";
	$file        = 'addedit.php';
}elseif(isset($_GET['add'])){
	// Add Siteuser
	$header = 'Add Links';
	$url    = site_root."ux-admin/linkage";	
	$file   = 'addedit.php';
}
elseif(isset($_GET['del'])){
	// Delete Siteuser
	$id = base64_decode($_GET['del']);
	// echo $id;
	//exit();

	$result           = $functionsObj->DeleteData('GAME_LINKAGE','Link_ID',$id,0);
	$resultLinkUsers  = $functionsObj->DeleteData('GAME_LINKAGE_USERS','UsScen_LinkId',$id,0);
	$resultSubLinkage = $functionsObj->DeleteData('GAME_LINKAGE_SUB','SubLink_LinkID',$id,0);
	// print_r($resultLinkUsers); echo "<br>"; print_r($result); exit;

	$_SESSION['msg']     = "Link deleted successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);

}elseif(isset($_GET['stat'])){
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ID='.$id), '', '', '', '', 0);
	$details = $functionsObj->FetchObject($object);
	
	if($details->Link_Status == 1){
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE', array('Link_Status'=> 0), 'Link_ID', $id, 0);
	}else{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE', array('Link_Status'=> 1), 'Link_ID', $id, 0);
	}
	if($result === true){
		$_SESSION['msg']     = "Link ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/linkage");
		exit(0);
	}else{
		$msg     = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}elseif(isset($_GET['link'])){
	$header = 'Add Links';
	$file   ='addeditlink.php';	
	$linkid = $_GET['link'];
	$where  = 'Link_ID='.$linkid;
	$url    = site_root."ux-admin/linkage";	
	$sql    = "SELECT
	L.*,
	(SELECT `Game_Name`  FROM  GAME_GAME WHERE  `Game_ID` = L.Link_GameID) as Game,
	(SELECT `Scen_Name`  FROM  GAME_SCENARIO WHERE  `Scen_ID` = L.`Link_ScenarioID`) as Scenario
	FROM
	`GAME_LINKAGE`as L
	WHERE
	L.Link_ID=".$linkid;
	//echo $sql."</br>";
	$object  = $functionsObj->ExecuteQuery($sql);
	$result  = $functionsObj->FetchObject($object);	
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
	(SELECT `SubComp_Name` FROM GAME_SUBCOMPONENT WHERE `SubComp_ID` = LS.SubLink_SubCompID) AS SubComponent,
	(SELECT `Area_Name` FROM GAME_AREA  WHERE `Area_ID` = LS.SubLink_AreaID) AS AreaName
	FROM
	`GAME_LINKAGE` L INNER JOIN GAME_LINKAGE_SUB LS 
	ON L.`Link_ID` = LS.SubLink_LinkID
	WHERE
	`SubLink_LinkID`= ".$linkid;
	//echo $linksql;
	$object1       = $functionsObj->ExecuteQuery($linksql);
	$nextComponent = $functionsObj->ExecuteQuery($linksql);
	
	$sqlcarry = "SELECT l.Link_ID, s.Scen_ID,s.Scen_Name
	FROM `GAME_LINKAGE` l INNER JOIN GAME_SCENARIO s on l.Link_ScenarioID=s.Scen_ID
	WHERE Link_GameID=".$result->Link_GameID." AND Link_Order <= 
	(SELECT Link_Order FROM GAME_LINKAGE WHERE Link_ID = ".$linkid.")";
//echo $sqlcarry;
	$objcarry = $functionsObj->ExecuteQuery($sqlcarry);
	
	
}
elseif(isset($_GET['tab']))
{
	$header  = 'Area Tab Sequencing';
	$file    ='addeditarea.php';
	
	$linkid  = $_GET['tab'];
	$where   = 'Link_ID='.$linkid;
	$url     = site_root."ux-admin/linkage";	
	
	$sqlarea = "SELECT DISTINCT a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_Sequencing
	FROM GAME_LINKAGE l 
	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
	INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
	INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
	LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
	INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
	WHERE ls.SubLink_Type=0 AND l.Link_ID=".$linkid." GROUP BY a.Area_ID,a.Area_Name 
	ORDER BY a.Area_Name";
	$area = $functionsObj->ExecuteQuery($sqlarea);
	
	// set seq in area tab
	
	if( !empty($_POST['areaTab']))
	{
		
		foreach ($_POST as $key => $value)
		{
			$result = $functionsObj->UpdateData('GAME_AREA', array('Area_Sequencing'=> $value), 'Area_ID', $key, 0);
		}

		$_SESSION['msg']     = "Area sequencing updated successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";		
		header("Location: ".site_root."ux-admin/linkage");
		exit(0);
	}	
	
}
elseif(isset($_GET['linkedit']))
{
	$header = 'Add Links';
	$file   = 'addeditlink.php';
	
	$linkid = $_GET['linkedit'];
	
	$sql    = "SELECT LS.*
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
	

	$url     = site_root."ux-admin/linkage/link/".$id;		
	$linksql = "SELECT  L.*,LS.*,
	(SELECT `Game_Name` FROM GAME_GAME  WHERE `Game_ID` = L.Link_GameID) AS Game,
	(SELECT `Scen_Name` FROM GAME_SCENARIO WHERE `Scen_ID` = L.`Link_ScenarioID`) AS Scenario,
	(SELECT `Comp_Name` FROM GAME_COMPONENT WHERE `Comp_ID` = LS.SubLink_CompID) AS Component,
	(SELECT `SubComp_Name` FROM GAME_SUBCOMPONENT WHERE `SubComp_ID` = LS.SubLink_SubCompID) AS SubComponent,
	(SELECT `Area_Name` FROM GAME_AREA  WHERE `Area_ID` = LS.SubLink_AreaID) AS AreaName
	FROM
	`GAME_LINKAGE` L INNER JOIN GAME_LINKAGE_SUB LS 
	ON L.`Link_ID` = LS.SubLink_LinkID
	WHERE
	`SubLink_LinkID`= ".$id;
	//echo $linksql;
	$object1  = $functionsObj->ExecuteQuery($linksql);
	$object   = $functionsObj->ExecuteQuery($linksql);
	$result   = $functionsObj->FetchObject($object);
	$sqlcarry = "SELECT l.Link_ID, s.Scen_ID,s.Scen_Name
	FROM `GAME_LINKAGE` l INNER JOIN GAME_SCENARIO s on l.Link_ScenarioID=s.Scen_ID
	WHERE Link_GameID=".$result->Link_GameID." AND Link_Order <= 
	(SELECT Link_Order FROM GAME_LINKAGE WHERE Link_ID = ".$id.")";
	// echo $sqlcarry;
	$objcarry = $functionsObj->ExecuteQuery($sqlcarry);

}elseif(isset($_GET['linkdel'])){
	// Delete Siteuser
	$linkid  = base64_decode($_GET['linkdel']);
	$sql     = "SELECT LS.*	FROM GAME_LINKAGE_SUB as LS WHERE SubLink_ID=".$linkid;
	$object2 = $functionsObj->ExecuteQuery($sql);
	//echo $linksql;
	if($object2->num_rows>0)
	{
		$linkdetails = $functionsObj->FetchObject($object2);
		$id          = $linkdetails->SubLink_LinkID;
	}	
	
	//exit();
	$result              = $functionsObj->DeleteData('GAME_LINKAGE_SUB','SubLink_ID',$linkid,0);
	$_SESSION['msg']     = "Link deleted successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/linkage/link/".$id);
	exit(0);

}elseif(isset($_GET['linkstat'])){
	// Enable disable siteuser account
	$linkid = base64_decode($_GET['linkstat']);
	$sql    = "SELECT LS.*	FROM GAME_LINKAGE_SUB as LS WHERE SubLink_ID=".$linkid;
	
	$object2 = $functionsObj->ExecuteQuery($sql);
	//echo $linksql;
	if($object2->num_rows>0)
	{
		$linkdetails = $functionsObj->FetchObject($object2);
		$id          = $linkdetails->SubLink_LinkID;
	}	
	
	$object  = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_ID='.$linkid), '', '', '', '', 0);
	$details = $functionsObj->FetchObject($object);
	
	if($details->SubLink_Status == 1){
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE_SUB', array('SubLink_Status'=> 0), 'SubLink_ID', $linkid, 0);
	}else{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_LINKAGE_SUB', array('SubLink_Status'=> 1), 'SubLink_ID', $linkid, 0);
	}
	if($result === true){
		$_SESSION['msg']     = "Link ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/linkage/link/".$id);
		exit(0);
	}else{
		$msg     = "Error: ".$result;
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
	$file   = 'list.php';
}


// Fetch Services list
if(isset($_GET['linkedit']))
{		
	$sublinkid               = $_GET['linkedit'];
	
	$result_object           = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_id='.$sublinkid), '', '', '', '', 0);
	$result_object           = $result_object->fetch_object();
	// getting the viewing order
	$SubLink_ViewingOrder    = $result_object->SubLink_ViewingOrder;
	// getting the background color
	$SubLink_BackgroundColor = $result_object->SubLink_BackgroundColor;
	// getting the text color
	$SubLink_TextColor       = $result_object->SubLink_TextColor;
	// getting the text for label current
	$SubLink_LabelCurrent    = $result_object->SubLink_LabelCurrent;
	// getting the text for label last
	$SubLink_LabelLast       = $result_object->SubLink_LabelLast;
	// getting the font size
	$SubLink_FontSize        = $result_object->SubLink_FontSize;
	// getting the font style
	$SubLink_FontStyle       = $result_object->SubLink_FontStyle;
	// getting the input field order
	$SubLink_InputFieldOrder = $result_object->SubLink_InputFieldOrder;
	// if range then find the min max and range interval
	if($result_object->SubLink_InputModeType == 'range')
	{
		$range                 = explode(',', $result_object->SubLink_InputModeTypeValue);
		$SubLink_MinVal        = $range['0'];
		$SubLink_MaxVal        = $range['1'];
		$SubLink_RangeInterval = $range['2'];
	}

	// if multiple choice then getting the question and options with value
	if($result_object->SubLink_InputModeType == 'mChoice')
	{
		$mChoice  = json_decode($result_object->SubLink_InputModeTypeValue);
		// echo "<pre>"; print_r($mChoice); exit();
		$question = $mChoice->question;
		$makeDefaultChecked = '';
		// ignoring the question as earlier stored into another variable, so once skip
		$flag  = true;
		foreach ($mChoice as $key => $value)
		{
			if($flag)
			{
				$flag = false;
				continue;
			}
			if($key != 'makeDefaultChecked')
			{
				$option[]       = $key;
				$option_value[] = $value;
			}
			else
			{
				$makeDefaultChecked = $value;
			}
		}
		// echo count($option).'<br>'; print_r($option); echo '<br>'; print_r($option_value); exit; 
		$options       = $option['0'];
		$options_value = $option_value['0'];
	}

}
// $areaLink       = $functionsObj->SelectData(array(), 'GAME_AREA', array('Area_Delete=0'), 'Area_Name', '', '', '', 0);
$areaQuery = "SELECT ga.Area_ID, ga.Area_Name, glsd.Game_Name, glsd.Scen_Name FROM GAME_AREA ga LEFT JOIN( SELECT gls.`SubLink_ID`, gls.`SubLink_LinkID`, gg.Game_ID, gg.Game_Name, gs.Scen_ID, gs.Scen_Name, gls.`SubLink_AreaID` FROM `GAME_LINKAGE_SUB` gls LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID = gls.SubLink_LinkID LEFT JOIN GAME_GAME gg ON gg.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Link_ScenarioID WHERE gls.SubLink_AreaID > 0 GROUP BY gls.SubLink_LinkID, gls.SubLink_AreaID ORDER BY `gls`.`SubLink_AreaID` ASC ) glsd ON ga.Area_ID = glsd.SubLink_AreaID ORDER BY `ga`.`Area_Name` ASC";
$areaLink = $functionsObj->ExecuteQuery($areaQuery);
// echo "<pre>"; print_r($areaLink); 
$checkAreaId = '';
$areaTitle   = '';
// creating a multidimensional array
$areaArray     = array();
$arrayCount    = 0;
$previousCount = 0;
while($row = $areaLink->fetch_object())
{
	if($checkAreaId != $row->Area_ID)
	{
		$previousCount                       = $arrayCount;
		$checkAreaId                         = $row->Area_ID;
		$areaArray[$arrayCount]['Area_ID']   = $row->Area_ID;
		$areaArray[$arrayCount]['Area_Name'] = $row->Area_Name;
		$areaArray[$arrayCount]['Game_Name'] = $row->Game_Name;
		$areaTitle                           = $row->Game_Name;
		$arrayCount++;
	}
	else
	{
		$areaTitle .= ', '.$row->Game_Name;
		$areaArray[$previousCount]['Game_Name'] = trim($areaTitle,',');
	}
}
// print_r($areaArray); exit();

$game           = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', 'Game_Name', '', '', 0);

$scenario       = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0','Scen_Branching=0'), array('Scen_Name ASC'), '', '', '', 0);
$BranchScenario = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0','Scen_Branching=1'), array('Scen_Name ASC'), '', '', '', 0);

$component      = $functionsObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_Delete=0'), 'Comp_Name', '', '', '', 0);

$subcomponent   = $functionsObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_Delete=0'), 'SubComp_Name', '', '', '', 0);

$formula        = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array(), 'formula_title', '', '', '', 0);
if($linkid!='')
{
	$userRequest = $functionsObj->SelectData(array(), 'GAME_SITE_USER_REPORT_REQUEST', array('linkid='.$linkid.' order by id desc limit 1'), '', '', '', '', 0);
	
}
$appendScenario       = array();
$appendBranchScenario = array();
if($linkdetails->Link_Branching == 1)
{
	while($row = $scenario->fetch_object()){
		$appendScenario[] = $row;
	}
}
else
{
	while($wrow = $BranchScenario->fetch_object()){
		$appendBranchScenario[] = $wrow;
	}
}
// echo count($appendScenario); echo ' and '.count($appendBranchScenario); exit;
// echo "<pre>"; print_r($appendScenario);print_r($appendBranchScenario); exit;
include_once doc_root.'ux-admin/view/Linkage/'.$file;