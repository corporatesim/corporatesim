<?php include_once doc_root.'ux-admin/common/header.php'; ?>
<style type="text/css" media="all">
	@import "<?php echo site_root; ?>components/widgeditor/css/widgEditor.css";
</style>

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
		<li class="active"><a href="<?php echo site_root."ux-admin/Enquiries"; ?>">Enquiries</a></li>
		<li class="active"><?php echo $header; ?></li>
	</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<form action="" method="post">
<div class="row">
	<div class="col-sm-10">
		<input type="hidden" name="enquiry_id" value="<?php echo $enq_id; ?>">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-3 col-xs-3"><label>Name</label></div>
				<div class="col-sm-1 col-xs-1">:</div>
				<div class="col-sm-6 col-xs-8"><?php echo $enq_details['fname']." ".$enq_details['lname']; ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-xs-3"><label>Email</label></div>
				<div class="col-sm-1 col-xs-1">:</div>
				<div class="col-sm-6 col-xs-8"><?php echo $enq_details['email']; ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-xs-3"><label>Company</label></div>
				<div class="col-sm-1 col-xs-1">:</div>
				<div class="col-sm-6 col-xs-8"><?php echo "(+91)".$enq_details['contact']; ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-xs-3"><label>Message</label></div>
				<div class="col-sm-1 col-xs-1">:</div>
				<div class="col-sm-6 col-xs-8"><?php echo $enq_details['message']; ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-xs-3"><label>Date</label></div>
				<div class="col-sm-1 col-xs-1">:</div>
				<div class="col-sm-6 col-xs-8"><?php echo $enq_details['date_time']; ?></div>
				<div class="clearfix"></div>
			</div>

			<div class="row form-group">
				<br />
				<label>Subject</label>
				<input class="form-control" name="subject" value="">
			</div>
			<div class="row form-group">
				<label>Message</label>
				<textarea id="reply_msg" class="form-control" style="resize:none;" rows="5" name="reply_msg"></textarea>
			</div>
			<div class="form-group text-center col-sm-10">
				<button class="btn btn-primary" type="submit" name="Reply" value="Reply">Reply</button>
				<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageEnquiry"; ?>';">Back</button>
			</div>
		</div>
	</div>
</div>
</form>

<script src="<?php echo site_root; ?>components/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	CKEDITOR.replace('reply_msg');
</script>

<?php include_once doc_root.'ux-admin/common/footer.php'; ?>