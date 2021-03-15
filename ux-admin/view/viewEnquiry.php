<?php include_once doc_root.'ux-admin/common/header.php'; ?>

<?php if($_GET['view'] == ''){
	header("Location:".site_root."ux-admin/Enquiries");
	exit;
}?>

<div class="clearfix"></div>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Enquiries</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="<?php echo site_root."ux-admin/Enquiries"; ?>">Enquiries</a></li>
			<li class="active">View Enquiry</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<div class="form-group">
		<div class="col-sm-3 col-xs-3"><label>Name</label></div>
		<div class="col-sm-1 col-xs-1">:</div>
		<div class="col-sm-6 col-xs-8"><?php echo $enq_details['fname']." ".$enq_details['lname']; ?></div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-3 col-xs-3"><label>Email</label></div>
		<div class="col-sm-1 col-xs-1">:</div>
		<div class="col-sm-6 col-xs-8"><?php echo $enq_details['email']; ?></div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-3 col-xs-3"><label>Contact</label></div>
		<div class="col-sm-1 col-xs-1">:</div>
		<div class="col-sm-6 col-xs-8"><?php echo "(+91)".$enq_details['contact']; ?></div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-3 col-xs-3"><label>Message</label></div>
		<div class="col-sm-1 col-xs-1">:</div>
		<div class="col-sm-6 col-xs-8"><?php echo $enq_details['message']; ?></div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-3 col-xs-3"><label>Date</label></div>
		<div class="col-sm-1 col-xs-1">:</div>
		<div class="col-sm-6 col-xs-8"><?php echo $enq_details['date_time']; ?></div>
		<div class="clearfix"></div>
	</div>
	<div class="form-group text-center col-sm-10">
		<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageEnquiry"; ?>';">Back</button>
	</div>
</div>
<div class="clearfix"></div>