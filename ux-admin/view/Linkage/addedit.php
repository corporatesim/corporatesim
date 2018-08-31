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
        if($(this).attr("value")=="1"){            
            $(".checkbox").show();
        }
		else{
			$(".checkbox").hide();
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
					name="scen_id" id="scen_id">
					<option value="">-- SELECT --</option>
						<?php while($row = $scenario->fetch_object()){ ?>
							<option value="<?php echo $row->Scen_ID; ?>"
						<?php if(isset($linkdetails->Link_ScenarioID) && $linkdetails->Link_ScenarioID == $row->Scen_ID){echo 'selected'; } ?>>
								<?php echo $row->Scen_Name; ?>
							</option>
						<?php } ?>
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
