<?php 
include_once 'includes/headerNav.php'; 
// include_once 'includes/header.php'; 
// include_once 'includes/header2.php'; 

?>

<br>
<div class="row">
	<div class="container col-md-9" style="margin-left:30%;" >
		<?php if(isset($msg) && !empty($msg)){ ?>
			<div class="alert <?php echo ($type[0]=='inputError')?'alert-danger':'alert-success'; ?> alert-dismissible" style="
			max-width: 59%;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<?php echo $msg; ?>
		</div>
	<?php } ?>
	<span class="anchor" id="formUserEdit"></span>
	<!-- form user info -->
	<div class="card1" >
		<div class="card-header">
			<h3 class="mb-0 settings">Settings</h3>
		</div>
		<div class="card-body setting_card">
			<form class="form" role="form" autocomplete="off" method="post" action="">

				<input type="hidden" name="id" value="<?php echo $userdetails->User_id; ?>">

				<div class="form-group row">
					<label class="col-lg-3 col-form-label form-control-label">Old Password</label>
					<div class="col-lg-6">
						<input name="old_password" class="form-control" type="password" value="" required="" placeholder="Enter Old Password">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-3 col-form-label form-control-label">New Password</label>
					<div class="col-lg-6">
						<input name="password" class="form-control" type="password" value="" required="" placeholder="Enter Password">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-3 col-form-label form-control-label">Confirm Password</label>
					<div class="col-lg-6">
						<input name="confirm" class="form-control" type="password" value="" required="" placeholder="Confirm Password">
					</div>
				</div>

				<center>
					<div class="form-group row">
						<!-- <label class="col-lg-3 col-form-label form-control-label"></label> -->
						<div class="col-lg-12">
							<input type="submit" class="btn btn-danger" name="submit" value="Update">
						</div>
					</div>
				</center>
				
			</form>
		</div>
	</div>
	<!-- /form user info -->
</div>    
</div>
<script>

</script>
<!-- <script src="js/jquery-3.3.1.slim.min.js"></script> -->
<!-- <script src="js/popper.min.js"></script> -->
<!-- <script src="js/bootstrap.min.js"></script> -->
</body>
</html>

<?php include_once 'includes/footer.php'; ?>		
