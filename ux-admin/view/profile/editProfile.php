<div class="clearfix"></div>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Edit Profile</h1>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
	<ul class="breadcrumb">
		<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
		<li class="active"><a href="<?php echo site_root."ux-admin/MyProfile"; ?>">My Profile</a></li>
		<li class="active">Edit Profile</li>
	</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-sm-12">
		<form method="post" action="">
			<div class="form-group col-sm-5">
				<label><span class="mandatory"></span>Firstname</label>
				<input class="form-control" type="text" name="fname" value="<?php echo $details['fname']; ?>">
			</div>
			
			<div class="form-group col-sm-5">
				<label>Lastname</label>
				<input class="form-control" type="text" name="lname" value="<?php echo $details['lname']; ?>">
			</div>
			<div class="clearfix"></div>
			
			<div class="form-group col-sm-5">
				<label>Contact:</label>
				<div class="input-group">
					<span class="input-group-addon">+91</span>
					<input class="form-control" type="text" name="contact" value="<?php echo $details['contact']; ?>">
				</div>
			</div>
			
			<div class="form-group col-sm-10">
				<label><span class="mandatory"></span>Email</label>
				<input class="form-control" type="email" name="email" pattern="[a-z]+[a-z0-9_-\.]+@[a-z-_]+.[a-z]{2,3}" value="<?php echo $details['email']; ?>" >
			</div>
			
			<div class="form-group col-sm-10 text-center">
				<button class="btn btn-primary" type="submit" name="update" value="Update">Update</button>
				<button class="btn btn-danger" type="button" onclick="window.location='<?php echo site_root."ux-admin/MyProfile"; ?>';">Back</button>
			</div>
		</form>
	</div>
</div>

<div class="clearfix"></div>