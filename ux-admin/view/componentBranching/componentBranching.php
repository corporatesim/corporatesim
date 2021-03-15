<!-- <?php // echo "<pre>"; print_r($compResult); exit; ?> -->
	<script type="text/javascript">
		<!--
			var loc_url_del  = "ux-admin/linkage/del/";
			var loc_url_stat = "ux-admin/linkage/stat/";
//-->
</script>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Component Branching</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="completed"><a href="<?php echo site_root."ux-admin/linkage"; ?>">Linkage</a></li>
			<li class="active">Manage Component Branching</li>			
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-4">
		<strong>Game: </strong><?php echo ucfirst($gameName);?>
	</div>
	<div class="col-md-4">
		<strong>Scenario: </strong><?php echo ucfirst($scenName);?>
	</div>
	<div class="col-md-4">
		<span class="pull-right" data-toggle="tooltip" title="Download Component Branching"><a href="javascript:void(0);" id="downloadComponentBranching"><i class="fa fa-download"></i></a></span>
		<div class="hidden">
			<form action="" id="downloadBranchingData" method="post">
				<input type="hidden" name="game_name" value="<?php echo $gameName;?>">
				<input type="hidden" name="scen_name" value="<?php echo $scenName;?>">
				<input type="hidden" name="downloadQuery" value="<?php echo $sqlComp;?>">
				<button type="submit" value="downloadBranchingData" name="downloadData" id="downloadData">Download</button>
			</form>
		</div>
	</div>
</div>
<br>	
<div class="clearfix"></div>
<!-- print labels -->
<div class="row">
	<div class="col-md-4">
		<label for="Select Component"><span class="alert-danger">*</span>Select Component</label>
	</div>
	<div class="col-md-1">
		<label for="Select Component"><span class="alert-danger">*</span>Min</label>
	</div>
	<div class="col-md-1">
		<label for="Select Component"><span class="alert-danger">*</span>Max</label>
	</div>
	<div class="col-md-1">
		<label for="Select Component"><span class="alert-danger">*</span>Order</label>
	</div>
	<div class="col-md-3">
		<label for="Select Component"><span class="alert-danger">*</span>Select Next Component From Same Area</label>
	</div>
	<div class="col-md-1">
		<button class="btn btn-primary" type="button" data-toggle="tooltip" title="Add More" id="addMore" style="margin-top: -6%;">
			<b>+</b>
		</button>
	</div>
