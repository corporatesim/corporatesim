<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Add Users</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Users</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">ADD USERS</h4><br>
						</div>
					</div>
					<form method="post" action="">
						<?php if($this->session->userdata('loginData')['User_Role']!=2){?>
							<div class="form-group row">
								<label for="User Type" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> User Type</label>
								<div class="col-sm-12 col-md-6">
									<input type="radio" value="0" name="userType" id="enterpriseUser" checked=""> Enterprise
									<input type="radio" value="1" name="userType" id="subenterpriseUser"> Subenterprise
								</div>
							</div>
						<?php }?>
						<?php if($this->session->userdata('loginData')['User_Role']!=1 && $this->session->userdata('loginData')['User_Role']!=2){?>
							<div class="form-group row" id="Enterprise_Section">
								<label for="Select Enterprise" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> Select Enterprise</label>
								<div class="col-sm-12 col-md-6">
									<select name="Enterprise" id="Enterprise" class="form-control">
										<option value="">--Select Enterprise--</option>
										<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
											<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name;?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
										<?php } ?>
									</select>
								</div>
								<input type="hidden" name="Enterprisename" id="Enterprisename">
							</div>
							<div class="form-group row" id="SubEnterprise_section" style="display: none">
								<label for="Select SubEnterprise" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> Select SubEnterprise</label> 
								<div class="col-sm-12 col-md-6">
									<select name="SubEnterprise" id="SubEnterprise" class="form-control">	
										<option value="">--Select SubEnterprise--</option> 
									</select>
								</div>
								<input type="hidden" name="SubEnterpriseName" id="SubEnterpriseName">
							</div>
						<?php }?>	
						<?php if($this->session->userdata('loginData')['User_Role']!=2){?>
							<div class="form-group row" id="selectSubenterprise" style="display: none">
								<label for="Select SubEnterprise" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span>Select SubEnterprise</label>
								<div class="col-sm-12 col-md-6">
									<select name='subenterprise' id='subenterprise' class='form-control'>
										<option value=''>--Select SubEnterprise--</option>
										<?php foreach ($Subenterprise as $row) { ?> 
											<option value="<?php echo $row->SubEnterprise_ID;?>"><?php echo $row->SubEnterprise_Name; ?></option>
										<?php } ?> 
									</select>
								</div>
							</div>
						<?php }?>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> First Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" type="text" name="User_fname" placeholder="" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> Last Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" placeholder="" name="User_lname" type="text" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> User Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="User_username" value="" type="text" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> Email</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="User_email" value="" type="text" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> Mobile No.</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="User_mobile" value="" type="tel" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span> Company</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control " placeholder="" name="User_companyid" type="text" required="">
							</div>
						</div>
						<div class="text-center">
							<button type="submit" name="submit"class="btn btn-primary">SUBMIT</button>
							<a href="<?php echo base_url('Dashboard');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
			//alert('here');
			<?php if($this->session->userdata('loginData')['User_Role']!=2 && $this->session->userdata('loginData')['User_Role']==1){?>
				$('input[type=radio]').on('change',function(){
					if($(this).val() == 1)
					{
						$('#selectSubenterprise').show();
					}
					else
					{
						$('#selectSubenterprise').hide();
					}
				});
			<?php }?>
			<?php if($this->session->userdata('loginData')['User_Role']!=2 && $this->session->userdata('loginData')['User_Role']!=1){?>
				$('input[type=radio]').on('change',function(){
					 if($(this).val() == 1)
					{
						$('#Enterprise_Section').show();
						$('#SubEnterprise_section').show();
					}
					else
					{
						$('#SubEnterprise_section').hide();
					}
				});	
			<?php }?>
//Show Subenterprise on change of enterprise
$('#Enterprise').on('change',function(){
	var Enterprise_ID  = $(this).val();
	if($(this).val())
	{ 
   // triggering ajax to show the subenterprise linked with this enterprise
   $.ajax({
   	url :"<?php echo base_url();?>Users/SelectSubEnterprise",
   	type: "POST",
   	data: "ajax=SelectSubEnterprise&Enterprise_ID="+Enterprise_ID,
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

