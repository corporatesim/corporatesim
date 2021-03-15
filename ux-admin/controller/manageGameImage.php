<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

//echo 'in file';
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$id = base64_decode($_GET['Edit']);
	//echo $_POST['gameid'];
	//exit();
	if(isset($_FILES['imgname'])){
		$errors= array();
		$file_name = $_FILES['imgname']['name'];
		$file_size =$_FILES['imgname']['size'];
		$file_tmp =$_FILES['imgname']['tmp_name'];
		$file_type=$_FILES['imgname']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['imgname']['name'])));
		
		$expensions= array("jpeg","jpg","png");
      
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}		
		
		if(empty($errors)==true){
			if(!empty($_POST['imgtitle']) && !empty($_POST['imgcomments']) && !empty($file_name)){
				$array = array(
						'GameImg_GameID'	=>	$_POST['gameid'],
						'GameImg_Title'		=>	$_POST['imgtitle'],
						'GameImg_Name'		=> 	$file_name,
						'GameImg_Comments'	=>	$_POST['imgcomments'],
						'GameImg_DateTime'	=>	date('Y-m-d H:i:s')
				);
				move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);		
				$result = $functionsObj->InsertData('GAME_GAMEIMAGE', $array);
				if($result){
					$_SESSION['msg'] 		= 'Image Added Successfully';
					$_SESSION['type[0]']	= 'inputSuccess';
					$_SESSION['type[1]']	= 'has-success';
					header("Location:".site_root."ux-admin/ManageGameImage/Edit/".base64_encode($id));
				}
			}
			else{
				$msg 		= 'Field cannot be empty';
				$type[0]	= 'inputError';
				$type[1]	= 'has-error';
			}
		}
		else{
			$msg 		= $errors;
			$type[0]	= 'inputError';
			$type[1]	= 'has-error';
		}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}
	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	if(isset($_FILES['imgname'])){
		$errors= array();
		$file_name = $_FILES['imgname']['name'];
		$file_size =$_FILES['imgname']['size'];
		$file_tmp =$_FILES['imgname']['tmp_name'];
		$file_type=$_FILES['imgname']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['imgname']['name'])));
		
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}
	}	
	
	if(!empty($_POST['imgtitle']) && !empty($_POST['imgcomments'])){
			if(empty($errors)==true && !empty($file_name)){			
				$array = array(
						'GameImg_Title'		=>	$_POST['imgtitle'],
						'GameImg_Name'		=> 	$file_name,
						'GameImg_Comments'	=>	$_POST['imgcomments']
				);		
				move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);
			}else{
				$array = array(
						'GameImg_Title'		=>	$_POST['imgtitle'],
						'GameImg_Comments'	=>	$_POST['imgcomments']
				);
			}
			$result = $functionsObj->UpdateData('GAME_GAMEIMAGE', $array, 'GameImg_ID', $docid);
			if($result){
				$_SESSION['msg'] 		= 'Image Updated Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageGameImage/Edit/".base64_encode($id));
			}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageGameImage"){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	//echo $docid;
	//exit();
	$fields = array();
	$where  = array('GameImg_ID='.$docid);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAMEIMAGE', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
	//var_dump($result);
	//echo $resultdoc->GameDoc_Title; 
	//exit();
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageGameImage"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Game_ID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAME', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);

	$object = $functionsObj->SelectData(array(), 'GAME_GAMEIMAGE', array("GameImg_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$gameid = $result->GameImg_GameID;
	}
	
	$result = $functionsObj->UpdateData('GAME_GAMEIMAGE', array('GameImg_Delete' => 1), 'GameImg_ID', $id);
	
		if( $result === true ){
			$_SESSION['msg'] 		= 'Image Deleted';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';			
			header("Location:".site_root."ux-admin/ManageGameImage/Edit/".base64_encode($gameid));
		}
	}

$id = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('GameImg_Delete = 0','GameImg_GameID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_GAMEIMAGE', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Game/manageGameImage.php';
?>