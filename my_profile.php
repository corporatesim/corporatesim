<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

//echo $_SESSION['userid'];
//echo $_SESSION['username'];

//exit();
// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
$functionsObj         = new Functions();
$_SESSION['userpage'] = 'profile';

$uid                  = $_SESSION['userid'];
	//base64_decode($_GET['edit']);
$object               = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
$userdetails          = $functionsObj->FetchObject($object);
	//$url = site_root."ux-admin/index?q=siteusers";

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
//	echo $_POST['fname'];
//	echo $_POST['lname'];
//	echo $_POST['mobile'];
//	echo $_POST['email'];
//	exit();
	$updateArray = array(
		'User_fname'         =>	$_POST['fname'],
		'User_lname'         =>	$_POST['lname'],
		'User_mobile'        =>	$_POST['mobile'],			
		'User_profile_video' =>	base64_encode($_POST['User_profile_video']),			
	);	
	// echo "<pre>"; print_r($updateArray); print_r($_FILES); exit;

	if(!empty($_POST['fname']) && !empty($_POST['lname'])  && !empty($_POST['mobile']))
	{
		$error = array();
		// if user_profile_pic or user_resume is not empty
		if(!empty($_FILES))
		{
			if(($_FILES['User_profile_pic']['error'] > 0 && $_FILES['User_profile_pic']['error'] != 4) || ($_FILES['User_Resume']['error'] > 0 && $_FILES['User_Resume']['error'] != 4))
			{
				if(($_FILES['User_profile_pic']['error'] > 0 && $_FILES['User_profile_pic']['error'] != 4))
				{
					$errorCode = $_FILES['User_profile_pic']['error'];
				}
				else
				{
					$errorCode = $_FILES['User_Resume']['error'];
				}
				// some error with the file upload
				switch($errorCode)
				{
					case 1:
					$error[] = 'The uploaded file exceeds the file size limit. ';
					break;

					case 2:
					$error[] = 'The uploaded file exceeds the MAX_FILE_SIZE. Limit is 2MB. ';
					break;

					case 3:
					$error[] = 'The uploaded file was only partially uploaded. ';
					break;

					case 4:
					$error[] = 'No file was uploaded. ';
					break;

					case 5:
					$error[] = 'Missing a temporary folder. ';
					break;

					case 6:
					$error[] = 'Failed to write file to disk. ';
					break;

					case 7:
					$error[] = 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop. ';
					break;
				}
				$msg     = implode(',',$error);
				$type[0] = "inputError";
				$type[1] = "has-error";
				// echo "<pre>"; print_r($_FILES); echo $msg; exit();
			}
			else
			{
				// if no error then upload the file to the specific folders
				if(!empty($_FILES['User_Resume']['name']))
				{
					$fileName                   = $_FILES['User_Resume']['name'];
					$updateArray['User_Resume'] = $fileName;
					$tmp                        = $_FILES['User_Resume']['tmp_name'];
					$moveResume = move_uploaded_file($tmp, 'images/userResume/'.$fileName);
				}
				if(!empty($_FILES['User_profile_pic']['name']))
				{
					$fileName                        = $_FILES['User_profile_pic']['name'];
					$updateArray['User_profile_pic'] = $fileName;
					$tmp                             = $_FILES['User_profile_pic']['tmp_name'];
					$moveProfile = move_uploaded_file($tmp, 'images/userProfile/'.$fileName);
				}
			}
		}

		$userdetails = (object)$updateArray;
		// echo "<pre>"; print_r($userdetails); die($_POST['id']);

		$uid   = $_POST['id'];
		$where = array(
			"(`User_email` ='".$userdetails->User_email."'
			OR `User_mobile` ='".$userdetails->User_mobile."')",
			"User_id != ". $uid
		);
		$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);

		if($object->num_rows > 0){
			$msg     = "Email address or mobile number already registered";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
		else
		{
			$result = $functionsObj->UpdateData('GAME_SITE_USERS', $userdetails, 'User_id', $uid, 0);
			if($result === true){
				$_SESSION['msg']     = "User details updated successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				//$msg = "User details updated successfully";
				//$type[0] = "inputSuccess";
				//$type[1] = "has-success";
				header("Location: ".site_root."my_profile.php");
				exit(0);
			}
			else
			{
				// die($msg);
				$msg     = "Error: ".$result;
				$type[0] = "inputError";
				$type[1] = "has-error";
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
if(empty($msg))
{
	$msg  = $_SESSION['msg'];
}
if(empty($type))
{
	$type = $_SESSION['type'];
}
unset($_SESSION['msg']);
unset($_SESSION['type']);
include_once doc_root.'views/my_profile.php';
