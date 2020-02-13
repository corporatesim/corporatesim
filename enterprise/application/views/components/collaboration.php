<script type="text/javascript">
	var loc_url_del = "<?php echo base_url('Users/delete/');?>";
	var func        = "<?php echo $this->uri->segment(2);?>";
</script>
<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<!-- model code adding here to add collaboration -->
		<div class="modal fade" id="addCollaborationModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">
							<a href="javascript:void(0);" data-toggle="tooltip" title="" id="editCollaborationFromAdd" data-original-title="View Collaboration">
								<i class="fa fa-eye text-blue"></i>
							</a>
						Add P2P Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="collaborationForm" method="post">
						<div class="modal-body">
							<div class="form-group">
								<label for="Group_Name" class="col-form-label">P2P/Group Name:</label>
								<input type="text" class="form-control" id="Group_Name" name="Group_Name" placeholder="Enter Collaboration/Group Name" required="">
							</div>
							<div class="form-group">
								<label for="Group_Info" class="col-form-label">P2P/Group Information:</label>
								<textarea class="form-control" id="Group_Info" name="Group_Info" placeholder="Enter Collaboration/Group Information" required=""></textarea>
							</div>
							<div class="row col-md-12 alert-danger" id="showAlertMessage"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="closeAddCollaborationModel">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- model code ends here -->
		<!-- model code adding here to view/edit collaboration -->
		<div class="modal fade" id="viewCollaborationModel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="viewModalLabel">
							<a href="javascript:void(0);" data-toggle="tooltip" title="" id="addCollaborationFromEdit" data-original-title="Add Collaboration">
								<i class="fa fa-plus-circle text-blue"></i>
							</a>
							View P2P/Group Details
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="editModalClose">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- adding search box -->
						<div class="input-group" style="background: #00000013;">
							<input class="form-control py-2 border-right-0 border" type="search" placeholder="Search Group/Collaboration" id="searchGroup">
							<span class="input-group-append">
								<div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
							</span>
						</div>
						<!-- end of adding search box -->
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<th>S.N.</th>
								<th>Group Name</th>
								<th>Group Info</th>
								<th>Action</th>
							</thead>
							<tbody>
								<tr>
									<td colspan="3">No data found</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="closeViewCollaborationModel">Close</button>
						<!-- <button type="button" class="btn btn-primary">Save</button> -->
					</div>
				</div>
			</div>
		</div>
		<!-- model code ends here -->
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<h1>
								<div class="row">
									<div class="col-md-6 pull-left">
										<a href="javascript:void(0);" data-toggle="tooltip" title="Add Collaboration" id="addCollaboration">
											<i class="fa fa-plus-circle text-blue" data-toggle="modal" data-target="#addCollaborationModel"></i>
											<!-- <button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#addCollaborationModel" data-whatever="" id="openCollaborationModel"></button> -->
										</a>
										Add P2P
									</div>
									<div class="col-md-6 pull-right">
										<a href="javascript:void(0);" data-toggle="tooltip" title="View Collaboration" id="viewCollaboration">
											<i class="fa fa-eye text-blue" data-toggle="modal" data-target="#viewCollaborationModel"></i>
										</a> View P2P
									</div>
								</div>
							</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Create Group For Teams</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
								<div class="clearfix mb-20">
									<h5 class="text-blue">
										<i class="fa fa-handshake-o text-blue"> 
										</i> Select P2P And Teams To Create Group
									</h5>
								</div>
								<form action="" method="post" class="" id="">
									<!-- add filters accordingly, as per the roles if user is superadmin-->
									<?php if($this->session->userdata('loginData')['User_Role']=='superadmin'){ ?>
										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="superadminUsers" name="filtertype" class="custom-control-input" checked="" value="superadminUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="superadminUsers">My Teams</label>
												</div>
											</div>
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="enterpriseUsers">Enterprize Teams</label>
												</div>
											</div>
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Teams</label>
												</div>
											</div>
											<div class="custom-control custom-checkbox col-sm-12 col-md-3 col-lg-3">
												<input type="checkbox" class="custom-control-input" id="selectAll" name="selectAll">
												<label class="custom-control-label" for="selectAll">Select All</label>
											</div>
										</div>
										<!-- end of radio, choose dropdown -->
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
											<label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprise</label>
											<div class="col-sm-12 col-md-9">
												<select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise">
													<option value="">--Select Enterprise--</option>
													<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
														<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name;?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<!-- for subenterprise selection -->
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
											<label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprise</label>
											<div class="col-sm-12 col-md-9">
												<select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
													<option value="">-Select SubEnterprise-</option>
												</select>
											</div>
										</div>
									<?php }	?>
									<!-- if user is enterprise -->
									<?php if($this->session->userdata('loginData')['User_Role']==1){ ?>
										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" checked="" data-filtertype="enterprise">
													<label class="custom-control-label" for="enterpriseUsers">My Teams</label>
												</div>
											</div>
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="enterprise">
													<label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Teams</label>
												</div>
											</div>
											<div class="custom-control custom-checkbox col-sm-12 col-md-3 col-lg-3">
												<input type="checkbox" class="custom-control-input" id="selectAll" name="selectAll">
												<label class="custom-control-label" for="selectAll">Select All</label>
											</div>
										</div>
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
											<label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprise</label>
											<div class="col-sm-12 col-md-9">
												<select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise" required="">
													<option value="">--Select Enterprise--</option>
													<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
														<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name;?>" selected><?php echo $EnterpriseData->Enterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<!-- for subenterprise selection -->
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
											<label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprise</label>
											<div class="col-sm-12 col-md-9">
												<select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
													<option value="">-Select SubEnterprise-</option>
													<?php foreach ($SubEnterprise as $SubEnterpriseData) { ?>
														<option value="<?php echo $SubEnterpriseData->SubEnterprise_ID; ?>" date-subEnterprisename="<?php echo $SubEnterpriseData->SubEnterprise_Name;?>"><?php echo $SubEnterpriseData->SubEnterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php }	?>
									<!-- if user is subEnterprise -->
									<?php if($this->session->userdata('loginData')['User_Role']==2){ ?>
										<div class="custom-control custom-checkbox col-sm-12 col-md-3 col-lg-3 float-right float-right">
											<input type="checkbox" class="custom-control-input" id="selectAll" name="selectAll">
											<label class="custom-control-label" for="selectAll">Select All</label>
										</div>
										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group d-none">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input checked="" type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="subEnterprise">
													<label class="custom-control-label" for="subEnterpriseUsers">My Teams</label>
												</div>
											</div>
										</div>
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
											<label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprise</label>
											<div class="col-sm-12 col-md-9">
												<select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise" required="">
													<option value="">--Select Enterprise--</option>
													<?php foreach ($EnterpriseName as $EnterpriseData) { ?>
														<option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name;?>" selected><?php echo $EnterpriseData->Enterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
											<label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprise</label>
											<div class="col-sm-12 col-md-9">
												<select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise" required="">
													<option value="">-Select SubEnterprise-</option>
													<?php foreach ($SubEnterprise as $SubEnterpriseData) { ?>
														<option value="<?php echo $SubEnterpriseData->SubEnterprise_ID; ?>" date-subEnterprisename="<?php echo $SubEnterpriseData->SubEnterprise_Name;?>" selected><?php echo $SubEnterpriseData->SubEnterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php } ?>
									<!-- after all the above filter show users here -->
									<div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="">
										<label for="gameCollaboration" class="col-sm-12 col-md-3 col-form-label">Select P2P</label>
										<div class="col-sm-9 col-md-9">
											<select name="gameCollaboration" id="gameCollaboration" class="custom-select2 form-control" required="">
												<option value="0">-Select P2P-</option>
											</select>
											<a href="javascript:void(0);" data-toggle="tooltip" title="Refresh P2P" id="refreshCollaboration">
												<i class="fa fa-refresh"></i>
											</a>
										</div>
									</div>
									<div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="gameDiv">
										<label for="selectGame" class="col-sm-12 col-md-3 col-form-label">Select Game</label>
										<div class="col-sm-12 col-md-9">
											<select name="selectGame" id="selectGame" class="custom-select2 form-control" required="">
												<option value="">-Select Game-</option>
											</select>
										<div class="text-danger">Please select only team id's for collaboration</div>
										</div>
									</div>
									<div class="row col-md-12 col-lg-12 col-sm-12 form-group d-none">
										<label for="searchUser" class="col-sm-12 col-md-3 col-form-label">Search</label>
										<div class="col-sm-12 col-md-6">
											<input type="search" name="searchUser" id="searchUser" class="form-control" placeholder="Search by Email/UserName">
											<span id="showUserCount" class="text-blue"></span>
										</div>
									</div>
									<!-- add users details here -->
									<div class="row col-md-12 col-lg-12 col-sm-12 form-group mb-20" id="addUsersHere">
									</div>
									<!-- end of adding users -->
									<div class="row col-md-12 form-group" style="margin-left: 33%;">
										<button class="btn btn-primary">Create P2P</button>
										&nbsp;
										<a href="<?php echo base_url();?>" class="btn btn-outline-danger">Cancel</a>
									</div>
								</form>
							</div>
						</div>
						<!-- team mapping starts here -->
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
									<div class="clearfix mb-20">
										<h5 class="text-blue">
											<i class="fa fa-users text-blue"> 
											</i> Team Mapping
										</h5>
									</div>

									Choose above filters accordingly to map users with team
									<form id="teamMappingForm" method="post">
										<div class="col-sm-12 col-md-12 col-lg-12 row form-group">
											<select name="teamDropdown" id="teamDropdown" class="custom-select2 form-control select2-hidden-accessible" required="">
												<option value="">--Select Team--</option>
											</select>
										</div>
										<!-- adding users below -->
										<div class="col-sm-12 col-md-12 col-lg-12 row form-group" id="teamUsers"></div>
										<button class="btn btn-primary" id="mapTeamUserButton">Submit</button>
									</form>
								</div>
							</div>
						</div>
						<!-- team mapping ends here -->
						<br>
						<br>
						<br>

						<script>
							$(document).ready(function()
							{
								// close edit model and open add model from edit model button
								$('#addCollaborationFromEdit').on('click',function(){
									$('#editModalClose').trigger('click');
									setTimeout(function(){
										$('#addCollaboration').children('i.fa-plus-circle').trigger('click');
										// alert('clicked');
									},100);
								});

								// close add model and open edit model from add model button
								$('#editCollaborationFromAdd').on('click',function(){
									$('#closeAddCollaborationModel').trigger('click');
									setTimeout(function(){
										$('#viewCollaboration').children('i.fa-eye').trigger('click');
										// alert('clicked');
									},100);
								});
								
								// while user save the collaboration details
								$('#collaborationForm').on('submit',function(e){
									e.preventDefault();
									var data = $( this ).serialize();
									$.ajax({
										type    : "POST",
										dataType: "json",
										data    :data,
										url     : "<?php echo base_url('Ajax/addEditDeleteFetchCollaboration/add');?>",
										beforeSend: function() {
											// $('.pre-loader').show();
										},
										success: function(result) 
										{
											// $('.pre-loader').hide();
											// close the model and make the input fields empty
											$('#closeAddCollaborationModel').trigger('click');
											$('#Group_Name').val('');
											$('#Group_Info').val('');
											if(result.status == 200)
											{
												Swal.fire({
													icon: 'success',
													html: result.message,
												});
												// refresh the view list
												$('#refreshCollaboration').trigger('click');
											}
											else
											{
												Swal.fire({
													icon: 'error',
													html: result.message,
												});
											}
										},
										error: function(jqXHR, exception)
										{
											{
												// $('.pre-loader').hide();
												Swal.fire({
													icon: 'error',
													html: jqXHR.responseText,
												});
												$("#input_loader").html('');
											}
										}

									});
								});
								// show all game by default and then show games as per the filter
								var allGameOption = "<option value=''>-Select Game-</option>";
								<?php foreach ($gameData as $games) { ?>
									allGameOption += "<option value=<?php echo $games->Game_ID; ?>><?php echo $games->Game_Name; ?></option>";
								<?php } ?>
								$('#selectGame').html(allGameOption);

								$('input[name="filtertype"]').on('change',function(){
									var filterValue = $(this).val();
									var loggedInAs  = $(this).data('filtertype');

									// clear all the set values and then fetch data accordingly
									// $('#Enterprise').val([])
									// $('#SubEnterprise').val([])
									// $('#selectGame').val([])
									$('#refreshCollaboration').trigger('click');

									// enterpriseDiv subEnterpriseDiv // superadminUsers enterpriseUsers subEnterpriseUsers
									// console.log(loggedInAs+' of type '+filterValue);
									if(loggedInAs == 'superadmin')
									{
										if(filterValue == 'superadminUsers')
										{
											$('#Enterprise').attr('required',false);
											$('#SubEnterprise').attr('required',false);
											$('#enterpriseDiv').addClass('d-none');
											$('#subEnterpriseDiv').addClass('d-none');
											fetchAssignedGames('superadminUsers',null);
										}
										else if(filterValue == 'enterpriseUsers')
										{
											$('#Enterprise').attr('required',true);
											$('#SubEnterprise').attr('required',false);
											$('#enterpriseDiv').removeClass('d-none');
											$('#subEnterpriseDiv').addClass('d-none');
										}
										else if(filterValue == 'subEnterpriseUsers')
										{
											$('#Enterprise').attr('required',true);
											$('#SubEnterprise').attr('required',true);
											$('#enterpriseDiv').removeClass('d-none');
											$('#subEnterpriseDiv').removeClass('d-none');
										}
									}
									else if(loggedInAs == 'enterprise')
									{
										if(filterValue == 'enterpriseUsers')
										{
											$('#Enterprise').attr('required',false);
											$('#SubEnterprise').attr('required',false);
											$('#enterpriseDiv').addClass('d-none');
											$('#subEnterpriseDiv').addClass('d-none');
										}
										else if(filterValue == 'subEnterpriseUsers')
										{
											$('#Enterprise').attr('required',false);
											$('#SubEnterprise').attr('required',true);
											$('#enterpriseDiv').addClass('d-none');
											$('#subEnterpriseDiv').removeClass('d-none');
										}
									}
									// if user is of type subenterprise
									else
									{
										$('#Enterprise').attr('required',false);
										$('#SubEnterprise').attr('required',true);
										$('#enterpriseDiv').addClass('d-none');
										$('#subEnterpriseDiv').addClass('d-none');
									}
									// getAgents();
								});

								$('#Enterprise').on('change',function(){
									$this             = $(this);
									var option        = '<option value="">--Select SubEnterprise--</option>';
									var Enterprise_ID = $(this).val();

									if($(this).val())
									{ 
										// getch all the collaborations/groups for the enterprise
										$('#refreshCollaboration').trigger('click');
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
													// Swal.fire('No SubEnterprise Associated With The Selected Enterprise');
												}
											},
										});

										fetchAssignedGames('enterpriseUsers',Enterprise_ID);
									}
									else
									{
										$this.parents('form').find('select.subenterprise').html(option);
										Swal.fire('Please Select Enterprise...');
										return false;
									}
									// getAgents();
								});

								$('#SubEnterprise').on('change',function()
								{
									// getch all the collaborations/groups for the SubEnterprise
									$('#refreshCollaboration').trigger('click');
									fetchAssignedGames('subEnterpriseUsers',$(this).val());
								});

								// on game change get the users and show them
								$('#selectGame').on('change',function(){
									getAgents();
								});

								$('#searchUser').on('keyup',function(){
									getAgents();
								});

								// select all checkboxes
								$('#selectAll').on('click',function(){
									if($(this).is(':checked'))
									{
										$('input[type="checkbox"]').each(function(){
											$(this).prop('checked',true);
										});
									}
									else
									{
										$('input[type="checkbox"]').each(function(){
											$(this).prop('checked',false);
										});
									}
								});

							// writing functions below

							function fetchAssignedGames(ent_SubEnt,id)
							{
								// show only assigned games only
								if(ent_SubEnt=='superadminUsers')
								{
									$('#selectGame').html(allGameOption);
								}
								else
								{
									$.ajax({
										url :"<?php echo base_url();?>Ajax/fetchAssignedGames/"+ent_SubEnt+"/"+id,
										type: "POST",
										success: function( result )
										{
											if(result == 'No game found')
											{
												Swal.fire('No game allocated to selected '+ent_SubEnt);
												$('#selectGame').html('<option value="">--Select Game--</option>');
											}
											else
											{
												result = JSON.parse(result);
												var entGameOption = '<option value="">--Select Game--</option>';
												$(result).each(function(i,e)
												{
													entGameOption += ("<option value='"+result[i].Game_ID+"'>"+result[i].Game_Name+"</option>");
												});
												$('#selectGame').html(entGameOption);
											}
										},
									});
								}
							}
							function getAgents()
							{
								var gameId            = $('#selectGame').val();
								var gameCollaboration = $('#gameCollaboration').val();
								var filterValue       = $('input[name="filtertype"]:checked').val();
								var loggedInAs        = $('input[name="filtertype"]:checked').data('filtertype');
								var enterpriseId      = $('#Enterprise').val();
								var subEnterpriseId   = $('#SubEnterprise').val();
								var searchFilter      = $('#searchUser').val();
								var siteUsers         = '';
								var teamUsers         = '';
								var teamDropdown      = '<option value="">--select team--</option>';

								if(gameId<1 || gameCollaboration<1)
								{
									Swal.fire("Error","Please Select Game And Collaboration","error");
									console.log('Please select game');
									$('#addUsersHere').html('<span class="row alert-danger">No record found</span>');
									$('#showUserCount').html('');
									return false;
								}
								$.ajax({
									url     :"<?php echo base_url();?>Ajax/getAgentsForCollaboration",
									type    : "POST",
									dataType: 'html',
									data    : "gameId='"+gameId+"'&filterValue="+filterValue+"&loggedInAs='"+loggedInAs+"'&enterpriseId='"+enterpriseId+"'&subEnterpriseId='"+subEnterpriseId+"'&searchFilter="+searchFilter+"&Group_Id="+gameCollaboration,
									success: function( result )
									{
										result = JSON.parse(result);
										// console.log(result.mappedUser);
										if(result.status == 200)
										{
											// Swal.fire("Success",result.message,result.icon);
											var alreadyMappedCount = 0;
											var userCount          = 0;
											var notSbumittedCount  = 0;
											var makeUsersRed       = '';
											var userdata           = result.userdata;
											var teamUsersData      = result.teamUsersData;

											$(userdata).each(function(i,e)
											{
												// check that this user is already mapped with this group/p2p/collaboration or not

												// also creating team drop-down for team mapping, which are already mapped that is team rest is users
												if($.inArray(userdata[i].User_id, result.mappedUser) != -1)
												{
													var alreadyMapped  = 'checked';
													teamDropdown      += "<option value="+userdata[i].User_id+">"+userdata[i].fullName+"</option>";
													alreadyMappedCount++;
												}
												else
												{
													var alreadyMapped = '';
												}

												siteUsers += ('<div class="custom-control custom-checkbox col-sm-12 col-md-2 col-lg-2" title="'+userdata[i].User_email+'"><input type="checkbox" '+alreadyMapped+' class="custom-control-input" value="'+userdata[i].User_id+'" id="'+userdata[i].User_id+'_user" name="siteUsers[]"><label class="custom-control-label" for="'+userdata[i].User_id+'_user">'+userdata[i].fullName+'</label></div>');
												userCount++;
											});
											$('#addUsersHere').html(siteUsers);
											$('#showUserCount').text(result.message+' '+alreadyMappedCount+' Users Already Mapped.');
											// adding data to team's dropdown
											$('#teamDropdown').html(teamDropdown);
											// getting all the users of the ent/subent/admin for mapping, while user has game or not
											$(teamUsersData).each(function(i,e)
											{
												teamUsers += ('<div class="custom-control custom-checkbox col-sm-12 col-md-2 col-lg-2" title="'+teamUsersData[i].User_email+'"><input type="checkbox" class="custom-control-input" value="'+teamUsersData[i].User_id+'" id="team_'+teamUsersData[i].User_id+'" name="teamUsers[]"><label class="custom-control-label" for="team_'+teamUsersData[i].User_id+'">'+teamUsersData[i].User_fname+' '+teamUsersData[i].User_lname+'</label></div>');
											});
											$('#teamUsers').html(teamUsers);
											// if any of the checkbox is not checked then uncheck the selectAll checkbox
											$('input[type="checkbox"]').on('click', function(){
												if(!$(this).is(':checked'))
												{
													$('#selectAll').prop('checked',false);
												}
											});
										}
										else
										{
											Swal.fire("Error",result.message,result.icon);
											$('#addUsersHere').html('<span class="row alert-danger">No record found</span>');
											$('#showUserCount').html('');
										}
									},
								});
							}

							fetchCollaborationData();
							// make table searchable
							$("#searchGroup").on('keyup',function(){
								var searchFilter = $(this).val().trim();
								fetchCollaborationData(searchFilter);
							});

							$('#refreshCollaboration').on('click',function(){
								$("#searchGroup").val('');
								fetchCollaborationData();
							});

							// mapping team usrs
							$('#teamMappingForm').on('submit',function(e){
								e.preventDefault();
								var data = $( this ).serialize();
								$.ajax({
									type    : "POST",
									dataType: "json",
									data    :data,
									url     : "<?php echo base_url('Ajax/teamUserMapping');?>",
									beforeSend: function() {
										// $('.pre-loader').show();
									},
									success: function(result) 
									{
										// $('.pre-loader').hide();
										// close the model and make the input fields empty
										$('#closeAddCollaborationModel').trigger('click');
										$('#Group_Name').val('');
										$('#Group_Info').val('');
										if(result.status == 200)
										{
											Swal.fire({
												icon: 'success',
												html: result.message,
											});
											$('#teamDropdown').trigger('change');
										}
										else
										{
											Swal.fire({
												icon: 'error',
												html: result.message,
											});
										}
									},
									error: function(jqXHR, exception)
									{
										{
											// $('.pre-loader').hide();
											Swal.fire({
												icon: 'error',
												html: jqXHR.responseText,
											});
											$("#input_loader").html('');
										}
									}
								});
							});

							// get team users on chage
							$('#teamDropdown').on('change',function()
							{
								var teamUserId      = $(this).val();
								var filterValue     = $('input[name="filtertype"]:checked').val();
								var loggedInAs      = $('input[name="filtertype"]:checked').data('filtertype');
								var enterpriseId    = $('#Enterprise').val();
								var subEnterpriseId = $('#SubEnterprise').val();
								var mappedUser      = '';
								var unMappedUser    = '';

								$.ajax({
									url     :"<?php echo base_url();?>Ajax/getAllUsersWithTeamMapping",
									type    : "POST",
									dataType: 'html',
									data    : "filterValue="+filterValue+"&loggedInAs='"+loggedInAs+"'&enterpriseId='"+enterpriseId+"'&subEnterpriseId='"+subEnterpriseId+"&teamUserId="+teamUserId,
									success: function( result )
									{
										result = JSON.parse(result);
										if(result.status == 200)
										{
											// console.log(result.teamUsersData);
											var teamUsersData = result.teamUsersData;
											$(teamUsersData).each(function(i,e){
												if(result.teamUsersData[i].exist == 'checked')
												{
													mappedUser += ('<div class="custom-control custom-checkbox col-sm-12 col-md-2 col-lg-2" title="'+teamUsersData[i].User_email+'"><input type="checkbox" class="custom-control-input" checked value="'+teamUsersData[i].User_id+'" id="teamMap_'+teamUsersData[i].User_id+'" name="teamUsers[]"><label class="custom-control-label" for="teamMap_'+teamUsersData[i].User_id+'">'+teamUsersData[i].User_fname+' '+teamUsersData[i].User_lname+'</label></div>');
												}
												else
												{
													unMappedUser += ('<div class="custom-control custom-checkbox col-sm-12 col-md-2 col-lg-2" title="'+teamUsersData[i].User_email+'"><input type="checkbox" class="custom-control-input" value="'+teamUsersData[i].User_id+'" id="teamMap_'+teamUsersData[i].User_id+'" name="teamUsers[]"><label class="custom-control-label" for="teamMap_'+teamUsersData[i].User_id+'">'+teamUsersData[i].User_fname+' '+teamUsersData[i].User_lname+'</label></div>');
												}
											});
											$("#teamUsers").html(mappedUser + unMappedUser);
										}
										else
										{
											Swal.fire("Error",result.message,result.icon);
										}
									},
								});
							});

						});

