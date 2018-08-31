<?php
require_once doc_root . 'ux-admin/model/model.php';
$functionsObj = new Model ();

if (isset ( $_POST ['submit'] ) && $_POST ['submit'] == 'Submit') {
	if (! empty ( $_POST ['Comp_Name'] ) && ! empty ( $_POST ['Area_ID'] )) {
		$Comp_Name = $_POST ['Comp_Name'] ;
		$Area_ID = $_POST ['Area_ID'];
		$object = $functionsObj->SelectData ( array (), 'GAME_COMPONENT', array (
				'Comp_AreaID=' . $Area_ID,
				"Comp_Name='" . $Comp_Name . "'" 
		), '', '', '', '', 0 );
		if ($object->num_rows > 0) {
			$msg = 'Entered Component name already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else {
			$array = array (
					'Comp_AreaID' => $Area_ID,
					'Comp_Name' => ucfirst ( $Comp_Name ),
					'Comp_Date' => date ( 'Y-m-d H:i:s' ) 
			);
			$result = $functionsObj->InsertData ( 'GAME_COMPONENT', $array, 0, 0 );
			if ($result) {
				$_SESSION ['msg'] = 'Component Added Successfully';
				$_SESSION ['type[0]'] = 'inputSuccess';
				$_SESSION ['type[1]'] = 'has-success';
				header ( "Location:" . site_root . "ux-admin/ManageComponent" );
			}
		}
	} else {
		$msg = 'Field cannot be empty';
		$type [0] = 'inputError';
		$type [1] = 'has-error';
	}
}

if (isset ( $_POST ['submit'] ) && $_POST ['submit'] == 'Update') {
	if (! empty ( $_POST ['Comp_Name'] )) {
		$Comp_Name = $_POST ['Comp_Name'];
		$Area_ID = $_POST ['Area_ID'];
		$Comp_ID = $_POST ['Comp_ID'];
		$object = $functionsObj->SelectData ( array (), 'GAME_COMPONENT', array (
				"Comp_AreaID=" . $Area_ID,
				"Comp_Name='" . $Comp_Name . "'",
				"Comp_ID !=" . $Comp_ID 
		), '', '', '', '', 0 );
		
		if ($object->num_rows > 0) {
			$msg = 'Entered Component name already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else {
			$array = array (
					'Comp_AreaID' => $Area_ID,
					'Comp_Name' => ucfirst ( $Comp_Name ) 
			);
			$result = $functionsObj->UpdateData ( 'GAME_COMPONENT', $array, 'Comp_ID', $Comp_ID );
			if ($result) {
				$_SESSION ['msg'] = 'Component Updated Successfully';
				$_SESSION ['type[0]'] = 'inputSuccess';
				$_SESSION ['type[1]'] = 'has-success';
				header ( "Location:" . site_root . "ux-admin/ManageComponent" );
			}
		}
	} else {
		$msg = 'Field cannot be empty';
		$type [0] = 'inputError';
		$type [1] = 'has-error';
	}
}

if (isset ( $_GET ['edit'] ) && $_GET ['q'] = "ManageComponent") {
	$Comp_ID = base64_decode ( $_GET ['edit'] );
	$where = array (
			'Comp_ID=' . $Comp_ID 
	);
	
	$obj = $functionsObj->SelectData ( array (), 'GAME_COMPONENT', $where, '', '', '', '', 0 );
	$result = $functionsObj->FetchObject ( $obj );
} elseif (isset ( $_GET ['delete'] )) {
	$Comp_ID = base64_decode ( $_GET ['delete'] );
	$fields = array ();
	$where = array (
			"SubComp_CompID = " . $Comp_ID,
			"SubComp_Delete = 0"
	);
	$obj = $functionsObj->SelectData ( $fields, 'GAME_SUBCOMPONENT', $where, '', '', '', '', 0 );
	if ($obj->num_rows > 0) {
		//$result = $functionsObj->FetchObject ( $obj );
		
		$msg = 'Cannot Delete Component! Component contains Subcomponent';
		$type [0] = 'inputError';
		$type [1] = 'has-error';
	} else {
		
		$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_CompID='.$Comp_ID), '', '', '', '', 0);
		if ($object->num_rows > 0) {
			
			$sql="SELECT g.Game_Name as Game, s.Scen_Name as Scenario 
				FROM `GAME_LINKAGE` l INNER JOIN GAME_GAME g on l.Link_GameID = g.Game_ID
					INNER JOIN GAME_SCENARIO s on Link_ScenarioID =s.Scen_ID
				WHERE Link_ID IN(SELECT SubLink_LinkID 
							FROM `GAME_LINKAGE_SUB` WHERE SubLink_CompID = ".$Comp_ID.")";
			$sublink = $functionsObj->ExecuteQuery($sql);
					
			while($row = $sublink->fetch_object()){
				$strresult = $strresult." '".$row->Game."->".$row->Scenario."' ";			
			}
			$msg = 'Cannot Delete Component! Component exists in '.$strresult;			
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else {		
			$result = $functionsObj->DeleteData('GAME_COMPONENT','Comp_ID',$Comp_ID,0);

			//if ($result == true) {
				$_SESSION ['msg'] = 'Component Deleted';
				$_SESSION ['type[0]'] = 'inputSuccess';
				$_SESSION ['type[1]'] = 'has-success';
				header ( "Location:" . site_root . "ux-admin/ManageComponent" );
				exit(0);
			//}
		}
	}
}

/* echo "<pre>";
print_r ( $result );
echo "</pre>"; */

// Fetch Categories
$sql = "SELECT 
			Comp_ID, 
			(SELECT Area_Name FROM GAME_AREA WHERE Area_ID= c.Comp_AreaID) as Area_Name,
			Comp_Name,
			Comp_date
		FROM 
			GAME_COMPONENT as c WHERE Comp_Delete =0";
$object = $functionsObj->ExecuteQuery ( $sql );

// Fetch Area List
$Area = $functionsObj->SelectData ( array (), 'GAME_AREA', array (
		'Area_Delete = 0' 
), '', '', '', '', 0 );

include_once doc_root . 'ux-admin/view/manageComponent.php';
?>