 <!--  <?php  //echo $type."<pre>";print_r($assignGames); exit(); ?> --> 
 	<div class="main-container">
 		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
 			<div class="min-height-200px">
 				<div class="page-header">
 					<div class="row">
 						<div class="col-md-6 col-sm-12">
 							<div class="title">
 								<h1>Assign Games</h1>
 							</div>
 							<nav aria-label="breadcrumb" role="navigation">
 								<ol class="breadcrumb">
 									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
 									<li class="breadcrumb-item active" aria-current="page">Game Allocation/Deallocation</li>
 								</ol>
 							</nav>
 						</div>	
 					</div>
 					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
 						<div class="clearfix">
 							<?php $this->load->view('components/trErMsg');?>
 							<div class="pull-left">
 								<h4 class="text-blue">
 									<?php switch($type)
 									{
 										case 'Enterprise':
 										echo "For Enterprise : $Games->Enterprise_Name ";
 										break;
 										case 'SubEnterprise':
 										echo "For SubEnterprise: $Games->SubEnterprise_Name ";
 										break;
 										case 'EnterpriseUsers':
 										echo "For Enterprise User: $Games->User_username ";
 										break;
 										case  'SubEnterpriseUsers':
 										echo "For SubEnterprise: $Games->SubEnterprise_Name <br> User: $Games->User_username ";
 										break;		
 									}?> </h4>
 								</div>
 							</div><br>
 							<?php
 							if(count($assignGames)<1){ ?>
 								<marquee behavior="alternate" direction="">
 									<div class="col-md-10 col-xs-12 row text-center alert-danger">No Game Assign To User Enterprise/Subenterprise
 									</div>
 								</marquee>
 							<?php }
 							else
 								{ ?>
 									<form action="" method="post" enctype="multipart/form-data">
 										<div class="form-group row">
 											<div class="col-md-6">
 												<label for="name"><span class="alert-danger">*</span>Select Games</label>
 											</div>
 											<div class="col-md-6">
 												<input type="checkbox" name="select_all" id="select_all">
 												<label for="name"> Select All</label>
 											</div>
 										</div><br>
 										<?php foreach ($assignGames as $games) { ?>
 											<div class="form-group row" id="addGames<?php echo $games->Game_ID;?>">
 												<?php switch($type)
 												{
 													case 'Enterprise':												
 													$GameStartDate = $games->Enterprise_GameStartDate;
 													$GameEndDate   = $games->Enterprise_GameEndDate;
 													$ReplayCount   = 0;
 													if($games->Game_ID == $games->EG_GameID)
 													{
 														$checked = 'checked';
 														if($checked)
 														{
 															$startDate = $games->EG_Game_Start_Date;
 															$endDate   = $games->EG_Game_End_Date;
 														}
 													}
 													else
 													{
 														$checked = ' ';
 														if($checked)
 														{
 															$startDate = $games->Enterprise_GameStartDate;;
 															$endDate   = $games->Enterprise_GameEndDate;
 														}
 													}
 													break;

 													case 'SubEnterprise':
 													echo "<input type='hidden' name='EnterpriseID' value=' $games->SubEnterprise_EnterpriseID'>";
 													$GameStartDate = $games->EG_Game_Start_Date;
 													$GameEndDate   = $games->EG_Game_End_Date;
 													$ReplayCount   = 0;

 													if($games->EG_GameID == $games->SG_GameID)
 													{
 														$checked = 'checked';
 														if($checked)
 														{
 															$startDate = $games->SG_Game_Start_Date;
 															$endDate   = $games->SG_Game_End_Date;
 														}
 													}
 													else
 													{
 														$checked = ' ';
 														if($checked)
 														{
 															$startDate = $games->EG_Game_Start_Date;
 															$endDate   = $games->EG_Game_End_Date;
 														}
 													}
 													break;

 													case 'EnterpriseUsers':
 													echo "<input type='hidden' name='Enterprise_ID' value=' $games->EG_EnterpriseID'>";
 													$GameStartDate = $games->EG_Game_Start_Date;
 													$GameEndDate   = $games->EG_Game_End_Date;
 													$ReplayCount   = $games->UG_ReplayCount;

 													if($games->EG_GameID == $games->UG_GameID) 
 													{
 														$checked = 'checked';
 														if($checked)
 														{
 															$startDate = $games->UG_GameStartDate;
 															$endDate   = $games->UG_GameEndDate;
 														}
 													}
 													else
 													{
 														$checked = ' ';
 														if($checked)
 														{
 															$startDate = $games->EG_Game_Start_Date;
 															$endDate   = $games->EG_Game_End_Date;
 														}
 													}
 													break;

 													case 'SubEnterpriseUsers':
 													echo "<input type='hidden' name='Enterprise_ID' value=' $games->SubEnterprise_EnterpriseID'>";
 													echo "<input type='hidden' name='SubEnterprise_ID' value=' $games->SubEnterprise_ID'>";
 													$GameStartDate = $games->SG_Game_Start_Date;
 													$GameEndDate   = $games->SG_Game_End_Date; 
 													$ReplayCount   = $games->UG_ReplayCount;

 													if($games->SG_GameID == $games->UG_GameID) 
 													{
 														$checked = 'checked';
 														if($checked)
 														{
 															$startDate = $games->UG_GameStartDate;
 															$endDate   = $games->UG_GameEndDate;
 														}
 													}
 													else
 													{
 														$checked = ' ';
 														if($checked)
 														{
 															$startDate = $games->SG_Game_Start_Date;
 															$endDate   = $games->SG_Game_End_Date;
 														}
 													}
 													break;
 												}
 												?>
 												<div class="col-md-4">
 													<input type="checkbox" class="GameCheckBox" name="assigngames[]" value="<?php echo $games->Game_ID;?>" id="<?php echo $games->Game_ID;?>" <?php echo $checked; ?>>
 													<strong> <?php echo $games->Game_Name;?>
 												</strong>
 											</div>
 											<div id="assignDate"class="col-md-6">
 												<input type="hidden"name="gameID[]" value="<?php echo $games->Game_ID;?>">
 												<div class="input-group" name="gamedate" id="datepicker">
 													<input type="text" class="form-control datepicker-here" id="<?php echo $games->Game_ID;?>_startDate" name="gamestartdate[]" value="<?php echo $startDate ?>" data-value="<?php echo strtotime($startDate);?>" placeholder="Select Start Date" required="" readonly="" data-startDate="<?php echo strtotime($GameStartDate);?>" data-endDate="<?php echo strtotime($GameEndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">

 													<span class="input-group-addon" >To</span>

 													<input type ="text" class="form-control datepicker-here" id="<?php echo $games->Game_ID;?>_endDate" name="gameenddate[]" value="<?php echo $endDate ?>" data-value="<?php echo strtotime($endDate);?>" placeholder="Select End Date" required="" readonly="" data-startDate="<?php echo strtotime($GameStartDate);?>" data-endDate="<?php echo strtotime($GameEndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">
 												</div>
 											</div>
 											<?php if($type!='Subenterprise'){ ?>
 												<div class="col-md-2">
 													<input type="text" class="form-control" name="UG_ReplayCount[]" id="UG_ReplayCount_<?php echo $games->Game_ID;?>" value="<?php echo $ReplayCount;?>" placeholder="Rep-Count">
 												</div>
 											<?php }?>
 										</div>
 									<?php }?>	
 									<div class="clearfix"></div>
 									<br><br>
 									<div class="text-center">
 										<button type="submit" class="btn btn-primary" name="submit" value="submit" id="submit">SUBMIT</button>
 										<?php if($type=='Enterprise'){?>
 											<a href="<?php echo base_url('Enterprise/');?>" class="btn btn-primary ">CANCEL</a>
 											<?php } elseif($type=='SubEnterprise')
 											{?><a href="<?php echo base_url('SubEnterprise/');?>" class="btn btn-primary ">CANCEL</a>
 										<?php }else{?>
 											<a href="<?php echo base_url('Users/').base64_decode($this->uri->segment(4));?>" class="btn btn-primary ">CANCEL</a>
 										<?php }?>				
 									</div>
 								</form>
 							<?php } ?>
 						</div>
 						<div class="clearfix"></div>
 					</div>
 				</div>
 			</div>
 		</div>
 		<script type="text/javascript">
 			$(document).ready(function(){
 				$('#select_all').click(function(i,e){
 					if($(this).is(':checked'))
 					{
 						$('input[type=checkbox]').each(function(i,e){
 							$(this).prop('checked',true);
 						});
 					}
 					else
 					{
 						$('input[type=checkbox]').each(function(i,e){
 							$(this).prop('checked',false);
 						});
 					}
 				});
 			});
 		</script>
