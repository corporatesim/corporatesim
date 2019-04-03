<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Add SubEnterprise</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add SubEnterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">Add SubEnterprise</h4>
						</div>
					</div><br>
					<form method="post" action="" enctype="multipart/form-data" id="filterForm">
						<?php if($this->session->userdata('loginData')['User_Role']!=1) {?>
							<div class="form-group row" id="selectSubenterprise">
								<label for="Select SubEnterprise" class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Select Enterprise</label>
								<div class="col-sm-12 col-md-6">
									<select name='Enterprise_ID' id='enterprise' class='form-control'>
										<option value=''>--Select Enterprise--</option>
										<?php foreach ($EnterpriseDetails as $row) { ?> <option value="<?php echo $row->Enterprise_ID;?>"><?php echo $row->Enterprise_Name; ?></option>
									<?php } ?> 
								</select>
							</div>
						</div>
					<?php }?>
					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Name</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Name" value="" type="text" placeholder="Enter SubEnterprise Name" required="">
						</div>
					</div> 
					<!-- adding more field -->
					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Number</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Number" value="" type="text" placeholder="Enter SubEnterprise Number" required="">
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Email</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Email" value="" type="email" placeholder="Enter SubEnterprise Email" required="">
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Address1</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Address1" value="" type="text" placeholder="Enter SubEnterprise Address1" required="">
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Address2</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Address2" value="" type="text" placeholder="Enter SubEnterprise Address2">
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Country</label>
						<div class="col-sm-12 col-md-6">
							<select class="form-control" name="SubEnterprise_Country" required="" id="country">
								<option value="">--Select Country--</option>
								<?php foreach ($country as $row) { ?>
									<option value="<?php echo $row->Country_Id;?>"><?php echo $row->Country_Name;?></option>
								<?php } ?>
							</select>
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise State</label>
						<div class="col-sm-12 col-md-6">
							<select class="form-control" name="SubEnterprise_State" required="" id="state">
								<option value="">--Select State--</option>
							</select>
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Province</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Province" value="" type="text" placeholder="Enter SubEnterprise Province">
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Pincode</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Pincode" value="" type="text" placeholder="Enter SubEnterprise Pincode" required="">
						</div>
					</div> 

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Password</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="SubEnterprise_Password" type="text" placeholder="Enter SubEnterprise Password" required="" value="123Ent@2019">
						</div>
					</div> 
					<!-- end of adding field -->
					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Choose Logo</label>
						<div class="col-sm-12 col-md-6">
							<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Account Duration</label>
						<div id="assignDate"class="col-sm-12 col-md-6">
							<div class="input-group" name="gamedate" id="datepicker">
								<input type="text" class="form-control datepicker-here" id="SubEnterprise_StartDate" name="SubEnterprise_StartDate" value="<?php echo date('d-m-Y');?>" data-value="<?php echo strtotime(date('d-m-Y'));?>" placeholder="Select Start Date" required="" readonly="" data-startDate="" data-endDate="" data-language='en' data-date-format="dd-mm-yyyy">
								<span class="input-group-addon" >To</span>
								<input type ="text" class="form-control datepicker-here" id="SubEnterprise_EndDate" name="SubEnterprise_EndDate" value="<?php echo date('d-m-Y');?>" data-value="<?php echo strtotime(date('d-m-Y'));?>" placeholder="Select End Date" required="" readonly="" data-startDate="" data-endDate="" data-language='en' data-date-format="dd-mm-yyyy">
							</div>
						</div>
					</div>
					<!-- 
					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Account Duration</label>
						<div id="assignDate"class="col-sm-12 col-md-6">
							<div class="input-group" name="gamedate" id="datepicker">
								<input type="text" class="form-control datepicker-here" id="SubEnterprise_StartDate" name="SubEnterprise_StartDate" value="<?php echo $editSubEnterprise->SubEnterprise_StartDate ?>" data-value="<?php echo strtotime($editSubEnterprise->SubEnterprise_StartDate);?>" placeholder="Select Start Date" required="" readonly="" data-startDate="<?php echo strtotime($editSubEnterprise->Enterprise_StartDate);?>" data-endDate="<?php echo strtotime($editSubEnterprise->Enterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">

								<span class="input-group-addon" >To</span>

								<input type ="text" class="form-control datepicker-here" id="SubEnterprise_EndDate" name="SubEnterprise_EndDate" value="<?php echo $editSubEnterprise->SubEnterprise_EndDate ?>" data-value="<?php echo $editSubEnterprise->SubEnterprise_EndDate ?>" placeholder="Select End Date" required="" readonly="" data-startDate="<?php echo strtotime($editSubEnterprise->Enterprise_StartDate);?>" data-endDate="<?php echo strtotime($editSubEnterprise->Enterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">
							</div>
						</div>
					</div> -->

					<div class="text-center">
						<button type="submit" name="submit"class="btn btn-primary">SUBMIT</button>
						<a href="<?php echo base_url('SubEnterprise');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#enterprise').on('change',function(){
			$('#filterForm').submit();
		});
	});
</script>
