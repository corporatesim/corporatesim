<?php
require_once doc_root.'ux-admin/model/model.php';

$functionsObj = new Model();

// Add Sub category
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	if(!empty($_POST['area_id']) && !empty($_POST['comp_id']) && !empty($_POST['SubComp_Name'])){
		$object = $functionsObj->SelectData ( array (), 'GAME_SUBCOMPONENT', array (
				'SubComp_AreaID=' . $_POST['area_id'],
				'SubComp_CompID=' . $_POST['comp_id'],
				"SubComp_Name='" .$_POST['SubComp_Name']. "'"
		), '', '', '', '', 0 );
		if ($object->num_rows > 0) {
			$msg = 'Entered SubComponent name already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else {		
			$array = array(
					'subcomp_areaid'		=> $_POST['area_id'],
					'subcomp_compid'	=> $_POST['comp_id'],
					'subcomp_name' => $_POST['SubComp_Name'],
					'subcomp_date' => date('Y-m-d H:i:s')
			);
			
			// Insert Values in db
			$result = $functionsObj->InsertData('GAME_SUBCOMPONENT', $array, 0, 0);
			if($result){
				// Display Success Message
				$_SESSION['msg'] 		= 'SubComponent Added Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				// Redirect to url
				header("Location:".site_root."ux-admin/ManageSubComponent");
				exit(0);
			}
		}
	}else{
		// Display Error Message
		$msg 		= 'Please fill all fields';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}
}

// Update Sub Category
if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	if(!empty($_POST['area_id']) && !empty($_POST['comp_id']) && !empty($_POST['SubComp_Name'])){
		$SubComp_ID = $_POST['SubComp_ID'];
		$array = array(
				'subcomp_areaid'		=> $_POST['area_id'],
				'subcomp_compid'	=> $_POST['comp_id'],
				'subcomp_name' => $_POST['SubComp_Name']
		);
		$result = $functionsObj->UpdateData('GAME_SUBCOMPONENT', $array, 'SubComp_ID', $SubComp_ID, 0);
		if( $result === true ){
			$_SESSION['msg'] 		= 'Sub Component Updated Successfully';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			header("Location:".site_root."ux-admin/ManageSubComponent");
			exit(0);
		}
	}else{
		$msg 		= 'Field can not be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}
}

// Edit Sub category
if(isset($_GET['Edit']) && $_GET['q'] = "ManageSubComponent"){
	$SubComp_ID = base64_decode($_GET['Edit']);
	
	$where  = array('SubComp_ID='.$SubComp_ID);
	$obj = $functionsObj->SelectData(array(), 'GAME_SUBCOMPONENT', $where, '', '', '', '', 0);
	$result = $functionsObj->FetchObject($obj);
	
	$component = $functionsObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_AreaID='.$result->SubComp_AreaID), '', '', '', '', 0);
}

// Delete Subcategory
if(isset($_GET['del'])){
	$SubComp_ID = base64_decode($_GET['del']);
	
	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_SubCompID='.$SubComp_ID), '', '', '', '', 0);
	
	if($object->num_rows > 0){
		//$result = $functionsObj->FetchObject($object);
		$sql="SELECT g.Game_Name as Game, s.Scen_Name as Scenario 
				FROM `GAME_LINKAGE` l INNER JOIN GAME_GAME g on l.Link_GameID = g.Game_ID
					INNER JOIN GAME_SCENARIO s on Link_ScenarioID =s.Scen_ID
				WHERE Link_ID IN(SELECT SubLink_LinkID 
							FROM `GAME_LINKAGE_SUB` WHERE SubLink_SubCompID = ".$SubComp_ID.")";
		$sublink = $functionsObj->ExecuteQuery($sql);
				
		while($row = $sublink->fetch_object()){
			$strresult = $strresult." '".$row->Game."->".$row->Scenario."' ";			
		}
		$msg 		= 'Cannot Delete SubComponent! SubComponent exists in '.$strresult;
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}else{
		//$result = $functionsObj->UpdateData('GAME_SUBCOMPONENT', array('SubComp_Delete' => 1), 'SubComp_ID', $SubComp_ID, 0);
		$result = $functionsObj->DeleteData('GAME_SUBCOMPONENT','SubComp_ID',$SubComp_ID,0);

		//if($result === true){
			$_SESSION['msg'] 		= 'Sub Component Deleted';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			header("Location:".site_root."ux-admin/ManageSubComponent");
			exit(0);
		//}
	}
}

// Fetch Services list
$area = $functionsObj->SelectData(array(), 'GAME_AREA', array('Area_Delete=0'), '', '', '', '', 0);

// Fetch Sub Categories List
$sql = "SELECT 
			SubComp_ID, SubComp_Name, (
						SELECT Comp_Name FROM GAME_COMPONENT WHERE comp_id = sub.subcomp_compid
					) as c_name, (
						SELECT Area_name FROM GAME_AREA WHERE area_id = sub.subcomp_areaid
					) as s_name 
		FROM
			GAME_SUBCOMPONENT as sub
		WHERE 
			subcomp_delete = 0
		";
$subcomponent = $functionsObj->ExecuteQuery($sql);
 
include_once doc_root.'ux-admin/view/manageSubComponent.php';
?>