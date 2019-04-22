<div class="main-container ">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Enterprize</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">Add Enterprize</h4>
						</div>
						<div class="pull-right">
							<input type="checkbox" name="showCsvForm" id="showCsvForm"> Choose File To Upload Enterprize
						</div>
					</div>
					<br>
					<!-- to add data by csv -->
					<form action="" method="post" id="addByCsv" enctype="multipart/form-data" class="d-none">
						<div class="pull-right"style="margin-top:-30px;"><a href="<?php echo base_url()."csvdemofiles/enterprise-upload-csv-demo-file.csv"; ?>" download="DemoEnterprise.csv"><u><i class="fa fa-download"></i></u> Demo CSV file</a></div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Choose Csv File To Upload</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" name="upload_csv" accept=".csv" id="csvFile" value="" class="form-control" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"></label>
							<div class="col-sm-12 col-md-6">
								<button class="btn btn-primary" type="submit" value="Upload" name="submit" id="uploadCsvFile">Upload</button>
							</div>
						</div>
					</form>
					<!-- to add data by single record -->
					<form method="post" action=""enctype="multipart/form-data" id="addByForm">
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Name" value="<?php echo set_value('Enterprise_Name');?>" type="text" placeholder="Enter Name" >
								<span><?php echo form_error('Enterprise_Name'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Contact Number</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Number" value="<?php echo set_value('Enterprise_Number');?>" type="text" placeholder="Enter Number" >
								<span><?php echo form_error('Enterprise_Number'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Email ID</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Email" value="<?php echo set_value('Enterprise_Email');?>" type="email" placeholder="Enter Email" >
								<span><?php echo form_error('Enterprise_Email'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Address1</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Address1" value="<?php echo set_value('Enterprise_Address1');?>" type="text" placeholder="Enter Address1" >
								<span><?php echo form_error('Enterprise_Address1'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Address2</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Address2" value="<?php echo set_value('Enterprise_Address2');?>" type="text" placeholder="Enter Address2">
								<span><?php echo form_error('Enterprise_Address2'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Country</label>
							<div class="col-sm-12 col-md-6">
								<select class="form-control" required="" name="Enterprise_Country"  id="country">
									<option value="">--Select Country--</option>
									<?php foreach ($country as $row) { ?>
										<option value="<?php echo $row->Country_Id;?>"><?php echo $row->Country_Name;?></option>
									<?php } ?>
								</select>
								<span><?php echo form_error('Enterprise_Country'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">State</label>
							<div class="col-sm-12 col-md-6">
								<select class="form-control" name="Enterprise_State"  id="state">
									<option value="">--Select State--</option>
								</select>
								<span><?php echo form_error('Enterprise_State'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Province</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Province" value="<?php echo set_value('Enterprise_Province');?>" type="text" placeholder="Enter Province">
								<span><?php echo form_error('Enterprise_Province'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Pincode</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Pincode" value="<?php echo set_value('Enterprise_Pincode');?>" type="text" placeholder="Enter Pincode" >
								<span><?php echo form_error('Enterprise_Pincode'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Password</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" required="" name="Enterprise_Password" type="text" placeholder="Enter Password"  value="<?php echo set_value('Enterprise_Password');?>">
								<span><?php echo form_error('Enterprise_Password'); ?></span>
							</div>
						</div> 

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Choose Logo</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" required="" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
								
							</div>
						</div>

						<div class="row" id="sandbox-container">
							<div class="col-md-4">
								<label for="Game Duration">Select Account Duration</label>
							</div>
							<div class="input-daterange input-group col-md-6" id="datepicker">
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate" value="" placeholder="Select Start Date" required readonly/>
								<!-- <span class="input-group-addon">to</span> --> &nbsp;
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate" value="" placeholder="Select End Date" required readonly/>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">Domain/Sub-Domain</label>
							<div class="col-sm-6 col-md-3" id="addDomainField">
								<input type="text" name="commonDomain" id="commonDomain" class="form-control" value="<?php echo set_value('commonDomain');?>" placeholder="Enter Sub-Domain Name" pattern="[A-Za-z]{3,}">
									<span><?php echo form_error('commonDomain'); ?></span>
							</div>
							<div class="col-sm-6 col-md-3" id="showDomain">
								.corporatesim.com
							</div>
						</div>

						<div class="text-center">
							<button type="submit" value="save" name="submit" class="btn btn-primary">SUBMIT</button>
							<a href="<?php echo base_url('Enterprise');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
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
			$('#addByCsv').submit();
			var form = $('#addByCsv').get(0);                     
			$.ajax({
				url        : '<?php echo base_url();?>Ajax/enterprisecsv',
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
						var response = JSON.parse( result );
						if( response.status == 1 ){
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


