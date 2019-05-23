<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$object = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_datetime DESC', '', '', '', 0);
$file   = 'GameList.php';

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	if(isset($_POST['Game_Status']))
	{
		$Game_Status = $_POST['Game_Status'];
	}
	else
	{
		$Game_Status = 0;
	}
	$Game_Introduction     = ($_POST['Game_Introduction'])?$_POST['Game_Introduction']:0;
	$Game_Description      = ($_POST['Game_Description'])?$_POST['Game_Description']:0;
	$Game_IntroductionLink = ($_POST['Game_IntroductionLink'])?$_POST['Game_IntroductionLink']:0;
	$Game_DescriptionLink  = ($_POST['Game_DescriptionLink'])?$_POST['Game_DescriptionLink']:0;
	$Game_BackToIntro      = ($_POST['Game_BackToIntro'])?$_POST['Game_BackToIntro']:0;
	$gamedetails           = (object) array(
		'Game_Name'             => $_POST['name'],
		'Game_Comments'         => $_POST['comments'],
		'Game_Message'          => $_POST['message'],
		'Game_Header'           => $_POST['Game_Header'],
		'Game_shortDescription' => $_POST['Game_shortDescription'],
		'Game_longDescription'  => $_POST['Game_longDescription'],
		'Game_prise'            => $_POST['Game_prize'],
		'Game_discount'         => $_POST['Game_discount'],
		'Game_Datetime'         => date('Y-m-d H:i:s'),
		'Game_Status'           => $Game_Status,
		'Game_Elearning'        => $_POST['eLearning'],
		'Game_Introduction'     => $Game_Introduction,
		'Game_Description'      => $Game_Description,
		'Game_IntroductionLink' => $Game_IntroductionLink,
		'Game_DescriptionLink'  => $Game_DescriptionLink,
		'Game_BackToIntro'      => $Game_BackToIntro,
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
	$Game_Introduction     = ($_POST['Game_Introduction'])?$_POST['Game_Introduction']:0;
	$Game_Description      = ($_POST['Game_Description'])?$_POST['Game_Description']:0;
	$Game_IntroductionLink = ($_POST['Game_IntroductionLink'])?$_POST['Game_IntroductionLink']:0;
	$Game_DescriptionLink  = ($_POST['Game_DescriptionLink'])?$_POST['Game_DescriptionLink']:0;
	$Game_BackToIntro      = ($_POST['Game_BackToIntro'])?$_POST['Game_BackToIntro']:0;
	$gamedetails = (object) array(
		'Game_Name'             => $_POST['name'],
		'Game_Comments'         => $_POST['comments'],
		'Game_Header'           => $_POST['Game_Header'],
		'Game_Message'          => $_POST['message'],
		'Game_Datetime'         => date('Y-m-d H:i:s'),
		'Game_Status'           => 1,
		'Game_Elearning'        => $_POST['eLearning'],
		'Game_Introduction'     => $Game_Introduction,
		'Game_Description'      => $Game_Description,
		'Game_IntroductionLink' => $Game_IntroductionLink,
		'Game_DescriptionLink'  => $Game_DescriptionLink,
		'Game_BackToIntro'      => $Game_BackToIntro,
	);

// echo "<pre>"; print_r($_POST); print_r($gamedetails); exit();
	if( !empty($_POST['name']) && !empty($_POST['comments']) )
	{
		$uid    = $_POST['id'];
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
	$header = 'Add Game';
	$url    = site_root."ux-admin/ManageGame";	
	$file   = 'addeditGame.php';
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
			$strresult = $strresult." '".$row->Scen."' ";
		}
		$msg     = 'Cannot Delete Game. Is linked with '.$strresult;
		$type[0] = 'inputError';
		$type[1] = 'has-error';		
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
	
	if($details->Game_Status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_GAME', array('Game_Status'=> 0), 'Game_ID', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_GAME', array('Game_Status'=> 1), 'Game_ID', $id, 0);
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
	$object = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_datetime DESC', '', '', '', 0);
	$file   = 'GameList.php';
}

include_once doc_root.'ux-admin/view/Game/'.$file;