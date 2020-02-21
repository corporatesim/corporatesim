<!-- <?php 
// echo $type."<pre>";print_r($enterpriseDropdown); exit(); 
?>   -->
<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<h3>Select <?php echo $select;?> To Allocate/De-Allocate Game: <strong>
								<a href="<?php echo $gameUrl;?>" target="_blank" data-toggle="tooltip" title="Click to see the URL to play">
									<?php echo $gamedata[1]; ?>
								</a>
							</strong>
						</h3>
					</div>
				</div>	
			</div>
			<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
				<div class="clearfix">
					<?php $this->load->view('components/trErMsg');?>
					<div class="custom-control custom-checkbox pull-right">
						<input type="checkbox" class="custom-control-input" id="select_all">
						<label class="custom-control-label" for="select_all">Select All</label>
					</div>
				</div>
				<br>
				<div class="row" id="labelNames">
					<div class="col-md-4">
						<label for="name"><span class="alert-danger">*</span>Select <?php echo $select;?></label>
					</div>
					<div class="col-md-3">
						<label for="name"><span class="alert-danger">*</span>Start Date</label>
					</div>
					<div class="col-md-3">
						<label for="name"><span class="alert-danger">*</span>End Date</label>
					</div>
					<div class="col-md-2">
						<label for="name">Replay Count (Unlimited -1)</label>
					</div>
				</div>
				<form action="" method="post" id="gameDataForm">
					<!-- check that to whom game need to be allocated or de-allocated -->
					<input type="hidden"name="gameID" value="<?php echo $gamedata[0]; ?>">
					<input type="hidden"name="allocateTo" value="<?php echo $allocateTo; ?>">
					<?php if($allocateTo=='enterprise'){ ?>
						<!-- <div class="row" id="to_enterprise"> -->
							<!-- show enterprise checkboxes only --><!-- <?php // echo $enterpriseRow->Enterprise_ID;?> -->
							<?php foreach($enterpriseCheckbox as $enterpriseRow){ 
									// print_r($enterpriseRow);
									// check for default checked and start and end date
								$startDate = strtotime($enterpriseRow->Enterprise_StartDate);
								$endDate   = strtotime($enterpriseRow->Enterprise_EndDate);

								if($enterpriseRow->EG_GameID==$gamedata[0])
								{
									$valueStartDate = strtotime($enterpriseRow->EG_Game_Start_Date);
									$valueEndDate   = strtotime($enterpriseRow->EG_Game_End_Date);
									$checked        = 'checked';
										// echo "$startDate, $endDate, $valueStartDate, $valueEndDate, $checked";
								}
								else
								{
									$valueStartDate = strtotime($enterpriseRow->Enterprise_StartDate);
									$valueEndDate   = strtotime($enterpriseRow->Enterprise_EndDate);
									$checked        = '';
								}
								?>

								<div class="row">
									<div class="col-md-4">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="enterprise[]" id="<?php echo $enterpriseRow->Enterprise_ID;?>" <?php echo $checked;?> value="<?php echo $enterpriseRow->Enterprise_ID;?>">
											<label class="custom-control-label" for="<?php echo $enterpriseRow->Enterprise_ID;?>"><?php echo $enterpriseRow->Enterprise_Name;?></label>
										</div>
									</div>
									<div id="assignDate"class="col-md-6">
										<div class="input-group" name="gamedate" id="datepicker">
											<input type="text" class="form-control datepicker-here" id="" name="<?php echo $enterpriseRow->Enterprise_ID;?>_gamestartdate" value="<?php echo date('Y-m-d', $valueStartDate);?>" data-value="<?php echo $valueStartDate;?>" placeholder="Select Start Date" required="" readonly="" data-startdate="<?php echo $startDate; ?>" data-enddate="<?php echo $endDate; ?>" data-language='en' data-date-format="dd-mm-yyyy">

											<span class="input-group-addon" >To</span>

											<input type ="text" class="form-control datepicker-here" id="" name="<?php echo $enterpriseRow->Enterprise_ID;?>_gameenddate" value="<?php echo date('Y-m-d', $valueEndDate);?>" data-value="<?php echo $valueEndDate;?>" placeholder="Select End Date" required="" readonly="" data-startdate="<?php echo $startDate; ?>" data-enddate="<?php echo $endDate; ?>" data-language='en' data-date-format="dd-mm-yyyy">
										</div>
									</div>
								</div>

							<?php } ?>
							<!-- </div> -->
						<?php } ?>

						<?php if($allocateTo=='subEnterprise'){ ?>
							<!-- if superadmin is logged in -->
							<?php if($loggedInAs == 'superadmin'){ ?>
								<div class="row col-md-12" id="to_subEnterprise">
									<!-- show Ent DropDown and subEnt checkboxes -->

									<div class="form-group row col-sm-12 col-md-6" id="Enterprise_Section">
										<select name="Enterprise" id="Enterprise" class="custom-select2 form-control" required="">
											<option value="">--Select Enterprise--</option>
											<?php foreach ($enterpriseDropdown as $EnterpriseData) { ?>
												<option value="<?php echo $EnterpriseData->Enterprise_ID.'_'.strtotime($EnterpriseData->EG_Game_Start_Date).'_'.strtotime($EnterpriseData->EG_Game_End_Date); ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
											<?php } ?>
										</select>
									</div>
									<!-- search here -->
									<div class="form-group row col-sm-12 col-md-6">
										<input type="search" class="form-control" placeholder="search" name="searchData" disabled="">
									</div>

									<!-- show subEnterprise checkbox here -->
									<div class="form-group row col-sm-12" id="subEnterpriseCheckbox">
									</div>

								</div>
							<?php } ?>
							<!-- if entperise is logged in -->
							<?php if($loggedInAs == '1'){ ?>
								<div class="" id="to_subEnterprise">
									<!-- show SubEnt checkboxes -->
									<?php if(count($subEnterpriseCheckbox) > 0)
									{
										foreach($subEnterpriseCheckbox as $subEnterpriseRow)
										{ 
												// check for default checked and start and end date
												// setting start date
											if($subEnterpriseRow->SubEnterprise_StartDate > $subEnterpriseRow->EG_Game_Start_Date)
											{
												$startDate      = $subEnterpriseRow->SubEnterprise_StartDate;
												$valueStartDate = $subEnterpriseRow->SubEnterprise_StartDate;
											}
											else
											{
												$startDate      = $subEnterpriseRow->EG_Game_Start_Date;
												$valueStartDate = $subEnterpriseRow->EG_Game_Start_Date;
											}
												// setting end date
											if($subEnterpriseRow->SubEnterprise_EndDate < $subEnterpriseRow->EG_Game_End_Date)
											{
												$endDate      = $subEnterpriseRow->SubEnterprise_EndDate;
												$valueEndDate = $subEnterpriseRow->SubEnterprise_EndDate;
											}
											else
											{
												$endDate      = $subEnterpriseRow->EG_Game_End_Date;
												$valueEndDate = $subEnterpriseRow->EG_Game_End_Date;
											}
											if($subEnterpriseRow->SG_GameID==$gamedata[0])
											{
												$valueStartDate = $subEnterpriseRow->SG_Game_Start_Date;
												$valueEndDate   = $subEnterpriseRow->SG_Game_End_Date;
												$checked        = 'checked';
													// echo "$startDate, $endDate, $valueStartDate, $valueEndDate, $checked";
											}
											else
											{
												$checked = '';
											}
											?>

											<div class="row">
												<div class="col-md-4">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="enterprise[]" id="<?php echo $subEnterpriseRow->SubEnterprise_ID;?>" <?php echo $checked;?> value="<?php echo $subEnterpriseRow->SubEnterprise_ID;?>">
														<label class="custom-control-label" for="<?php echo $subEnterpriseRow->SubEnterprise_ID;?>"><?php echo $subEnterpriseRow->SubEnterprise_Name;?></label>
													</div>
												</div>
												<div id="assignDate"class="col-md-6">
													<div class="input-group" name="gamedate" id="datepicker">
														<input type="text" class="form-control datepicker-here" id="" name="<?php echo $subEnterpriseRow->SubEnterprise_ID;?>_gamestartdate" value="<?php echo date('Y-m-d', $valueStartDate);?>" data-value="<?php echo $valueStartDate;?>" placeholder="Select Start Date" required="" readonly="" data-startdate="<?php echo $startDate; ?>" data-enddate="<?php echo $endDate; ?>" data-language='en' data-date-format="dd-mm-yyyy">

														<span class="input-group-addon" >To</span>

														<input type ="text" class="form-control datepicker-here" id="" name="<?php echo $subEnterpriseRow->SubEnterprise_ID;?>_gameenddate" value="<?php echo date('Y-m-d', $valueEndDate);?>" data-value="<?php echo $valueEndDate;?>" placeholder="Select End Date" required="" readonly="" data-startdate="<?php echo $startDate; ?>" data-enddate="<?php echo $endDate; ?>" data-language='en' data-date-format="dd-mm-yyyy">
													</div>
												</div>
											</div>

										<?php } ?>
									<?php } else{ ?>
										<marquee class="alert-danger">No SubEnterprises</marquee>
									<?php } ?>
								</div>
							<?php } ?>
						<?php } ?>

						<?php if($allocateTo=='entErpriseUsers'){ ?>
							<!-- if superadmin is logged in -->
							<?php if($loggedInAs == 'superadmin'){ ?>
								<div class="row" id="to_entErpriseUsers">
									<!-- show Ent DropDown and then show users checkboxes -->

									<div class="form-group row col-sm-12 col-md-6" id="Enterprise_Section">
										<select name="Enterprise" id="Enterprise" class="custom-select2 form-control" required="">
											<option value="">--Select Enterprise--</option>
											<?php foreach ($enterpriseDropdown as $EnterpriseData) { ?>
												<option value="<?php echo $EnterpriseData->Enterprise_ID.'_'.strtotime($EnterpriseData->EG_Game_Start_Date).'_'.strtotime($EnterpriseData->EG_Game_End_Date); ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
											<?php } ?>
										</select>
									</div>
									<!-- search here -->
									<div class="form-group row col-sm-12 col-md-6">
										<input type="search" class="form-control" placeholder="search" name="searchData" disabled="">
									</div>

									<!-- show entErpriseUsers checkbox here -->
									<div class="form-group row col-sm-12" id="entErpriseUsersCheckbox">
									</div>

								</div>
							<?php } ?>
							<!-- if entperise is logged in -->
							<?php if($loggedInAs == '1'){ ?>
								<div class="row" id="to_entErpriseUsers">
									<input type="hidden" id="Enterprise" name="Enterprise" value="<?php echo $enterpriseData->Enterprise_ID.'_'.strtotime($enterpriseData->EG_Start_Date_Game).'_'.strtotime($enterpriseData->EG_End_Date_Game); ?>">
									<!-- put search box here to search -->
									<div class="col-md-6"></div>
									<div class="form-group row col-sm-12 col-md-6">
										<input type="search" class="form-control" placeholder="search" name="searchData" disabled="">
									</div>

									<div class="form-group row col-sm-12" id="entErpriseUsersCheckbox">
										<!-- making enterprise checkboxes here by calling the js function-->
										<!-- end of making enterprise users checkboxes here -->
									</div>
								</div>
							<?php } ?>
						<?php } ?>

						<?php if($allocateTo=='subEnterpriseUsers'){ ?>
							<!-- if superadmin is logged in -->
							<?php if($loggedInAs == 'superadmin'){ ?>
								<div class="row" id="to_subEnterpriseUsers">
									<!-- show Ent and SubEnt DropDown then users checkboxes -->

									<div class="form-group row col-sm-12 col-md-6" id="Enterprise_Section">
										<select name="Enterprise" id="Enterprise" class="custom-select2 form-control" required="">
											<option value="">--Select Enterprise--</option>
											<?php foreach ($enterpriseDropdown as $EnterpriseData) { ?>
												<option value="<?php echo $EnterpriseData->Enterprise_ID.'_'.strtotime($EnterpriseData->EG_Game_Start_Date).'_'.strtotime($EnterpriseData->EG_Game_End_Date); ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="form-group row col-sm-12 col-md-6 d-none" id="subEnterpriseUsers_Section">
										<select name="SubEnterpriseDropdown" id="SubEnterpriseDropdown" class="custom-select2 form-control" required="">
											<option value="">--Select SubEnterprise--</option>
										</select>
									</div>

									<!-- search here -->
									<div class="form-group row col-sm-12 col-md-6 d-none">
										<input type="search" class="form-control" placeholder="search" name="searchData" disabled="">
									</div>

									<!-- show subErpriseUsers checkbox here -->
									<div class="form-group row col-sm-12" id="subEntErpriseUsersCheckbox">
									</div>

								</div>
							<?php } ?>
							<!-- if entperise is logged in -->
							<?php if($loggedInAs == '1'){ ?>
								<div class="row" id="to_subEnterpriseUsers">
									<div class="form-group row col-sm-12 col-md-6 " id="subEnterpriseUsers_Section">
										<?php if(isset($entData)) { ?>
											<input type="hidden" name="Enterprise" value="<?php echo $entData['User_Id'].'_'.time().'_'.time();?>">
										<?php } ?>
										<!-- show SubEnt DropDown and then users checkboxes -->
										<select name="SubEnterpriseDropdown" id="SubEnterpriseDropdown" class="custom-select2 form-control" required="">
											<option value="">--Select SubEnterprise--</option>
											<?php if(count($subEnterpriseDropdown) > 0){ 
												foreach ($subEnterpriseDropdown as $subEnterpriseDropdownRow) { ?>
													<option value="<?php echo $subEnterpriseDropdownRow->SubEnterprise_ID.'_'.$subEnterpriseDropdownRow->startDate.'_'.$subEnterpriseDropdownRow->endDate;?>"><?php echo $subEnterpriseDropdownRow->SubEnterprise_Name;?></option>
												<?php } } ?>
											</select>
										</div>

										<!-- search here -->
										<div class="form-group row col-sm-12 col-md-6 ">
											<input type="search" class="form-control" placeholder="search" name="searchData" disabled="">
										</div>

										<!-- show subErpriseUsers checkbox here -->
										<div class="form-group row col-sm-12" id="subEntErpriseUsersCheckbox">
										</div>
									</div>
								<?php } ?>
								<!-- if subEntperise is logged in -->
								<?php if($loggedInAs == '2'){ ?>
									<div class="col-md-12" id="to_subEnterpriseUsers">
										<!-- show users checkboxes only -->
										<input type="hidden" name="Enterprise" value="<?php echo $ent_subEnt_Data->Enterprise_ID?>">
										<input type="hidden" name="SubEnterpriseDropdown" value="<?php echo $ent_subEnt_Data->SubEnterprise_ID.'_'.$ent_subEnt_Data->SG_Game_Start_Date.'_'.$ent_subEnt_Data->SG_Game_End_Date?>">
										<!-- $ent_subEnt_Data->SG_Game_Start_Date and $ent_subEnt_Data->SG_Game_End_Date -->
										<?php if(isset($subEntErpriseUsersCheckbox) && count($subEntErpriseUsersCheckbox) > 0)
										{
											foreach($subEntErpriseUsersCheckbox as $subEntErpriseUsersRow)
											{ 
													// check for default checked and start and end date
													// setting start date
												if($subEntErpriseUsersRow->UserStartDate > $ent_subEnt_Data->SG_Game_Start_Date)
												{
													$startDate      = $subEntErpriseUsersRow->UserStartDate;
													$valueStartDate = $subEntErpriseUsersRow->UserStartDate;
												}
												else
												{
													$startDate      = $ent_subEnt_Data->SG_Game_Start_Date;
													$valueStartDate = $ent_subEnt_Data->SG_Game_Start_Date;
												}
													// setting end date
												if($subEntErpriseUsersRow->UserEndDate < $ent_subEnt_Data->SG_Game_End_Date)
												{
													$endDate      = $subEntErpriseUsersRow->UserEndDate;
													$valueEndDate = $subEntErpriseUsersRow->UserEndDate;
												}
												else
												{
													$endDate      = $ent_subEnt_Data->SG_Game_End_Date;
													$valueEndDate = $ent_subEnt_Data->SG_Game_End_Date;
												}
													// if user already has the game 
												if($subEntErpriseUsersRow->UG_GameID==$gamedata[0])
												{
													$valueStartDate = $subEntErpriseUsersRow->UG_GameStartDate;
													$valueEndDate   = $subEntErpriseUsersRow->UG_GameEndDate;
													$checked        = 'checked';
														// echo "$startDate, $endDate, $valueStartDate, $valueEndDate, $checked";
												}
												else
												{
													$checked = '';
												}
												?>
												<div class="row">
													<div class="col-md-4" data-toggle="tooltip" title="<?php echo $subEntErpriseUsersRow->User_email;?>">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" name="subEnterpriseUser[]" id="<?php echo $subEntErpriseUsersRow->User_id;?>" <?php echo $checked;?> value="<?php echo $subEntErpriseUsersRow->User_id;?>">
															<label class="custom-control-label" for="<?php echo $subEntErpriseUsersRow->User_id;?>"><?php echo $subEntErpriseUsersRow->userName;?></label>
														</div>
													</div>
													<div id="assignDate" class="col-md-6">
														<div class="input-group" name="gamedate" id="datepicker">
															<input type="text" class="form-control datepicker-here" id="" name="<?php echo $subEntErpriseUsersRow->User_id;?>_gamestartdate" value="<?php echo date('Y-m-d', $valueStartDate);?>" data-value="<?php echo $valueStartDate;?>" placeholder="Select Start Date" required="" readonly="" data-startdate="<?php echo $startDate; ?>" data-enddate="<?php echo $endDate; ?>" data-language='en' data-date-format="dd-mm-yyyy">

															<span class="input-group-addon" >To</span>

															<input type ="text" class="form-control datepicker-here" id="" name="<?php echo $subEntErpriseUsersRow->User_id;?>_gameenddate" value="<?php echo date('Y-m-d', $valueEndDate);?>" data-value="<?php echo $valueEndDate;?>" placeholder="Select End Date" required="" readonly="" data-startdate="<?php echo $startDate; ?>" data-enddate="<?php echo $endDate; ?>" data-language='en' data-date-format="dd-mm-yyyy">
														</div>
													</div>
													<div class="col-md-2">
														<input type="text" class="form-control" name="<?php echo $subEntErpriseUsersRow->User_id;?>_replaycount" value="<?php echo ($subEntErpriseUsersRow->UG_ReplayCount)?$subEntErpriseUsersRow->UG_ReplayCount:0?>">
													</div>
												</div>
											<?php } ?>
										<?php } else{ ?>
											<marquee class="alert-danger">No Users</marquee>
										<?php } ?>

									</div>
								<?php } ?>
							<?php } ?>

							<!-- <div class="row">
								<div class="col-md-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck3">
										<label class="custom-control-label" for="customCheck3">Mohit Kumar Sahu</label>
									</div>
								</div>
								<div id="assignDate"class="col-md-6">
									<input type="hidden"name="gameID[]" value="">
									<div class="input-group" name="gamedate" id="datepicker">
										<input type="text" class="form-control datepicker-here" id="" name="gamestartdate[]" value="" data-value="" placeholder="Select Start Date" required="" readonly="" data-startdate="" data-enddate="" data-language='en' data-date-format="dd-mm-yyyy">

										<span class="input-group-addon" >To</span>

										<input type ="text" class="form-control datepicker-here" id="" name="gameenddate[]" value="" data-value="" placeholder="Select End Date" required="" readonly="" data-startdate="" data-enddate="" data-language='en' data-date-format="dd-mm-yyyy">
									</div>
								</div>

								<div class="col-md-2">
									<input type="text" class="form-control" name="UG_ReplayCount[]" id="UG_ReplayCount_<?php // echo $games->Game_ID;?>" value="" placeholder="Rep-Count">
								</div>
							</div> -->
							<div class="clearfix"><br></div>
							<div class="row col-md-12 form-group" style="margin-left: 33%;">
								<button class="btn btn-primary" type="submit" id="submitForm">Submit</button>
								&nbsp;
								<a href="<?php echo base_url(); ?>" class="btn btn-outline-danger">Cancel</a>
							</div>

						</form>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			var gameid   = <?php echo $gamedata[0];?>;
			var gameName = "<?php echo $gamedata[1];?>";
			$('#Enterprise').on('change',function(){
				$('#subEnterpriseUsers_Section').addClass('d-none');
				var idAndDate      = $(this).val().split('_');
				var valueStartDate = '<?php echo time(); ?>';
				var valueEndDate   = '<?php echo time(); ?>';
				// console.log(idAndDate); // id_startDate_endDate
				$('#subEnterpriseCheckbox').html('');
				$('#entErpriseUsersCheckbox').html('');
				var Enterprise_ID    = idAndDate[0];
				var entGameStartDate = idAndDate[1];
				var entGameEndDate   = idAndDate[2];
				if(Enterprise_ID)
				{
					$.ajax({
						url        : '<?php echo base_url();?>AjaxAllocationDeallocation/getSubEnterpriseWithGame/'+Enterprise_ID+'/'+gameid+'/<?php echo $allocateTo;?>',
						type       : "POST",
						cache      : false,
						contentType: false,
						processData: false,
						beforeSend : function(){
							$('.pre-loader').show();
						},
						error: function(){
							$('.pre-loader').hide();
							swal.fire('Pleaser try later, or contact admin');
						},
						success: function( result ){
							try
							{
								if( result == 'no game' )
								{
									swal.fire("Selected enterprise doesn't have <span class='text-blue'>"+gameName+"</span>");
								}
								else
								{
									// console.log(JSON.parse( result ));
									result = JSON.parse( result );

									// for entErpriseUsers
									<?php if($allocateTo == 'entErpriseUsers'){ ?>
										if(result.length<1)
										{
											swal.fire("Selected enterprise doesn't have any enterprise user associated");
											$('.pre-loader').hide();
											return false;
										}
										var entErpriseUsersCheckbox = '';
										// append the checkboxes of entErpriseUsers to #entErpriseUsersCheckbox
										$.each(result,function(i,e){
											var replayCount = (result[i].UG_ReplayCount == null)?0:result[i].UG_ReplayCount;
											// to set start date
											if(idAndDate[1] < result[i].UserStartDate)
											{
												// to check that ent game end date is > user end date
												entGameStartDate = result[i].UserStartDate;
												valueStartDate   = result[i].UserStartDate;
											}
											else
											{
												entGameStartDate = idAndDate[1];
												valueStartDate   = idAndDate[1];
												// console.log('here for '+result[i].User_email);
											}

											// to set end date
											if(idAndDate[2] > result[i].UserEndDate)
											{
												// to check that ent game end date is > user end date
												entGameEndDate = result[i].UserEndDate;
												valueEndDate   = result[i].UserEndDate;
											}
											else
											{
												entGameEndDate = idAndDate[2];
												valueEndDate   = idAndDate[2];
												// console.log('here for '+result[i].User_email);
											}

											// user already has the game
											if(gameid == result[i].UG_GameID)
											{
												var valueStartDate = result[i].UG_GameStartDate;
												var valueEndDate   = result[i].UG_GameEndDate;
												var checked        = 'checked';
												// console.log(idAndDate[2]+' and '+result[i].UserEndDate+' for '+result[i].User_email);
											}
											// user don't have the game
											else
											{
												var checked = '';
											}


											entErpriseUsersCheckbox += '<div class="row col-md-12"><div class="col-md-4"><div class="custom-control custom-checkbox" data-toggle="tooltip" title="'+result[i].User_email+'"><input '+checked+' type="checkbox" class="custom-control-input" id="'+result[i].User_id+'" name="EnterpriseUser[]" value='+result[i].User_id+'><label class="custom-control-label" for="'+result[i].User_id+'">'+result[i].userName+'</label></div></div><div id="assignDate"class="col-md-6"><div class="input-group" name="gamedate" id="datepicker"><input type="text" class="form-control datepicker-here" id="" name="'+result[i].User_id+'_gamestartdate" value="" data-value="'+valueStartDate+'" placeholder="Select Start Date" required="" readonly="" data-startdate="'+entGameStartDate+'" data-enddate="'+entGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"><span class="input-group-addon" >To</span><input type ="text" class="form-control datepicker-here" id="" name="'+result[i].User_id+'_gameenddate" value="" data-value="'+valueEndDate+'" placeholder="Select End Date" required="" readonly="" data-startdate="'+entGameStartDate+'" data-enddate="'+entGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"></div></div><div class="col-md-2"><input type="text" class="form-control" name="'+result[i].User_id+'_replaycount" id="replaycount<?php // echo $games->Game_ID;?>" value="'+replayCount+'" placeholder="Rep-Count"></div></div>';
										});
										$('#entErpriseUsersCheckbox').html(entErpriseUsersCheckbox);
										datepickerBindHere();
									<?php } ?>

									// for subenterprise
									<?php if($allocateTo == 'subEnterprise'){ ?>
										if(result.length<1)
										{
											swal.fire("Selected enterprise doesn't have any Subenterprise associated");
											$('.pre-loader').hide();
											return false;
										}

										var subEnterpriseCheckbox = '';
										// append the checkboxes of subenterprise to #subEnterpriseCheckbox
										$.each(result,function(i,e)
										{
											// to check that ent game start date is > sub ent date
											if(idAndDate[1] < result[i].SubEnterprise_StartDate)
											{
												entGameStartDate = result[i].SubEnterprise_StartDate;
												valueStartDate   = result[i].SubEnterprise_StartDate;
											}
											else
											{
												entGameStartDate = idAndDate[1];
												valueStartDate   = idAndDate[1];
											}

											// to check that ent game end date is > sub ent date
											if(idAndDate[2] > result[i].SubEnterprise_EndDate)
											{
												entGameEndDate = result[i].SubEnterprise_EndDate;
												valueEndDate   = result[i].SubEnterprise_EndDate;
											}
											else
											{
												entGameEndDate = idAndDate[2];
												valueEndDate   = idAndDate[2];
											}

											if(gameid == result[i].SG_GameID)
											{
												var valueStartDate = result[i].SG_Game_Start_Date;
												var valueEndDate   = result[i].SG_Game_End_Date;
												var checked        = 'checked';
											}
											else
											{
												var checked = '';
											}
											subEnterpriseCheckbox += '<div class="row col-md-12"><div class="col-md-4"><div class="custom-control custom-checkbox"><input '+checked+' type="checkbox" class="custom-control-input" id="'+result[i].SubEnterprise_ID+'" name="subEnterprise[]" value='+result[i].SubEnterprise_ID+'><label class="custom-control-label" for="'+result[i].SubEnterprise_ID+'">'+result[i].SubEnterprise_Name+'</label></div></div><div id="assignDate"class="col-md-6"><div class="input-group" name="gamedate" id="datepicker"><input type="text" class="form-control datepicker-here" id="" name="'+result[i].SubEnterprise_ID+'_gamestartdate" value="" data-value="'+valueStartDate+'" placeholder="Select Start Date" required="" readonly="" data-startdate="'+entGameStartDate+'" data-enddate="'+entGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"><span class="input-group-addon" >To</span><input type ="text" class="form-control datepicker-here" id="" name="'+result[i].SubEnterprise_ID+'_gameenddate" value="" data-value="'+valueEndDate+'" placeholder="Select End Date" required="" readonly="" data-startdate="'+entGameStartDate+'" data-enddate="'+entGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"></div></div></div>';
										});
										$('#subEnterpriseCheckbox').html(subEnterpriseCheckbox);
										datepickerBindHere();
									<?php } ?>

									// creating the subenterprise dropdown
									var SubEnterpriseDropdown = '<option value="">--Select SubEnterprise--</option>';
									// append the checkboxes of subenterprise to #SubEnterpriseDropdown
									$('.pre-loader').hide();
									// creating subenterprise dropdown
									$.each(result,function(i,e)
									{
										if(gameid == result[i].SG_GameID)
										{
											entGameStartDate = result[i].SG_Game_Start_Date;
											entGameEndDate   = result[i].SG_Game_End_Date;
										}
										else
										{
											entGameStartDate = '';
											entGameEndDate   = '';
										}

										SubEnterpriseDropdown += '<option value="'+result[i].SubEnterprise_ID+'_'+entGameStartDate+'_'+entGameEndDate+'">'+result[i].SubEnterprise_Name+'</option>'
									});

									$('#subEnterpriseUsers_Section').removeClass('d-none');
									$('#SubEnterpriseDropdown').html(SubEnterpriseDropdown);
								}
							}
							catch ( e )
							{
								console.log( result );
								$('.pre-loader').hide();
							}
							$('.pre-loader').hide();
						}
					});
}
else
{
	swal.fire('Please Select Enterprise');
}
});

// when subenterprise dropdown is changed subEntErpriseUsersCheckbox
$('#SubEnterpriseDropdown').on('change',function(){
	var dateAndId = $(this).val().split('_');
	// console.log(dateAndId); // id_startDate_endDate
	$('#subEnterpriseCheckbox').html('');
	$('#subEntErpriseUsersCheckbox').html('');
	var SubEnterprise_ID           = dateAndId[0];
	var subEntGameStartDate        = dateAndId[1];
	var subEntGameEndDate          = dateAndId[2];
	var subEntErpriseUsersCheckbox = '';
	var valueDateStart             = '<?php echo time();?>';
	var valueDateEnd               = '<?php echo time();?>';
	// append the checkboxes of entErpriseUsers to #subEntErpriseUsersCheckbox
	if(!dateAndId[0])
	{
		swal.fire('Please Select SubEnterprise');
		return false;
	}
	$.ajax({
		url        : '<?php echo base_url();?>AjaxAllocationDeallocation/getSubEnterpriseUsers/'+SubEnterprise_ID+'/'+gameid+'/<?php echo $allocateTo;?>/'+SubEnterprise_ID,
		type       : "POST",
		cache      : false,
		contentType: false,
		processData: false,
		beforeSend : function(){
			$('.pre-loader').show();
		},
		error: function(){
			$('.pre-loader').hide();
			swal.fire('Pleaser try later, or contact admin');
		},
		success: function( result ){
			try
			{
				if( result == 'no game' )
				{
					swal.fire("Selected SubEnterprise doesn't have <span class='text-blue'>"+gameName+"</span>");
					$('.pre-loader').hide();
					return false;
				}
				else
				{
					result = JSON.parse( result );
					if(result.length<1)
					{
						swal.fire("Selected SubEnterprise doesn't have any User associated");
						$('.pre-loader').hide();
						return false;
					}
					$.each(result,function(i,e){
						var expiredUser      = '';
						var desablExpireUser = '';
						var replayCount      = (result[i].UG_ReplayCount == null)?0:result[i].UG_ReplayCount;
						// to set start date
						if(dateAndId[1] < result[i].UserStartDate)
						{
							// to check that ent game end date is > user end date
							subEntGameStartDate = result[i].UserStartDate;
							valueDateStart      = result[i].UserStartDate;
						}
						else
						{
							subEntGameStartDate = dateAndId[1];
							valueDateStart      = dateAndId[1];
							// console.log('here for '+result[i].User_email);
						}

						// to set end date
						if(dateAndId[2] > result[i].UserEndDate)
						{
							// to check that ent game end date is > user end date
							subEntGameEndDate = result[i].UserEndDate;
							valueDateEnd      = result[i].UserEndDate;
							console.log('end date is greater '+subEntGameEndDate);
						}
						else
						{
							subEntGameEndDate = dateAndId[2];
							valueDateEnd      = dateAndId[2];
							console.log('end date is less '+subEntGameEndDate);
						}

						// user already has the game
						if(gameid == result[i].UG_GameID)
						{
							var checked = 'checked';
							// console.log(dateAndId[2]+' and '+result[i].UserEndDate+' for '+result[i].User_email);
						}
						// user don't have the game
						else
						{
							var valueDateStart = subEntGameStartDate;
							var valueDateEnd   = subEntGameEndDate;
							var checked        = '';
						}

						subEntErpriseUsersCheckbox += '<div class="row col-md-12"><div class="col-md-4"><div class="custom-control custom-checkbox" data-toggle="tooltip" title="'+result[i].User_email+'"><input '+checked+' type="checkbox" '+desablExpireUser+' class="custom-control-input" id="'+result[i].User_id+'" name="subEnterpriseUser[]" value='+result[i].User_id+'><label class="custom-control-label '+expiredUser+'" for="'+result[i].User_id+'">'+result[i].userName+'</label></div></div><div id="assignDate"class="col-md-6"><div class="input-group" name="gamedate" id="datepicker"><input type="text" class="form-control datepicker-here" id="" name="'+result[i].User_id+'_gamestartdate" value="" data-value="'+valueDateStart+'" placeholder="Select Start Date" required="" readonly="" data-startdate="'+subEntGameStartDate+'" data-enddate="'+subEntGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"><span class="input-group-addon" >To</span><input type ="text" class="form-control datepicker-here" id="" name="'+result[i].User_id+'_gameenddate" value="" data-value="'+valueDateEnd+'" placeholder="Select End Date" required="" readonly="" data-startdate="'+subEntGameStartDate+'" data-enddate="'+subEntGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"></div></div><div class="col-md-2"><input type="text" class="form-control" name="'+result[i].User_id+'_replaycount" id="UG_ReplayCount_<?php // echo $games->Game_ID;?>" value="'+replayCount+'" placeholder="Rep-Count"></div></div>';
					});
					$('#subEntErpriseUsersCheckbox').html(subEntErpriseUsersCheckbox);
					datepickerBindHere();
				}

			}
			catch ( e )
			{
				console.log( result );
				$('.pre-loader').hide();
			}
			$('.pre-loader').hide();
		}
	});
});

<?php if($allocateTo == 'enterprise' || $allocateTo == 'subEnterprise'){ ?>
	$('#submitForm').on('click', function(e){
		e.preventDefault();
		Swal.fire({
			title: "Game duration will be changed accordingly depending on <?php echo $allocateTo; ?>",
			text : "Are you sure?",
			type : 'warning',
			showCancelButton  : true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor : '#d33',
			confirmButtonText : 'Ok'
		}).then((result) => {
			if (result.value) {
				// Swal.fire(
				// 	'Deleted!',
				// 	'Your file has been deleted.',
				// 	'success'
				// 	)
				$('#gameDataForm').submit();
			}
		})
	});
<?php } ?>

// adding function to get the enterprise users
function showEnterpriseUsers(enterpriseData)
{
	$('#entErpriseUsersCheckbox').html('');
	var entData          = enterpriseData.split('_');
	var Enterprise_ID    = entData[0];
	var entGameStartDate = entData[1];
	var entGameEndDate   = entData[2];
	var startValueDate   = '<?php echo time();?>';
	var endValueDate     = '<?php echo time();?>';
	// console.log(Enterprise_ID+' and '+entGameStartDate+' and '+entGameEndDate);

	$.ajax({
		url        : '<?php echo base_url();?>AjaxAllocationDeallocation/getSubEnterpriseWithGame/'+Enterprise_ID+'/'+gameid+'/<?php echo $allocateTo;?>',
		type       : "POST",
		cache      : false,
		contentType: false,
		processData: false,
		beforeSend : function(){
			$('.pre-loader').show();
		},
		error: function(){
			swal.fire('Pleaser try later, or contact admin');
		},
		success: function( result ){
			try
			{
				var entErpriseUsersCheckbox = '';
				result = JSON.parse( result );
				// append the checkboxes of entErpriseUsers to #entErpriseUsersCheckbox
				$.each(result,function(i,e){
					var replayCount = (result[i].UG_ReplayCount == null)?0:result[i].UG_ReplayCount;
					// to set start date
					if(entData[1] < result[i].UserStartDate)
					{
						// to check that ent game end date is > user end date
						entGameStartDate = result[i].UserStartDate;
						startValueDate   = result[i].UserStartDate;
					}
					else
					{
						entGameStartDate = entData[1];
						startValueDate   = entData[1];
						// console.log('here for '+result[i].User_email);
					}
					// to set end date
					if(entData[2] > result[i].UserEndDate)
					{
						// to check that ent game end date is > user end date
						entGameEndDate = result[i].UserEndDate;
						endValueDate   = result[i].UserEndDate;
					}
					else
					{
						entGameEndDate = entData[2];
						endValueDate   = entData[2];
						// console.log('here for '+result[i].User_email);
					}

					// user already has the game
					if(gameid == result[i].UG_GameID)
					{
						var startValueDate = result[i].UG_GameStartDate;
						var endValueDate   = result[i].UG_GameEndDate;
						var checked        = 'checked';
						// console.log(entData[2]+' and '+result[i].UserEndDate+' for '+result[i].User_email);
					}
					// user don't have the game
					else
					{
						var checked = '';
					}

					entErpriseUsersCheckbox += '<div class="row col-md-12"><div class="col-md-4"><div class="custom-control custom-checkbox" data-toggle="tooltip" title="'+result[i].User_email+'"><input '+checked+' type="checkbox" class="custom-control-input" id="'+result[i].User_id+'" name="EnterpriseUser[]" value='+result[i].User_id+'><label class="custom-control-label" for="'+result[i].User_id+'">'+result[i].userName+'</label></div></div><div id="assignDate"class="col-md-6"><div class="input-group" name="gamedate" id="datepicker"><input type="text" class="form-control datepicker-here" id="" name="'+result[i].User_id+'_gamestartdate" value="" data-value="'+startValueDate+'" placeholder="Select Start Date" required="" readonly="" data-startdate="'+entGameStartDate+'" data-enddate="'+entGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"><span class="input-group-addon" >To</span><input type ="text" class="form-control datepicker-here" id="" name="'+result[i].User_id+'_gameenddate" value="" data-value="'+endValueDate+'" placeholder="Select End Date" required="" readonly="" data-startdate="'+entGameStartDate+'" data-enddate="'+entGameEndDate+'" data-language="en" data-date-format="dd-mm-yyyy"></div></div><div class="col-md-2"><input type="text" class="form-control" name="'+result[i].User_id+'_replaycount" id="replaycount<?php // echo $games->Game_ID;?>" value="'+replayCount+'" placeholder="Rep-Count"></div></div>';
				});
				$('#entErpriseUsersCheckbox').html(entErpriseUsersCheckbox);
				datepickerBindHere();
			}
			catch ( e )
			{
				console.log( e );
			}
		}
	});
}
<?php if(isset($showEnterpriseUsers) && $showEnterpriseUsers == 'showEnterpriseUsers'){ ?>
	showEnterpriseUsers("<?php echo $enterpriseData->Enterprise_ID.'_'.$enterpriseData->EG_Game_Start_Date.'_'.$enterpriseData->EG_Game_End_Date; ?>");
<?php } ?>

});
</script>