</div>
<form action="" method="post" id="branchingForm">
	<!-- fetching records for editing -->
	<?php 
	$sqlCompObj = $functionsObj->ExecuteQuery($sqlComp);
	if($sqlCompObj->num_rows > 0)
	{ 
		while($row = $sqlCompObj->fetch_object()){ ?>
			<input type="hidden" name="update" value="update"><br>
			<div class="row removeDiv">
				<div class="col-md-4">
					<select name="componentName[]" id="editComponentId" class="form-control compClass" data-class="<?php echo $row->CompBranch_Id;?>" required="">
						<option value="">--Select Component--</option>
						<?php
						$query = "SELECT gls.SubLink_ID, gls.SubLink_LinkID, gls.SubLink_AreaID, gls.SubLink_CompID, gc.Comp_Name,ga.Area_Name FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID LEFT JOIN GAME_BRANCHING_COMPONENT gbc ON gbc.CompBranch_SublinkId=gls.SubLink_ID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gls.SubLink_CompID WHERE gls.SubLink_LinkID=".$linkId." AND gls.SubLink_SubCompID<1 GROUP BY gls.SubLink_ID ORDER BY gls.SubLink_Order ASC";
						$queryObj = $functionsObj->ExecuteQuery($query);
						while($wrow = $queryObj->fetch_object()){
							?>
							<option value="<?php echo $wrow->SubLink_CompID.','.$wrow->SubLink_ID.','.$wrow->SubLink_AreaID; ?>" <?php echo ($row->CompBranch_CompId == $wrow->SubLink_CompID)?'selected':'';?> title="Area: <?php echo $wrow->Area_Name;?>"><?php echo $wrow->Comp_Name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-1">
					<input type="text" name="minVal[]" class="form-control" placeholder="Min Val" required="" value="<?php echo $row->CompBranch_MinVal?>">
				</div>
				<div class="col-md-1">
					<input type="text" name="maxVal[]" class="form-control" placeholder="Max Val" required="" value="<?php echo $row->CompBranch_MaxVal?>">
				</div>
				<div class="col-md-1">
					<input type="number" name="order[]" class="form-control" placeholder="Order" required="" value="<?php echo $row->CompBranch_Order?>" min='1'>
				</div>
				<div class="col-md-4">
					<select name="componentNextName[]" id="editComponentNextId" class="form-control" data-id="<?php echo $row->CompBranch_Id;?>" required="">
						<option value="">--Select Next Component--</option>
						<?php
						$nextCompSql = "SELECT gls.SubLink_ID,gls.SubLink_CompID,gc.Comp_Name FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gls.SubLink_CompID WHERE gls.SubLink_SubCompID<1 AND gls.SubLink_AreaID=".$row->CompBranch_AreaId." AND gls.SubLink_LinkID=".$linkId." AND gls.SubLink_ID !=".$row->CompBranch_SublinkId;
						$nextCompObj = $functionsObj->ExecuteQuery($nextCompSql);
						while($nrow = $nextCompObj->fetch_object()){
							?>
							<option value="<?php echo $nrow->SubLink_CompID.','.$nrow->SubLink_ID; ?>" <?php echo ($nrow->SubLink_CompID == $row->CompBranch_NextCompId)?'selected':'';?>><?php echo $nrow->Comp_Name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-1">
					<button class="btn btn-danger removeThis" type="button" data-toggle="tooltip" title="Remove"><b>-</b></button>
				</div>
			</div>
		<?php }	
	}
	// if there is no record for component branching or first time 
	else{ ?>
		<br>
		<div class="row">
			<div class="col-md-4">
				<select name="componentName[]" id="componentId" class="form-control compClass" data-class="componentId" required="">
					<option value="">--Select Component--</option>
				</select>
			</div>
			<div class="col-md-1">
				<input type="text" name="minVal[]" class="form-control" placeholder="Min Val" required="">
			</div>
			<div class="col-md-1">
				<input type="text" name="maxVal[]" class="form-control" placeholder="Max Val" required="">
			</div>
			<div class="col-md-1">
				<input type="number" name="order[]" class="form-control" placeholder="Order" required="" min="1">
			</div>
			<div class="col-md-4">
				<select name="componentNextName[]" id="componentNextId" class="form-control" data-id="componentId" required="">
					<option value="">--Select Next Component--</option>
				</select>
			</div>
		</div>
	<?php }
	?>
	<br>
	<div class="row" id="addHere"></div>
	<div class="row" id="sandbox-container" style="margin-left: 25%">
		<div class="col-md-3 text-center">
			<button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="submit" id="submit">SUBMIT</button>
		</div>
		<input type="hidden" name="addEdit" value="">
		<div class="col-md-3 text-center">
			<a href="<?php echo site_root; ?>ux-admin/linkage" class="btn btn-primary btn-lg btn-block">CANCEL</a>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){
		// alert('<?php // echo $linkId; ?>');
		// appending the comp, next comp drop down options
		var options     = '<option value="">-- Select Component--</option>';
		var nextOptions = '<option value="">-- Select Next Component--</option>';
		<?php while ($compResult = $compSqlObj->fetch_object()) { ?>
			options += '<option value="<?php echo $compResult->SubLink_CompID.','.$compResult->SubLink_ID.','.$compResult->SubLink_AreaID; ?>" title="Area: <?php echo $compResult->Area_Name?>"><?php echo $compResult->Comp_Name; ?></option>'
		<?php } ?>
		$('#componentId').html(options);
		$('#componentNextId').html(nextOptions);
		$('#addMore').on('click',function(){
			// doing all this for random number
			var date = new Date();
			var time = date.getHours() + date.getMinutes() + date.getSeconds();
			time     = time*Math.random();
			// console.log(time);
			$('#addHere').append('<div class="removeDiv" style="padding-bottom: 4%;"><div class="col-md-4"><select name="componentName[]" id="" data-class="'+time+'" class="form-control compClass" required="">'+options+'</select></div><div class="col-md-1"><input type="text" class="form-control" name="minVal[]" placeholder="Min Val" required=""></div><div class="col-md-1"><input type="text" class="form-control" name="maxVal[]" placeholder="Max Val" required=""></div><div class="col-md-1"><input type="number" class="form-control" name="order[]" placeholder="Order" required=""></div><div class="col-md-4"><select name="componentNextName[]" id="" data-id="'+time+'" class="form-control" required="">'+nextOptions+'</select></div><div class="col-md-1"><button class="btn btn-danger removeThis" type="button" data-toggle="tooltip" title="Remove"><b>-</b></button></div></div>');
			removeDiv();
			nextCompData();
		});
		nextCompData();
		removeDiv();
		// downloadComponentBranching
		$('#downloadComponentBranching').on('click',function(){
			$('#downloadData').trigger('click');
		});
	});

	function removeDiv()
	{
		$('.removeThis').each(function(){
			$(this).on('click',function(){
				$(this).parents('div.removeDiv').remove();
			});
		});
	}
	// this function will apeend the next comp details for the selected comp accorging to its area, and this function will take the next component field id to append data
	function nextCompData(nextCompId)
	{
		// while changing comp drop then only show next component dropdown for that area
		$('.compClass').each(function(){
			$(this).on('change',function(){
				var selectedValue   = $(this).val();
				var appendElementId = $(this).data('class');
				if(selectedValue.length < 1)
				{
					alert('Please Select Component');
					return false;
				}
				var selectedValue  = selectedValue.split(',');
				var sublink_id     = selectedValue[1];
				var area_id        = selectedValue[2];
				var SubLink_LinkID = "<?php echo $linkId;?>";
				// trigger ajax to get the options data for next component of the selected component area
				$.ajax({
					url : site_root + "ux-admin/model/ajax/componentBranching.php",
					type: "POST",
					data: 'findArea=findArea&area_id='+area_id+'&SubLink_LinkID='+SubLink_LinkID+'&sublink_id='+sublink_id,
					success: function(result){
						$('[data-id="'+appendElementId+'"]').html(result);
					}
				});
			});
		});
	}
</script>