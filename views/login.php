<?php 
include_once 'includes/header.php'; 
?>
<?php if(isset($msg)){
		//echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";
		} ?>

	<section>
		<div class="container">
			<div class="row">
			<form role="form" method="post" action="">				
				<div class="col-sm-8 col-md-6 loginBg col-sm-offset-2 col-md-offset-3">
					<div class="col-sm-12 text-center">
						<h1 class="pageHeadLine">User Login</h1>
					</div>
					
					<?php if(isset($msg)){ 
						//echo $type[0]." ".$type[1];
					?>
					<div class="clearfix"></div>
						<div class="form-group <?php echo $type[1]; ?>">
							<div align="center" class="form-control" id="<?php echo $type[0]; ?>">
								<label class="control-label" for="<?php echo $type[0] ?>"><?php echo $msg ?></label>
							</div>
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
					
					<!--
					<div class="col-sm-8 col-sm-offset-2 text-right">
						<a href="#" class="blueColor regular">Forgot Password ?</a>
					</div>
					-->
				</div>
			</form>	
			</div>
		</div>
	</section>	
	
<?php include_once 'includes/footer.php'; ?>