<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';

$funObj = new Functions();


if(isset($_POST['area_id']))
{
	$area_id = $_POST['area_id'];
	$object  = $funObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_AreaID='.$area_id, 'Comp_Delete=0'), 'Comp_Name', '', '', '', 0);
	?>
	<option value="">-- SELECT --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->Comp_ID; ?>"><?php echo $row->Comp_Name; ?></option>
		<?php }
	}
}
//dropdown for download subcomponent in excelsheet
if(isset($_POST['area']))
{
	$area_id = $_POST['area'];
	$area_ids = implode(',',$area_id);
	/*$object  = $funObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_AreaID='.$area_id, 'Comp_Delete=0'), 'Comp_Name', '', '', '', 0);*/
	$object  = $funObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_AreaID IN('.$area_ids.')', 'Comp_Delete=0'), 'Comp_Name', '', '', '', 0);
	?>
	<option value="">-- SELECT --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->Comp_ID; ?>"><?php echo $row->Comp_Name; ?></option>
		<?php }
	}
}
//dropdown to get scenario for personalize outcome to download data in excel
if(isset($_POST['game']))
{
	$game_id = $_POST['game'];
	$sqlscen = "SELECT s.Scen_ID,s.Scen_Name, Link_ID  
	FROM `GAME_LINKAGE` INNER JOIN GAME_SCENARIO s ON Link_ScenarioID=s.Scen_ID
	WHERE Link_GameID=".$game_id;
	$object = $funObj->ExecuteQuery($sqlscen);
	
	?>
	<option value="">-- SELECT --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->Scen_ID; ?>"><?php echo $row->Scen_Name; ?></option>
		<?php }
	}
}

if(isset($_POST['area_id_subcomp']))
{
	$area_id_subcomp = $_POST['area_id_subcomp'];
	$object          = $funObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_AreaID='.$area_id_subcomp, 'SubComp_Delete=0'), '', '', '', '', 1);
	?>
	<option value="">-- SELECT --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->SubComp_ID; ?>"><?php echo $row->SubComp_Name; ?></option>
		<?php }
	}
}


if(isset($_POST['link_id']))
{
	$link_id = $_POST['link_id'];
	$sqlcomp = "SELECT DISTINCT c.Comp_ID, c.Comp_Name 
	FROM `GAME_LINKAGE_SUB` ls INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID
	WHERE SubLink_LinkID=".$link_id."
	ORDER BY c.Comp_Name";
	
	$object = $funObj->ExecuteQuery($sqlcomp);
	
	//$object = $funObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_CompID='.$comp_id, 'SubComp_Delete=0'), '', '', '', '', 1);
	?>
	<option value="">-- Select Component --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->Comp_ID; ?>"><?php echo $row->Comp_Name; ?></option>
		<?php }
	}
}

if(isset($_POST['game_id']))
{
	$game_id = $_POST['game_id'];
	$sqlscen = "SELECT s.Scen_ID,s.Scen_Name, Link_ID  
	FROM `GAME_LINKAGE` INNER JOIN GAME_SCENARIO s ON Link_ScenarioID=s.Scen_ID
	WHERE Link_GameID=".$game_id;
	$object = $funObj->ExecuteQuery($sqlscen);
	
	?>
	<option value="">-- SELECT --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->Link_ID; ?>"><?php echo $row->Scen_Name; ?></option>
		<?php }
	}
}

if(isset($_POST['comp_id']))
{
	$comp_id = $_POST['comp_id'];
	$object = $funObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_CompID='.$comp_id, 'SubComp_Delete=0'), '', '', '', '', 1);
	?>
	<option value="">-- Select Subcomponent --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->SubComp_ID; ?>"><?php echo $row->SubComp_Name; ?></option>
		<?php }
	}
}