function fetchCollaborationData(searchFilter)
{
	// get all the collaboration associated with the logged in user and show for table and dorpdown as well
	var entId             = $('#Enterprise').val();
	var subEntId          = $('#SubEnterprise').val();
	var addTableBodyRow   = "";
	var gameCollaboration = "<option value=''>-- Select Collaboration --</option>";
	var searchFilter      = (searchFilter)?searchFilter:'';
	// console.log(entId+' and '+ subEntId); return false;
	if(searchFilter.trim().length>0)
	{
		var data = {'searchFilter':searchFilter, 'Enterprise_ID':entId, 'SubEnterprise_ID':subEntId};
	}
	else
	{
		var data = {'Enterprise_ID':entId, 'SubEnterprise_ID':subEntId, 'fetchFor':$('input[name="filtertype"]:checked').val()};
	}
	$.ajax({
		type    : "POST",
		dataType: "json",
		data    : data,
		url     : "<?php echo base_url('Ajax/addEditDeleteFetchCollaboration/fetch');?>",
		beforeSend: function() {
			// $('.pre-loader').show();
		},
		complete: function(){
			// $('.pre-loader').hide();
			$('[data-toggle="tooltip"]').tooltip();
			editDeleteCollaboration();
		},
		success: function(result)
		{
			if(result.status == 200)
			{
				result = result.groupData;
				if(result.length>0)
				{
					j = 1;
					$.each(result, function(i, e) {
						// console.log(result[i]);
						addTableBodyRow   += "<tr><td>"+j+"</td><td>"+result[i].Group_Name+"</td><td>"+result[i].Group_Info+"</td><td><a class='editCollaboration' data-groupid="+result[i].Group_Id+" data-toggle='tooltip' title='Edit' href='javascript:void(0);' id=edit_"+result[i].Group_Id+"><i class='fa fa-pencil'></i></a> <a class='saveCollaboration' style='display:none;' data-groupid="+result[i].Group_Id+" data-toggle='tooltip' title='Save' href='javascript:void(0);' id=save_"+result[i].Group_Id+"><i class='fa fa-save'></i></a> <a class='deleteCollaboration' data-groupid="+result[i].Group_Id+" data-toggle='tooltip' title='Delete' href='javascript:void(0);' id=delete_"+result[i].Group_Id+"><i class='fa fa-trash'></i></a></td></tr>";

						gameCollaboration += "<option value='"+result[i].Group_Id+"' title='"+result[i].Group_Info+"'>"+result[i].Group_Name+"</option>";
						j++;
					});
				}
				else
				{
					addTableBodyRow   += "<tr class='alert-danger'><td colspan='4'>No data found with the searched keyword.</td></tr>";
				}

				// console.log(gameCollaboration)
				// console.log(addTableBodyRow)
				$('#gameCollaboration').html(gameCollaboration);
				$('tbody').html(addTableBodyRow);
			}
			else
			{
				Swal.fire({
					icon: 'error',
					html: result.message,
				});
			}
		},
		error: function(jqXHR, exception)
		{
			{
				// $('.pre-loader').hide();
				Swal.fire({
					icon: 'error',
					html: jqXHR.responseText,
				});
			}
		}

	});
}

