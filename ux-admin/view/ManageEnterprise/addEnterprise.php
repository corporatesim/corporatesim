<script type="text/javascript">
	<!--
		var loc_url_del = "ux-admin/ManageEnterprise/del/";
		var loc_url_stat = "ux-admin/ManageEnterprise/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Add Enterprise</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active">Add Enterprise</li>			
			</ul>
		</div>
	</div>

	<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

	<div class="row">
		<div class="col-lg-12">
			<div class="pull-right legend">
				<ul>
					<li><b>Legend : </b></li>
					<li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
					<li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
					<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>
					<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
					<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- DISPLAY ERROR MESSAGE -->
	<?php  if(!empty($tr_msg)) { ?>
		<div class="alert-danger alert"><?php echo $tr_msg; ?></div>
	<?php } ?>
	<?php  if(!empty($er_msg)) { ?>
		<div class="alert-danger alert"><?php echo $er_msg; ?></div>
	<?php } ?>
	<!-- DISPLAY ERROR MESSAGE END -->
	<div id="container">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group col-md-6">
					<label for="Enterprise"><span class="alert-danger">*</span> Enterprise Name</label>
					<input type="text" name="Enterprise" value="" class="form-control" required="">
				</div>
				<div class="form-group col-md-6">
					<label for="Enterprise"><span class="alert-danger">*</span> Choose Logo</label>
					<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
				</div>
			</div><br>
			<div class="row" id="sandbox-container">
				<div class="col-md-4">
					<label for="Game Duration"><span class="alert-danger">*</span>Select Account Duration</label>
				</div>
				<div class="input-daterange input-group col-md-6" id="datepicker">
					<input type="text" class="input-sm form-control" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate" value="" placeholder="Select Start Date" required readonly/>
					<span class="input-group-addon">to</span>
					<input type="text" class="input-sm form-control" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate" value="" placeholder="Select End Date" required readonly/>
				</div>
			</div><br>
			<div class="row text-center">
				<button type="submit" class="btn btn-primary " name="addEnterprise" value="addEnterprise" id="addEnterprise">SAVE</button>
				<a href="<?php echo site_root."ux-admin/ManageEnterprise"; ?>" class="btn btn-primary">CANCEL</a>
			</div>
		</form>
	</div>