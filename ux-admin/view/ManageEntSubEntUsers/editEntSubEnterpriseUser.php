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
				<li class="active"><a
					href="<?php echo site_root."ux-admin/ManageEntSubEntUsers"; ?>">Enterprise/SubenterpriseUsers</a></li>
					<li class="active"><?php echo $header; ?></li>
				</ul>
			</div>
		</div>

		<!-- DISPLAY ERROR MESSAGE -->
	<!-- <?php  if(!empty($_SESSION['tr_msg'])) { ?>
		<div class="alert-success alert"><?php echo $_SESSION['tr_msg']; ?></div>
	<?php } ?>
	<?php  if(!empty($_SESSION['er_msg'])) { ?>
		<div class="alert-danger alert"><?php echo $_SESSION['er_msg']; ?></div>
		<?php } ?> -->
		<!-- DISPLAY ERROR MESSAGE END -->

		<div class="col-sm-10">
			<form method="POST" action="" id="edituser" name="edituser">
				<label for="name"><span class="alert-danger">*</span>Name</label>
				<div class="row name" id="name">
					<div class="col-sm-6">
						<input type="hidden" name="id"
						value="<?php  echo $userdetails->User_id;  ?>">
						<div class="form-group">
							<input type="text" name="fname"
							value="<?php echo $userdetails->User_fname; ?>"class="form-control" 
							placeholder="First Name" readonly>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="lname" class="form-control"
							placeholder="Last Name" value="<?php echo $userdetails->User_lname; ?>"
							readonly>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<input type="text" name="username" class="form-control" placeholder="User Name" value="<?php echo $userdetails->User_username; ?>"
							readonly>
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
								placeholder="Mobile Number" value="<?php echo $userdetails->User_mobile; ?>"
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
							value="<?php echo $userdetails->User_email; ?>"
							required>
						</div>
					</div>
				</div>
				<!-- Add dropDown for select Enterprise and SubEnterprise Users -->
				<div class="form-group">
					<div class="row">
						<div class="col-md-6" id="Enterprise_Section">
							<label for="Select Enterprise"><span class="alert-danger">*</span>Select Enterprise</label>
							<select name="Enterprise" id="Enterprise" class="form-control">
								<option value="">--Select Enterprise--</option>
								<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
									<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" <?php echo ($EnterpriseData->Enterprise_ID==$userdetails->User_ParentId)?"selected":''; ?>><?php echo $EnterpriseData->Enterprise_Name; ?></option>
								<?php } ?>
							</select>
						</div>
						<input type="hidden" name="Enterprisename" id="Enterprisename">
						<div class="col-md-6" id="SubEnterprise_section">
							<label for="Select SubEnterprise"><span class="alert-danger">*</span>Select SubEnterprise</label> 
							<select name="SubEnterprise" id="SubEnterprise" class="form-control">
								<option value="">--Select SubEnterprise--</option>
							</select>
						</div>
						<input type="hidden" name="SubEnterpriseName" id="SubEnterpriseName">
					</div><br>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group text-center">
						<button type="submit" name="edituser" id="edituser" value="edituser" class="btn btn-primary"
						value="Update"> Update </button>
						<a href="<?php echo site_root."ux-admin/ManageEntSubEntUsers"; ?>"<button type="button" class="btn btn-primary"> Cancel </button></a>
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
          // triggering ajax to show the subenterprise linked with this enterprise
          $.ajax({
          	url : "<?php echo site_root;?>ux-admin/model/ajax/EntSubenterpriseUsers.php",
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
        	alert('Please Select Enterprise...');
        	return false;
        }
      });
		});
	</script>