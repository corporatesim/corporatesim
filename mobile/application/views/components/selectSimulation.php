<div class="row m-1" style="margin-top: 48px!important;">
	<?php $this->load->view('components/trErAlert'); ?>
	<!-- if user has the bot enabled games then show the games else logged user out -->
	<?php if(count($gameResult) > 0) { 
		foreach($gameResult as $gameResultRow){
			// echo "<pre>"; print_r($gameResultRow); echo "</pre>";
			?>
			<!-- <div class="card m-1" style="max-width: 540px;"> -->
			<div class="card m-1 col-md-3" style="background-color: #fff8dc">
				<div class="row no-gutters">
					<div class="col-md-4">
						<img src="<?php echo base_url('../images/'); echo ($gameResultRow->Game_Image)?$gameResultRow->Game_Image:'Game2.jpg';?>" class="card-img" alt="...">
					</div>
					<div class="col-md-8">
						<div class="card-body">
							<h5 class="card-title"><?php echo $gameResultRow->Game_Name; ?></h5>
							<p class="card-text"><?php echo $gameResultRow->Game_Comments;?></p>
							<p class="card-text">
								<!-- if user is allowed to play games within UG_GameStartDate and UG_GameEndDate-->
								<?php if( time() > strtotime($gameResultRow->UG_GameStartDate) && time() < strtotime($gameResultRow->UG_GameEndDate)) { ?>

									<!-- check if user has completed (US_LinkID == 1)) the simulation-->
									<?php if($gameResultRow->US_LinkID == 1){ ?>

										<?php if($gameResultRow->UG_ReplayCount > 0 || $gameResultRow->UG_ReplayCount < 0 || $this->session->userdata('botUserData')->User_companyid == 21){ ?>
											<!-- it means user belongs to humanlink or has some or unlimited replay access to play the simulation -->

											<a href="<?php echo base_url('PlaySimulation/result/'.base64_encode($gameResultRow->Game_ID));?>" data-toggle="tooltip" title="Simulation Result"><img src="<?php echo base_url('../images/report.png');?>" alt="Simulation Result" width="80" height="80"></a>

											<a href="javascript:void(0);" class="replaySimulation" data-imageurl="<?php echo base_url('../images/'); echo ($gameResultRow->Game_Image)?$gameResultRow->Game_Image:'Game2.jpg';?>" data-gameid="<?php echo $gameResultRow->Game_ID; ?>" data-toggle="tooltip" title="Replay Simulation"><img src="<?php echo base_url('../images/replay1.png');?>" alt="Replay Simulation" width="80" height="80"></a>

										<?php } else { ?>
											<!-- user has complted the simulation and don't have the replay option -->
											<a href="<?php echo base_url('PlaySimulation/result/'.base64_encode($gameResultRow->Game_ID));?>" data-toggle="tooltip" title="Simulation Result"><img src="<?php echo base_url('../images/report.png');?>" alt="Simulation Result" width="80" height="80"></a>
										<?php } ?>

									<?php } else { ?>
										<!-- further check that user has sumitted the o/p page or not -->

										<?php if($gameResultRow->US_Output == 1){ ?>
											<!-- It means user has not submitted the o/p page, still in o/p page -->
											<a href="<?php echo base_url('PlaySimulation/output/'.base64_encode($gameResultRow->Game_ID));?>" data-toggle="tooltip" title="Submit O/P to complete"><img src="<?php echo base_url('../images/play1.png');?>" alt="Submit O/P to complete" width="80" height="80"></a>

										<?php } else { ?>
											<!-- this means user has not started the simulation till now -->
											<a href="<?php echo base_url('PlaySimulation/input/'.base64_encode($gameResultRow->Game_ID));?>" data-toggle="tooltip" title="Play Simulation"><img src="<?php echo base_url('../images/play1.png');?>" alt="Play Simulation" width="80" height="80"></a>
										<?php } ?>

									<?php } } else { ?>
										<!-- when user is not allowed to play games -->
										<small class="text-muted notAllowedToPlay" data-imageurl="<?php echo base_url('../images/'); echo ($gameResultRow->Game_Image)?$gameResultRow->Game_Image:'Game2.jpg';?>" data-startdate="<?php echo date('d-m-Y',strtotime($gameResultRow->UG_GameStartDate));?>" data-enddate="<?php echo date('d-m-Y',strtotime($gameResultRow->UG_GameEndDate));?>" data-gamename="<?php echo $gameResultRow->Game_Name;?>"><img src="<?php echo base_url('../images/timer.gif');?>" alt="Play Simulation" width="80" height="80" style="cursor: pointer;"></small>
									<?php } ?>

								</p>
							</div>
						</div>
					</div>
				</div>
			<?php } } else{ ?>
				<!-- show message and logged out -->
				<script>
					let timerInterval
					Swal.fire({
						// imageUrl   : 'https://unsplash.it/400/200',
						// imageWidth : 400,
						// imageHeight: 200,
						// imageAlt   : 'Custom image',
						icon       : 'error',
						title      : 'No Bot Simulation Assigned!',
						html       : 'You will be logged out in <b></b> milliseconds.',
						timer      : 3000,
						onBeforeOpen: () => {
							Swal.showLoading()
							timerInterval = setInterval(() => {
								Swal.getContent().querySelector('b')
								.textContent = Swal.getTimerLeft()
							}, 100)
						},
						onClose: () => {
						// logout user if don't have bot enabled game
						clearInterval(timerInterval);
						<?php
						$this->session->sess_destroy();
						?>
						window.location = '<?php echo base_url("Login"); ?>';
					}
				}).then((result) => {
					if (
						/* Read more about handling dismissals below */
						result.dismiss === Swal.DismissReason.timer
						) {
						console.log('I was closed by the timer')
				}
			})
		</script>
	<?php } ?>
</div>