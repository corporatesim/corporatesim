<?php 
include_once 'includes/header.php'; 

?>
<?php if(isset($msg)){
		//echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";
} ?>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<script src="<?php echo site_root;?>js/jquery.min.js"></script>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<link rel="stylesheet" href="<?php echo site_root;?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo site_root;?>css/UserStyle.css">


</head>

<body style="background-image: url('images/bg1.jpg');">
	
	<div class="container" id="loginForm">
		<!-- login form -->
		<form method="post" action="" id="register">
			<div id="login-box">
				<div class="row text-center alert-danger hidden" id="showMsg"></div>
				<h1 class="caption"><span class="tweak">L</span>ogin</h1><br>
				<?php if(isset($msg)){ 
						//echo $type[0]." ".$type[1];
					?>
					<div class="clearfix"></div>
					<div class="<?php echo $type ?>">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<center>
							<strong><?php echo $msg ?></strong>
						</center>
					</div>
					<div class="clearfix"></div>
				<?php } ?>
				<div class="form-group">
					<input type="text" name="username" id="username" placeholder="username" class="form-control" required="required"/>
					<br>
					<input type="password" name="password" id="password" placeholder="password" class="form-control" required="required"/>
					<br>
					<div class="col-sm-8 col-sm-offset-2 text-right pull-right" style="padding-bottom:2px;">
						<a href="javascript:void(0);" class="blueColor regular" id="resetPassword">Forgot Password ?</a>
					</div>

					<div class="col-sm-12 text-center">
						<button class="btn  btn-default  btn-custom" name="submit" id="submit" value="Login" style="height:40px;width:100px;">Login</button>
						<button type="button" class="btn  btn-default  btn-custom hidden" name="back" id="back" value="back" onclick="location.href='registration.php'">Back</button></div>
						<div class="clearfix"></div><br>
						<div class="text-center hidden" style="color: #ffffff;">Dont have account? &nbsp;&nbsp;<a href="javascript:void(0);" id="registerBtn">Register</a></div>

					</div><!-- /.controls -->
					

				</div><!-- /#login-box -->
			</form>
		</div>

		<div class="row hidden" id="forgotPassword"><br><br>
			<br><br>
			<form role="form" method="post" action="">				
				<div class="col-sm-8 col-md-6 loginBg col-sm-offset-2 col-md-offset-3" style="background:#ffffff;height:320px;margin-top:7%;padding-top:10px;">
					<div class="col-sm-12 text-center">
						<h1 class="pageHeadLine text-primary">Forgot Password</h1>
					</div>
					<div class="form-group col-sm-8 col-sm-offset-2">
						<label class="text-primary">Email ID</label>
						<input type="Email" id="registeredEmail" name="registeredEmail" class="form-control" placeholder="Enter your registered Email ID" required=""></input>
					</div>
					<div class="form-group col-sm-8 col-sm-offset-2">
						<button class="btn btn-primary" value="resetPassword" name="reset">Request Password</button>
					</div>
					<div class="col-sm-8 col-sm-offset-2 text-right">
						<a href="javascript:void(0);" class="blueColor regular" id="loginHere">Login Here</a>
					</div>
				</div>
			</form>
		</div>
		
		<script>
			$(document).ready(function(){
				$('#resetPassword').on('click',function(){
					$('#loginForm').addClass('hidden');
					$('#forgotPassword').removeClass('hidden');
				});
				$('#loginHere').on('click',function(){
					$('#loginForm').removeClass('hidden');
					$('#forgotPassword').addClass('hidden');
				});
			});
		</script>

		<?php include_once 'includes/footer.php'; // print_r($_SESSION); ?>
