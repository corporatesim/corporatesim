<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<meta name="keywords" content="HTML5 Admin Template" />
	<meta name="description" content="Porto Admin - Responsive HTML5 Template">
	<meta name="author" content="okler.net">

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('common/vendors');?>/images/favicon.ico">
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url('common/loginSignup');?>/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?php echo base_url('common/loginSignup');?>/vendor/modernizr/modernizr.js"></script>

</head>
<body>
	<!-- start: page -->
	<section class="body-sign">
		<div class="center-sign">
			<?php $this->load->view('components/trErMsg');?>
			<a href="<?php echo base_url();?>" class="logo pull-left">
				<img src="<?php echo base_url('common/loginSignup');?>/images/cs_logo.jpg" height="54" alt="Porto Admin" style="margin-top:12%;"/>
			</a>

			<div class="panel panel-sign">
				<div class="panel-title-sign mt-xl text-right">
					<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign Up</h2>
				</div>
				<div class="panel-body">
					<form action="<?php echo site_url('login/verifyLogin');?>" method="post">
						<div class="form-group mb-lg">
							<label>Name</label>
							<input name="name" type="text" class="form-control input-lg" />
						</div>

						<div class="form-group mb-lg">
							<label>E-mail Address</label>
							<input name="email" type="email" class="form-control input-lg" />
						</div>

						<div class="form-group mb-none">
							<div class="row">
								<div class="col-sm-6 mb-lg">
									<label>Password</label>
									<input name="pwd" type="password" class="form-control input-lg" />
								</div>
								<div class="col-sm-6 mb-lg">
									<label>Password Confirmation</label>
									<input name="pwd_confirm" type="password" class="form-control input-lg" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-8">
								<div class="checkbox-custom checkbox-default">
									<input id="AgreeTerms" name="agreeterms" type="checkbox"/>
									<label for="AgreeTerms">I agree with <a href="#">terms of use</a></label>
								</div>
							</div>
							<div class="col-sm-4 text-right">
								<button type="submit" class="btn btn-primary hidden-xs">Sign Up</button>
								<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign Up</button>
							</div>
						</div>

						<span class="mt-lg mb-lg line-thru text-center text-uppercase">
							<span>or</span>
						</span>

						<div class="mb-xs text-center">
							<a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
							<a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
						</div>

						<p class="text-center">Already have an account? <a href="<?php echo base_url();?>">Sign In!</a>

						</form>
					</div>
				</div>

				<!-- <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p> -->
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/jquery/jquery.js"></script>
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?php echo base_url('common/loginSignup');?>/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url('common/loginSignup');?>/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url('common/loginSignup');?>/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url('common/loginSignup');?>/javascripts/theme.init.js"></script>

	</body>
	</html>