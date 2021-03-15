<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
include_once 'tcpdf/tcpdf.php'; 

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
// setting the error message if any
$msg                  = $_SESSION['msg'];		
$type[0]              = $_SESSION['type[0]'];
$type[1]              = $_SESSION['type[1]'];
$_SESSION['msg']      = '';
$_SESSION['type[0]']  = '';
$_SESSION['type[1]']  = '';

// for downloading result output report for user
if(isset($_POST['download']) && $_POST['download'] == 'download')
{
	// echo "<pre>"; print_r($_POST); exit();
	$oputput_gameid = $_POST['gameid'];
	$oputput_scenid = $_POST['ScenID'];
	$oputput_linkid = $_POST['linkid'];
	$gameData       = $functionsObj->RunQueryFetchObject("SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS FullName, gsu.User_email AS Email, gsu.User_mobile AS Mobile, gsu.User_profile_pic AS ProfileImage, gg.Game_Name, gg.Game_ReportFirstPage, gg.Game_ReportSecondPage, gsu.User_ParentId, gsu.User_SubParentId, ge.Enterprise_Name, ge.Enterprise_Logo, gse.SubEnterprise_Name, gse.SubEnterprise_Logo FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gsu.User_id = gug.UG_UserID AND gug.UG_GameID =".$oputput_gameid." LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gsu.User_ParentId AND ge.Enterprise_Status=0 LEFT JOIN GAME_SUBENTERPRISE gse ON gse.SubEnterprise_ID=gsu.User_SubParentId AND gse.SubEnterprise_Status=0 WHERE gsu.User_id=".$userid)[0];
	// echo "<pre>"; print_r($gameData); exit(); // Game_ReportFirstPage Game_ReportSecondPage
	$sqlarea = "SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_BackgroundColor as BackgroundColor, a.Area_TextColor as TextColor, gas.Sequence_Order AS Area_Sequencing
	FROM GAME_LINKAGE l 
	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
	INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
	INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
	INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
	LEFT JOIN GAME_AREA_SEQUENCE gas on a.Area_ID=gas.Sequence_AreaId
	LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
	WHERE ls.SubLink_Type=1 AND gas.Sequence_LinkId=".$oputput_linkid." AND l.Link_ID=".$oputput_linkid." ORDER BY gas.Sequence_Order DESC";
	// echo $sqlarea; exit();
	$area = $functionsObj->RunQueryFetchObject($sqlarea);
	if(count($area) > 0)
	{
		$printPdfFlag = TRUE;
		// echo count($area)."<pre><br>".$sqlarea.'<br>'; print_r($area); exit();

		foreach ($area as $areaRow)
		{
			// to check that this area comp are visible or hide by admin, if visible then only show area to user else not
			$checkVisibleCompSql = "SELECT gls.*,gi.input_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=".$userid." WHERE gls.SubLink_LinkID =".$oputput_linkid." AND gls.SubLink_AreaID =".$areaRow->AreaID." AND gls.SubLink_ShowHide = 0 AND gls.SubLink_SubCompID<1 ORDER BY gls.SubLink_Order";
			$visibleComponents   = $functionsObj->RunQueryFetchObject($checkVisibleCompSql);
			// echo $checkVisibleCompSql.'<br>';

			if(count($visibleComponents) > 0)
			{
				// this means this area has some comp or subcomp that is visible, take this area data and break the loop
				$printPdfFlag = FALSE;
				break;
			}
		}

		// if nothing to visible then redirect to result page, showing the alert message
		if($printPdfFlag)
		{
			$_SESSION['msg']     = "This game output not available/visible. Please contact admin.";
			$_SESSION['type[0]'] = "inputError";
			$_SESSION['type[1]'] = "has-error";
			header("Location:".site_root."result.php?ID=".$gameid);
			exit();
		}

		// finding the game completion date
		$gameCompletDate = $functionsObj->RunQueryFetchObject("SELECT US_CompletedOn FROM GAME_USERSTATUS WHERE US_GameID=$oputput_gameid AND US_UserID=$userid")[0];

		// echo count($visibleComponents)."<pre><br>".$checkVisibleCompSql.'<br>'; print_r($visibleComponents); exit();
		$pageHeader = '<table align="left" cellspacing="0" cellpadding="1" style"font-weight:bold;"><tr><td colspan="2" align="center" style="background-color:#ececec;"><b>Participant Details</b></td></tr><tr style="background-color:#c4daec;"><td><b>Name</b>: </td><td>'.$gameData->FullName.'</td></tr> <tr style="background-color:#c4daec;"><td><b>Email</b>: </td><td>'.$gameData->Email.'</td></tr> <tr style="background-color:#c4daec;"><td><b>Mobile</b>: </td><td>'.'XXXXXX'.substr($gameData->Mobile, -4).'</td></tr> <tr style="background-color:#c4daec;"><td><b>Simulation/Game</b>: </td><td>'.$gameData->Game_Name.' ('.date('d-m-Y',strtotime($gameCompletDate->US_CompletedOn)).')</td></tr></table><br>'.$gameData->Game_ReportFirstPage;

		foreach ($visibleComponents as $visibleComponentsRow)
		{
			// $printData .= $visibleComponentsRow->SubLink_CompName.$visibleComponentsRow->input_current;
			$printData .= '<div style="width:100%; display:inline-block;" class="componentDiv">';

			// adding ckEditor/chart div
			$printData .= '<div class="componentDivCkeditor" style="width:50%; display:inline-block;">';
			if(empty($visibleComponentsRow->SubLink_ChartID))
			{
				$printData .= $visibleComponentsRow->SubLink_Details;
			}
			else
			{
				// $printData .= $visibleComponentsRow->SubLink_ChartID;
				$printData .= '<img src="'.site_root.'chart/'.$visibleComponentsRow->SubLink_ChartType.'.php?gameid='.$oputput_gameid.'&userid='.$userid.'&ChartID='.$visibleComponentsRow->SubLink_ChartID.'">';
			}

			$printData .= '</div>';
			// end of ckEditor/chart div

			$personalizeOutcomeSql = "SELECT * FROM GAME_PERSONALIZE_OUTCOME gpo WHERE gpo.Outcome_LinkId=".$visibleComponentsRow->SubLink_LinkID." AND gpo.Outcome_CompId=".$visibleComponentsRow->SubLink_CompID." AND gpo.Outcome_IsActive=0 ORDER BY gpo.Outcome_Order ASC";
			$personalizeOutcomeResult = $functionsObj->RunQueryFetchObject($personalizeOutcomeSql);
			if(count($personalizeOutcomeResult) > 0)
			{
				$foundInRangeFlag = TRUE;
				foreach ($personalizeOutcomeResult as $personalizeOutcomeResultRow)
				{
					if($personalizeOutcomeResultRow->Outcome_FileType !=3 && ($visibleComponentsRow->input_current>=$personalizeOutcomeResultRow->Outcome_MinVal AND $visibleComponentsRow->input_current<=$personalizeOutcomeResultRow->Outcome_MaxVal))
					{
						// adding the inputField/PersonalizeOutcome div GAME_PERSONALIZE_OUTCOME
						$printData .= '<div style="width:50%; display:inline-block;" class="componentDivInputFieldPo">';
						$printData .= '<img src="'.doc_root.'/ux-admin/upload/Badges/'.str_replace(' ', '%20', $personalizeOutcomeResultRow->Outcome_FileName).'"><br><br><br><div>'.$personalizeOutcomeResultRow->Outcome_Description.'</div>';
						$foundInRangeFlag = FALSE;
						$printData .= '</div>';
						break;
					}	
				}
				if($foundInRangeFlag)
				{
					// if there is no condition matched, i.e. gap in range so so the value as it is
					$printData .= "Gap in range for personalizeOutcomeResult and the actual value is:- ".$visibleComponentsRow->input_current;
				}
			}
			else
			{
				if($visibleComponentsRow->SubLink_ViewingOrder != 15 && $visibleComponentsRow->SubLink_ViewingOrder != 16)
				{
					// adding the inputField/PersonalizeOutcome div GAME_PERSONALIZE_OUTCOME
					$printData .= '<div style="width:50%; display:inline-block;" class="componentDivInputField">';
					$printData .= $visibleComponentsRow->input_current;
					$printData .= '</div>';
				}
			}

			// end of adding inputField/PersonalizeOutcome div

			// after coming out from the loop check that component has subcomponent or not
			$checkVisibleSubCompSql = "SELECT gls.*,gi.input_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=".$userid." WHERE gls.SubLink_LinkID =".$oputput_linkid." AND gls.SubLink_AreaID =".$visibleComponentsRow->SubLink_AreaID." AND gls.SubLink_ShowHide = 0 AND gls.SubLink_CompID=".$visibleComponentsRow->SubLink_CompID." AND gls.SubLink_SubCompID>1 ORDER BY gls.SubLink_Order";
			$visibleSubComponents   = $functionsObj->RunQueryFetchObject($checkVisibleSubCompSql);

			if(count($visibleSubComponents) > 0)
			{
				foreach ($visibleSubComponents as $visibleSubComponentsRow)
				{
					$printData .= '<div class="subComponentDiv" style="width:100%; display:inline-block;">';

					// adding ckEditor/chart div
					$printData .= '<div class="subComponentDivCkeditor" style="width:50%; display:inline-block;">';
					if(empty($visibleSubComponentsRow->SubLink_ChartID))
					{
						$printData .= $visibleSubComponentsRow->SubLink_Details;
					}
					else
					{
						// $printData .= $visibleSubComponentsRow->SubLink_ChartID;
						$printData .= '<img src="'.site_root.'chart/'.$visibleSubComponentsRow->SubLink_ChartType.'.php?gameid='.$oputput_gameid.'&userid='.$userid.'&ChartID='.$visibleSubComponentsRow->SubLink_ChartID.'">';
					}

					$printData .= '</div>';
					// end of ckEditor/chart div

					// adding the inputField div
					$printData .= '<div class="subComponentDivInputField" style="width:50%; display:inline-block;">'.$visibleSubComponentsRow->input_current.'</div>';
					// end of adding inputField div

					$printData .= '</div>';
					// end of subComponentDiv
				}
			}

			$printData .= "</div>";
			// end of componentDiv
		}

		// echo $printData; exit();

		define(Enterprise_Name, ($gameData->Enterprise_Name)?$gameData->Enterprise_Name:'noVal');
		define(Enterprise_Logo, ($gameData->Enterprise_Logo)?str_replace(' ', '%20', $gameData->Enterprise_Logo):'noVal');
		define(SubEnterprise_Name, ($gameData->SubEnterprise_Name)?$gameData->SubEnterprise_Name:'noVal');
		define(SubEnterprise_Logo, ($gameData->SubEnterprise_Logo)?str_replace(' ', '%20', $gameData->SubEnterprise_Logo):'noVal');
		// echo "<pre>"; print_r($_SERVER); exit();
		// $pathFile = site_root.'chart/donutchart.php?gameid=70&userid=1989&ChartID=127';
		// if(file_exists($pathFile))
		// {
		// 	die('file found <br>'.$pathFile);
		// }
		// else
		// {
		// 	die('not found <br>'.$pathFile);
		// }
		// for downloading pdf file, creating new objects, only if there is one area
		// echo Enterprise_Name.', '.Enterprise_Logo.', '.SubEnterprise_Logo.', '.SubEnterprise_Name; die(' here');
		class MYPDF extends TCPDF
		{
			//Page header
			public function Header()
			{
				// get the current page break margin
				$bMargin = $this->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $this->AutoPageBreak;
				// disable auto-page-break
				$this->SetAutoPageBreak(false, 0);
				// set bacground image
				$img_file = K_PATH_IMAGES.'../../../images/watermark.png';
				$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
				// restore auto-page-break status
				$this->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$this->setPageMark();

        // Enterprise Logo
				// if(Enterprise_Logo != 'noVal')
				// {
				// 	// if there is enterprise logo then only show ent logo
				// 	$image_file = K_PATH_IMAGES.'../../../enterprise/common/Logo/'.Enterprise_Logo;
				// 	$ext        = explode('.',$gameData->Enterprise_Logo);
				// 	$extension  = end($ext);
				// 	$this->Image($image_file, 10, 10, 20, '',$extension, '', 'T', false, 300, '', false, false, 0, false, false, false);
				// }
				// if(Enterprise_Name != 'noVal')
				// {
				// 	// if there is enterprise name then only show the name of enterprise
				// 	$this->Cell(0, 15, Enterprise_Name, 0, false, 'A', 0, '', 0, false, 'T', 'B');
				// }

        // Humanlinks Logo
				$image_file = K_PATH_IMAGES.'../../../images/logo.png';
				$this->Image($image_file, 90, 10, 20, '', 'png', 'https://humanlinks.in/', 'T', false, 300, '', false, false, 0, false, false, false);
				// $this->Cell(0, 15, ' Humanlinks ', 0, false, 'B', 0, 'https://humanlinks.in/', 0, false, 'T', 'B');

        // Sub-Enterprise Logo
				// if(SubEnterprise_Logo != 'noVal')
				// {
				// 	$image_file = K_PATH_IMAGES.'../../../enterprise/common/Logo/'.SubEnterprise_Logo;
				// 	$ext        = explode('.',$gameData->SubEnterprise_Logo);
				// 	$extension  = end($ext);
				// 	$this->Image($image_file, 150, 10, 20, '', $extension, '', 'T', false, 300, '', false, false, 0, false, false, false);
				// }
				// if(SubEnterprise_Name != 'noVal')
				// {
				// 	// if there is subEnterprise name then only show the name of enterprise
				// 	$this->Cell(0, 15, SubEnterprise_Name, 0, false, 'C', 0, '', 0, false, 'T', 'B');
				// }

        // Set font
				$this->SetFont('helvetica', 'B', 20);
			}

		    // Page footer
			public function Footer()
			{
        // Position at 15 mm from bottom
				$this->SetY(-15);
        // Set font
				$this->SetFont('helvetica', 'I', 8);
        // Page number
				$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			}

	    //Page header
			// public function Header()
			// {
        // get the current page break margin
				// $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
				// $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
				// $this->SetAutoPageBreak(false, 0);
        // set bacground image
				// $img_file = site_root.'images/mobileHomePage.png';
				// $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
				// $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
				// $this->setPageMark('show this string mksahu');
			// }
		}

		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Humanlinks');
		$pdf->SetTitle($gameData->Game_Name.' Report');
		$pdf->SetSubject('Simulation Output Report');
		$pdf->SetKeywords('Simulation, Report, Output, Result, Simulation Report');
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// adding first page to show header and user data
		$pdf->AddPage();
		// ---------------------------------------------------------
		$pdf->writeHTML($pageHeader, true, false, false, false, '');

		// adding a second page for game report
		$pdf->AddPage();
		$secondPage = $gameData->Game_ReportSecondPage;
		$pdf->writeHTML($secondPage, true, false, false, false, '');

		// finally adding page to print game result
		$pdf->AddPage();
		$pdf->writeHTML($printData, true, false, false, false, '');

		$outputFileName = $gameData->FullName.'-'.$gameData->Game_Name.'_'.date('d-m-Y').'.pdf';
		// to show this pdf in browser
		$pdf->Output($outputFileName,'I');
		// to download this pdf with the given name
		// $pdf->Output($outputFileName,'D');
		// echo count($area)."<pre><br>".$sqlarea.'<br>'; print_r($area); exit();
	}
	else
	{
		$_SESSION['msg']     = "This game output not available/visible. Please contact admin.";
		$_SESSION['type[0]'] = "inputError";
		$_SESSION['type[1]'] = "has-error";
		header("Location:".site_root."result.php?ID=".$gameid);
		exit();
	}
}
// end of donwloading pdf resutl of o/p for user


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
							'US_LinkID'      => 1,
							'US_CompletedOn' => date('Y-m-d H:i:s')
						);
						$result = $functionsObj->UpdateData ( 'GAME_USERSTATUS', $array, 'US_ID', $userstatusid  );
						// updating the game status to complete above, and now capturing the data of output for feedback/performance
						$leaderboardSql  = "SELECT * FROM GAME_LEADERBOARD WHERE Lead_BelongTo=0 AND Lead_Status=0 AND Lead_GameId=".$gameid." AND Lead_ScenId=".$result1->US_ScenID;
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
$performanceSql  = "SELECT gp.Performance_Id, gp.Performance_Value, gc.Comp_NameAlias, gc.Comp_Name, gp.Performance_CreatedOn, IF((SELECT MAX(Performance_Value) FROM GAME_USER_PERFORMANCE WHERE Performance_GameId=gl.Lead_GameId) > (SELECT MAX(input_current) FROM GAME_INPUT WHERE input_sublinkid = (SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID = (SELECT gln.Link_ID FROM GAME_LINKAGE gln WHERE gln.Link_GameID=gl.Lead_GameId AND gln.Link_ScenarioID=gl.Lead_ScenId) AND gls.SubLink_CompID=gl.Lead_CompId AND gls.SubLink_SubCompID < 1)), (SELECT MAX(Performance_Value) FROM GAME_USER_PERFORMANCE WHERE Performance_GameId=gl.Lead_GameId), (SELECT MAX(input_current) FROM GAME_INPUT WHERE input_sublinkid = (SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID = (SELECT gln.Link_ID FROM GAME_LINKAGE gln WHERE gln.Link_GameID=gl.Lead_GameId AND gln.Link_ScenarioID=gl.Lead_ScenId) AND gls.SubLink_CompID=gl.Lead_CompId AND gls.SubLink_SubCompID < 1))) AS max_value FROM GAME_USER_PERFORMANCE gp LEFT JOIN GAME_LEADERBOARD gl ON gp.Performance_GameId = gl.Lead_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 0 AND gl.Lead_Status = 0 AND gl.Lead_GameId =".$gameid." AND gp.Performance_Delete = 0 AND gp.Performance_UserId =".$userid." ORDER BY gp.Performance_CreatedOn";

// $performanceSql  = "SELECT gp.Performance_Id, gp.Performance_Value, gc.Comp_NameAlias, gc.Comp_Name, gp.Performance_CreatedOn FROM GAME_USER_PERFORMANCE gp LEFT JOIN GAME_LEADERBOARD gl ON gp.Performance_GameId = gl.Lead_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 0 AND gl.Lead_Status = 0 AND gl.Lead_GameId =".$gameid." AND gp.Performance_Delete = 0 AND gp.Performance_UserId =".$userid." ORDER BY gp.Performance_Id";

$performanceData       = $functionsObj->RunQueryFetchObject($performanceSql);
// echo $performanceSql."<br><pre>"; print_r($performanceData); exit();
$performanceGraphTitle = ($performanceData[0]->Comp_NameAlias)?$performanceData[0]->Comp_NameAlias:$performanceData[0]->Comp_Name;
// $overAllBenchmark      = $performanceData[0]->max_value;
// echo $performanceSql; exit();
include_once doc_root.'views/result.php';