if(isset($_POST['carry_linkid']) && isset($_POST['carry_compid']))
{
	$carry_linkid = $_POST['carry_linkid'];
	$carry_compid = $_POST['carry_compid'];
	$sql          = "SELECT DISTINCT s.SubComp_ID,s.SubComp_Name 
	FROM `GAME_LINKAGE_SUB` INNER JOIN GAME_SUBCOMPONENT s on SubLink_SubCompID=s.SubComp_ID
	WHERE SubLink_LinkID=".$carry_linkid." AND SubLink_CompID=".$carry_compid.
	" ORDER BY s.SubComp_Name";
	$object = $funObj->ExecuteQuery($sql);
	
//	$object = $funObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_CompID='.$comp_id, 'SubComp_Delete=0'), '', '', '', '', 1);
	?>
	<option value="">-- SELECT --</option>
	<?php 
	
	if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->SubComp_ID; ?>"><?php echo $row->SubComp_Name; ?></option>
		<?php }
	}
}

if(isset($_POST['formula_id']))
{
	$formula_id = $_POST['formula_id'];
	$object     = $funObj->SelectData(array(), 'GAME_FORMULAS', array('f_id='.$formula_id), '', '', '', '', 0);
	$formula    = $object->fetch_object();
	echo $formula->expression_string;
}

if(isset($_POST['comp_scen_id']))
{
	$link_id = $_POST['comp_scen_id'];
	
	$sqlcomp = "SELECT DISTINCT c.Comp_ID, c.Comp_Name, a.Area_Name
	FROM `GAME_LINKAGE_SUB` ls INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID
	INNER JOIN GAME_AREA a ON ls.SubLink_AreaID=a.Area_ID
	WHERE SubLink_LinkID=".$link_id." 
	ORDER BY c.Comp_Name";	

	$components = $funObj->ExecuteQuery($sqlcomp);
	
	if( $components->num_rows > 0 ) 
	{
		while( $rows = $components->fetch_object() ){ ?>
			<li id="comp_<?php echo $rows->Comp_ID; ?>" data-toggle="tooltip" title="<?php echo $rows->Area_Name; ?>" value="{<?php echo $rows->Comp_Name; ?>}">
				<?php echo $rows->Comp_Name; ?>
				</li><?php
			}
		}
	}

	if(isset($_POST['subcomp_scen_id']))
	{
		$link_id = $_POST['subcomp_scen_id'];
		$sqlcomp = "SELECT DISTINCT s.SubComp_ID, c.Comp_Name, s.SubComp_Name, a.Area_Name
		FROM `GAME_LINKAGE_SUB` ls INNER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID
		INNER JOIN GAME_AREA a ON ls.SubLink_AreaID=a.Area_ID
		INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID
		WHERE SubLink_LinkID=".$link_id." 
		ORDER BY s.SubComp_Name";	
		
		$subcomponents = $funObj->ExecuteQuery($sqlcomp);
		
		if( $subcomponents->num_rows > 0 ) 
		{
			while( $rows = $subcomponents->fetch_object() ){ ?>
				<li id="subc_<?php echo $rows->SubComp_ID; ?>" data-toggle="tooltip" title='"Area: <?php echo $rows->Area_Name; ?> ,  Component: <?php echo $rows->Comp_Name; ?>"' value='"{<?php echo $rows->SubComp_Name; ?>}"'>
					<?php echo $rows->SubComp_Name; ?>
					</li><?php
				}
			}	
		}
		// for populating the game chart dropdown 
		if(isset($_POST['gameId']) && isset($_POST['statusType']))
		{
			// print_r($_POST);
			$gameId     = $_POST['gameId'];
			$statusType = $_POST['statusType'];
			// $chartSql   = "SELECT * FROM `GAME_CHART` WHERE `Chart_GameID`=".$result->Link_GameID." AND Chart_Type_Status=".$statusType;
			$chartObject  = $funObj->SelectData(array(), 'GAME_CHART', array('Chart_GameID='.$gameId, 'Chart_Type_Status='.$statusType), 'Chart_Name', '', '', '', 0);
			?>
			<option value="">-- Select Chart --</option>
			<?php 

			if($chartObject->num_rows > 0)
			{
				while($wrow = $chartObject->fetch_object()){ ?>
					<option value="<?php echo $wrow->Chart_ID; ?>"><?php echo $wrow->Chart_Name; ?></option>
				<?php }
			}
		}