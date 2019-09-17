<script type="text/javascript">
	var loc_url_del = "<?php echo base_url('Users/delete/');?>";
	var func        = "<?php echo $this->uri->segment(2);?>";
</script>
<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1><a href="<?php echo base_url('Users/addUsers/subentuser');?>" data-toggle="tooltip" title="Add User"><i class="fa fa-plus-circle text-blue"> 
							</i></a> SubEnterprize Users
						</h1>
					</div>
					<nav aria-label="breadcrumb" role="navigation">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Manage SubEnterprize Users</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="title">
						<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
							<!-- <div class="pull-right">
								<form method="post"  action="<?php echo base_url('excel_export/downloadExcel/'.$filterID); ?>" enctype="multipart/form-data">
									<button type="submit" name="submit" id="user_download" class="btn btn-primary"
									value="Download" style="display: none"><span class="fa fa-download"></span> Download </button>
								</form>
								<form method="post" id="uploadUser" name="uploadUser" action="" enctype="multipart/form-data">
									<span id="fileselector">
										<label class="btn btn-default" for="upload-file">
											<input id="upload-file" type="file" name="upload_csv" style="display: none">
											<span class="btn btn-primary"><i class="fa fa-upload"></i> Upload</span>
										</label>
									</span>
								</form>
								<a href="<?php echo base_url()."csvdemofiles/user-subenterprise-upload-csv-demo-file.csv";?>" download="DemoSubEnterpriseUser.csv"><u>Demo SubEnterprise Users</u></a>
							</div> -->
							<div class="clearfix mb-20">
								<h5 class="text-blue mb-20">SubEnterprize Users Details</h5>
								<!-- to show filter only for enterprise users -->
								<!-- <?php if($this->session->userdata('loginData')['User_Role']!=2){ ?>
									<form method="post" action="" id="filterForm">
										<div class="form-group row"id="selectSubenterprise">
											<label for="Select SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Choose Filter</label>
											<div class="col-sm-12 col-md-6">
												<select name='SubEnterprise_ID' id='subenterprise' class='form-control'>
													<option value=''>--Select SubEnterprise--</option>
													<?php foreach ($Subenterprise as $row) { ?> 
														<option value="<?php echo $row->SubEnterprise_ID;?>"data-subenterprise="<?php echo $row->SubEnterprise_Name; ?>" <?php echo ($filterID==$row->SubEnterprise_ID)?'selected':'';?>><?php echo $row->SubEnterprise_Name; ?></option>
													<?php } ?> 
												</select>
											</div>
										</div>
									</form>
								<?php } ?> -->
							</div>
							<div class="row">
								<table class="stripe hover multiple-select-row data-table-export nowrap" >
									<thead>
										<tr>
											<th>Sr.No.</th>
											<th class="datatable-nosort">Enterprize</th>
											<th class="datatable-nosort">SubEnterprize</th>
											<th class="table-plus">User Name</th>
											<th>Email</th>
											<th>Password</th>
											<th class="datatable-nosort">Contact</th>
											<th class="datatable-nosort">Games</th>
											<th class="datatable-nosort noExport">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1;
										foreach ($userDetails as $userDetails) { ?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $userDetails->Enterprise_Name; ?></td>
												<td class="table-plus"><?php echo $userDetails->SubEnterprise_Name ; ?></td>
												<td><?php echo $userDetails->User_username;?>
											</td>
											<td><?php echo $userDetails->User_email; ?></td>
											<td><?php echo $userDetails->password; ?></td>
											<td><?php echo $userDetails->User_mobile; ?></td>
											<td>
												<a href="<?php echo base_url('Games/assignGames/').base64_encode($userDetails->User_id).'/'.base64_encode($this->uri->segment(2)); ?>" title="Allocate/Deallocate Games"><?php echo "<b style='color:#0029ff;'>".$userDetails->gameCount."</b>"; ?></a>
											</td>
											<td>
												<div class="dropdown">
													<a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="fa fa-ellipsis-h"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-left">
														<!-- <a class="dropdown-item" href="#"><i class="fa fa-eye"></i> View</a> -->
														<a class="dropdown-item" href="<?php echo base_url('Users/user/').base64_encode($userDetails->User_id).'/'.$this->uri->segment(2);?>"><i class="fa fa-pencil"></i> Edit</a>
														<!-- <a class="dropdown-item" href="<?php //echo base_url('Users/assignGames/');?><?php //echo base64_encode($userDetails->User_id); ?>" title="Allocate/Deallocate Games"><i class="fa fa-gamepad"></i> Allocate/Deallocate Games</a> -->
														<a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo 
														$userDetails->User_id; ?>" title="Delete"><i class="fa fa-trash"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										<?php $i++; }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="Modal_Bulkupload" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Import Success</h4>
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
						$(document).ready(function(){
							$('#subenterprise').on('change',function(){
								$('#filterForm').submit();
							});
						});
					</script>
					<script type="text/javascript">
						$('#upload-file').on('click',function(){
							<?php	if($filterID < 1){ ?>
								alert('Please select Subenterprise to upload users');
								return false;
							<?php } ?>
						});
						$('#upload-file').change( function(){
							var form = $('#uploadUser').get(0);
							$.ajax({
								url        : "<?php echo base_url('Users/SubenterpriseUsersCSV/'.$filterID);?>",
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
										} 
										else
										{
											$('#bulk_u_err').html( response.msg );
											$('#Modal_BulkuploadError').modal( 'show' );
										}
									} 
									catch ( e )
									{
										console.log( result );
									}
									$('#loader').removeClass('loading');
								}
							});
						});
					</script>