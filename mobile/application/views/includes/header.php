<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="<?php echo base_url('common/vendor/js/jQuery.js?v=').file_version_cs;?>"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->

	<link rel="stylesheet" href="<?php echo base_url('common/vendor/css/bootstrap.min.css?v=').file_version_cs;?>">
	<link rel="stylesheet" href="<?php echo base_url('common/vendor/css/customStyle.css?v=').file_version_cs;?>">
	<link rel="stylesheet" href="<?php echo base_url('common/vendor/font-awesome/css/font-awesome.min.css?v=').file_version_cs;?>">

	<script src="<?php echo base_url('common/vendor/js/bootstrap.popper.min.js?v=').file_version_cs;?>"></script>
	<script src="<?php echo base_url('common/vendor/js/bootstrap.min.js?v=').file_version_cs;?>"></script>

	<link href="<?php echo base_url('common/vendor/sweetalert/sweetalert2.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('common/vendor/sweetalert/animate.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"> -->

	<script src="<?php echo base_url('common/vendor/sweetalert/sweetalert2.all.min.js?v=').file_version_cs;?>"></script>
	<!-- pre-loader starts here -->
	<div id="pre-loader" class="col-md-12 overlay">
		<img src="<?php echo base_url('../images/loader.gif?v=').file_version_cs;?>" alt="Loader" style="width: 50px; position: fixed; bottom: 0; margin: 0; padding: 0;">
	</div>
	<!-- pre-loader ends here -->
</head>
<!-- <body style="background-image: url('<?php echo base_url("../images/bg3.jpg"); ?>');"> -->
	<script>
		$(document).ready(function(){
			csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
			csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
			
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
		/*to hide the radio button*/
		/*.custom-control-label::before{
			width: 1px;
			height: 1px;
		}
		.custom-control-label::after{
			width: 1px;
			height: 1px;
		}*/
	</style>
	<body>
		<section id="bodySection" style="background-image: url(<?php echo base_url('../images/mobileHomePage.png');?>); min-height: 100vh;">