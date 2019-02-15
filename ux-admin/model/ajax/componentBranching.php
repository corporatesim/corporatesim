<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';

$funObj = new Functions();


if(isset($_POST['area_id']))
{
	// print_r($_POST); exit();
	$SubLink_LinkID = $_POST['SubLink_LinkID'];
	$SubLink_AreaID = $_POST['area_id'];
	$SubLink_ID     = $_POST['sublink_id'];
	$nextCompSql    = "SELECT gls.SubLink_ID,gls.SubLink_CompID,gc.Comp_Name FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gls.SubLink_CompID WHERE gls.SubLink_SubCompID<1 AND gls.SubLink_ShowHide<1 AND gls.SubLink_AreaID=".$SubLink_AreaID." AND gls.SubLink_LinkID=".$SubLink_LinkID." AND SubLink_ID!=".$SubLink_ID;
	$object = $funObj->ExecuteQuery($nextCompSql); ?>
	<option value="">--Select Next Component--</option>
	<?php if($object->num_rows > 0)
	{
		while($row = $object->fetch_object()){ ?>
			<option value="<?php echo $row->SubLink_CompID.','.$row->SubLink_ID; ?>"><?php echo $row->Comp_Name; ?></option>
		<?php }
	}
	else
	{ ?>
		<option value="">There is no other component to show in the selected area</option>
	<?php }
}
