<style>
	.swal-size-sm{
		width: auto;
	}
	.swal2-content
	{
		font-size: 1em;
		font-weight: bold !important;
	}
</style>
<script type="text/javascript">
	var loc_url_del = "<?php echo base_url('Users/delete/');?>";
	var func        = "<?php echo $this->uri->segment(2);?>";
</script>
<div class="main-container">
	<!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1><a href="javascript:void(0);" data-toggle="tooltip" title="Reports"><i class="fa fa-file text-blue"> 
							</i></a> Group/P2P Report</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Group/P2P Report</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
								<div class="clearfix mb-20">
									<!-- <h5 class="text-blue">Choose Filter Accordingly</h5> -->
								</div>


								<form action="" method="post" class="" id="fetchAssignedGroupsDataForm">
									<!-- add filters accordingly, as per the roles if user is superadmin-->
									<?php if($this->session->userdata('loginData')['User_Role']=='superadmin'){ ?>
										<input type="hidden" name="loggedInAs" value="superadmin">
										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="superadminUsers" name="filtertype" class="custom-control-input" checked="" value="superadminUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="superadminUsers">My Groups</label>
												</div>
											</div>

											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="enterpriseUsers">Enterprize Groups</label>
												</div>
											</div>

											<div class=" col-sm-12 col-md-3 col-lg-3 d-none">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="superadmin">
													<label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Groups</label>
												</div>
											</div>

										</div>
										<!-- end of radio, choose dropdown -->
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
											<label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
											<div class="col-sm-12 col-md-9">
												<select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise">
													<option value="">--Select Enterprize--</option>
													<?php foreach ($enterpriseData as $enterpriseDataRow) { ?>
														<option value="<?php echo $enterpriseDataRow->Enterprise_ID; ?>" date-enterprisename="<?php echo $enterpriseDataRow->Enterprise_Name;?>"><?php echo $enterpriseDataRow->Enterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<!-- for subEnterprize selection -->
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
											<label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprize</label>
											<div class="col-sm-12 col-md-9">
												<select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
													<option value="">-Select Subenterprize-</option>
												</select>
											</div>
										</div>
									<?php }	?>


									<!-- if user is Enterprize -->
									<?php if($this->session->userdata('loginData')['User_Role']==1){ ?>
										<input type="hidden" name="loggedInAs" value="enterprise">
										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" checked="" data-filtertype="enterprise">
													<label class="custom-control-label" for="enterpriseUsers">My Groups</label>
												</div>
											</div>

											<div class=" col-sm-12 col-md-3 col-lg-3 d-none">
												<div class="custom-control custom-radio mb-5">
													<input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="enterprise">
													<label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Groups</label>
												</div>
											</div>

										</div>

										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
											<label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
											<div class="col-sm-12 col-md-9">
												<select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise" required="">
													<option value="">--Select Enterprize--</option>
													<?php foreach ($enterpriseData as $enterpriseDataRow) { ?>
														<option value="<?php echo $enterpriseDataRow->Enterprise_ID; ?>" date-enterprisename="<?php echo $enterpriseDataRow->Enterprise_Name;?>" selected><?php echo $enterpriseDataRow->Enterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<!-- for subEnterprize selection -->
										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
											<label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprize</label>
											<div class="col-sm-12 col-md-9">
												<select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
													<option value="">-Select Subenterprize-</option>
													<?php foreach ($SubEnterprise as $SubEnterpriseData) { ?>
														<option value="<?php echo $SubEnterpriseData->SubEnterprise_ID; ?>" date-subEnterprisename="<?php echo $SubEnterpriseData->SubEnterprise_Name;?>"><?php echo $SubEnterpriseData->SubEnterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php }	?>


									<!-- if user is subEnterprize -->
									<?php if($this->session->userdata('loginData')['User_Role']==2){ ?>
										<input type="hidden" name="loggedInAs" value="subEnterprise">

										<div class=" col-sm-12 col-md-12 col-lg-12 row form-group d-none">
											<div class=" col-sm-12 col-md-3 col-lg-3">
												<div class="custom-control custom-radio mb-5">
													<input checked="" type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="subEnterprise">
													<label class="custom-control-label" for="subEnterpriseUsers">My Groups</label>
												</div>
											</div>
										</div>

										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
											<label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
											<div class="col-sm-12 col-md-9">
												<select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise">
													<option value="">--Select Enterprize--</option>
													<?php foreach ($enterpriseData as $enterpriseDataRow) { ?>
														<option value="<?php echo $enterpriseDataRow->Enterprise_ID; ?>" date-enterprisename="<?php echo $enterpriseDataRow->Enterprise_Name;?>" selected><?php echo $enterpriseDataRow->Enterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
											<label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select Subenterprize</label>
											<div class="col-sm-12 col-md-9">
												<select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
													<option value="">-Select Subenterprize-</option>
													<?php foreach ($SubEnterprise as $SubEnterpriseData) { ?>
														<option value="<?php echo $SubEnterpriseData->SubEnterprise_ID; ?>" date-subEnterprisename="<?php echo $SubEnterpriseData->SubEnterprise_Name;?>" selected><?php echo $SubEnterpriseData->SubEnterprise_Name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php } ?>


									<!-- after all the above filter show users here -->
									<div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="GroupDiv">
										<label for="selectGroup" class="col-sm-12 col-md-3 col-form-label">Select Group</label>
										<div class="col-sm-12 col-md-9">
											<select name="selectGroup" id="selectGroup" class="custom-select2 form-control" required="">
												<?php if(count($groupData) > 0) { ?>
													<option value="">-Select Group-</option>
													<?php foreach($groupData as $groupDataRow) { ?>
														<option value="<?php echo $groupDataRow->Group_Id; ?>" title="<?php echo $groupDataRow->Group_Info; ?>"><?php echo $groupDataRow->Group_Name; ?></option>
													<?php } } else { ?>
														<option value="">-No group created till now-</option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="gameDiv">
											<label for="selectGame" class="col-sm-12 col-md-3 col-form-label">Select Card</label>
											<div class="col-sm-12 col-md-9">
												<select name="selectGame" id="selectGame" class="custom-select2 form-control" required="">
													<option value="">--Select Card--</option>
												</select>
											</div>
										</div>

										<div class="row col-md-12 form-group" style="margin-left: 33%;">
											<button class="btn btn-primary" type="submit" id="get_reports">View Report</button>
											&nbsp;
											<a href="<?php echo base_url();?>" class="btn btn-outline-danger">Cancel</a>
										</div>
									</form>
								</div>
								<!-- end of adding users -->
							</div>

						<!-- show group,users,game data for the selected collaboration -->
						<div class="col-md-12 col-sm-12">
							<div class="pd-20 bg-white border-radius-4 box-shadow mb-30 row">
								<!-- show pie/donut chart here -->
								<div class="col-md-4" id="resultGroupName">
									<!-- show the data here received from ajax -->
								</div>
								<div class="col-md-4" id="resultGroupInfo">
									<!-- show the data here received from ajax -->
								</div>
								<div class="col-md-4" id="resultGameName">
									<!-- show the data here received from ajax -->
								</div>
							</div>
							<div class="row">
								<!-- put pie chart here -->
								<div class="col-md-4" id="showPieChartHere">
									<canvas id="pieChart" width="400" height="400"></canvas>
								</div>
								<!-- put donut chart here -->
								<div class="col-md-4 d-none">
									<canvas id="donutChart" width="400" height="400"></canvas>
								</div>
							</div>
							<!-- show data table here -->
						</div>
						<!-- end of group,users,game data for the selected collaboration -->

						<script>
							$(document).ready(function()
							{
								// show all Group by default and then show Groups as per the filter
								var allGroupOption = "<option value=''>-Select Group-</option>";
								<?php foreach ($groupData as $Groups) { ?>
									allGroupOption += '<option value="<?php echo $Groups->Group_Id; ?>" title="<?php echo $Groups->Group_Info; ?>"><?php echo $Groups->Group_Name; ?></option>';
								<?php } ?>
								$('#selectGroup').html(allGroupOption);
								$('input[name="filtertype"]').on('change',function()
								{
									var filterValue = $(this).val();
									var loggedInAs  = $(this).data('filtertype');
									$('#addUsersHere').html('');
									$('#selectGroup').html("<option value=''>-Select Group-</option>");
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
										fetchAssignedGroups('superadminUsers',null,null);

										<?php if($this->session->userdata('loginData')['User_Role']=='superadmin') { ?>
											var entOption = '<option value="">--Select Enterprize--</option>';
											<?php foreach ($enterpriseData as $enterpriseDataRow) { ?>
												entOption += '<option value="<?php echo $enterpriseDataRow->Enterprise_ID; ?>"><?php echo $enterpriseDataRow->Enterprise_Name; ?></option>';
											<?php } ?>
											$('#Enterprise').html(entOption);
										<?php } ?>
										$('#SubEnterprise').html('<option value="">--Select Subenterprize--</option>');

									}

									else if(filterValue == 'enterpriseUsers')
									{
										$('#Enterprise').attr('required',true);
										$('#SubEnterprise').attr('required',false);
										$('#enterpriseDiv').removeClass('d-none');
										$('#subEnterpriseDiv').addClass('d-none');
										if($('#Enterprise').val())
										{
											$('#Enterprise').trigger('change');
										}
										// $('#selectGroup').html('<option value="">--Select Group--</option>');
									}
									else if(filterValue == 'subEnterpriseUsers')
									{
										$('#Enterprise').attr('required',true);
										$('#SubEnterprise').attr('required',true);
										$('#enterpriseDiv').removeClass('d-none');
										$('#subEnterpriseDiv').removeClass('d-none');
										// $('#Enterprise').trigger('change');
										$('#selectGroup').html('<option value="">--Select Group--</option>');
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
										<?php if(count($groupData) > 0) { ?>
											var selGroup = '<option value="">-Select Group-</option>';
											<?php foreach($groupData as $groupDataRow) { ?>
												selGroup += '<option value="<?php echo $groupDataRow->Group_Id; ?>" title="<?php echo $groupDataRow->Group_Info; ?>"><?php echo $groupDataRow->Group_Name; ?></option>';
											<?php } ?>
											$('#selectGroup').html(selGroup);
										<?php } ?>
									}
									else if(filterValue == 'subEnterpriseUsers')
									{
										$('#Enterprise').attr('required',false);
										$('#SubEnterprise').attr('required',true);
										$('#enterpriseDiv').addClass('d-none');
										$('#subEnterpriseDiv').removeClass('d-none');

										<?php if($this->session->userdata('loginData')['User_Role']==1) { ?>
											var subEntOption = '<option value="">--Select Enterprize--</option>';
											<?php foreach ($subEnterpriseData as $subEnterpriseDataRow) { ?>
												subEntOption += '<option value="<?php echo $subEnterpriseDataRow->SubEnterprise_ID; ?>"><?php echo $subEnterpriseDataRow->SubEnterprise_Name; ?></option>';
											<?php } ?>
											$('#SubEnterprise').html(subEntOption);
										<?php } ?>
										$('#selectGroup').html('<option value="">--Select Group--</option>');
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
							});

$('#Enterprise').on('change',function(){
	$this             = $(this);
	var option        = '<option value="">--Select Subenterprize--</option>';
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
					$.each(result, function(i,e)
					{
						option += ("<option value='"+result[i].SubEnterprise_ID+"'>"+result[i].SubEnterprise_Name+"</option>");
					});
					$this.parents('form').find('select.subenterprise').html(option);
					option = '<option value="">--Select Subenterprize--</option>';
					// $('.SubEnterprise').html(option);
				}
				else
				{
					$this.parents('form').find('select.subenterprise').html(option);
					// alert('No SubEnterprise Associated With The Selected Enterprise');
				}
			},
		});

		fetchAssignedGroups('enterpriseUsers',Enterprise_ID,null);
	}
	else
	{
		$this.parents('form').find('select.subenterprise').html(option);
		// alert('Please Select Enterprise...');
		return false;
	}
});

$('#SubEnterprise').on('change',function(){
	if($(this).val())
	{
		<?php if($this->session->userdata('loginData')['User_Role']=='superadmin') { ?>
			var ent_id = $('#Enterprise').val();
		<?php } elseif($this->session->userdata('loginData')['User_Role']==1) { ?>
			var ent_id = <?php echo $this->session->userdata('loginData')['User_ParentId']; ?>;
		<?php } ?>
		fetchAssignedGroups('subEnterpriseUsers', ent_id, $(this).val());
	}
	else
	{
		Swal.fire('Please select SubEnterprise');
	}
});


// writing functions below

function fetchAssignedGroups(userType,entId,subEntId)
{
	// show only assigned Groups only
	if(userType=='superadminUsers')
	{
		$('#selectGroup').html(allGroupOption);	
	}
	else
	{
		$.ajax({
			url :"<?php echo base_url();?>Ajax/fetchAssignedGroups/"+userType+"/"+entId+"/"+subEntId,
			type: "POST",
			success: function( result )
			{
				if(result == 'No Group found')
				{
					Swal.fire('No Group Found to selected '+userType);
					$('#selectGroup').html('<option value="">--Select Group--</option>');
				}
				else
				{
					result = JSON.parse(result);
					var entGroupOption = '<option value="">--Select Group--</option>';
					$.each(result, function(i,e)
					{
						entGroupOption += ("<option value='"+result[i].Group_Id+"'>"+result[i].Group_Name+"</option>");
					});
					$('#selectGroup').html(entGroupOption);
				}
			},
		});
	}
}
submitFormGetData();

// when group is changed then find all the games associated with this, if not then show alert
$('#selectGroup').on('change',function(){
	var Map_GroupId        = $(this).val();
	var collaborationGames = '<option value="">--select Card--</option>';

	if(!Map_GroupId)
	{
		console.log('Pleae select group');
		return false;
	}

	$.ajax({
		type    : "POST",
		dataType: "json",
		// data    :data,
		url     : "<?php echo base_url('Ajax/getCollaborationGames/');?>"+Map_GroupId,
		beforeSend: function() {
		},
		success: function(result) 
		{
			if(result.status == 200)
			{
				// console.log(result.gameData);
				var gameData = result.gameData;
				$(gameData).each(function(i,e){
					collaborationGames += "<option value='"+gameData[i].Game_ID+"'>"+gameData[i].Game_Name+"</option>";
				});
				$("#selectGame").html(collaborationGames);
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
				Swal.fire({
					icon: 'error',
					html: jqXHR.responseText,
				});
				$("#input_loader").html('');
			}
		}
	});
});
});

function submitFormGetData()
{
	$('#fetchAssignedGroupsDataForm').on('submit',function(e){
		e.preventDefault();
		var formData = $('#fetchAssignedGroupsDataForm').serialize();
		$.ajax({
			url :"<?php echo base_url();?>Ajax/getGroupData/",
			type: "POST",
			data: formData,
			success: function( result )
			{
				// console.log(result); console.log(JSON.parse(result));
				result = JSON.parse(result);
				if(result.status == 200)
				{
					let timerInterval
					Swal.fire({
						icon            : result.icon,
						title           : result.title,
						html            : result.message,
						timer           : 1000,
						timerProgressBar: true,
						onBeforeOpen: () => {
							Swal.showLoading()
							timerInterval = setInterval(() => {
								const content = Swal.getContent()
								if (content) {
									const b = content.querySelector('b')
									if (b) {
										b.textContent = Swal.getTimerLeft()
									}
								}
							}, 100)
						},
						onClose: () => {
							clearInterval(timerInterval)
							$('#resultGroupName').html('<b>Group Name: </b>'+result.data.Group_Name);
							$('#resultGroupInfo').html('<b>Group Info: </b>'+result.data.Group_Info);
							$('#resultGameName').html('<b>Card Name: </b>'+result.data.Game_Name);
							// console.log(result.data.userData);
							// var donutChart = $('#donutChart');
							var chart_labels          = [];
							var chart_backgroundColor = [];
							var chart_data            = [];
							var user_team_id          = [];
							$.each(result.data.userData, function(i,e) {
								chart_labels.push(result.data.userData[i].fullName);
								chart_backgroundColor.push(result.data.userData[i].chartColor);
								chart_data.push(Number(result.data.userData[i].input_current));
								user_team_id.push(Number(result.data.userData[i].User_id));
							});

							$('#showPieChartHere').html('');
							$('#showPieChartHere').html('<canvas id="pieChart" width="400" height="400"></canvas>');
							// adding and removing above 2 lines of code to reload chart js data graph
							var pieCtx     = $('#pieChart');
							var myPieChart = new Chart(pieCtx, {
								type: 'pie',
								data: {
									labels: chart_labels,
									datasets: [{
										backgroundColor: chart_backgroundColor,
										data: chart_data
									}],
									Function_Id: user_team_id
								},
								// options: {
								// 	scales: {
								// 		yAxes: [{
								// 			ticks: {
								// 				beginAtZero: true
								// 			}
								// 		}]
								// 	}
								// }
							});

							// add click handlere to show team data for that team
							pieCtx.on('click',function(e){
								var activePoints = myPieChart.getElementsAtEvent(e);
								if(activePoints[0])
								{
									// console.log(activePoints[0]);
									var chartData = activePoints[0]['_chart'].config.data;
									var idx       = activePoints[0]['_index'];
									var label     = chartData.labels[idx];
									var team_id   = chartData.Function_Id[idx];
									var value     = chartData.datasets[0].data[idx];
									// console.log(idx+' /n '+label+' /n '+value+' /n '+team_id);
									// trigger ajax and get the team users , pass game id and get data accordingly in future if team is for particular game
									getTeamData(team_id);
								}
							});
							// end of click handler for pie chart to show team data

							var donutCtx        = $('#donutChart');
							var myDoughnutChart = new Chart(donutCtx, {
								type: 'doughnut',
								data: {
									labels: chart_labels,
									datasets: [{
										backgroundColor: chart_backgroundColor,
										data: chart_data
									}]
								},
								// options: {
								// 	scales: {
								// 		yAxes: [{
								// 			ticks: {
								// 				beginAtZero: true
								// 			}
								// 		}]
								// 	}
								// }
							});
						}
					}).then((resultSwal) => {
						/* Read more about handling dismissals below */
						if (resultSwal.dismiss === Swal.DismissReason.timer) {
							console.log(result.data);
						}
					})
				}
				else
				{
					Swal.fire({
						icon : result.icon,
						title: result.title,
						html : result.message,
					});
					console.log(result);
				}
			},
		});
	});
}

function getTeamData(teamId)
{
	var teamData = '<table class="table-striped table table-bordered table-hover table-sm"><thead class="thead-dark"><tr><th>ID</th><th>Name</th><th>Email</th><th>User Name</th><th>Mobile</th></tr></thead><tbody>';
	$.ajax({
		type    : "POST",
		dataType: "json",
		// data    :data,
		url     : "<?php echo base_url('Ajax/getTeamMembers/');?>"+teamId,
		beforeSend: function() {
		},
		success: function(result) 
		{
			if(result.status == 200)
			{
				// console.log(result.teamUsersData);
				var teamUsersData = result.teamUsersData;
				$(teamUsersData).each(function(i,e){
					teamData += "<tr><td>"+eval(i+1)+"</td><td>"+teamUsersData[i].fullName+"</td><td>"+teamUsersData[i].User_email+"</td><td>"+teamUsersData[i].User_username+"</td><td>"+teamUsersData[i].User_mobile+"</td></tr>";
				});
				teamData += '</tbody></table>';
				Swal.fire({
					// icon       : result.icon,
					title      : result.title,
					html       : teamData,
					customClass: 'swal-size-sm',
					showClass  : {
						popup: 'animated fadeInDown faster'
					},
					hideClass: {
						popup: 'animated fadeOutUp faster'
					}
				});
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
				Swal.fire({
					icon: 'error',
					html: jqXHR.responseText,
				});
				$("#input_loader").html('');
			}
		}
	});
}
</script>						