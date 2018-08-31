<div class="clearfix"></div>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header"><?php echo $header; ?></h1>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="completed"><a href="<?php echo site_root."ux-admin/ManageEmailTemplates"; ?>">Manage Email Templates</a></li>
			<li class="active"><?php echo $header; ?></li>
		</ul>
	</div>
</div>

<div class="col-sm-12">
	<div class="col-sm-12 form-group">
		<div class="col-sm-3"><label>Subject : </label></div>
		<div class="col-sm-9"><?php echo $template_details['subject']; ?></div>			
	</div>
	<div class="col-sm-8 form-group">
		<div class="col-sm-3"><label>Content : </label></div>
		<div class="col-sm-9"><?php echo $template_details['content']; ?></div>			
	</div>
	<div class="col-sm-8 form-group">
		<div class="col-sm-3"><label>From Email : </label></div>
		<div class="col-sm-9"><?php echo $template_details['from_email']; ?></div>			
	</div>
	<div class="col-sm-12 form-group text-center">
		<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageEmailTemplates/editTemplate/".$_GET['viewTemplate']; ?>'">Edit</button>
		<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageEmailTemplates"; ?>'">Back</button>		
	</div>
</div>
<div class="clearfix"></div>

<?php include_once doc_root.'ux-admin/common/footer.php'; ?>