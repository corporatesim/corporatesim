<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
$functionsObj = new Model();

// $object  = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_datetime DESC', '', '', '', 0);
// $file    = 'GameList.php';

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{	
	// echo "<pre>"; print_r($_POST); exit();
	$Game_Introduction     = ($_POST['Game_Introduction'])?$_POST['Game_Introduction']:0;
	$Game_Description      = ($_POST['Game_Description'])?$_POST['Game_Description']:0;
	$Game_IntroductionLink = ($_POST['Game_IntroductionLink'])?$_POST['Game_IntroductionLink']:0;
	$Game_DescriptionLink  = ($_POST['Game_DescriptionLink'])?$_POST['Game_DescriptionLink']:0;
	$Game_BackToIntro      = ($_POST['Game_BackToIntro'])?$_POST['Game_BackToIntro']:0;
	$Game_HideScenarioLink = ($_POST['Game_HideScenarioLink'])?$_POST['Game_HideScenarioLink']:0;

	if(strpos(trim($_POST['Game_Category']), trim('Mobile')) !== false)
	{
		// if mobile category consist of mobile then make this game bot-enabled
		$_POST['Game_Type'] = 1;
	}
	// echo "<pre>"; print_r($_POST); exit();

	$gamedetails = (object) array(
		'Game_Name'              => $_POST['name'],
		'Game_Comments'          => $_POST['comments'],
		'Game_Message'           => $_POST['message'],
		'Game_ReportFirstPage'   => $_POST['Game_ReportFirstPage'],
		'Game_LeaderboardButton' => $_POST['Game_LeaderboardButton'],
		'Game_ReportButton'      => $_POST['Game_ReportButton'],
		'Game_ReportSecondPage'  => $_POST['Game_ReportSecondPage'],
		'Game_Header'            => $_POST['Game_Header'],
		'Game_shortDescription'  => $_POST['Game_shortDescription'],
		'Game_longDescription'   => $_POST['Game_longDescription'],
		'Game_prise'             => $_POST['Game_prize'],
		'Game_discount'          => $_POST['Game_discount'],
		'Game_Datetime'          => date('Y-m-d H:i:s'),
		'Game_Status'            => (isset($_POST['Game_Status']))?$_POST['Game_Status']:0,
		'Game_Elearning'         => $_POST['eLearning'],
		'Game_Type'              => (isset($_POST['Game_Type']))?$_POST['Game_Type']:0,
		'Game_Category'          => $_POST['Game_Category'],
		'Game_Introduction'      => $Game_Introduction,
		'Game_Description'       => $Game_Description,
		'Game_IntroductionLink'  => $Game_IntroductionLink,
		'Game_DescriptionLink'   => $Game_DescriptionLink,
		'Game_BackToIntro'       => $Game_BackToIntro,
		'Game_HideScenarioLink'  => $Game_HideScenarioLink,
		'Game_CreatedBy'         => $_SESSION['ux-admin-id'],
		'Game_Associates'        => $_POST['Game_Associates'],
	);
	
	if( !empty($_POST['name']) && !empty($_POST['comments']))
	{
		// if there is file in the form
		if(!empty($_FILES['Game_Image']['name']))
		{
			// echo "<pre>"; print_r($_POST); print_r($_FILES['Game_Image']); exit();
			if($_FILES['Game_Image']['error']>1)
			{
				$error = $_FILES['Game_Image']['error'];
				switch ($error) {
					case 1:
					$_SESSION['msg'] = 'The uploaded file exceeds the file size';
					break;

					case 2:
					$_SESSION['msg'] = 'The uploaded file exceeds the MAX_FILE_SIZE';
					break;

					case 3:
					$_SESSION['msg'] = 'The uploaded file was only partially uploaded';
					break;

					case 4:
					$_SESSION['msg'] = 'No file was uploaded';
					break;

					default:
					$_SESSION['msg'] = 'File Not Found, Please Choose Another File';
					break;
				}
				$_SESSION['type[0]'] = "inputError";
				$_SESSION['type[1]'] = "has-error";
				header("Location: ".site_root."ux-admin/ManageGame/add/1");
				exit(0);
			}
			$fileName          = $_FILES['Game_Image']['name'];
			$allowedExtensions = ['jpg','jpeg','png','gif'];
			$ext               = explode('.',$fileName);
			$fileExtension     = strtolower(end($ext));
			if(!in_array($fileExtension,$allowedExtensions))
			{
				$_SESSION['msg']     = 'Only jpg, jpeg, and png file type are allowed';
				$_SESSION['type[0]'] = "inputError";
				$_SESSION['type[1]'] = "has-error";
				header("Location: ".site_root."ux-admin/ManageGame/add/1");
				exit(0);
			}
			$moveFile = move_uploaded_file($_FILES["Game_Image"]["tmp_name"],doc_root.'images/'.$fileName);
			if($moveFile)
			{
				$gamedetails->Game_Image = $fileName;
				// echo "<pre>"; print_r($gamedetails); exit;
				$result                  = $functionsObj->InsertData('GAME_GAME', $gamedetails, 0, 0);
				if($result)
				{
					$uid                 = $functionsObj->InsertID();
					$_SESSION['msg']     = "Game created successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location: ".site_root."ux-admin/ManageGame");
					exit(0);

				}
				else
				{
					$msg     = "Error: ".$result;
					$type[0] = "inputError";
					$type[1] = "has-error";
					header("Location: ".site_root."ux-admin/ManageGame");
					exit(0);
				}
			}
			else
			{
				$_SESSION['msg']     = 'Path Not Found';
				$_SESSION['type[0]'] = "inputError";
				$_SESSION['type[1]'] = "has-error";
				header("Location: ".site_root."ux-admin/ManageGame/add/1");
				exit(0);
			}
		}
		// if no file then as it is
		// echo "<pre>"; print_r($gamedetails); exit;
		$result = $functionsObj->InsertData('GAME_GAME', $gamedetails, 0, 0);
		if($result)
		{
			$uid                 = $functionsObj->InsertID();
			$_SESSION['msg']     = "Game created successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageGame");
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	// echo "<pre>"; print_r($_POST); exit();
	// if game is bot enabled then check that this doesn't contains multiple areas in i/p side and doesn't have any subcomponent
	if(isset($_POST['Game_Type']) || (strpos(trim($_POST['Game_Category']), trim('Mobile')) !== false))
	{
		$checkSql = "SELECT * FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID =".$_POST['id']." ) AND SubLink_Status=1 ORDER BY SubLink_SubCompID DESC, SubLink_AreaID";

		$checkSqlObj = $functionsObj->ExecuteQuery($checkSql);

		if($checkSqlObj->num_rows > 0)
		{
			$areaID = '';
			$linkID = '';

			while($row = $checkSqlObj->fetch_object())
			{
				if($row->SubLink_SubCompID > 1)
				{
					$_SESSION['msg']     = 'This game can not be converted to Mobile Category. Because this is having subcomponents';
					$_SESSION['type[0]'] = "inputError";
					$_SESSION['type[1]'] = "has-error";
					header("Location: ".site_root."ux-admin/ManageGame/edit/".base64_encode($_POST['id']));
					exit(0);
				}
				else
				{
					if($row->SubLink_Type == 0)
					{
						$tmpLinkId = $linkID;
						$tmpAreaId = $areaID;
						$linkID    = $row->SubLink_LinkID;
						$areaID    = $row->SubLink_AreaID;

						if($tmpAreaId != $areaID && $tmpLinkId == $linkID)
						{
							$_SESSION['msg']     = 'This game can not be converted to Mobile Category. Because this is having multiple areas in input side';
							$_SESSION['type[0]'] = "inputError";
							$_SESSION['type[1]'] = "has-error";
							header("Location: ".site_root."ux-admin/ManageGame/edit/".base64_encode($_POST['id']));
							exit(0);
						}
					}
				}
			}
		}
	}

	$Game_Introduction     = ($_POST['Game_Introduction'])?$_POST['Game_Introduction']:0;
	$Game_Description      = ($_POST['Game_Description'])?$_POST['Game_Description']:0;
	$Game_IntroductionLink = ($_POST['Game_IntroductionLink'])?$_POST['Game_IntroductionLink']:0;
	$Game_DescriptionLink  = ($_POST['Game_DescriptionLink'])?$_POST['Game_DescriptionLink']:0;
	$Game_BackToIntro      = ($_POST['Game_BackToIntro'])?$_POST['Game_BackToIntro']:0;
	$Game_HideScenarioLink = ($_POST['Game_HideScenarioLink'])?$_POST['Game_HideScenarioLink']:0;

	if(strpos(trim($_POST['Game_Category']), trim('Mobile')) !== false)
	{
		// if mobile category consist of mobile then make this game bot-enabled
		$_POST['Game_Type'] = 1;
	}
	// echo "<pre>"; print_r($_POST); exit();

	$gamedetails = (object) array(
		'Game_Name'              => $_POST['name'],
		'Game_Comments'          => $_POST['comments'],
		'Game_Header'            => $_POST['Game_Header'],
		'Game_Message'           => $_POST['message'],
		'Game_ReportFirstPage'   => $_POST['Game_ReportFirstPage'],
		'Game_LeaderboardButton' => $_POST['Game_LeaderboardButton'],
		'Game_ReportButton'      => $_POST['Game_ReportButton'],
		'Game_ReportSecondPage'  => $_POST['Game_ReportSecondPage'],
		'Game_shortDescription'  => $_POST['Game_shortDescription'],
		'Game_longDescription'   => $_POST['Game_longDescription'],
		'Game_prise'             => $_POST['Game_prize'],
		'Game_discount'          => $_POST['Game_discount'],
		'Game_Status'            => (isset($_POST['Game_Status']))?$_POST['Game_Status']:0,
		'Game_Elearning'         => $_POST['eLearning'],
		'Game_Type'              => (isset($_POST['Game_Type']))?$_POST['Game_Type']:0,
		'Game_Category'          => $_POST['Game_Category'],
		'Game_Introduction'      => $Game_Introduction,
		'Game_Description'       => $Game_Description,
		'Game_IntroductionLink'  => $Game_IntroductionLink,
		'Game_DescriptionLink'   => $Game_DescriptionLink,
		'Game_BackToIntro'       => $Game_BackToIntro,
		'Game_HideScenarioLink'  => $Game_HideScenarioLink,
		'Game_UpdatedBy'         => $_SESSION['ux-admin-id'],
		'Game_UpdatedOn'         => date('Y-m-d H:i:s'),
		'Game_Associates'        => $_POST['Game_Associates'],
	);

	// echo "<pre>"; print_r($_POST); print_r($gamedetails); exit();
	if( !empty($_POST['name']) && !empty($_POST['comments']) )
	{
		$uid = $_POST['id'];
		// if there is file in the form
		if(!empty($_FILES['Game_Image']['name']))
		{
			// echo "<pre>"; print_r($_POST); print_r($_FILES['Game_Image']); exit();
			if($_FILES['Game_Image']['error']>1)
			{
				$error = $_FILES['Game_Image']['error'];
				switch ($error) {
					case 1:
					$_SESSION['msg'] = 'The uploaded file exceeds the file size';
					break;

					case 2:
					$_SESSION['msg'] = 'The uploaded file exceeds the MAX_FILE_SIZE';
					break;

					case 3:
					$_SESSION['msg'] = 'The uploaded file was only partially uploaded';
					break;

					case 4:
					$_SESSION['msg'] = 'No file was uploaded';
					break;

					default:
					$_SESSION['msg'] = 'File Not Found, Please Choose Another File';
					break;
				}
				$_SESSION['type[0]'] = "inputError";
				$_SESSION['type[1]'] = "has-error";
				header("Location: ".site_root."ux-admin/ManageGame/add/1");
				exit(0);
			}
			$fileName          = $_FILES['Game_Image']['name'];
			$allowedExtensions = ['jpg','jpeg','png','gif'];
			$ext               = explode('.',$fileName);
			$fileExtension     = strtolower(end($ext));
			if(!in_array($fileExtension,$allowedExtensions))
			{
				$_SESSION['msg']     = 'Only jpg, jpeg, and png file type are allowed';
				$_SESSION['type[0]'] = "inputError";
				$_SESSION['type[1]'] = "has-error";
				header("Location: ".site_root."ux-admin/ManageGame/add/1");
				exit(0);
			}
			$moveFile = move_uploaded_file($_FILES["Game_Image"]["tmp_name"],doc_root.'images/'.$fileName);
			if($moveFile)
			{
				$gamedetails->Game_Image = $fileName;
				// echo "<pre>"; print_r($gamedetails); exit;
				$result                  = $functionsObj->UpdateData('GAME_GAME', $gamedetails, 'Game_ID', $uid, 0);
				if($result)
				{
					$uid                 = $uid;
					$_SESSION['msg']     = "Game updated successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location: ".site_root."ux-admin/ManageGame");
					exit(0);

				}
				else
				{
					$msg     = "Error: ".$result;
					$type[0] = "inputError";
					$type[1] = "has-error";
					header("Location: ".site_root."ux-admin/ManageGame");
					exit(0);
				}
			}
			else
			{
				$_SESSION['msg']     = 'Path Not Found';
				$_SESSION['type[0]'] = "inputError";
				$_SESSION['type[1]'] = "has-error";
				header("Location: ".site_root."ux-admin/ManageGame/add/1");
				exit(0);
			}
		}

		$result = $functionsObj->UpdateData('GAME_GAME', $gamedetails, 'Game_ID', $uid, 0);

		$updateLinkageSql = "UPDATE GAME_LINKAGE SET Link_Introduction=".$Game_Introduction.", Link_Description=".$Game_Description.", Link_IntroductionLink=".$Game_IntroductionLink.", Link_DescriptionLink=".$Game_DescriptionLink.", Link_BackToIntro=".$Game_BackToIntro." WHERE Link_GameID=".$uid;
		$functionsObj->ExecuteQuery($updateLinkageSql);

		if($result === true)
		{
			$_SESSION['msg']     = "Game updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageGame");
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}		
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

