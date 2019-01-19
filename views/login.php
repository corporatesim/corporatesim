<?php 
include_once 'includes/header.php'; 

?>
<?php if(isset($msg)){
		//echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";
} ?>

<section>
	<div class="container">
		<div class="row" id="login">
			<form role="form" method="post" action="">				
				<div class="col-sm-8 col-md-6 loginBg col-sm-offset-2 col-md-offset-3">
					<div class="col-sm-12 text-center">
						<h1 class="pageHeadLine">User Login</h1>
					</div>
					
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
					
					<div class="form-group col-sm-8 col-sm-offset-2">
						<label>Email ID/Username</label>
						<input type="text" id="username" name="username" class="form-control"></input>
					</div>
					
					<div class="form-group col-sm-8 col-sm-offset-2">
						<label>Password</label>
						<input type="password" id="password" name="password" class="form-control"></input>
					</div>
					
					<div class="form-group col-sm-8 col-sm-offset-2">
						<input type="checkbox" name="" value=""> Remember Me </input>
					</div>	
					
					<div class="col-sm-12 text-center">
						<button type="submit" value="Login" name="submit" class="btn loginBtn">Login</button>
					</div>
					
					<div class="col-sm-8 col-sm-offset-2 text-right">
						<a href="javascript:void(0);" class="blueColor regular" id="resetPassword">Forgot Password ?</a>
					</div>
					
				</div>
			</form>	
		</div>

		<div class="row hidden" id="forgotPassword">
			<form role="form" method="post" action="">				
				<div class="col-sm-8 col-md-6 loginBg col-sm-offset-2 col-md-offset-3">
					<div class="col-sm-12 text-center">
						<h1 class="pageHeadLine">Forgot Password</h1>
					</div>
					<div class="form-group col-sm-8 col-sm-offset-2">
						<label>Email ID</label>
						<input type="Email" id="registeredEmail" name="registeredEmail" class="form-control" placeholder="Enter your registered Email ID" required=""></input>
					</div>
					<div class="form-group col-sm-8 col-sm-offset-2">
						<button class="btn btn-primary" value="reset" name="reset">Request Password</button>
					</div>
					<div class="col-sm-8 col-sm-offset-2 text-right">
						<a href="javascript:void(0);" class="blueColor regular" id="loginHere">Login Here</a>
					</div>
				</div>
			</form>
		</div>

	</div>
</section>	
<script>
	$(document).ready(function(){
		$('#resetPassword').on('click',function(){
			$('#login').addClass('hidden');
			$('#forgotPassword').removeClass('hidden');
		});
		$('#loginHere').on('click',function(){
			$('#login').removeClass('hidden');
			$('#forgotPassword').addClass('hidden');
		});
	});
</script>

<?php include_once 'includes/footer.php'; // print_r($_SESSION); ?>
