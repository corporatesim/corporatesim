<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 
// echo "<pre>"; print_r($_SESSION); echo "</pre>".$msg; 
?>
<div class="row" style="margin-top:50px;">

	<div class="container col-md-7" style="margin-top:60px; margin-left:160px;" >


		<span class="anchor" id="formUserEdit"></span>
		<!-- form user info -->
		<div class="card card-outline-secondary" style="height:800px; width:800px;">
			<div class="card-header">
				<h3 style="color:#ffffff;" class="mb-0 text-center">My Profile</h3>
			</div>
			<div class="card-body profile_card" >
				<form class="form" role="form" autocomplete="off" method="post" action="" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">First name</label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="User_fname" id="User_fname" value="<?php echo $userdetails->User_fname;?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Last name</label>
						<div class="col-lg-9">
							<input class="form-control" type="text" name="User_lname" id="User_lname" value="<?php echo $userdetails->User_lname;?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Contact</label>
						<div class="col-lg-9">
							<input class="form-control" type="number" name="User_mobile" id="User_mobile" value="<?php echo $userdetails->User_mobile;?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Email</label>
						<div class="col-lg-9">
							<input class="form-control" type="email" name="User_email" value="<?php echo $userdetails->User_email;?>" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Profile Picture</label>
						<div class="col-lg-7">
							<input class="form-control" type="file" name="User_profile_pic" id="User_profile_pic" accept="image/*">
						</div>
						<div class="col-lg-2">
							<?php if($userdetails->User_profile_pic){ ?>
								<img id="myImg" class="showImageModal" src="<?php echo site_root.'images/userProfile/'.$userdetails->User_profile_pic; ?>" alt="Profile Picture" data-toggle="tooltip" title="<?php echo $userdetails->User_fname.' '.$userdetails->User_lname; ?>" style="width:40px; height:40px;">
							<?php } else { ?>
								<code>No File Choosen Yet</code>
							<?php } ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Resume</label>
						<div class="col-lg-7">
							<input type="file" id="User_Resume" name="User_Resume" class="form-control" accept="application/msword,text/plain, application/pdf">
						</div>
						<div class="col-lg-2">
							<?php if($userdetails->User_Resume){ ?>
								<a href="<?php echo site_root.'images/userResume/'.$userdetails->User_Resume; ?>" download class="" data-toggle="tooltip" title="Download Resume" style="width: 50px;">
									<!-- <i class="glyphicon glyphicon-download-alt"></i> -->
									<input type="image" src="images/download.png"  width="40" height="40">
								</a>
							<?php } else { ?>
								<code>No File Choosen Yet</code>
							<?php } ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Profile Video</label>
						<div class="col-lg-9">
							<input class="form-control" type="text" id="videoUrl" value='<?php echo base64_decode($userdetails->User_profile_video);?>'>
							<input type="hidden" name="User_profile_video" id="User_profile_video" value='<?php echo $userdetails->User_profile_video; ?>'>
						</div>
					</div>

					<center>
						<div class="form-group row">
							<div class="col-lg-12">
								<input type="submit" class="update btn btn-danger" name="submit" value="Update">
							</div>
						</div>
					</center>
					<!-- if video is there then show the video -->
					<?php if($userdetails->User_profile_video){ ?> 
						<div class="form-group row">
							<center>
								<?php echo base64_decode($userdetails->User_profile_video); ?>
							</center>
						</div>
					<?php } ?>
				</form>
				<!-- <iframe src='<iframe width="560" height="315" src="https://www.youtube.com/embed/H7_yY3yr-jE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' height="315" width="560" style="margin-left:100px;"></iframe> -->
			</div>
		</div>
	</div>    
</div>
</div>
</div>
</section>	

<?php include_once 'includes/footer.php'; ?>		
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
		$('#videoUrl').on('change keyup keydown',function(){
			var videoUrl = $(this).val();
			$('#User_profile_video').val(btoa(videoUrl));
		});
	});
</script>
