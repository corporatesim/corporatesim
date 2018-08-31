<style type="text/css">
span.alert-danger {
	background-color: #ffffff;
	font-size: 18px;
}
</style>

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
			<li class="active"><a href="javascript:void(0);">Master Management</a></li>
			<li class="active"><a
				href="<?php echo site_root."ux-admin/ManageGame"; ?>"> Manage 
					Scenario</a></li>
			<li class="active"><?php echo $header; ?></li>
		</ul>
	</div>
</div>
<?php if(isset($_GET['edit'])){ ?>
<div class="row">
	<div class="col-lg-12">		
		<div class="right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
			<a href="<?php echo site_root."ux-admin/ManageScenario"; ?>"
				title="Scenario List"> Back</a> | 
			<a href="<?php echo site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($scendetails->Scen_ID); ?>"
				title="General"><span class="fa fa-book"></span> Content</a> | 				
			<a href="<?php echo site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($scendetails->Scen_ID); ?>"
				title="Document"><span class="fa fa-image"></span> Document</a> | 
			<a href="<?php echo site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($scendetails->Scen_ID); ?>"
				title="Image"><span class="fa fa-image"></span> Image</a> |
			<a href="<?php echo site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($scendetails->Scen_ID); ?>"
				title="Video"><span class="fa fa-video-camera"></span> Video</a>	
		</div>
	</div>
</div>
<?php } ?>		
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

<div class="col-sm-10">
	<form method="POST" action="" id="scen_frm" name="scen_frm">		
		<div class="row name" id="name">
			<div class="col-sm-6">
				<input type="hidden" name="id"
					value="<?php if(isset($_GET['edit'])){ echo $scendetails->Scen_ID; } ?>">
				<div class="form-group">
					<label for="name"><span class="alert-danger">*</span>Name</label>
					<input type="text" name="name"
						value="<?php if(!empty($scendetails->Scen_Name)) echo $scendetails->Scen_Name; ?>"
						class="form-control" placeholder="Scenario Name" required>
				</div>
			</div>
		</div>
		<div class="row name" id="comments">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="name"><span class="alert-danger">*</span>Comments</label>
					<textarea id="comments" name="comments" class="form-control" placeholder="Comments"><?php if(!empty($scendetails->Scen_Comments)) echo $scendetails->Scen_Comments; ?></textarea>
				</div>
			</div>					
		</div>		

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-center">
				<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
					<button type="button" id="scen_btn_update" class="btn btn-primary"
						> Update </button>
					<button type="submit" name="submit" id="scen_update" class="btn btn-primary hidden"
						value="Update"> Update </button>
					<button type="button" class="btn btn-primary"
						onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }else{?>
					<button type="button" id="scen_btn" class="btn btn-primary"
						value="Submit"> Add </button>
					<button type="submit" name="submit" id="scen_sbmit"
						class="btn btn-primary hidden" value="Submit"> Add </button>
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

$('#scen_btn').click( function(){
//	if($("#siteuser_frm").valid()){		
		$( "#scen_sbmit" ).trigger( "click" );
//	}
});

$('#scen_btn_update').click( function(){
//	if($("#siteuser_frm").valid()){
		$( "#scen_update" ).trigger( "click" );
//	}
});

// -->
</script>
