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
						value="<?php if(!empty($userdetails->User_fname)) echo $userdetails->User_fname; ?>"class="form-control" 
						placeholder="First Name" required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" name="lname" class="form-control"
						placeholder="Last Name" value="<?php if(!empty($userdetails->User_lname)) echo $userdetails->User_lname; ?>"
						required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" name="username" class="form-control"
						placeholder="User Name" value="<?php if(!empty($userdetails->User_username)) echo $userdetails->User_username; ?>"
						required>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" name="company" class="form-control"
						placeholder="Company Name" value="<?php if(!empty($userdetails->User_companyid)) echo $userdetails->User_companyid; ?>"
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
							placeholder="Mobile Number" value="<?php if(!empty($userdetails->User_mobile)) echo $userdetails->User_mobile; ?>"
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
			</div>
			<!-- Add dropDown for select Enterprise and SubEnterprise Users -->
			<div class="form-group hidden">
				<div class="row">
					<div class="col-md-6" id="Enterprise_Section">
						<label for="Select Enterprise">Select Enterprise</label>
						<select name="Enterprise" id="Enterprise" class="form-control">
							<option value="">--Select Enterprise--</option>           
							<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
								<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" <?php echo ($EnterpriseData->Enterprise_ID==$userdetails->User_ParentId)?"selected":''; ?>><?php echo $EnterpriseData->Enterprise_Name; ?></option>
							<?php } ?>
						</select>
					</div>
					<input type="hidden" name="Enterprisename" id="Enterprisename">
					<div class="col-md-6 hidden" id="SubEnterprise_section">
						<label for="Select SubEnterprise">Select SubEnterprise</label> 
						<select name="SubEnterprise" id="SubEnterprise" class="form-control">	<?php if(isset($_GET['edit'])){ ?>
							<option value="<?php echo $subObjRes->SubEnterprise_ID; ?>" <?php echo ($subObjRes->SubEnterprise_ID==$userdetails->User_SubParentId)?"selected":''; ?>><?php echo $subObjRes->SubEnterprise_Name; ?></option> 
						<?php }else {?>
							<option value="">--Select SubEnterprise--</option> 
						<?php } ?>
					</select>
				</div>
				<input type="hidden" name="SubEnterpriseName" id="SubEnterpriseName">
			</div><br>
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
<script type="text/javascript">
	$(document).ready(function() {
		$('#Enterprise').on('change',function(){
			var Enterprise_ID  = $(this).val();
			var EnterpriseName = $(this).find(':selected').data('enterprisename');
			$('#Enterprisename').attr('value',EnterpriseName);
			$('#SubEnterpriseName').attr('value','');
			if($(this).val())
			{
				$('#SubEnterprise_section').removeClass('hidden');
          // triggering ajax to show the subenterprise linked with this enterprise
          $.ajax({
          	url : "<?php echo site_root;?>ux-admin/model/ajax/siteusers.php",
          	type: "POST",
          	data: "action=Subenterprise&Enterprise_ID="+Enterprise_ID,
          	success: function( result )
          	{
            	//alert(result);
            	var option = '<option value="">--Select SubEnterprise--</option>';
            	if(result.trim() != 'no link')
            	{
            		result = JSON.parse(result)
            		$(result).each(function(i,e)
            		{
                  //console.log(index);
                  option += ('<option value='+result[i].SubEnterprise_ID+' data-subenterpriseid="'+result[i].SubEnterprise_ID+'" data-subenterprisename="'+result[i].SubEnterprise_Name+'">'+result[i].SubEnterprise_Name+'</option>');
                });
               // console.log(option);
               $('#SubEnterprise').html(option);
             }
             else
             {
             	$('#SubEnterprise').html(option);
             }
           },
         });          
        }
        else
        {
        	if(!($('#SubEnterprise_section').hasClass('hidden')))
        	{
        		$('#SubEnterprise_section').addClass('hidden');
        	}
        	// alert('Please Select Enterprise...');
        	console.log('Please Select Enterprise...');
        	return false;
        }
      });
		//show selected Subenterprise
		$('#Enterprise').trigger('change');
		<?php if(isset($_GET['edit'])){ ?>
			if(<?php echo $subObjRes->SubEnterprise_ID; ?>)
			{
			// alert(<?php // echo $subObjRes->SubEnterprise_ID; ?>);
			setTimeout(function(){
				$('#SubEnterprise [value="<?php echo $subObjRes->SubEnterprise_ID; ?>"]').prop('selected', true);
			},100);
		}
	<?php }?>
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

});
// -->
</script>
