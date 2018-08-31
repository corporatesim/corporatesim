<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

//echo 'in file';
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$id = base64_decode($_GET['Edit']);
	//echo $_POST['scenid'];
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
						'ScenImg_ScenID'	=>	$_POST['scenid'],
						'ScenImg_Title'		=>	$_POST['imgtitle'],
						'ScenImg_Name'		=> 	$file_name,
						'ScenImg_Comments'	=>	$_POST['imgcomments'],
						'ScenImg_DateTime'	=>	date('Y-m-d H:i:s')
				);
				move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);		
				$result = $functionsObj->InsertData('GAME_SCENIMAGE', $array);
				if($result){
					$_SESSION['msg'] 		= 'Image Added Successfully';
					$_SESSION['type[0]']	= 'inputSuccess';
					$_SESSION['type[1]']	= 'has-success';
					header("Location:".site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($id));
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
						'ScenImg_Title'		=>	$_POST['imgtitle'],
						'ScenImg_Name'		=> 	$file_name,
						'ScenImg_Comments'	=>	$_POST['imgcomments']
				);		
				move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);
			}else{
				$array = array(
						'ScenImg_Title'		=>	$_POST['imgtitle'],
						'ScenImg_Comments'	=>	$_POST['imgcomments']
				);
			}
			$result = $functionsObj->UpdateData('GAME_SCENIMAGE', $array, 'ScenImg_ID', $docid);
			if($result){
				$_SESSION['msg'] 		= 'Image Updated Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($id));
			}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageScenarioImage"){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	//echo $docid;
	//exit();
	$fields = array();
	$where  = array('ScenImg_ID='.$docid);
	$obj = $functionsObj->SelectData($fields, 'GAME_SCENIMAGE', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
	//var_dump($result);
	//echo $resultdoc->ScenDoc_Title; 
	//exit();
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageScenarioImage"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Scen_ID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_SCENARIO', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);

	$object = $functionsObj->SelectData(array(), 'GAME_SCENIMAGE', array("ScenImg_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$scenid = $result->ScenImg_ScenID;
	}
	
	$result = $functionsObj->UpdateData('GAME_SCENIMAGE', array('ScenImg_Delete' => 1), 'ScenImg_ID', $id);
	
		if( $result === true ){
			$_SESSION['msg'] 		= 'Image Deleted';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			header("Location:".site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($scenid));
		}
	}

$id = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('ScenImg_Delete = 0','ScenImg_ScenID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_SCENIMAGE', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Scenario/manageScenarioImage.php';
?>