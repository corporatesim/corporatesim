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
								<li class="breadcrumb-item active" aria-current="page">Add Users</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">Add Users</h4><br>
						</div>
						<div class="pull-right">
							<input type="checkbox" name="showCsvForm" id="showCsvForm"> Choose File To Upload Users
						</div>
					</div>
					<!-- to add data by csv -->
					<form action="" method="post" id="addByCsv" enctype="multipart/form-data" class="d-none">
						<div class="pull-right"style="margin-top:-30px;"><a href="<?php echo base_url()."csvdemofiles/user-enterprise-upload-csv-demo-file.csv"; ?>" download="DemoEnterpriseUsers.csv"><u><i class="fa fa-download"></i></u> Demo CSV file</a></div>
						<div class="form-group row" id="Enterprise_Section">
							<label for="Select Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprise</label>
							<div class="col-sm-12 col-md-6">
								<select name="Enterprise" id="Enterprise" class="form-control Enterprise" required="">
									<option value="">--Select Enterprise--</option>
									<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
										<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name;?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- subenterprise dropdown -->
						<?php if($typeUser == 'subentuser') { ?>
							<div class="form-group row selectSubenterprise" id="selectSubenterprise">
								<label for="Select SubEnterprise" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span>Select SubEnterprise</label>
								<div class="col-sm-12 col-md-6">
									<select name='subenterprise' id='subenterprise' class='form-control subenterprise' required="">
										<option value=''>-Select SubEnterprise-</option>
										<?php foreach ($Subenterprise as $row) { ?> 
											<option value="<?php echo $row->SubEnterprise_ID;?>"><?php echo $row->SubEnterprise_Name; ?></option>
										<?php } ?> 
									</select>
								</div>
							</div>
						<?php } ?>

						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label">Choose Csv File To Upload</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" name="upload_csv" accept=".csv" id="upload-file" value="" class="form-control" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"></label>
							<div class="col-sm-12 col-md-6">
								<button class="btn btn-primary" type="submit">Upload</button>
							</div>
						</div>
					</form>
					<!-- to add data by single record -->
					<form method="post" action="" id="addByForm">
						<div class="form-group row d-none">
							<label for="User Type" class="col-sm-12 col-md-3 col-form-label">User Type</label>
							<div class="col-sm-12 col-md-6">
								<input type="radio" value="0" name="userType" <?php echo ($typeUser == 'entuser')?'checked':''; ?> id="enterpriseUser"> Enterprise
								<input type="radio" value="1" name="userType" <?php echo ($typeUser == 'subentuser')?'checked':''; ?> id="subenterpriseUser"> Subenterprise
							</div>
						</div>
						<!-- enterprise dropdwon -->
						<div class="form-group row" id="Enterprise_Section">
							<label for="Select Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprise</label>
							<div class="col-sm-12 col-md-6">
								<select name="Enterprise" id="Enterprise" class="form-control Enterprise" required="">
									<option value="">--Select Enterprise--</option>
									<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
										<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name;?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- subenterprise dropdown -->
						<?php if($typeUser == 'subentuser') { ?>
							<div class="form-group row selectSubenterprise" id="selectSubenterprise">
								<label for="Select SubEnterprise" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span>Select SubEnterprise</label>
								<div class="col-sm-12 col-md-6">
									<select name='subenterprise' id='subenterprise' class='form-control subenterprise' required="">
										<option value=''>-Select SubEnterprise-</option>
										<?php foreach ($Subenterprise as $row) { ?> 
											<option value="<?php echo $row->SubEnterprise_ID;?>"><?php echo $row->SubEnterprise_Name; ?></option>
										<?php } ?> 
									</select>
								</div>
							</div>
						<?php } ?>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label">First Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" type="text" name="User_fname" placeholder="Enter First Name" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label">Last Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" placeholder="Enter Last Name" name="User_lname" type="text" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label">User Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="User_username" placeholder="Enter username" value="" type="text" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label">Email ID</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="User_email" placeholder="Enter Email"value="" type="text" required="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-3 col-form-label">Contact Number</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="User_mobile" placeholder="Enter Contact Number" value="" type="tel" required="">
							</div>
						</div>
						<div class="form-group row d-none">
							<label class="col-sm-12 col-md-3 col-form-label">Company</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control " value="0" placeholder="If applicable" name="User_companyid" type="text" required="">
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
	$(document).ready(function() {
	//Show Subenterprise on change of enterprise
	$('.Enterprise').on('change',function(){
		$this             = $(this);
		var option        = '<option value="">--Select SubEnterprise--</option>';
		var Enterprise_ID = $(this).val();
		if($(this).val())
		{ 
   	// triggering ajax to show the subenterprise linked with this enterprise
   	$.ajax({
   		url :"<?php echo base_url();?>Ajax/get_subenterprise/"+Enterprise_ID,
   		type: "POST",
   		success: function( result )
   		{
   			result = JSON.parse(result);
   			if(result.length > 0)
   			{
   				$(result).each(function(i,e)
   				{
   					option += ("<option value='"+result[i].SubEnterprise_ID+"'>"+result[i].SubEnterprise_Name+"</option>");
   				});
   				$this.parents('form').find('select.subenterprise').html(option);
   				option = '<option value="">--Select SubEnterprise--</option>';
   				// $('.SubEnterprise').html(option);
   			}
   			else
   			{
   				$this.parents('form').find('select.subenterprise').html(option);
   				// alert('No SubEnterprise Associated With The Selected Enterprise');
   			}
   		},
   	});          
   }
   else
   {
   	$this.parents('form').find('select.subenterprise').html(option);
   	alert('Please Select Enterprise...');
   	return false;
   }
 });
});
</script>

<script type="text/javascript">
	<!--

		$('#upload-file').change( function(){
			var Enterpriseid = $('#Enterprise').val()
			var SubEnterpriseid = $('#subenterprise').val()
			
			if(SubEnterpriseid != '' && SubEnterpriseid != undefined){

				$url = '<?php echo base_url();?>Ajax/SubEnterpriseUsersCSV/'+Enterpriseid+'/'+SubEnterpriseid

			}
			else{

				$url= '<?php echo base_url();?>Ajax/EnterpriseUsersCSV/'+Enterpriseid;

			}

          //alert(Enterpriseid);
          var form = $('#addByCsv').get(0);                     
          $.ajax({
          	url        : $url,
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