// Edit Siteuser
if(isset($_GET['edit']))
{
	$header      = 'Edit Game';
	$uid         = base64_decode($_GET['edit']);
	$object      = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_ID='.$uid), '', '', '', '', 0);
	$gamedetails = $functionsObj->FetchObject($object);
	$userSql     = "SELECT * FROM GAME_ADMINUSERS WHERE id != ".$gamedetails->Game_CreatedBy." AND status=1";
	$userObj     = $functionsObj->RunQueryFetchObject($userSql);
	//print_r($gamedetails);exit;
	$url         = site_root."ux-admin/ManageGame";
	$file        = 'addeditGame.php';
	if(isset($_GET['tab']))
	{
		$tabid = base64_decode($_GET['tab']);
		switch($_GET['tab']){
			case '1':
			$file = 'GameDocument.php';
			break;
		}
	}	

}
elseif(isset($_GET['add']))
{
	// Add Siteuser
	$userSql = "SELECT * FROM GAME_ADMINUSERS WHERE id != ".$_SESSION['ux-admin-id']." AND status=1";
	$userObj = $functionsObj->RunQueryFetchObject($userSql);
	$header  = 'Add Game';
	$url     = site_root."ux-admin/ManageGame";	
	$file    = 'addeditGame.php';
}
elseif(isset($_GET['del']))
{
	// Delete Siteuser
	$id      = base64_decode($_GET['del']);
	
	$sql     = "SELECT s.Scen_Name as Scen FROM `GAME_LINKAGE` INNER JOIN GAME_SCENARIO s on link_ScenarioID = s.Scen_ID WHERE Link_GameID=".$id;
	$sublink = $functionsObj->ExecuteQuery($sql);

	if($sublink->num_rows > 0)
	{
		while($row = $sublink->fetch_object())
		{
			$strresult = $strresult." '".$row->Scen."', ";
		}
		$_SESSION['msg']     = 'Can not Delete Game. Is linked with '.trim($strresult, ', ');
		$_SESSION['type[0]'] = 'inputError';
		$_SESSION['type[1]'] = 'has-error';		
		header("Location: ".site_root."ux-admin/ManageGame");
		exit(0);
	}
	else
	{
		$result = $functionsObj->DeleteData('GAME_GAME','Game_ID',$id,0);

		//$result = $functionsObj->UpdateData('GAME_GAME', array( 'Game_Delete' => 1 ), 'Game_ID', $id, 0);
		//if($result === true){
		$_SESSION['msg']     = "Game Deleted";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";

		header("Location: ".site_root."ux-admin/ManageGame");
		exit(0);
		//}else{
		//	$msg = "Error: ".$result;
		//	$type[0] = "inputError";
		//	$type[1] = "has-error";
		//}
	}
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_ID='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->Game_Delete < 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_GAME', array('Game_Delete'=> 1), 'Game_ID', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_GAME', array('Game_Delete'=> 0), 'Game_ID', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "Game ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/ManageGame");
		exit(0);
	}
	else
	{
		$msg     = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}
