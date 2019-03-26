<?php
include_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

if(isset($_POST['submit']) && $_POST['submit'] == 'Login')
{
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
		$username = $functionsObj->EscapeString($_POST['username']);
		$password = md5($_POST['password']);
		$where    = array("BINARY username='".$username."'", "password='".$password."'", "status='1'");
		$object   = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', $where, "", "", "", "", 0);
		
		if($object->num_rows > 0)
		{
			$result = $functionsObj->FetchObject($object);
			if( $result->admin_access == 1 )
			{
				if(isset($_POST['remember']))
				{
					$password_hash = $password;
					setcookie ($cookie_name, 'usr='.$username.'&hash='.$password_hash, time() + $cookie_time);
				}

				//$access_obj = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS_ACCESS', array('uid='.$result->id), "", "", "", "", 0);

				$_SESSION['ux-admin-id']    = $result->id;

				//$_SESSION['admin_access'] = 1;
				$_SESSION['admin_fname']	  = $result->fname;
				$_SESSION['admin_lname']	  = $result->lname;
				$_SESSION['admin_usertype']	= $result->usertype;
				$_SESSION['admin_username']	= $result->username;

				header("Location:".site_root."ux-admin/Dashboard");
				exit();
			}else
			{
				$msg = 'You dont have access to admin panel';
			}
		}
		else
		{
			$msg = 'Wrong Username or Passoword';
		}
	}
	else
	{
		$msg = 'Username & Password can not be empty';
	}
}
include_once doc_root.'ux-admin/view/login.php';
?>