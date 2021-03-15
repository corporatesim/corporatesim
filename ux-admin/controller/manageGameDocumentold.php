<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	echo 'In Submit';
	exit();
	if(!empty($_POST['doctitle']) && !empty($_POST['docname'])){
		$id = base64_decode($_GET['Edit']);
		
		//$Area_Name = strtolower($_POST['Area_Name']);		
		$array = array(
				'GameDoc_GameID'	=>	$id,
				'GameDoc_Title' 	=>	$_POST['doctitle'],
				'GameDoc_Name'		=>	$_POST['docname'],
				'GameDoc_DateTime'	=>	date('Y-m-d H:i:s')
		);
		$result = $functionsObj->InsertData('GAME_GAMEDOCUMENT', $array);
		if($result){
			$_SESSION['msg'] 		= 'Document Added Successfully';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			header("Location:".site_root."ux-admin/ManageGameDocument/edit/".base64_encode($id));
		}
	}else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}
}


if(isset($_GET['Edit']) && $_GET['q'] = "ManageGameDocument"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('GameDoc_GameID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAMEDOCUMENT', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);

}elseif(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);
	$fields = array();
	$where  = array('Comp_AreaID='.$id, "Comp_Delete = 0");
	$obj = $functionsObj->SelectData($fields, 'GAME_COMPONENT', $where, '', '', '', '', 0);
	if($obj->num_rows > 0){
		$msg 		= 'Can not Delete Area! Area not empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}else{		
		$result = $functionsObj->UpdateData('GAME_AREA', array('Area_Delete' => 1), 'Area_ID', $id);
	
		if( $result === true ){
			$_SESSION['msg'] 		= 'Area Deleted';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			
		}
	}
}


$fields = array();
$where  = array('GameDoc_Delete = 0');
$object = $functionsObj->SelectData($fields, 'GAME_GAMEDOCUMENT', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Game/manageGameDocument.php';
?>