<style type="text/css">
span.alert-danger {
	background-color: #ffffff;
	font-size: 18px;
}
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active"><a href="javascript:void(0);">Manage SiteUsers</a></li>
				<li class="active"><a
					href="<?php echo site_root."ux-admin/siteusers"; ?>">Site
				Users</a></li>
				<li class="active"><?php echo $header; ?></li>
			</ul>
		</div>
	</div>

	<!-- DISPLAY ERROR MESSAGE -->
	<?php if(isset($msg)){ ?>
		<div class="form-group <?php echo $type[1]; ?> alert-dismissible alert">
			<div align="center" id="<?php echo $type[0]; ?>">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="right:1%; top:5px;">&times;</a>
				<label class="control-label" for="<?php echo $type[0]; ?>">
					<?php echo $msg; ?>
				</label>
			</div>
		</div>
	<?php } ?>
	<!-- DISPLAY ERROR MESSAGE END -->

	<div class="col-sm-10">
		<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
			<label for="name"><span class="alert-danger">*</span>Name</label>
			<div class="row name" id="name">
				<div class="col-sm-6">
					<input type="hidden" name="id"
					value="<?php if(isset($_GET['edit'])){ echo $userdetails->User_id; } ?>">
					<div class="form-group">
						<input type="text" name="fname"
						value="<?php if(!empty($userdetails->User_fname)) echo $userdetails->User_fname; ?>"
						class="form-control" title="Minimum 3 letters"
						pattern="[a-zA-Z]{3,}" placeholder="First Name" required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" name="lname" class="form-control"
						title="Minimum 3 letters" pattern="[a-zA-Z]{3,}"
						placeholder="Last Name"
						value="<?php if(!empty($userdetails->User_lname)) echo $userdetails->User_lname; ?>"
						required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" name="username" class="form-control"
						title="Minimum 3 letters" pattern="[a-zA-Z]{3,}"
						placeholder="User Name"
						value="<?php if(!empty($userdetails->User_username)) echo $userdetails->User_username; ?>"
						required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" name="company" class="form-control"
						title="Minimum 3 letters" pattern="[a-zA-Z]{3,}"
						placeholder="Company Name"
						value="<?php if(!empty($userdetails->User_companyid)) echo $userdetails->User_companyid; ?>"
						>
					</div>
				</div>			
			</div>

			<div class="row">
				<div class="col-sm-6">
					<label for="mobile"><span class="alert-danger">*</span>Mobile</label>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">+91</span>
							<input type="text" name="mobile" id="mobile" class="form-control"
							title="Minimum 10 digits" pattern="[0-9]{10,}"
							placeholder="Mobile Number"
							value="<?php if(!empty($userdetails->User_mobile)) echo $userdetails->User_mobile; ?>"
							required>
						</div>
						<div class="contact_error"></div>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="email"><span class="alert-danger">*</span>E-mail</label>
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control"
						placeholder="E-mail"
						value="<?php  if(!empty($userdetails->User_email)) echo $userdetails->User_email; ?>"
						required>
					</div>
				</div>
				<?php if(isset($_GET['edit'])){ ?>
					<div class="col-sm-6">
						<label for="password"><span class="alert-danger">*</span>Password</label>
						<div class="form-group">
							<input type="text" name="password" id="password" class="form-control"
							placeholder="E-mail"
							value="<?php  if(!empty($userauth->Auth_password)) echo $userauth->Auth_password; ?>"
							required>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group text-center">
						<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
							<button type="button" id="siteuser_btn_update" class="btn btn-primary"
							> Update </button>
							<button type="submit" name="submit" id="siteuser_update" class="btn btn-primary hidden"
							value="Update"> Update </button>
							<button type="button" class="btn btn-primary"
							onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
						<?php }else{?>
							<button type="button" id="siteuser_btn" class="btn btn-primary"
							value="Submit"> Submit </button>
							<button type="submit" name="submit" id="siteuser_sbmit"
							class="btn btn-primary hidden" value="Submit"> Submit </button>
							<button type="button" class="btn btn-primary"
							onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
						<?php }?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>

	<script>
		<!--

//$("#siteuser_frm").validate({
//	rules: {
//		fname: "required",
//		lname: "required",
//		mobile: {
//			required: true,
//			minlength: 10,
//			maxlength: 10
//		},
//		email:  {
//			required: true,
//			email: true
//		},
//		username: "required"
//	},
//	// Specify validation error messages
//	messages: {
//		mobile: {
//			required: "Please provide mobile number",
//			minlength: "Please Enter a valid 10 digit mobile number",
//			maxlength: "Please Enter a valid 10 digit mobile number"
//		}
//    },
//    errorPlacement: function(error, element) {
//		if (element.attr("name") == "mobile" ){  //Id of input field
//             error.appendTo('.contact_error');
//		}
//	}
//});

$('#siteuser_btn').click( function(){
//	if($("#siteuser_frm").valid()){		
	$( "#siteuser_sbmit" ).trigger( "click" );
//	}
});

$('#siteuser_btn_update').click( function(){
//	if($("#siteuser_frm").valid()){
	$( "#siteuser_update" ).trigger( "click" );
//	}
});

// -->
</script>
