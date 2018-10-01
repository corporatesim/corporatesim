<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	if(!empty($_POST['Area_Name'])){
		$Area_Name = $_POST['Area_Name'];
		$object    = $functionsObj->SelectData(array(), 'GAME_AREA', array("Area_Name ='".$Area_Name."'"), '', '', '');
		if($object->num_rows > 0){
			$msg     = 'Entered area name already present';
			$type[0] = 'inputError';
			$type[1] = 'has-error';
		}else{
			$array = array(
				'Area_Name'            =>	ucfirst($Area_Name),
				'Area_CreateDate'      =>	date('Y-m-d H:i:s'),
				'Area_BackgroundColor' => $_POST['Area_BackgroundColor'],
				'Area_TextColor'       => $_POST['Area_TextColor'],
			);
			$result = $functionsObj->InsertData('GAME_AREA', $array);
			if($result){
				$_SESSION['msg']     = 'Area Added Successfully';
				$_SESSION['type[0]'] = 'inputSuccess';
				$_SESSION['type[1]'] = 'has-success';
				header("Location:".site_root."ux-admin/ManageArea");
			}
		}
	}else{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	if(!empty($_POST['Area_Name'])){
		$Area_Name = $_POST['Area_Name'];
		$Area_ID   = $_POST['id'];
		$object    = $functionsObj->SelectData(array(), 'GAME_AREA', array("Area_Name ='".$Area_Name."'", "Area_ID !=".$Area_ID), '', '', '', '', 0);
		if($object->num_rows > 0){
			$msg     = 'Entered area name already present';
			$type[0] = 'inputError';
			$type[1] = 'has-error';
		}else{
			$array = array(
				'Area_Name'            =>	ucfirst($Area_Name),
				'Area_BackgroundColor' => $_POST['Area_BackgroundColor'],
				'Area_TextColor'       => $_POST['Area_TextColor'],
			);
			//var_dump($array);
			$result = $functionsObj->UpdateData('GAME_AREA', $array, 'Area_ID', $Area_ID);
			if($result){
				$_SESSION['msg']     = 'Area Updated Successfully';
				$_SESSION['type[0]'] = 'inputSuccess';
				$_SESSION['type[1]'] = 'has-success';
				header("Location:".site_root."ux-admin/ManageArea");
			}
		}
	}else{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageArea"){
	$id                   = base64_decode($_GET['Edit']);
	$fields               = array();
	$where                = array('Area_ID='.$id);
	$obj                  = $functionsObj->SelectData($fields, 'GAME_AREA', $where, '', '', '');
	$result               = $functionsObj->FetchObject($obj);
	$Area_BackgroundColor = $result->Area_BackgroundColor;
	$Area_TextColor       = $result->Area_TextColor;

}elseif(isset($_GET['Delete'])){
	$id     = base64_decode($_GET['Delete']);
	$fields = array();
	$where  = array('Comp_AreaID='.$id, "Comp_Delete = 0");
	$obj    = $functionsObj->SelectData($fields, 'GAME_COMPONENT', $where, '', '', '', '', 0);
	if($obj->num_rows > 0){
		$msg     = 'Can not Delete Area! Area not empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}else{		
		//$result = $functionsObj->UpdateData('GAME_AREA', array('Area_Delete' => 1), 'Area_ID', $id);

		$result = $functionsObj->DeleteData('GAME_AREA','Area_ID',$id,0);
		
		//if( $result === true ){
		$_SESSION['msg']     = 'Area Deleted';
		$_SESSION['type[0]'] = 'inputSuccess';
		$_SESSION['type[1]'] = 'has-success';
		header("Location:".site_root."ux-admin/ManageArea");
		//}
	}
}

$fields = array();
$where  = array('Area_Delete = 0');
$object = $functionsObj->SelectData($fields, 'GAME_AREA', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/manageArea.php';
?>