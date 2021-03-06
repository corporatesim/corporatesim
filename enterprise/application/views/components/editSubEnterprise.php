<div class="main-container">
	<!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>
								<a href="<?php echo base_url(); ?>SubEnterprise/addSubEnterprise/" data-toggle="tooltip" title="" data-original-title="Add SubEnterprise"><i class="fa fa-plus-circle text-blue"></i></a>
								Edit SubEnterprise
							</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Edit SubEnterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<!-- <h4 class="text-blue">Edit SubEnterprise</h4><br> -->
						</div>
					</div>
					<form method="post" action=""enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Enterprise Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Name" value="<?php echo $editSubEnterprise->Enterprise_Name?>" type="text"readonly>
								<input class="form-control" name="Enterprise_ID" value="<?php echo $editSubEnterprise->Enterprise_ID?>" type="hidden"readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" type="text" value="<?php echo $editSubEnterprise->SubEnterprise_Name?>" 
								name="SubEnterprise_Name">
								<span><?php echo form_error('SubEnterprise_Name'); ?></span>
							</div>
						</div>
						<!-- adding more field -->
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Contact Number</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Number" value="<?php echo $editSubEnterprise->SubEnterprise_Number;?>" type="text" placeholder="Enter SubEnterprise Number" required="">
								<span><?php echo form_error('SubEnterprise_Number'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Email ID</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Email" value="<?php echo $editSubEnterprise->SubEnterprise_Email;?>" type="email" placeholder="Enter SubEnterprise Email" required="">
								<span><?php echo form_error('SubEnterprise_Email'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Address1</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Address1" value="<?php echo $editSubEnterprise->SubEnterprise_Address1;?>" type="text" placeholder="Enter SubEnterprise Address1" required="">
								<span><?php echo form_error('SubEnterprise_Address1'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Address2</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Address2" value="<?php echo $editSubEnterprise->SubEnterprise_Address2;?>" type="text" placeholder="Enter SubEnterprise Address2">
								<span><?php echo form_error('SubEnterprise_Address2'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Country</label>
							<div class="col-sm-12 col-md-6">
								<select class="custom-select2 form-control" name="SubEnterprise_Country" required="" id="country">
									<option value="">--Select Country--</option>
									<?php foreach ($country as $row) { ?>
										<option value="<?php echo $row->Country_Id;?>" <?php echo ($editSubEnterprise->SubEnterprise_Country==$row->Country_Id)?'selected':'';?>><?php echo $row->Country_Name;?></option>
									<?php } ?>
								</select>
								<span><?php echo form_error('SubEnterprise_Country'); ?></span>
								<?php if($editSubEnterprise->SubEnterprise_Country){ ?>
									<script>
										setTimeout(function(){
											$('#country').trigger('change');
										},3000);
									</script>
								<?php } ?>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">State</label>
							<div class="col-sm-12 col-md-6">
								<select class="custom-select2 form-control" name="SubEnterprise_State" required="" id="state" data-stateid="<?php echo $editSubEnterprise->SubEnterprise_State;?>">
									<option value="">--Select State--</option>
								</select>
								<span><?php echo form_error('SubEnterprise_State'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Province</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Province" value="<?php echo $editSubEnterprise->SubEnterprise_Province;?>" type="text" placeholder="Enter SubEnterprise Province">
								<span><?php echo form_error('SubEnterprise_Province'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Pincode</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Pincode" value="<?php echo $editSubEnterprise->SubEnterprise_Pincode;?>" type="text" placeholder="Enter SubEnterprise Pincode" required="">
								<span><?php echo form_error('SubEnterprise_Pincode'); ?></span>
							</div>
						</div> 

						<!-- <div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Password</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="SubEnterprise_Password" type="text" placeholder="Enter SubEnterprise Password" required="" value="123Ent@2019">
							</div>
						</div>  -->
						<!-- end of adding field -->
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Choose Logo</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
							</div>
						</div>

					<!-- 	<div class="form-group row"id="sandbox-container">
							<div class="col-md-4">
								<label for="Game Duration">Select Account Duration</label>
							</div>
							<div class="input-daterange input-group col-md-6" id="datepicker">
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="SubEnterprise_StartDate" name="SubEnterprise_StartDate" value="<?php echo $editSubEnterprise->Enterprise_StartDate;?>" placeholder="Select Start Date" required readonly/>
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="SubEnterprise_EndDate" name="SubEnterprise_EndDate" value="<?php echo $editSubEnterprise->Enterprise_EndDate;?>" placeholder="Select End Date" required readonly/>
							</div>
						</div> -->

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Account Duration</label>
							<div id="assignDate"class="col-sm-12 col-md-6">
								<div class="input-group" name="gamedate" id="datepicker">
									<input type="text" class="form-control datepicker-here" id="SubEnterprise_StartDate" name="SubEnterprise_StartDate" value="<?php echo $editSubEnterprise->SubEnterprise_StartDate ?>" data-value="<?php echo strtotime($editSubEnterprise->SubEnterprise_StartDate);?>" placeholder="Select Start Date" required="" readonly="" data-startDate="<?php echo strtotime($editSubEnterprise->Enterprise_StartDate);?>" data-endDate="<?php echo strtotime($editSubEnterprise->Enterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">
									<!-- <span class="input-group-addon" >To</span> --> &nbsp;
									<input type ="text" class="form-control datepicker-here" id="SubEnterprise_EndDate" name="SubEnterprise_EndDate" value="<?php echo $editSubEnterprise->SubEnterprise_EndDate ?>" data-value="<?php echo strtotime($editSubEnterprise->SubEnterprise_EndDate);?>" placeholder="Select End Date" required="" readonly="" data-startDate="<?php echo strtotime($editSubEnterprise->Enterprise_StartDate);?>" data-endDate="<?php echo strtotime($editSubEnterprise->Enterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">
								</div>
							</div>
						</div>
						
						<!-- <div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Domain/Sub-Domain</label>
							<div class="form-group row">
								<label class="col-sm-12 col-md-12 col-form-label"></label>
								<div class="col-sm-12 col-md-12" id="addDomainField">
									<input type="text" name="commonDomain" id="commonDomain" class="form-control" value="" placeholder="exampleAbc.corporatesim.com">
								</div>
							</div>
						</div> -->

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Current SubEnterprise Logo</label>
							<div class="col-sm-12 col-md-6">
								<img src="<?php echo base_url('common/Logo/'.$editSubEnterprise->SubEnterprise_Logo);?>" width="100px"height="100px" alternate="SubEnterprise_Logo">
							</div>
						</div>
						<div class="text-center">
							<button type="submit" name="submit"class="btn btn-primary">UPDATE</button>
							<a href="<?php echo base_url('SubEnterprise/');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

