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
							<h1><a href="javascript:void(0);" data-toggle="tooltip" title="Reports"><i class="fa fa-file text-blue"> 
							</i></a> Reports</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Simulation Reports</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
								<div class="clearfix mb-20">
									<h5 class="text-blue">Choose To Download</h5>
								</div>

								<form action="" method="post" class="" id="">
									<!-- add filters accordingly, as per the roles if user is superadmin-->
									<?php if($this->session->userdata('loginData')['User_Role']=='superadmin'){ ?>
										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="superadminUsers" name="filtertype" class="custom-control-input" checked="" value="superadminUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="superadminUsers">My Users</label>
												</div>
											</div>

											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="enterpriseUsers">Enterprize Users</label>
												</div>
											</div>

											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Users</label>
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
													<label class="custom-control-label" for="enterpriseUsers">My Users</label>
												</div>
											</div>

											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="enterprise">
													<label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Users</label>
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
													<label class="custom-control-label" for="subEnterpriseUsers">My Users</label>
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
									<div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="gameDiv">
										<label for="selectGame" class="col-sm-12 col-md-3 col-form-label">Select Game</label>
										<div class="col-sm-12 col-md-9">
											<select name="selectGame" id="selectGame" class="custom-select2 form-control" required="">
												<option value="">-Select Game-</option>
											</select>
										</div>
									</div>

									<div class="row col-md-12 col-lg-12 col-sm-12 form-group">
										<label for="searchUser" class="col-sm-12 col-md-3 col-form-label">Search</label>
										<div class="col-sm-12 col-md-6">
											<input type="search" name="searchUser" id="searchUser" class="form-control" placeholder="Search by Email/UserName">
											<span id="showUserCount"></span>
										</div>
									</div>

									<!-- add users details here -->
									<div class="row col-md-12 col-lg-12 col-sm-12 form-group mb-20" id="addUsersHere">
									</div>
									<!-- end of adding users -->

									<div id="assignDate" class="row col-md-12 col-lg-12 col-sm-12 row form-group">
										<label for="date" class="col-sm-12 col-md-3 col-form-label">Select Date</label>
										<div class="col-sm-12 col-md-9">
											<div class="input-group" name="gamedate" id="datepicker">
												<input type="text" class="form-control datepicker-here" id="report_startDate" name="gamestartdate" value="" data-value="<?php echo time();?>" placeholder="Select Start Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">

												&nbsp; <span class="input-group-addon">To</span> &nbsp;

												<input type="text" class="form-control datepicker-here" id="report_endDate" name="gameenddate" value="" data-value="<?php echo time();?>" placeholder="Select End Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">
											</div>
										</div>
									</div>

									<div class="row col-md-12 form-group" style="margin-left: 33%;">
										<button class="btn btn-primary">Download</button>
										&nbsp;
										<a href="<?php echo base_url();?>" class="btn btn-outline-danger">Cancel</a>
									</div>
								</form>
							</div>
						</div>
						<br>
						<br>
						<br>

						<script>
							$(document).ready(function(){
								// show all game by default and then show games as per the filter
								var allGameOption = "<option value=''>-Select Game-</option>";
								<?php foreach ($gameData as $games) { ?>
									allGameOption += "<option value=<?php echo $games->Game_ID; ?>><?php echo $games->Game_Name; ?></option>";
								<?php } ?>
									// console.log(allGameOption);
									$('#selectGame').html(allGameOption);

									$('input[name="filtertype"]').on('change',function(){
										var filterValue = $(this).val();
										var loggedInAs  = $(this).data('filtertype');
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

										fetchAssignedGames('enterpriseUsers',Enterprise_ID);
									}
									else
									{
										$this.parents('form').find('select.subenterprise').html(option);
										alert('Please Select Enterprise...');
										return false;
									}
									// getAgents();
								});

									$('#SubEnterprise').on('change',function(){
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
													alert('No game allocated to selected '+ent_SubEnt);
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
									var gameId          = $('#selectGame').val();
									var filterValue     = $('input[name="filtertype"]:checked').val();
									var loggedInAs      = $('input[name="filtertype"]:checked').data('filtertype');
									var enterpriseId    = $('#Enterprise').val();
									var subEnterpriseId = $('#SubEnterprise').val();
									var searchFilter    = $('#searchUser').val();
									var siteUsers       = '';
									// $('#addUsersHere').html('<h3>Add users checkbox here by fetching from ajax for Game_ID:-'+gameId+'</h3>');
									if(gameId.length<1)
									{
										console.log('Please select game');
										$('#addUsersHere').html('<span class="row alert-danger">No record found</span>');
										$('#showUserCount').html('');
										return false;
									}
									$.ajax({
										url     :"<?php echo base_url();?>Ajax/getAgents",
										type    : "POST",
										dataType: 'html',
										data    : "gameId='"+gameId+"'&filterValue="+filterValue+"&loggedInAs='"+loggedInAs+"'&enterpriseId='"+enterpriseId+"'&subEnterpriseId='"+subEnterpriseId+"'&searchFilter="+searchFilter,
										success: function( result )
										{
											result = JSON.parse(result);
											if(result.length > 0)
											{
												var userCount         = 0;
												var notSbumittedCount = 0;
												var makeUsersRed      = '';
												$(result).each(function(i,e)
												{
													if(result[i].US_LinkID < 1)
													{
														notSbumittedCount++;
														makeUsersRed = "style='color:#ff0000;'";
													}
													else
													{
														makeUsersRed = '';
													}
													siteUsers += ('<div class="custom-control custom-checkbox col-sm-12 col-md-2 col-lg-2" title="'+result[i].User_email+'"><input type="checkbox" class="custom-control-input" value="'+result[i].User_id+'" id="'+result[i].User_id+'_user" name="siteUsers[]"><label class="custom-control-label" for="'+result[i].User_id+'_user" '+makeUsersRed+'>'+result[i].User_fname+" "+result[i].User_lname+'</label></div>');
													userCount++;
												});
												console.log(userCount);
												$('#addUsersHere').html(siteUsers);
												$('#showUserCount').html('<span class="alert-success">Total Users Played: <b>'+userCount+'</b>, Completed: <b>'+parseInt(userCount-notSbumittedCount)+'</b>, Incompleted(in red): <b>'+notSbumittedCount+'</b></span>');
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
												$('#addUsersHere').html('<span class="row alert-danger">No record found</span>');
												$('#showUserCount').html('');
											}
										},
									});
								}
							});
						</script>