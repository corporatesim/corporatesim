<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 

?>
				
	<div class="col-sm-10">
		<?php if(isset($msg)){
			echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";
		} ?>

		<div class="col-sm-12"><h2 class="InnerPageHeader">Settings</h2></div>
		<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
			<div class="col-sm-12 shadow profile_setting_BG">
				<input type="hidden" name="id"
					value="<?php echo $userdetails->User_id; ?>">
				<div class="form-group col-sm-12">
					<div class="col-sm-4 col-md-3 text-right">
						<label>Change Password</label>
					</div>
					<div class="col-sm-6">
						<input type="password" id="password" name="password" class="form-control"></input>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="form-group col-sm-12">
					<div class="col-sm-4 col-md-3 text-right">
						<label>Confirm Password</label>
					</div>
					<div class="col-sm-6">
						<input type="password" id="confirm" name="confirm" class="form-control"></input>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="col-sm-12 text-center">
					<button  type="submit" name="submit" value="Update"  class="btn loginBtn">Update</button>
				</div>
			</div>
		</form>
	</div>
					
</div>
</div>
</section>	
	
<?php include_once 'includes/footer.php'; ?>		
