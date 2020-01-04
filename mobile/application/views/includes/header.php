<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="<?php echo base_url('common/vendor/js/jQuery.js');?>"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->

	<link rel="stylesheet" href="<?php echo base_url('common/vendor/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('common/vendor/css/customStyle.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('common/vendor/font-awesome/css/font-awesome.min.css');?>">

	<script src="<?php echo base_url('common/vendor/js/bootstrap.popper.min.js');?>"></script>
	<script src="<?php echo base_url('common/vendor/js/bootstrap.min.js');?>"></script>

	<link href="<?php echo base_url();?>common/vendor/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>common/vendor/sweetalert/animate.min.css" rel="stylesheet" type="text/css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"> -->

	<script src="<?php echo base_url();?>common/vendor/sweetalert/sweetalert2.all.min.js"></script>
	<!-- pre-loader starts here -->
	<div id="pre-loader" class="col-md-12 overlay">
		<img src="<?php echo base_url('../images/loader.gif');?>" alt="Loader" style="width: 50px; position: fixed; bottom: 0; margin: 0; padding: 0;">
	</div>
	<!-- pre-loader ends here -->
</head>
<!-- <body style="background-image: url('<?php echo base_url("../images/bg3.jpg"); ?>');"> -->
	<script>
		$(document).ready(function(){
			$('marquee').each(function(){
				$(this).on('mouseover',function(){this.stop();});
				$(this).on('mouseout',function(){this.start();});
			});
		});
	</script>
	<style>
		.swal2-container.swal2-backdrop-show
		{
			background: #00000066;
		}
		.swal-size-sm
		{
			width: auto;
		}
		.custom-style-alert
		{
			width     : auto;
			height    : auto;
			margin-top: 70px !important;
		}
	</style>
	<body>
		<section id="bodySection">