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
				<button name="login" value="login" class="btn btn-lg btn-primary  pull-right" style="margin-top: 2px; margin-right: -10%;" onclick="window.location='login.php'">Login</button>
			</div>
		</div>
	</nav>
	<div class="clearfix"></div><br>
	<div class="container">
		<form method="post" action="" id="register">
			<div id="login-box">
				<div class="row text-center alert-danger hidden" id="showMsg"></div>

				<h1 class="caption"><span class="tweak">R</span>egister</h1><br>

				<div class="form-group">

					<input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control" required="required" /><br>
					<input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control" required="required"/><br>
					<input type="email" name="email" id="email" placeholder="Email" class="form-control"  required="required"><br>
					<input type="tel" name="username" id="username" placeholder="Username" class="form-control" required="required"><br>
					<input type="text" name="mobile" placeholder="Mobile No." class="form-control"  required="required"/><br>
					<input type="text" name="game" placeholder="Game Name" class="form-control"  required="required" readonly="readonly" value="<?php echo $run->Game_Name?>" /><br>
					<div class="col-sm-12 text-center">

						<button class="btn  btn-default  btn-custom" name="submit" id="submit" value="register" disabled="">Submit</button>
						<button type="button" class="btn  btn-default  btn-custom" name="back" id="back" value="back" onclick="location.href='registration.php'">Back</button></div>
						<div class="clearfix"></div><br>
						<!-- <div class="text-center" style="color: #ffffff;">Already have an account &nbsp;&nbsp;<a href="login.php">Login</a></div> -->
					</div><!-- /.controls -->

				</div><!-- /#login-box -->
			</form>
		</div><!-- /.container -->
		<script>
			$(document).ready(function(){

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
								$('#submit').removeAttr('disabled',false);
								$('#reset').remove();
								console.log('newUser '+result);
							}
							else if(result.trim() == 'reset allow')
							{
								// if user already have the same game and played then reset and allow
								$('#showMsg').addClass('hidden');
								$('#reset').remove();
								$('#register').append("<input type='hidden' name='reset' value='reset' id='reset'>");
								$('#submit').removeAttr('disabled',false);
								console.log('reset & allow '+result);
							}
							else
							{
								// if user already own the same game but not played then don't allow
								$('#submit').attr('disabled',true);
								$('#reset').remove();
								// alert('You already have this game. Please login to play this game.');
								$('#showMsg').removeClass('hidden').html('You already have <b><?php echo $run->Game_Name?></b> game. Please login to play.');
								console.log('user not played '+result);
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
