<?php 
$funObj = new Model();
$f_list = $funObj->SelectData(array(), formulas, array(), '', '', '', '', 0);
$file   = 'list.php';

function cmp($a, $b)
{
	return strcmp($a->flag, $b->flag);
}

$head               = "Add Formula";
$componentsQuery    = 'SELECT gc.*,ga.Area_Name AS AreaName FROM GAME_COMPONENT gc LEFT JOIN GAME_AREA ga ON ga.Area_ID= gc.Comp_AreaID WHERE gc.Comp_Delete=0 ORDER BY gc.Comp_Name';
$areaComponents     = $funObj->RunQueryFetchObject($componentsQuery);

$subcomponentsQuery = 'SELECT gs.*,gc.Comp_Name AS ComponentName,ga.Area_Name AS AreaName FROM GAME_SUBCOMPONENT gs LEFT JOIN GAME_AREA ga ON ga.Area_ID = gs.SubComp_AreaID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gs.SubComp_CompID WHERE gs.SubComp_Delete=0 ORDER BY gs.SubComp_Name';
$areaSubcomponents  = $funObj->RunQueryFetchObject($subcomponentsQuery);
$comp_subcomp_exp = array();
if( isset( $_GET['add'] ) && !empty( $_GET['add'] ) )
{
	$components         = $funObj->SelectData(array(), component, array(), 'Comp_Name', '', '', '', 0);
	$subcomponents      = $funObj->SelectData(array(), subcomponent, array(), 'SubComp_Name', '', '', '', 0);
	$operators          = $funObj->SelectData(array(), math_operators, array(), '', '', '', '', 0);
	
	$file = 'add_edit_formula.php';
}
elseif( isset( $_GET['edit'] ) && !empty( $_GET['edit'] ) )
{
	$head = "Edit Formula";
	$fid  = base64_decode($_GET['edit']);
	
	$components    = $funObj->SelectData(array(), component, array(), 'Comp_Name', '', '', '', 0);
	$subcomponents = $funObj->SelectData(array(), subcomponent, array(), 'SubComp_Name', '', '', '', 0);
	$operators     = $funObj->SelectData(array(), math_operators, array(), '', '', '', '', 0);
	$formula       = $funObj->SelectData(array(), formulas, array('f_id='.$fid), '', '', '', '', 0);
	$details       = $functionsObj->FetchObject($formula);
	$comp_subcomp_exp = explode(' ', $details->expression);
	// using foreach loop to sort the object data to get selected first
	foreach($areaComponents as $row)
	{
		if(in_array('comp_'.$row->Comp_ID, $comp_subcomp_exp))
		{
			$row->flag = 1;
		}
		else
		{
			$row->flag = 2;
		}
	}

	foreach($areaSubcomponents as $row)
	{
		if(in_array('subc_'.$row->SubComp_ID, $comp_subcomp_exp))
		{
			$row->flag = 1;
		}
		else
		{
			$row->flag = 2;
		}
	}
	usort($areaComponents, "cmp");
	usort($areaSubcomponents, "cmp");

	// print_r($areaSubcomponents); exit();

	$file = 'add_edit_formula.php';
}
elseif( isset( $_GET['del'] ) && !empty( $_GET['del'] ) )
{
	$fid    = base64_decode($_GET['del']);
	
	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_FormulaID='.$fid), '', '', '', '', 0);
	if ($object->num_rows > 0) {
		$_SESSION ['msg']     = 'Cannot Delete Formula! It is already in use';
		$_SESSION ['type[0]'] = 'inputError';
		$_SESSION ['type[1]'] = 'has-error';
		header ( "Location:" . site_root . "ux-admin/Formulas" );
		exit(0);	
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
	// $f_list = $funObj->SelectData(array(), formulas, array(), '', '', '', '', 1);
	$formulaSql = "SELECT gf.*, gls.SubLink_ID, gls.SubLink_AreaName, gls.SubLink_CompName, gls.SubLink_SubcompName, gls.SubLink_LinkID FROM GAME_FORMULAS gf LEFT JOIN GAME_LINKAGE_SUB gls ON gls.SubLink_FormulaID = gf.f_id ORDER BY gf.f_id";
	$f_list = $functionsObj->RunQueryFetchObject($formulaSql);
	$file   = 'list.php';
	$flag = 0;
	$formulaArrayList = array();
	foreach($f_list as $row)
	{
		if($row->f_id == $flag)
		{
			$formulaArrayList[$row->f_id]['formula_title'] = $row->formula_title;
			$formulaArrayList[$row->f_id]['expression_string'] = $row->expression_string;
			$formulaArrayList[$row->f_id]['linkageLink'] = $formulaArrayList[$row->f_id]['linkageLink'].',__, '.site_root.'ux-admin/linkage/linkedit/'.$row->SubLink_ID;
			$formulaArrayList[$row->f_id]['SubLink_ID'] = $formulaArrayList[$row->f_id]['SubLink_ID'].', '.$row->SubLink_ID;
		}
		else
		{
			// always comes first time here
			$formulaArrayList[$row->f_id]['f_id'] = $row->f_id;
			$formulaArrayList[$row->f_id]['formula_title'] = $row->formula_title;
			$formulaArrayList[$row->f_id]['expression_string'] = $row->expression_string;
			$formulaArrayList[$row->f_id]['linkageLink'] = site_root.'ux-admin/linkage/linkedit/'.$row->SubLink_ID;
			$formulaArrayList[$row->f_id]['SubLink_ID'] = $row->SubLink_ID;
			$formulaArrayList[$row->f_id]['date_time'] = date('d-m-Y H:i:s', strtotime($row->date_time));
			$flag = $row->f_id;
		}
	}
	// echo site_root."ux-admin/linkage/linkedit/16115<pre>"; print_r($formulaArrayList); exit;
}

include_once doc_root.'ux-admin/view/formula/'.$file;