function editDeleteCollaboration()
{
	var clickedEditIcon = '';
	// when user delete the group 
	$('.deleteCollaboration').each(function(){
		$(this).on('click',function(){
			var groupid = $(this).data('groupid');
			var url     = "<?php echo base_url('Ajax/addEditDeleteFetchCollaboration/delete/');?>"+groupid;
			var textMsg = "All the users/games associated with this group will also be deleted.";
			Swal.fire({
				title             : 'Are you sure?',
				html              : textMsg,
				icon              : 'question',
				showCancelButton  : true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Yes, Proceed!',
				cancelButtonText  : 'No, Cancel!',
				// footer            : ""
			}).then((result) => {
				if (result.value)
				{
					callAjax(url);
				}
			})
		});
	});
	// when user edit the group
	$('.editCollaboration').each(function(){
		$(this).on('click',function(){
			clickedEditIcon = $(this);
			var groupid     = $(this).data('groupid');
			// toggle save and edit icon/buttons
			$('.saveCollaboration').each(function(){
				$(this).hide();
			});
			$('.editCollaboration').each(function(){
				$(this).show();
			});

			$(this).hide();
			$('#save_'+groupid).show();

			// make all td's border default and not editable, first
			$('td').each(function(){
				$(this).attr("contenteditable", false).css({'border':'1px solid #dee2e6'});
			});
			// after that set border and make the td editable
			$(this).parents('tr').children('td:nth-child(2)').attr("contenteditable", true).css({'border':'2px solid #0099ff'}).focus();
			$(this).parents('tr').children('td:nth-child(3)').attr("contenteditable", true).css({'border':'2px solid #0099ff'});
		});
	});

	// when user save the changes
	$('.saveCollaboration').each(function(){
		$(this).on('click',function(){
			var groupid = $(this).data('groupid');
			var url     = "<?php echo base_url('Ajax/addEditDeleteFetchCollaboration/edit/');?>"+groupid;

			// toggle save and edit icon/buttons
			$(this).hide();
			$('#edit_'+groupid).show();

			// take value and save it via ajax
			var group_name = $(this).parents('tr').children('td:nth-child(2)').text();
			var group_info = $(this).parents('tr').children('td:nth-child(3)').text();
			// console.log(group_name+' and '+group_info);

			// make all td's border default and not editable
			$('td').each(function(){
				$(this).attr("contenteditable", false).css({'border':'1px solid #dee2e6'});
			});

			var data = {'Group_Name':group_name,'Group_Info':group_info};
			callAjax(url,data);
		});
	});

	// when user clicks outside the model, or close it, then make the editable false and set the border default
	$(document).on('click',function(e){
		if($(e.target).closest(".table").length === 0)
		{
		 // console.log('no table found');
		 $('.saveCollaboration').each(function(){
		 	$(this).hide();
		 });
		 $(clickedEditIcon).show();
		 $('td').each(function(){
		 	$(this).attr("contenteditable", false).css({'border':'1px solid #dee2e6'});
		 });
		}
	});
}

function callAjax(url,data){
	$.ajax({
		type    : "POST",
		dataType: "json",
		data    : data,
		url     : url,
		success: function(result)
		{
			fetchCollaborationData();
		},
		error: function(jqXHR, exception)
		{
			{
				// $('.pre-loader').hide();
				Swal.fire({
					icon: 'error',
					html: jqXHR.responseText,
				});
			}
		}

	});
}
</script>