<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 
// echo "<pre>"; print_r($_SESSION); echo "</pre>".$msg; 
?>
<div class="col-sm-10">
	<?php if(isset($msg)){
		echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";
	} ?>
	<div class="col-sm-12"><h2 class="InnerPageHeader">My Profile</h2></div>

	<form method="POST" action="" id="siteuser_frm" name="siteuser_frm" enctype="multipart/form-data">

		<div class="col-sm-12 shadow profile_setting_BG">
			<input type="hidden" name="id"
			value="<?php echo $userdetails->User_id; ?>">
			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>First Name</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="fname" name="fname" class="form-control" value="<?php echo $userdetails->User_fname;?>" required></input>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>Last Name</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="lname" name="lname" class="form-control" value="<?php echo $userdetails->User_lname; ?>" required></input>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>Contact</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo $userdetails->User_mobile; ?>" required></input>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>Email</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="email" name="email" class="form-control" value="<?php echo $userdetails->User_email;  ?>" readonly></input>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>Profile Video</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="User_profile_video" class="form-control" name="User_profile_video" value='<?php echo base64_decode($userdetails->User_profile_video); ?>'></input>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>Profile Picture</label>
				</div>
				<div class="col-sm-6">
					<input type="file" id="User_profile_pic" name="User_profile_pic" class="form-control" accept="image/*"></input>
				</div>
				<!-- only if there is file -->
				<div class="col-sm-3 text-right">
					<?php if($userdetails->User_profile_pic){ ?>
						<img id="myImg" src="<?php echo site_root.'images/userProfile/'.$userdetails->User_profile_pic; ?>" alt="Profile Picture" width="50px" height="50px" data-toggle="tooltip" title="<?php echo $userdetails->User_fname.' '.$userdetails->User_lname; ?>">
					<?php } else { ?>
						<code>No File Choosen Yet</code>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="form-group col-sm-12">
				<div class="col-sm-3 text-right">
					<label>Resume</label>
				</div>
				<div class="col-sm-6">
					<input type="file" id="User_Resume" name="User_Resume" class="form-control" accept="application/msword,text/plain, application/pdf"></input>
				</div>
				<!-- only if there is file -->
				<div class="col-sm-3 text-right">
					<?php if($userdetails->User_Resume){ ?>
						<a href="<?php echo site_root.'images/userResume/'.$userdetails->User_Resume; ?>" download class="btn btn-primary" data-toggle="tooltip" title="Download Resume" style="width: 50px;">
							<i class="glyphicon glyphicon-download-alt"></i>
						</a>
					<?php } else { ?>
						<code>No File Choosen Yet</code>
					<?php } ?>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="col-sm-12 text-center">
				<button type="submit" name="submit" value="Update" class="btn loginBtn">Update</button>
			</div>
			<?php if($userdetails->User_profile_video){ ?> 
				<center>
					<?php echo base64_decode($userdetails->User_profile_video); ?>
				</center>
			<?php } ?>
		</div>
	</form>
	<!-- to play video if any -->
</div>

</div>
</div>
</section>	

<section>
	<style>

	#myImg {
		border-radius: 5px;
		cursor       : pointer;
		transition   : 0.3s;
	}

	#myImg:hover {opacity: 0.7;}

	/* The Modal (background) */
	.modal {
		display         : none; /* Hidden by default */
		position        : fixed; /* Stay in place */
		z-index         : 1; /* Sit on top */
		padding-top     : 100px; /* Location of the box */
		left            : 0;
		top             : 0;
		width           : 100%; /* Full width */
		height          : 100%; /* Full height */
		overflow        : hidden; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
	}

	/* Modal Content (image) */
	.modal-content {
		margin   : auto;
		display  : block;
		width    : 80%;
		max-width: 700px;
	}

	/* Caption of Modal Image */
	#caption {
		margin    : auto;
		display   : block;
		width     : 80%;
		max-width : 700px;
		text-align: center;
		color     : #ccc;
		padding   : 10px 0;
		height    : 150px;
	}

	/* Add Animation */
	.modal-content, #caption {  
		-webkit-animation-name    : zoom;
		-webkit-animation-duration: 0.6s;
		animation-name            : zoom;
		animation-duration        : 0.6s;
	}

	@-webkit-keyframes zoom {
		from {-webkit-transform:scale(0)} 
		to {-webkit-transform:scale(1)}
	}

	@keyframes zoom {
		from {transform:scale(0)} 
		to {transform:scale(1)}
	}

	/* The Close Button */
	.close {
		position   : absolute;
		top        : 15%;
		right      : 1%;
		color      : #f1f1f1;
		font-size  : 40px;
		font-weight: bold;
		transition : 0.3s;
		opacity    : 1;
	}

	.close:hover,
	.close:focus {
		color          : #bbb;
		text-decoration: none;
		cursor         : pointer;
		transform      : rotate(360deg);
		opacity        : 1;
		color          : #ff0000;
		transition     : 1s;
	}

	/* 100% Image Width on Smaller Screens */
	@media only screen and (max-width: 700px){
		.modal-content {
			width: 100%;
		}
		.close{
			position: static;
			top     : 20%;
			z-index : 1;
			color   : #ff0000;
		}
	}
</style>
<!-- The Modal -->
<div id="myModal" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="img01">
	<div id="caption"></div>
</div>

<script>
// Get the modal
var modal             = document.getElementById('myModal');
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img               = document.getElementById('myImg');
	var modalImg          = document.getElementById("img01");
	var captionText       = document.getElementById("caption");
	img.onclick           = function(){
		modal.style.display   = "block";
		modalImg.src          = this.src;
		captionText.innerHTML = this.alt;
	}

// Get the <span> element that closes the modal
var span     = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
	modal.style.display = "none";
}
</script>
</section>

<?php include_once 'includes/footer.php'; ?>		
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});
</script>
