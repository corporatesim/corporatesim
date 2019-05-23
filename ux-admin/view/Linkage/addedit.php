
<style type="text/css">
span.alert-danger {
	background-color: #ffffff;
	font-size: 18px;
}
</style>

<!-- <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script> -->
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
				<li class="active"><a href="javascript:void(0);">Manage Linkage</a></li>
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
			<div class="row">
				<!-- adding this checkbox for component branching -->
				<div class="row name col-md-2 col-lg-3 col-sm-12 col-xs-12" id="branchingCheckbox">
					<div class="form-group" data-toggle="tooltip" title="If checked, then only component branching enabled scenario will be visible">
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="Link_Branching" name="Link_Branching" value="1" <?php echo ($linkdetails->Link_Branching == 1)?'checked':'';?>>
							<label class="form-check-label" for="Component Branching">Component Branching</label>
						</div>
					</div>
				</div>
				<!-- end of checkbox for component branching -->
				<!-- adding checkbox to skip introduction and description -->
				<div class="row name col-md-2 col-lg-2 col-sm-12 col-xs-12" id="skipIntroduction">
					<div class="form-group">
						<div class="form-check" data-toggle="tooltip" title="If checked, then skipped for current game">
							<input type="checkbox" class="form-check-input" id="Link_Introduction" name="Link_Introduction" value="1" <?php echo ($linkdetails->Link_Introduction == 1)?'checked':'';?>>
							<label class="form-check-label" for="Skip Introduction">Skip Introduction</label>
						</div>
					</div>
				</div>

				<div class="row name col-md-2 col-lg-2 col-sm-12 col-xs-12" id="skipDescription">
					<div class="form-group">
						<div class="form-check" data-toggle="tooltip" title="If checked, then skipped for current scenario">
							<input type="checkbox" class="form-check-input" id="Link_Description" name="Link_Description" value="1" <?php echo ($linkdetails->Link_Description == 1)?'checked':'';?>>
							<label class="form-check-label" for="Skip Description">Skip Description</label>
						</div>
					</div>
				</div>

				<div class="row name col-md-2 col-lg-2 col-sm-12 col-xs-12" id="skipDescription">
					<div class="form-group">
						<div class="form-check" data-toggle="tooltip" title="If checked, then skipped for current scenario">
							<input type="checkbox" class="form-check-input" id="Link_IntroductionLink" name="Link_IntroductionLink" value="1" <?php echo ($linkdetails->Link_IntroductionLink == 1)?'checked':'';?>>
							<label class="form-check-label" for="Skip Description">Hide Introduction Link</label>
						</div>
					</div>
				</div>

				<div class="row name col-md-2 col-lg-2 col-sm-12 col-xs-12" id="skipDescription">
					<div class="form-group">
						<div class="form-check" data-toggle="tooltip" title="If checked, then skipped for current scenario">
							<input type="checkbox" class="form-check-input" id="Link_DescriptionLink" name="Link_DescriptionLink" value="1" <?php echo ($linkdetails->Link_DescriptionLink == 1)?'checked':'';?>>
							<label class="form-check-label" for="Skip Description">Hide Description Link</label>
						</div>
					</div>
				</div>

				<div class="row name col-md-2 col-lg-2 col-sm-12 col-xs-12" id="skipBackToIntro">
					<div class="form-group">
						<div class="form-check" data-toggle="tooltip" title="If checked, then skipped for current scenario">
							<input type="checkbox" class="form-check-input" id="Link_BackToIntro" name="Link_BackToIntro" value="1" <?php echo ($linkdetails->Link_BackToIntro == 1)?'checked':'';?>>
							<label class="form-check-label" for="Skip BackToIntro">Hide Back To Intro</label>
						</div>
					</div>
				</div>
				<!-- end of adding checkbox to skip introduction and description -->
				<div class="col-md-4">
					<input type="hidden" name="id"
					value="<?php if(isset($_GET['edit'])){ echo $details->Link_ID; } ?>">
					<label><span class="alert-danger">*</span>Select Game</label> <select class="form-control"
					name="game_id" id="game_id">
					<option value="">-- SELECT --</option>
					<?php while($row = $game->fetch_object()){ ?>
						<option value="<?php echo $row->Game_ID; ?>"
							<?php if(isset($linkdetails->Link_GameID) && $linkdetails->Link_GameID == $row->Game_ID){echo 'selected'; } ?>>
							<?php echo $row->Game_Name; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-4" >
				<label><span class="alert-danger">*</span>Select Scenario</label> <select class="form-control"
				name="scen_id" id="scen_id" required="">
				<option value="">-- SELECT --</option>
				<!-- if branching default -->
				<?php if($linkdetails->Link_Branching != 1) { while($row = $scenario->fetch_object()){ 
					$appendScenario[] = $row;
					?>
					<option value="<?php echo $row->Scen_ID; ?>"
						<?php if(isset($linkdetails->Link_ScenarioID) && $linkdetails->Link_ScenarioID == $row->Scen_ID){echo 'selected'; } ?>>
						<?php echo $row->Scen_Name; ?>
					</option>
				<?php } } else { ?>
					<!-- if component branching enabled -->
					<?php while($row = $BranchScenario->fetch_object()){ 
						$appendBranchScenario[] = $row;
						?>
						<option value="<?php echo $row->Scen_ID; ?>"
							<?php if(isset($linkdetails->Link_ScenarioID) && $linkdetails->Link_ScenarioID == $row->Scen_ID){echo 'selected'; } ?>>
							<?php echo $row->Scen_Name; ?>
						</option>
					<?php } } ?>
				</select>
			</div>
			<div class="col-md-4">
				<label><span class="alert-danger">*</span>Order</label>
				<div class="form-group">
					<div class="input-group">						
						<input type="text" name="order" id="order" value="<?php if(!empty($linkdetails->Link_Order)) echo $linkdetails->Link_Order; ?>"
						class="form-control"	required>
					</div>
					<div class="contact_error"></div>
				</div>
			</div>
		</div>
		<div class="row">

		</div>
		<div class="row">
			<div class="col-md-3" >
				<label><span class="alert-danger">*</span>Hour</label> 
				<input type="text" name="hour" id="hour" value="<?php if(!empty($linkdetails->Link_Hour)) echo $linkdetails->Link_Hour; ?>"
				class="form-control"	required>
			</div>
			<div class="col-md-3" >
				<label><span class="alert-danger">*</span>Minutes</label> 
				<input type="text" name="minute" id="minute" value="<?php if(!empty($linkdetails->Link_Min)) echo $linkdetails->Link_Min; ?>"
				class="form-control"	required>			
			</div>
			<div class="col-md-3">
				<label><span class="alert-danger">*</span>Mode</label>

				<div class="form-group">
					<input type="radio" name="Mode" value="1"
					<?php if(!empty($linkdetails) && $linkdetails->Link_Mode == 1){ echo "checked"; } ?> > Manual
					<input type="radio" name="Mode" value="0"
					<?php if(!empty($linkdetails) && $linkdetails->Link_Mode == 0){ echo "checked"; } ?> > Automatic

				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox" <?php if(!empty($linkdetails) && $linkdetails->Link_Mode == 1){} else { echo "style='display:none;'";}?>>
					<input type='checkbox' name='enabled' <?php if(!empty($linkdetails) && $linkdetails->Link_Enabled == 1){ echo "checked"; } ?>>Enabled
				</div>
			</div>
		</div>

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

<script>
	<!--
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			$('input[type="radio"]').click(function(){
				if($(this).attr("value")=="1"){            
					$(".checkbox").show();
				}
				else{
					$(".checkbox").hide();
				}
			});
			$('#Link_Branching').on('click',function(){
				var appendScenario       = '<option value="">--Select Scenario--</option>';
				var appendBranchScenario = '<option value="">--Select Branching Scenario--</option>';
				if(!$(this).is(':checked'))
				{
				// console.log('"<?php // print_r($appendScenario); ?>"');
				<?php foreach ($appendScenario as $row ) { ?>
					appendScenario += "<option value='<?php echo $row->Scen_ID; ?>'><?php echo $row->Scen_Name?></option>"
				<?php } ?>
				// console.log(appendScenario);
				$('#scen_id').html(appendScenario);
			}
			else
			{
				// $('#scen_id').html(options);
				<?php foreach ($appendBranchScenario as $row ) { ?>
					appendBranchScenario += "<option value='<?php echo $row->Scen_ID; ?>'><?php echo $row->Scen_Name?></option>"
				<?php } ?>
				$('#scen_id').html(appendBranchScenario);
			}
		});
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
		});

// -->
</script>

<script type="text/javascript">
	$(document).ready(function(){
	$("#game_id").select2();
	$("#scen_id").select2();
});
</script>
