<div class="clearfix"></div>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Change Password</h1>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
	<ul class="breadcrumb">
		<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
		<li class="active"><a href="<?php echo site_root."ux-admin/MyProfile"; ?>">My Profile</a></li>
		<li class="active">Change Password</li>
	</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<div class="col-sm-5">
		<form method="post" action="">
			<div class="form-group">
				<label>Old Password</label>
				<input class="form-control" type="password" name="old_pass">
			</div>
			<div class="form-group">
				<label>New Password</label>
				<input class="form-control" type="password" name="new_pass">
			</div>
			<div class="form-group">
				<label>Retype Password</label>
				<input class="form-control" type="password" name="retype_pass">
			</div>
			<div class="form-group text-center">
				<button class="btn btn-primary" type="submit" name="changePassword" value="Change Password">Change Password</button>
				<button class="btn btn-danger" type="button" onclick="window.location='<?php echo site_root."ux-admin/MyProfile"; ?>';">Back</button>
			</div>
		</form>
	</div>
</div>

<div class="clearfix"></div>
