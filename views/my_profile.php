<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 

?>


				<div class="col-sm-10">
					<?php if(isset($msg)){
						echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";
						} ?>


					<div class="col-sm-12"><h2 class="InnerPageHeader">My Profile</h2></div>

					<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">

					<div class="col-sm-12 shadow profile_setting_BG">
						<input type="hidden" name="id"
							value="<?php echo $userdetails->User_id; ?>">
						<div class="form-group col-sm-12">
							<div class="col-sm-3 text-right">
								<label>First Name</label>
							</div>
							<div class="col-sm-6">
								<input type="text" id="fname" name="fname" class="form-control" value="<?php echo $userdetails->User_fname; ?>"></input>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="form-group col-sm-12">
							<div class="col-sm-3 text-right">
								<label>Last Name</label>
							</div>
							<div class="col-sm-6">
								<input type="text" id="lname" name="lname" class="form-control" value="<?php echo $userdetails->User_lname;  ?>"></input>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="form-group col-sm-12">
							<div class="col-sm-3 text-right">
								<label>Contact</label>
							</div>
							<div class="col-sm-6">
								<input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo $userdetails->User_mobile;  ?>"></input>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="form-group col-sm-12">
							<div class="col-sm-3 text-right">
								<label>Email</label>
							</div>
							<div class="col-sm-6">
								<input type="text" id="email" name="email" class="form-control" value="<?php echo $userdetails->User_email;  ?>" disabled></input>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="col-sm-12 text-center">
							<button type="submit" name="submit" value="Update" class="btn loginBtn">Update</button>
						</div>
					
					</div>
					</form>
				</div>
					
			</div>
		</div>
	</section>	
	
<?php include_once 'includes/footer.php'; ?>		