else
{
	// fetch siteuser list from db
	// $object = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_datetime DESC', '', '', '', 0);
	$gameSql = "SELECT ( SELECT COUNT(*) FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gg.Game_ID ) AS ScenarioCount, gg.*, CONCAT( ga.fname, ' ', ga.lname, ', ', ga.email ) AS nameEmail, CONCAT(ga.fname, ' ', ga.lname) AS NAME FROM GAME_GAME gg LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gg.Game_CreatedBy WHERE Game_Delete = 0 ORDER BY Game_datetime DESC";
	// echo '<pre>'.$gameSql; print_r($_SESSION);
	$object  = $functionsObj->ExecuteQuery($gameSql);
	$file    = 'GameList.php';
}

//download Game in excelsheet..
if(isset($_POST['download_excel']) && $_POST['download_excel'] == 'Download'){

	$from     =  $_POST['fromdate'];
	$end      =  $_POST['enddate'];
	$fromdate = date('Y-m-d', strtotime($from));
	$enddate  = date('Y-m-d', strtotime($end));
	//echo $fromdate;exit;

	//echo "<pre>";print_r($_POST);exit;
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Game');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Game');
	$objSheet->getCell('B1')->setValue('Game');
	
	if($from == '' && $end == '')
	//if($enddate>$fromdate)
	{
		$sql = "SELECT Game_Name,Game_Elearning FROM GAME_GAME";
		//echo "error";
	}
	else
	{
		$sql = "SELECT Game_Name,Game_Elearning FROM GAME_GAME WHERE Game_Datetime BETWEEN '$fromdate' AND '$enddate'";
	}
	
	//echo $sql;exit;	

	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row = $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			if($row->Game_Elearning == 1)
			{
				$objSheet->getCell('B'.$i)->setValue($row->Game_Name." (eLearning)");
			}
			else
			{
				$objSheet->getCell('B'.$i)->setValue($row->Game_Name);
			}
			$i++;
		}
	}
	
	//$objPHPExcel->
	
	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	

	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('J1:J100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('K1:K100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="game.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
	
}

include_once doc_root.'ux-admin/view/Game/'.$file;