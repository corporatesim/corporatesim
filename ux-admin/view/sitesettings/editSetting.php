<div class="clearfix"></div>


<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Edit Site Setting</h1>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="<?php echo site_root."ux-admin/SiteSettings"; ?>">Site Settings</a></li>
			<li class="active">Edit Site Settings</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<form action="" method="post">
		<div class="form-group">
			<input type="hidden" name="sid" value="<?php echo $editsetting['id'];?>">
			<label>Name</label>
			<input class="form-control" type="text" name="title" value="<?php echo $editsetting['name'];?>" disabled>
		</div>
		<div class="form-group">
			<label>Value</label>
			<textarea class="form-control" name="value"><?php echo $editsetting['value'];?></textarea>
		</div>
		<div class="form-group text-center">
			<button class="btn btn-primary" type="submit" name="settings" value="Update">Update</button>
			<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/SiteSettings"; ?>';">Back</button>
		</div>
	</form>
</div>
<div class="clearfix"></div>
