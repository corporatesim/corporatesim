<style type="text/css">
	span.alert-danger {
		background-color: #ffffff;
		font-size: 18px;
	}
</style>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="radio"]').click(function(){
			if($(this).attr("value")=="pie"){
				$("#axis_placement").hide();
			}
			else{
				$("#axis_placement").show();
			}

		});
	});
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active"><a href="javascript:void(0);">Manage Chart</a></li>
				<li class="active"><?php echo $header; ?></li>
			</ul>
		</div>
	</div>

	<!-- DISPLAY ERROR MESSAGE -->
	<?php if(isset($msg)){ ?>
		<div class="form-group <?php echo $type[1]; ?>">
			<div align="center" id="<?php echo $type[0]; ?>">
				<label class="control-label" for="<?php echo $type[0]; ?>">
					<?php echo $msg; ?>
				</label>
			</div>
		</div>
	<?php } ?>
	<!-- DISPLAY ERROR MESSAGE END -->

	<div class="col-sm-12">
		<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
			<div class="row" >
				<div class="col-md-2">
					<label><span class="alert-danger"></span><span class="alert-danger">*</span>Type of chart : </label>
				</div>
				<div class="col-md-2">
					<input type="radio" name="chartType" value="pie"
					<?php if(!empty($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'pie'){ echo "checked"; } ?> > Pie &nbsp;&nbsp;
				</div>
				<div class="col-md-2">	
					<input type="radio" name="chartType" value="horizontal-bars"
					<?php if(!empty($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'horizontal-bars'){ echo "checked"; } ?> > Horizontal-Bars &nbsp;&nbsp;
				</div>
				<div class="col-md-2">
					<input type="radio" name="chartType" value="vertical-bars"
					<?php if(!empty($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'vertical-bars'){ echo "checked"; } ?> > Vertical-Bars &nbsp;&nbsp;
				</div>
				<div class="col-md-2">
					<input type="radio" name="chartType" value="trendline"
					<?php if(!empty($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'trendline'){ echo "checked"; } ?> > Trendline &nbsp;&nbsp;
				</div>
				<div class="col-md-2">
					<input type="radio" name="chartType" value="3D-bars"
					<?php if(!empty($chartdetails->Chart_Type) && $chartdetails->Chart_Type == '3D-bars'){ echo "checked"; } ?> > 3D-Bars 
				</div>
				<!-- adding new charts -->
				<!-- end of adding new charts -->
			</div>

			<div class="row">&nbsp;</div>

			<div class="row">
				<div class="col-md-2">
					<label><span class="alert-danger">*</span>Chart Name</label> 
				</div>
				<div class="col-md-4" >

					<input type="text" name="chartName" id="chartName" value="<?php if(!empty($chartdetails->Chart_Name)) echo $chartdetails->Chart_Name; ?>"
					class="form-control"	required>
				</div>
			</div>

			<div class="row">&nbsp;</div>

			<div class="row" id="axis_placement" <?php if(!empty($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'pie'){ echo 'style="display:none;"'; } else {echo 'style="display:block;"';}?>>
				<div class="col-md-2">
					<label><span class="alert-danger">*</span>Axis Placement : </label>
				</div>

				<div class="col-md-2">
					<input type="radio" name="axis_placement" value="x-axis"
					<?php if(!empty($chartdetails->Chart_Axis) && $chartdetails->Chart_Axis == 'x-axis'){ echo "checked"; } ?> > X-axis
				</div>

				<div class="col-md-2">
					<input type="radio" name="axis_placement" value="y-axis"
					<?php if(!empty($chartdetails->Chart_Axis) && $chartdetails->Chart_Axis == 'y-axis'){ echo "checked"; } ?> > Y-axis
				</div>

				<div class="col-md-2">
					<input type="radio" name="axis_placement" value="Z-axis"
					<?php if(!empty($chartdetails->Chart_Axis) && $chartdetails->Chart_Axis == 'z-axis'){ echo "checked"; } ?> > Z-axis
				</div>
			</div>
			
			<div class="row">&nbsp;</div>

			<div class="row">
				<div class="col-md-4">
					<input type="hidden" name="id"
					value="<?php if(isset($_GET['edit'])){ echo $details->Chart_ID; } ?>">

					<label><span class="alert-danger">*</span>Select Game</label> <select class="form-control"
					name="game_id" id="game_id">
					<option value="">-- SELECT --</option>
					<?php while($row = $game->fetch_object()){ ?>
						<option value="<?php echo $row->Game_ID; ?>"
							<?php if(isset($chartdetails->Chart_GameID) && $chartdetails->Chart_GameID == $row->Game_ID){echo 'selected'; } ?>>
							<?php echo $row->Game_Name; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-4" >
				<label><span class="alert-danger">*</span>Select Scenario</label> <select class="form-control"
				name="scen_id" id="scen_id">
				<option value="">-- SELECT --</option>
				<?php while($row = $scenario->fetch_object()){ ?>
					<option value="<?php echo $row->Scen_ID; ?>"
						<?php if(isset($chartdetails->Chart_ScenarioID) && $chartdetails->Chart_ScenarioID == $row->Scen_ID){echo 'selected'; } ?>>
						<?php echo $row->Scen_Name; ?>
					</option>
				<?php } ?>
			</select>
		</div>

	</div>
	<div class="row">&nbsp;</div>


	<div class="row">
		<div class="col-md-4">
			<label><span class="alert-danger">*</span>Select Area </label> 
			<select class="form-control" name="area_id" id="area_id">
				<option value="">-- SELECT --</option>
				<?php while($row = $area->fetch_object()){ ?>
					<option value="<?php echo $row->Area_ID; ?>"
						<?php if(isset($chartdetails->Chart_AreaID) && $chartdetails->Chart_AreaID == $row->Area_ID){echo 'selected'; } ?>>
						<?php echo $row->Area_Name; ?>
					</option>
				<?php } ?>
			</select>
		</div>



	</div>
	<div class="row">&nbsp;</div>


	<div class="row">
		<div class="col-md-4">
			<label><span class="alert-danger">*</span>Select Component</label> 
			<select class="form-control" name="component[]" id="comp_id" multiple="multiple" size="8">
				<option value="">-- SELECT --</option>
				<?php 
				$comp = $chartdetails->Chart_Components;
				$compArray = explode(',',$comp);
				while($row = $component->fetch_object()){ ?>
					<option value="<?php echo $row->Comp_ID; ?>"
						<?php if(isset($chartdetails->Chart_GameID) && in_array($row->Comp_ID,$compArray)){echo 'selected'; } ?>>
						<?php echo $row->Comp_Name; ?>
					</option>
				<?php } ?>
			</select>
		</div>

		<div class="col-md-4" >
			<label><span class="alert-danger">*</span>Select Subcomponent</label> 
			<select class="form-control" name="subcomponent[]" id="subcomp_id" multiple="multiple" size="8">
				<option value="">-- SELECT --</option>
				<?php 
				$subcomp = $chartdetails->Chart_Subcomponents;
				$subcompArray = explode(',',$subcomp);
				while($row = $subcomponent->fetch_object()){ ?>
					<option value="<?php echo $row->SubComp_ID; ?>"
						<?php if(isset($chartdetails->Chart_ScenarioID) && in_array($row->SubComp_ID,$subcompArray)){echo 'selected'; } ?>>
						<?php echo $row->SubComp_Name; ?>
					</option>
				<?php } ?>
			</select>
		</div>

	</div>
	<div class="row">&nbsp;</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="form-group text-center">
				<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
					<button type="button" id="siteuser_btn_update" class="btn btn-primary"
					> Update </button>
					<button type="submit" name="submit" id="siteuser_update" class="btn btn-primary hidden"
					value="Update"> Update </button>
					<button type="button" class="btn btn-primary"
					onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }else{?>
					<button type="button" id="siteuser_btn" class="btn btn-primary"
					value="Submit"> Submit </button>
					<button type="submit" name="submit" id="siteuser_sbmit"
					class="btn btn-primary hidden" value="Submit"> Submit </button>
					<button type="button" class="btn btn-primary"
					onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }?>
			</div>
		</div>
	</div>
</form>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
	$('#area_id').change( function(){
		var area_id = $(this).val();
		
		getSubComp(area_id);
		
		//alert(area_id);
		$('#comp_id').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { area_id: area_id },
			success: function(data){
				$('#comp_id').html(data);
			}
		});
	});
	
	function getSubComp(areaID)
	{
		//alert(area_id);
		$('#subcomp_id').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { area_id_subcomp: areaID },
			success: function(data){
				$('#subcomp_id').html(data);
			}
		});
	};


	<!--

	$('#siteuser_btn').click( function(){
//	if($("#siteuser_frm").valid()){		
	$( "#siteuser_sbmit" ).trigger( "click" );
//	}
});

	$('#siteuser_btn_update').click( function(){
//	if($("#siteuser_frm").valid()){
	$( "#siteuser_update" ).trigger( "click" );
//	}
});

// -->
</script>
