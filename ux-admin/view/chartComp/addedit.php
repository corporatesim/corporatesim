<style type="text/css">
span.alert-danger {
	background-color: #ffffff;
	font-size: 18px;
}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
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
				<div class="col-md-4">
					<select class="form-control" name="chartType" id="chartType" required>
						<option value="">-- Select Chart Type--</option>

						<option disabled >-- Pie Charts --</option>
						<option value="simplepie" 
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'simplepie'){echo 'selected'; } ?>> Simple Pie Chart</option>
						<option value="threedpie" 
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'threedpie'){echo 'selected'; } ?>>3D Pie Chart</option>
						<option value="multidepthpie" 
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'multidepthpie'){echo 'selected'; } ?>>Multi-Depth Pie Chart</option>
						<option value="sidelabelpie"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'sidelabelpie'){echo 'selected'; } ?>>Side Label Layout</option>
						<option value="threeddonutshading" 
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'threeddonutshading'){echo 'selected'; } ?>>3D Donut Shading</option>
						<option value="donutChart" 
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'donutChart'){echo 'selected'; } ?>>Donut Chart</option>
						
						<option disabled>-- Bar Charts --</option>
						<option value="simplebar"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'simplebar'){echo 'selected'; } ?>>Simple Bar Chart</option>
						<option value="barlabel"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'barlabel'){echo 'selected'; } ?>>Bar Labels</option>
						<option value="colorbar"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'colorbar'){echo 'selected'; } ?>>Multi-Color Bar Chart</option>
						<option value="softbarshading"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'softBarShading'){echo 'selected'; } ?>>Soft Bar Shading</option>
						<option value="multicolorbarchartone"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'multicolorbarchartone'){echo 'selected'; } ?>>Multi-Color Bar Chart (1)</option>
						<option value="histogramwithbellcurve"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'histogramwithbellcurve'){echo 'selected'; } ?>>Histogram with Bell Curve</option>
						
						<option disabled>-- Trending Charts --</option>
						<option value="trendline"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'trendline'){echo 'selected'; } ?>>Trend Line Chart</option>

						<option disabled>-- Scatter/Bubble/Vector Charts --</option>
						<option value="customscattersymbols"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'customscattersymbols'){echo 'selected'; } ?>>Custom Scatter Symbols</option>
						
						<option disabled>-- Area Charts --</option>
						<option value="simplearea"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'simplearea'){echo 'selected'; } ?>>Simple Area Chart</option>
						<option value="arealinechart"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'arealinechart'){echo 'selected'; } ?>>Area Line Chart</option>
						<option value="percentageareachart"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'percentageareachart'){echo 'selected'; } ?>>Percentage Area Chart</option>
						
						<option disabled>-- Waterfall Charts --</option>
						<option value="posnegwaterfall"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'posnegwaterfall'){echo 'selected'; } ?>>Pos/Neg Waterfall Chart</option>

						<option disabled>-- Gantt Charts --</option>
						<option value="simpleganttchart"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'simpleganttchart'){echo 'selected'; } ?>>Simple Gantt Chart</option>
						
						<option disabled>-- Radar Charts --</option>
						<option value="simpleradar"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'simpleradar'){echo 'selected'; } ?>>Simple Radar Chart</option>
						<option value="multiradarchart"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'multiradarchart'){echo 'selected'; } ?>>Multi Radar Chart</option>
						
						<option disabled>-- Cones Charts --</option>
						<option value="cone"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'cone'){echo 'selected'; } ?>>Cone Chart</option>

						<option disabled>-- Pyramids/Cones/Funnels --</option>
						<option value="rotatedpyramidchart"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'rotatedpyramidchart'){echo 'selected'; } ?>>Rotated Pyramid Chart</option>
						
						<option disabled>-- Angular Meters/Guages --</option>
						<option value="semicirclemeter"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'semicirclemeter'){echo 'selected'; } ?>>Semicircle Meter</option>
						<option value="roundmeter"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'roundmeter'){echo 'selected'; } ?>>
					Round Meter</option>
					<option value="semicirclemetergreentored"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'semicirclemetergreentored'){echo 'selected'; } ?>>Semicircle Meter Green To Red</option>
						<option value="roundmetergreentored"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'roundmetergreentored'){echo 'selected'; } ?>>Round Meter Green To Red</option>
						<option value="semicircleMeterwithReadout"
						<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'semicircleMeterwithReadout'){echo 'selected'; } ?>>Semicircle Meter with Readout</option>
					
					<option disabled>-- Linear Meters/Guages --</option>
					<option value="horizontallinearmeter"
					<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'horizontallinearmeter'){echo 'selected'; } ?>>Horizontal Linear Meter</option>
					<option value="verticallinearmeter"
					<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'verticallinearmeter'){echo 'selected'; } ?>>
				Vertical Linear Meter</option>
				<option value="horizontallinearmetergreentored"
					<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'horizontallinearmetergreentored'){echo 'selected'; } ?>>Horizontal Linear Meter Green To Red</option>
					<option value="verticallinearmetergreentored"
					<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'verticallinearmetergreentored'){echo 'selected'; } ?>>
				Vertical Linear Meter Green To Red</option>
				
				<option disabled>-- Bar Meters/Guages --</option>
				<option value="horizontalbarmeter"
				<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'horizontalbarmeter'){echo 'selected'; } ?>>Horizontal Bar Meter</option>
				<option value="verticalbarmeter"
				<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'verticalbarmeter'){echo 'selected'; } ?>>Vertical Bar Meter</option>
				<option value="horizontalbarmetergreentored"
				<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'horizontalbarmetergreentored'){echo 'selected'; } ?>>Horizontal Bar Meter Green To Red</option>
				<option value="verticalbarmetergreentored"
				<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'verticalbarmetergreentored'){echo 'selected'; } ?>>Vertical Bar Meter Green To Red</option>
				<option value="blackhorizontalbarmeters"
				<?php if(isset($chartdetails->Chart_Type) && $chartdetails->Chart_Type == 'blackhorizontalbarmeters'){echo 'selected'; } ?>>Black Horizontal Bar Meters</option>
			</select>
		</div>
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
	<div class="row">
		<div class="col-md-4">
			<input type="hidden" name="id"
			value="<?php if(isset($_GET['edit'])){ echo $details->Chart_ID; } ?>">
			<label><span class="alert-danger">*</span>Select Game</label> 
			<select class="form-control"
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
		<label><span class="alert-danger">*</span>Select Scenario</label> 
		<select class="form-control"
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