<?php 
$funObj = new Model();
$f_list = $funObj->SelectData(array(), formulas, array(), '', '', '', '', 0);
$file   = 'list.php';

if( isset( $_GET['add'] ) && !empty( $_GET['add'] ) )
{
	$head               = "Add Formula";
	$componentsQuery    = 'SELECT gc.*,ga.Area_Name AS AreaName FROM GAME_COMPONENT gc LEFT JOIN GAME_AREA ga ON ga.Area_ID= gc.Comp_AreaID WHERE gc.Comp_Delete=0 ORDER BY gc.Comp_Name';
	$subcomponentsQuery = 'SELECT gs.*,gc.Comp_Name AS ComponentName,ga.Area_Name AS AreaName FROM GAME_SUBCOMPONENT gs LEFT JOIN GAME_AREA ga ON ga.Area_ID = gs.SubComp_AreaID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gs.SubComp_CompID WHERE gs.SubComp_Delete=0 ORDER BY gs.SubComp_Name';
	$areaComponents     = $funObj->ExecuteQuery($componentsQuery);
	$areaSubcomponents  = $funObj->ExecuteQuery($subcomponentsQuery);
	$components         = $funObj->SelectData(array(), component, array(), 'Comp_Name', '', '', '', 0);
	$subcomponents      = $funObj->SelectData(array(), subcomponent, array(), 'SubComp_Name', '', '', '', 0);
	$operators          = $funObj->SelectData(array(), math_operators, array(), '', '', '', '', 0);
	
	$file = 'add_edit_formula.php';
}
elseif( isset( $_GET['edit'] ) && !empty( $_GET['edit'] ) )
{
	$head = "Add Formula";
	$fid  = base64_decode($_GET['edit']);
	
	$components    = $funObj->SelectData(array(), component, array(), 'Comp_Name', '', '', '', 0);
	$subcomponents = $funObj->SelectData(array(), subcomponent, array(), 'SubComp_Name', '', '', '', 0);
	$operators     = $funObj->SelectData(array(), math_operators, array(), '', '', '', '', 0);
	$formula       = $funObj->SelectData(array(), formulas, array('f_id='.$fid), '', '', '', '', 0);
	$details       = $functionsObj->FetchObject($formula);
	//exit();
	$file          = 'add_edit_formula.php';
}
elseif( isset( $_GET['del'] ) && !empty( $_GET['del'] ) )
{
	$fid    = base64_decode($_GET['del']);
	
	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_FormulaID='.$fid), '', '', '', '', 0);
	if ($object->num_rows > 0) {
		$msg      = 'Cannot Delete Formula! It is already in use';
		$type [0] = 'inputError';
		$type [1] = 'has-error';		
	}
	else
	{
		$result               = $functionsObj->DeleteData('GAME_FORMULAS','f_id',$fid,0);
		$_SESSION ['msg']     = 'Formula Deleted';
		$_SESSION ['type[0]'] = 'inputSuccess';
		$_SESSION ['type[1]'] = 'has-success';
		header ( "Location:" . site_root . "ux-admin/Formulas" );
		exit(0);	
	}

} 
else
{
	$f_list = $funObj->SelectData(array(), formulas, array(), '', '', '', '', 0);
	$file   = 'list.php';
}

include_once doc_root.'ux-admin/view/formula/'.$file;
