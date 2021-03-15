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

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<form action="" method="POST">
		<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $temp_id; ?>">
			<label>Comment</label>
			<input class="form-control" type="text" name="comment" value="<?php echo $template_details['comment']; ?>">
		</div>
		<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $temp_id; ?>">
			<label>Subject</label>
			<input class="form-control" type="text" name="subject" value="<?php echo $template_details['subject']; ?>">
		</div>
		<div class="form-group">
			<label>Content</label>
			<textarea id="content" class="form-control" name="content"><?php echo $template_details['content']; ?></textarea>
		</div>
		<div class="form-group">
			<label>From Email</label>
			<input class="form-control" type="text" name="from_email" value="<?php echo $template_details['from_email']; ?>">
		</div>
		<div class="form-group text-center">
			<?php if(isset($_GET['editTemplate'])){ ?>
				<button class="btn btn-primary" name="updateTemp" value="Update">Update</button>
				<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageEmailTemplates"; ?>';"> Back</button>
			<?php }else{ ?>
				<button class="btn btn-primary" name="addTemp" value="Submit">Submit</button>
			<?php } ?>
		</div>
	</form>
</div>

<div class="clearfix"></div>


<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	CKEDITOR.replace('content');
</script>