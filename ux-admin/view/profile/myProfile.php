<style>
.action_panel{
	float:none;
	text-align:left;
}
@media screen and (min-width:768px){
	.action_panel{
		float:right;
	}
}
</style>
<div class="clearfix"></div>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">My Profile</h1>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
	<ul class="breadcrumb">
		<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
		<li class="active">My Profile</li>
	</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<div class="row">
		<div class="form-group col-sm-5 col-md-3 action_panel">
			<div class="panel panel-default">
				<div class="panel-heading">Actions</div>
				<div class="panel-body">
					<p><a href="<?php echo site_root."ux-admin/MyProfile/edit/".base64_encode(true);?>"><i class="fa fa-pencil"></i> Edit Profile</a></p>
					<p><a href="<?php echo site_root."ux-admin/MyProfile/ChangePassword/".base64_encode(true);?>"><i class="fa fa-pencil"></i> Change Password</a></p>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-7 col-md-9">
			<div class="row">
				<div class="col-sm-12">
					<label>Contact Information</label>
					<div class="row">
						<div class="col-sm-4 col-md-3">Email :</div>
						<div class="col-sm-8 col-md-9"><?php echo $details['email']; ?></div>
						<div class="clearfix"></div>
						<div class="col-sm-4 col-md-3">Contact :</div>
						<div class="col-sm-8 col-md-9"><?php echo !empty($details['contact']) ? "+91".$details['contact']: ""; ?></div>
					</div>
				</div>
				<div class="col-sm-12">
					<label>General Information</label>
					<div class="row">
						<div class="col-sm-4 col-md-3">Name :</div>
						<div class="col-sm-8 col-md-9"><?php echo $details['fname']." ".$details['lname']; ?></div>
						<div class="clearfix"></div>
						<div class="col-sm-4 col-md-3">Username :</div>
						<div class="col-sm-8 col-md-9"><?php echo $details['username']; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>