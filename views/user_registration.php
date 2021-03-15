<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<script src="<?php echo site_root;?>js/jquery.min.js"></script>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<link rel="stylesheet" href="<?php echo site_root;?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo site_root;?>css/UserStyle.css">

	<title> User Register</title>
</head>
<body background="<?php echo site_root;?>images/bg1.jpg">
	<nav class="navbar navbar-fixed-top" style="background: #ffffff; border-color: #000000;">
		<div class="container">
			<div class="navbar-header">
				<!--<a class="navbar-brand logo" href="#">Logo</a>-->
				<!--a style="padding: 2px 15px;" class="navbar-brand" href="http://localhost/corp_simulation/index.php"--> 
				<img src="<?php echo site_root;?>images/logo-main.png" width="40px" style="margin-top: 2px;">
				<!--/a-->
			</div>
			<div>
				<button name="login" value="login" class="btn btn-lg btn-primary  pull-right" style="margin-top: 2px;" onclick="window.location='login.php'">Login</button>
			</div>
		</div>
	</nav>
	<div class="clearfix"></div><br>
	<!-- login form -->
	<div class="container" id="loginForm">
		<form method="post" action="" id="register">
			<div id="login-box">
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
					<input type="text" name="username" id="username" placeholder="username" class="form-control" required="required" /><br>
					<input type="password" name="password" id="password" placeholder="password" class="form-control" required="required"/><br>
					
					<div class="col-sm-8 col-sm-offset-2 text-right pull-right" style="padding-bottom:2px;">
						<a href="javascript:void(0);" class="blueColor regular" id="resetPassword">Forgot Password ?</a>
					</div>

					<div class="col-sm-12 text-center">
						<button class="btn  btn-default  btn-custom" name="submit" id="submit" value="Login">Login</button>
						<button type="button" class="btn  btn-default  btn-custom" name="back" id="back" value="back" onclick="location.href='registration.php'">Back</button></div>
						<div class="clearfix"></div><br>
						<div class="text-center" style="color: #ffffff;">Dont have account? &nbsp;&nbsp;<a href="javascript:void(0);" id="registerBtn">Register</a></div>

					</div><!-- /.controls -->

				</div><!-- /#login-box -->
			</form>
		</div>

		<!-- forget password -->
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

		<!-- registration form -->
		<div class="container hidden" id="registrationForm">
			
			<form method="post" action="" id="register">
				<div id="login-box">
					<div class="row text-center alert-danger hidden" id="showMsg"></div>

					<h1 class="caption"><span class="tweak">R</span>egister</h1><br>

					<div class="form-group">

						<input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control" required="required" /><br>
						<input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control" required="required"/><br>
						<input type="email" name="email" id="email" placeholder="Email" class="form-control"  required="required"><br>
						<input type="text" name="username" id="username" placeholder="Username" class="form-control" required="required"><br>
						<input type="text" name="mobile" placeholder="Mobile No." class="form-control"  required="required"/><br>
						<input type="text" name="game" placeholder="Game Name" class="form-control"  required="required" readonly="readonly" value="<?php echo $run->Game_Name?>" /><br>
						<div class="col-sm-12 text-center">

							<button class="btn  btn-default  btn-custom" name="submit" id="Submit" value="register" disabled="disabled">Submit</button>
							<button type="button" class="btn  btn-default  btn-custom" name="back" id="back" value="back" onclick="location.href='registration.php'">Back</button></div>
							<div class="clearfix"></div><br>

							<div class="text-center" style="color: #ffffff;">Already have an account? &nbsp;&nbsp;<a href="javascript:void(0);" id="loginBtn">Login</a></div>

						</div><!-- /.controls -->

					</div><!-- /#login-box -->
				</form>
			</div><!-- /.container -->

			<script>

				$(document).ready(function(){
					/*register page and login page at only one time....*/
					$('#registerBtn').on('click',function(){
						$('#registrationForm').removeClass('hidden');
						$('#loginForm').addClass('hidden');
					});
					$('#loginBtn').on('click',function(){
						$('#loginForm').removeClass('hidden');
						$('#registrationForm').addClass('hidden');
					});

					/*login page and reset password page at only one time...*/
					$('#resetPassword').on('click',function(){
						$('#loginForm').addClass('hidden');
						$('#forgotPassword').removeClass('hidden');
					});
					$('#loginHere').on('click',function(){
						$('#loginForm').removeClass('hidden');
						$('#forgotPassword').addClass('hidden');
					});


					$('#email').on('change blur', function(){
						var email = $(this).val();
						var gameId = "<?php echo $_GET['ID']; ?>";
					// console.log($(this).val());
					$.ajax({
						type:'POST',
						url :'<?php echo site_root;?>/user_registration.php',
						data: "action=checkExistance&email="+email+"&gameId="+gameId,
						success:function(result)
						{
							// console.log(result); return false;
							if(result.trim() == 'allow')
							{
								// newUser / notRegistered
								$('#showMsg').addClass('hidden');
								$('#Submit').removeAttr('disabled',false);
								$('#reset').remove();
								console.log('newUser '+result);
							}
							/*else if(result.trim() == 'reset allow')
							{
								// if user already have the same game and played then reset and allow
								$('#showMsg').addClass('hidden');
								$('#reset').remove();
								$('#register').append("<input type='hidden' name='reset' value='reset' id='reset'>");
								$('#Submit').removeAttr('disabled',false);
								console.log('reset & allow '+result);
							}*/
							/*else if(result.trim()== 'do not allow')
							{
								// if user already own the same game but not played then don't allow
								$('#Submit').attr('disabled',true);
								$('#reset').remove();
								// alert('You already have this game. Please login to play this game.');
								$('#showMsg').removeClass('hidden').html("You already have <b><?php echo $run->Game_Name?></b> game. Please login to play.");
								console.log('user not played '+result);
							}*/
							else
							{
								$('#Submit').attr('disabled',true);
								$('#reset').remove();
								$('#showMsg').removeClass('hidden').html("<b> This email already taken,Please login to Play</b>");
								console.log('this email already taken '+result);
							}
							
						}
					});
				});

				});
			</script>
			<!-- Optional JavaScript -->
			<script src="<?php echo site_root;?>js/popper.min.js"></script>
			<script src="<?php echo site_root;?>js/bootstrap.min.js"></script>
		</body>
		</html>
