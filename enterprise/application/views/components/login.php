<!-- <?php //  echo "<pre>"; print_r($logo); exit(); ?> -->
	<!doctype html>
	<html class="fixed">
	<head>
		<title>Enterprize Login</title>

		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="CorporateSim Enterprise Login" />
		<meta name="description" content="CorporateSim Enterprise Login">
		<meta name="author" content="okler.net">

		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('common/vendors/images/favicon.ico');?>">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/vendor/bootstrap/css/bootstrap.css?v=').file_version_cs;?>" />
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/vendor/font-awesome/css/font-awesome.css?v=').file_version_cs;?>" />
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/vendor/magnific-popup/magnific-popup.css?v=').file_version_cs;?>" />
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/vendor/bootstrap-datepicker/css/datepicker3.css?v=').file_version_cs;?>" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/stylesheets/theme.css?v=').file_version_cs;?>" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/stylesheets/skins/default.css?v=').file_version_cs;?>" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url('common/loginSignup/stylesheets/theme-custom.css?v=').file_version_cs;?>">

		<!-- Head Libs -->
		<script src="<?php echo base_url('common/loginSignup/vendor/modernizr/modernizr.js?v=').file_version_cs;?>"></script>

	</head>
	<?php
		// prd($_SERVER);
	if(strpos($_SERVER['HTTP_HOST'], 'localhost') !== FALSE)
	{
		echo "<body style='background-color:#d9534f;'>";
	}
	elseif(strpos($_SERVER['HTTP_HOST'], 'develop.corpsim.in') !== FALSE)
	{
		echo "<body style='background-color:#337ab7;'>";
	}
	else
	{
		echo "<body>";
	}
	?>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="<?php echo base_url();?>" class="logo pull-left">
					<img src="<?php echo $logo;?>" alt="CorporateSim Logo" style="margin-top: 11%; max-width: 300px; height: 45px;"/>
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
					</div>
					<div class="panel-body">
						<?php $this->load->view('components/trErMsg');?>
						<form action="<?php echo site_url('login/verifyLogin');?>" method="post">
							<div class="form-group mb-lg">
								<label>Username/Email</label>
								<div class="input-group input-group-icon">
									<input name="Users_Email" type="text" class="form-control input-lg" placeholder="Enter Username/Email" required="" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">Password</label>

								</div>
								<div class="input-group input-group-icon">
									<input name="Users_Password" type="password" class="form-control input-lg" placeholder="Enter Password" required="" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">
										<input id="RememberMe" name="rememberme" type="checkbox"/>
										<label for="RememberMe">Remember Me</label>
									</div>
								</div>

								<a href="<?php echo base_url('login/requestPassword'); ?>" class="pull-right">Lost Password?</a>

								<div class="col-sm-4 text-right" style="margin-top:10px;">
									<button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
									<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
								</div>
							</div>

						<!-- <span class="mt-lg mb-lg line-thru text-center text-uppercase">
							<span>or</span>
						</span>

						<div class="mb-xs text-center">
							<a class="btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class="fa fa-facebook"></i></a>
							<a class="btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class="fa fa-twitter"></i></a>
						</div>

						<p class="text-center">Don't have an account yet? <a href="<?php echo base_url('login/signUp'); ?>">Sign Up!</a> -->

						</form>
					</div>
				</div>

				<!-- <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p> -->
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="<?php echo base_url('common/loginSignup/vendor/jquery/jquery.js?v=').file_version_cs;?>"></script>
		<script src="<?php echo base_url('common/loginSignup/vendor/jquery-browser-mobile/jquery.browser.mobile.js?v=').file_version_cs;?>"></script>
		<script src="<?php echo base_url('common/loginSignup/vendor/bootstrap/js/bootstrap.js?v=').file_version_cs;?>"></script>
		<script src="<?php echo base_url('common/loginSignup/vendor/nanoscroller/nanoscroller.js?v=').file_version_cs;?>"></script>
		<script src="<?php echo base_url('common/loginSignup/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js?v=').file_version_cs;?>"></script>
		<script src="<?php echo base_url('common/loginSignup/vendor/magnific-popup/magnific-popup.js?v=').file_version_cs;?>"></script>
		<script src="<?php echo base_url('common/loginSignup/vendor/jquery-placeholder/jquery.placeholder.js?v=').file_version_cs;?>"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url('common/loginSignup/javascripts/theme.js?v=').file_version_cs;?>"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url('common/loginSignup/javascripts/theme.custom.js?v=').file_version_cs;?>"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url('common/loginSignup/javascripts/theme.init.js?v=').file_version_cs;?>"></script>

	</body>
	<!-- <img src="http://www.ten28.com/fref.jpg"> -->
	</html>