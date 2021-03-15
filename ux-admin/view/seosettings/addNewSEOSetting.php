<div class="clearfix"></div>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Add Script</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="<?php echo site_root."ux-admin/SEOSettings"; ?>">SEO Settings</a></li>
			<li class="active">Add Script</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" >
				<div id="code" class="row">
					<div class="form-group">
						<label class="control-label col-sm-2" for="type">Type:</label>
						<div class="col-sm-8">
							<select class="form-control" id="type" name="type" onchange="showhide();">
								<option value="meta">Search Engine verification Code</option>
								<option value="script">Analytic Script</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="code_value">Code:</label>
						<div class="col-sm-8">
							<textarea class="form-control" id="code_value" name="code_value"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div id="uploadfile" class="form-group">
						<label class="control-label col-sm-2" for="usr_file">Upload File:</label>
						<div class="col-sm-8">
							<input class="form-control" id="usr_file" type="file" name="usr_file">
						</div>
					</div>
				</div>
				<div class="form-group col-sm-12 text-center">
					<input class="btn btn-primary" type="submit" name="AddSetting" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>
<div class="clearfix"></div>