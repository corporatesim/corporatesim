<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
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
						<div class="pull-right">
							<input type="checkbox" name="showCsvForm" id="showCsvForm"> Choose File To Upload SubEnterprise
							
						</div>
					</div>
					<br>
					<!-- to add data by csv -->
					<form action="" method="post" id="addByCsv" enctype="multipart/form-data" class="d-none">

						<div class="pull-right"style="margin-top:-30px;"><a href="<?php echo base_url()."csvdemofiles/subenterprise-upload-csv-demo-file.csv"; ?>" download="DemoSubEnterprise.csv"><u><i class="fa fa-download"></i></u> Demo CSV File</a></div>

						<?php if($this->session->userdata('loginData')['User_Role']!=1) { ?>
							<div class="form-group row" id="selectSubenterprise">
								<label for="Select SubEnterprise" class="col-sm-12 col-md-4 col-form-label">Select Enterprise</label>
								<div class="col-sm-12 col-md-6">
									<select name='Enterprise_ID' id='enterprise' class='form-control' required="">
										<option value=''>--Select Enterprise--</option>
										<?php foreach ($EnterpriseDetails as $row) { ?> <option value="<?php echo $row->Enterprise_ID;?>"><?php echo $row->Enterprise_Name; ?></option>
									<?php } ?> 
								</select>
							</div>
						</div>
					<?php } ?>
					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label">Choose Csv File To Upload</label>
						<div class="col-sm-12 col-md-6">
							<input type="file" name="upload_csv" accept=".csv" id="upload-file" value="" class="form-control" required="">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-12 col-md-4 col-form-label"></label>
						<div class="col-sm-12 col-md-6">
							<button class="btn btn-primary" type="submit" name="submit" value = "Upload" id="uploadCsvFile">Upload</button>
						</div>
					</div>
				</form>
				<!-- to add data by single record -->
				<form method="post" action="" enctype="multipart/form-data" id="addByForm">
					<?php if($this->session->userdata('loginData')['User_Role']!=1) { ?>
						<div class="form-group row" id="selectSubenterprise">
							<label for="Select SubEnterprise" class="col-sm-12 col-md-4 col-form-label">Select Enterprise</label>
							<div class="col-sm-12 col-md-6">
								<select name='Enterprise_ID' id='enterprise' class='form-control enterprise' required="">
									<option value=''>--Select Enterprise--</option>
									<?php foreach ($EnterpriseDetails as $row) { ?> <option value="<?php echo $row->Enterprise_ID;?>"><?php echo $row->Enterprise_Name; ?></option>
								<?php } ?> 
							</select>
						</div>
					</div>
				<?php } ?>
				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Name</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Name" value="" type="text" placeholder="Enter Name" required="">
					</div>
				</div> 
				<!-- adding more field -->
				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Contact Number</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Number" value="" type="text" placeholder="Enter Number" required="">
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Email ID</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Email" value="" type="email" placeholder="Enter Email" required="">
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Address1</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Address1" value="" type="text" placeholder="Enter Address1" required="">
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Address2</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Address2" value="" type="text" placeholder="Enter Address2">
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Country</label>
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
					<label class="col-sm-12 col-md-4 col-form-label">State</label>
					<div class="col-sm-12 col-md-6">
						<select class="form-control" name="SubEnterprise_State" required="" id="state">
							<option value="">--Select State--</option>
						</select>
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Province</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Province" value="" type="text" placeholder="Enter Province">
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Pincode</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Pincode" value="" type="text" placeholder="Enter Pincode" required="">
					</div>
				</div> 

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Password</label>
					<div class="col-sm-12 col-md-6">
						<input class="form-control" name="SubEnterprise_Password" type="text" placeholder="Enter Password" required="" value="123Ent@2019">
					</div>
				</div> 
				<!-- end of adding field -->
				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Choose Logo</label>
					<div class="col-sm-12 col-md-6">
						<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-12 col-md-4 col-form-label">Account Duration</label>
					<div id="assignDate"class="col-sm-12 col-md-6">
						<div class="input-group" name="gamedate" id="datepicker">
							<input type="text" class="form-control datepicker-here" id="SubEnterprise_StartDate" name="SubEnterprise_StartDate" value="<?php echo date('d-m-Y');?>" data-value="<?php echo strtotime(date('d-m-Y'));?>" placeholder="Select Start Date" required="" readonly="" data-startDate="" data-endDate="" data-language='en' data-date-format="dd-mm-yyyy">
							<!-- <span class="input-group-addon" >To</span> --> &nbsp;
							<input type ="text" class="form-control datepicker-here" id="SubEnterprise_EndDate" name="SubEnterprise_EndDate" value="<?php echo date('d-m-Y');?>" data-value="<?php echo strtotime(date('d-m-Y'));?>" placeholder="Select End Date" required="" readonly="" data-startDate="" data-endDate="" data-language='en' data-date-format="dd-mm-yyyy">
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

<div id="Modal_Bulkupload" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<p id="bulk_u_msg"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="Modal_BulkuploadError" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<p id="bulk_u_err"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	<!--

		$('#uploadCsvFile').on('click',function(e){
			e.preventDefault();
			var enterpriseid = $('#enterprise').val()
          	//alert(enterpriseid);
          	var form = $('#addByCsv').get(0);                     
          	$.ajax({
          		url        : '<?php echo base_url();?>Ajax/subenterprisecsv/' +enterpriseid,
          		type       : "POST",
          		data       : new FormData(form),
          		cache      : false,
          		contentType: false,
          		processData: false,
          		beforeSend : function(){
          			$('#loader').addClass('loading');
          		},
          		success: function( result ){
          			try {   
                //alert(result);                            
                var response = JSON.parse( result );
                //alert(response.status);
                if( response.status == 1 ){
                  //alert('in status = 1 ');
                  $('#bulk_u_msg').html( response.msg );
                  $('#Modal_Bulkupload').modal( 'show' );
                } else {
                	$('#bulk_u_err').html( response.msg );
                	$('#Modal_BulkuploadError').modal( 'show' );
                }
              } catch ( e ) {
              	console.log( result );
              }
              $('#loader').removeClass('loading');
            }
          });
          });
          //-->
        </script>

