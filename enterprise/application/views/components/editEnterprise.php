<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Edit Enterprise</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Edit Enterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
						</div>
					</div>
					<form method="post" action=""enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span>Enterprise Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" type="text" value="<?php echo $editEnterprise->Enterprise_Name;?>" name="Enterprise_Name">
							</div>
						</div>
						<!-- start adding more fields -->
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise Number</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Number" value="<?php echo $editEnterprise->Enterprise_Number;?>" type="text" required="">
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise Email</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Email" value="<?php echo $editEnterprise->Enterprise_Email;?>" type="email" required="">
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise Address1</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Address1" value="<?php echo $editEnterprise->Enterprise_Address1;?>" type="text" required="">
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"> Enterprise Address2</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Address2" value="<?php echo $editEnterprise->Enterprise_Address2;?>" type="text">
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise Country</label>
							<div class="col-sm-12 col-md-6">
								<select class="form-control" name="Enterprise_Country" required="" id="country">
									<!-- value="<?php echo $editEnterprise->Enterprise_Country;?>" -->
									<option value="">--Select Country--</option>
									<?php foreach ($country as $row) { ?>
										<option value="<?php echo $row->Country_Id;?>" <?php echo ($row->Country_Id==$editEnterprise->Enterprise_Country)?'selected':''; ?>><?php echo $row->Country_Name;?></option>
									<?php } ?>
								</select>
								<?php if($editEnterprise->Enterprise_Country){ ?>
									<script>
										setTimeout(function(){
											$('#country').trigger('change');
										},1000);
									</script>
								<?php } ?>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise State</label>
							<div class="col-sm-12 col-md-6">
								<select class="form-control" name="Enterprise_State" required="" id="state" data-stateid="<?php echo $editEnterprise->Enterprise_State;?>">
									<option value="">--Select State--</option>
								</select>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"> Enterprise Province</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Province" value="<?php echo $editEnterprise->Enterprise_Province;?>" type="text">
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise Pincode</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Pincode" value="<?php echo $editEnterprise->Enterprise_Pincode;?>" type="text" required="">
							</div>
						</div>
						<!-- end of adding more fields  -->
						<div class="form-group row"id="sandbox-container">
							<div class="col-md-4">
								<label for="Game Duration"><span class="alert-danger">*</span> Select Account Duration</label>
							</div>
							<div class="input-daterange input-group col-md-6" id="datepicker">
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_StartDate" name="Enterprise_StartDate" value="<?php echo $editEnterprise->Enterprise_StartDate;?>" placeholder="Select Start Date" required readonly/>
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_EndDate" name="Enterprise_EndDate" value="<?php echo $editEnterprise->Enterprise_EndDate;?>" placeholder="Select End Date" required readonly/>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">
								<span class="alert-danger">*</span> Choose Logo</label>
								<div class="col-sm-12 col-md-6">
									<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Current Enterprise Logo</label>
								<div class="col-sm-12 col-md-6">
									<img src="<?php echo base_url('common/Logo/'.$editEnterprise->Enterprise_Logo);?>" width="100px"height="100px" alternate="Enterprise_Logo">
								</div>
							</div>
							<div class="text-center">
								<button type="submit" name="submit"class="btn btn-primary">UPDATE</button>
								<a href="<?php echo base_url('Enterprise/');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

