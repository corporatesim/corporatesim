<?php
// include_once 'includes/headerNav.php'; 
include_once 'includes/header.php';
?>
<section id="video_player">
	<div class="container">
		<div class="row">
			<div class="clearfix"><br></div>
			<div class="col-sm-12 no_padding scenario_name scenario_header">
				<h6 class="InnerPageHeader">End of Card</h6>
			</div>
			<div class="clearfix"></div>
			<div class="no_padding ">
				<div class="shadow col-sm-12">
					
					<div class="row">
						<div class="progress">
							<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:15px" >
								100%
							</div>
						</div>
					</div>

					<div class="col-sm-10 col-sm-offset-1 text-right">
						<!-- show error message if any -->
						<?php if (isset($msg) && !empty($msg)) { ?>
							<div class="alert <?php echo ($type[0] == 'inputError') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
								<?php echo $msg; ?>
							</div>
						<?php } ?>
						<!-- error message ends here -->

						<?php if ($gamedetails->Game_LeaderboardButton < 1) { ?>
							<!-- View Card Report <img src="images/reportIcon.png" alt="Report"> -->
							<a href="javascript:void(0);" data-toggle="tooltip" title="View Card Leaderboard" id="showLeaderboard">
								<img src="images/leaderboard.png" alt="Report" width="75">
							</a>
						<?php }
						// echo "<pre>"; print_r($result1); echo "</pre>";
						// finding user company id if it is 21 then allow replay $result1->US_UserID
						if (count($performanceData) > 1) {
							echo '<a href="javascript:void(0);" data-toggle="tooltip" title="View Card Performance" id="showPerformance">
							<img src="images/performance.png" alt="Report" width="75"></a>';
						}

						$compSql        = "SELECT User_companyid FROM GAME_SITE_USERS WHERE User_companyid = '21' AND User_id=" . $result1->US_UserID;
						$compObj        = $functionsObj->ExecuteQuery($compSql);
						$replaySql      = "SELECT UG_ReplayCount FROM GAME_USERGAMES WHERE UG_GameID = " . $gameid . " AND UG_UserID=" . $result1->US_UserID;
						$replayObj      = $functionsObj->ExecuteQuery($replaySql);
						$UG_ReplayCount = $functionsObj->FetchObject($replayObj);

						if (($compObj->num_rows > 0) || ($UG_ReplayCount->UG_ReplayCount == '-1') || ($UG_ReplayCount->UG_ReplayCount > 0)) {
							$allowReplay = true;
						} else {
							$allowReplay = false;
						}
						if ($result1->US_ReplayStatus == 1 || $allowReplay) {
							$urlstr .= "<a id='restart' href='#' data-gameid='" . $gameid . "' data-scenid='" . $ScenID . "' data-linkid='" . $linkid . "' class='restart' title='ReStart/Resume Game' data-toggle='tooltip'><img src='images/replay.png' alt='ReStart/Resume Game' width='75'></a>";
							echo $urlstr;
						}

						if ($gamedetails->Game_ReportButton < 1) { ?>
							<!-- show/download output result -->
							<a href="<?php echo site_root . 'report.php?ID=' . $gameid . '&linkid=' . $linkid; ?>" target="_blank" data-toggle="tooltip" title="View Card Output" data-gameid='<?php echo $gameid; ?>' data-scenid='<?php echo $ScenID; ?>' data-linkid='<?php echo $linkid; ?>' id="showDownloadOutput">
								<img src="images/downloadReport.png" alt="Output" width="75">
							</a>
						<?php } ?>

						<form action="" class="" id="downloadReportForm" method="post">
							<input type="hidden" name="gameid" id="gameid" value="<?php echo $gameid; ?>">
							<input type="hidden" name="ScenID" id="ScenID" value="<?php echo $ScenID; ?>">
							<input type="hidden" name="linkid" id="linkid" value="<?php echo $linkid; ?>">
							<input type="hidden" name="download" id="download" value="download">
						</form>
					</div>
					<!-- show user performance chart here only if user has played Card more than one time -->
					<?php if (count($performanceData) > 1) { ?>

						<div class="clearfix"><br></div>

						<div class="row" id="showPerformanceChart" style="display: none;">
							<div class="col-md-8">
								<a id="downloadPerformanceChart" download="performanceGraph.png" data-toggle="tooltip" title="Download Performance Chart" class="pull-right">
									<i class="glyphicon glyphicon-download"></i>
								</a>

								<canvas id="lineChart" width="400" height="400"></canvas>
							</div>

							<!-- <div class="clearfix"><br></div> -->
							<div class="col-md-4">
								<div class="clearfix"><br></div>
								<h2 class="alert-success">
									<marquee behavior="alternate" direction="">Performance Chart</marquee>
								</h2>
								<strong>
									<p>
										Based on your results we have drawn a line-chart to show your performance for repeat plays that you undertook.
										<br><br>
										Your performance has been compared with the top score as per the leaderboard at this point in time.
										<br><br>
										The chart shown here provides the following key inputs for your development:
										<br><br>
									</p>
									<ul>
										<li>
											Whether you improved on your performance from the last time or not, and
										</li>
										<li>
											Whether your best performance was close to the benchmark or not
										</li>
									</ul>
								</strong>

							</div>

						</div>
					<?php } ?>
					<!-- performance chart end here -->
					<div class="clearfix"></div>
					<div class="col-sm-10 col-sm-offset-1 mssgeforUser">
						<!--Message for User... -->
						<?php echo $gamedetails->Game_Message; ?>
					</div>
					<div class="col-sm-12">
					</div>
					<div class="col-sm-10 col-sm-offset-1 ">
						<!-- <h4 class="innerh4">Other Unplayed Card</h4> -->
					</div>
					<div class="col-sm-10 col-sm-offset-1 no_padding" style="padding-bottom:20px;">
						<?php
						//echo $str;
						if (count($strgames) > 0) {
							foreach ($strgames as $y => $y_value) {
								//if exists in user_status with result =1
								//echo $y ."--".$y_value;
								if (!empty($y_value)) {
									$sqlquery = "SELECT US_Gameid FROM `GAME_USERSTATUS` WHERE US_LinkID>0 AND US_UserID=" . $userid . " and US_GameID=" . $y_value;
									//echo $sqlquery;
									$result1 = $functionsObj->ExecuteQuery($sqlquery);
									if ($result1->num_rows > 0) {
									} else {
										$sql = "SELECT
										  *
										FROM
										`GAME_USERGAMES` UG
										INNER JOIN
										GAME_GAME G ON UG.`UG_GameID` = G.Game_ID
										WHERE
										G.Game_Status = 1 and G.Game_ID =" . $y_value . " AND G.Game_Delete = 0 AND UG.`UG_UserID` = " . $userid;
										//echo $sql;
										// exit();
										$result = $functionsObj->ExecuteQuery($sql);
										while ($row = mysqli_fetch_array($result)) {
											echo "<div class='col-sm-12'>";
											echo "<div class='col-sm-12 no_padding StartGameStrip'></div>";
											echo "<div class='col-sm-12 shadow'>";
											echo "<input type='hidden' name='id' value='{$row['Game_ID']}'>";
											echo "<div class='col-sm-2  col-xs-2 regular no_padding '>";
											echo $row['Game_Name'];
											echo "</div><div class=' col-md-8 col-xs8 light'>";
											echo $row['Game_Comments'];
											echo "</div><div class='col-sm-2 col-xs-2 regular no_padding  text-right'>";
											//check status of user for this Card
											//if record exist for Userid and GameID in Game_Userstatus
											$where = array(
												"US_GameID = " . $row['Game_ID'],
												"US_UserID = " . $userid
											);
											$obj = $functionsObj->SelectData(array(), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0);
											if ($obj->num_rows > 0) {
												$result1 = $functionsObj->FetchObject($obj);
												//print_r($result1);
												if ($result1->US_LinkID == 0) {
													//get linkid
													$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=" . $row['Game_ID'] . " AND Link_ScenarioID= " . $result1->US_ScenID;
													//echo $sqllink;
													$link       = $functionsObj->ExecuteQuery($sqllink);
													$resultlink = $functionsObj->FetchObject($link);
													$linkid     = $resultlink->Link_ID;
													//echo $linkid;
													if ($result1->US_Input == 0 && $result1->US_Output == 0) {
														if ($link->num_rows > 0) {
															$url = site_root . "scenario_description.php?Link=" . $resultlink->Link_ID;
															//echo $url;
														}
														//exit();
														//scenario_description.php?Link=".$result->Link_ID;
														echo "<a href='" . $url . "'><img src='images/startGameIcon.png' alt='Start/Resume Card' class=''></a>";
													} elseif ($result1->US_Input == 1 && $result1->US_Output == 0) {
														//goto Input page
														$url = site_root . "input.php?ID=" . $row['Game_ID'];
														echo "<a href='" . $url . "'><img src='images/startGameIcon.png' alt='Start/Resume Card' class=''></a>";
													} else {
														$url = site_root . "output.php?ID=" . $row['Game_ID'];
														echo "<a href='" . $url . "'><img src='images/startGameIcon.png' alt='Start/Resume Card' class=''></a>";
														//Goto next scenario
													}
												} else {
													//result
													$url = site_root . "result.php?ID=" . $row['Game_ID'];
													echo "<a href='" . $url . "'><img src='images/reportIcon.png' alt='Start/Resume Card' class=''></a>";
												}
											} else {
												echo "<a href='game_description.php?Game=" . $row['Game_ID'] . "'><img src='images/startGameIcon.png' alt='Start/Resume Card' class=''></a>";
											}
											echo "</div><div class='clearfix'></div></div></div>";
										}
									}
								}
							}
						} ?>
					</div>
				</div>
				<!--shadow-->
				<div class="clearfix"></div>
			</div>
		</div>
		<!--row-->
	</div>
	<!--container---->
</section>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<span></span>
			</div>
		</div>
	</div>
</footer>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		// setTimeout(function(){
		// 	$('#showLeaderboard').trigger('click');
		// },100)

		// if user has played Card more than one time then show the chart to user
		<?php if (count($performanceData) > 1) {
			$data             = '';
			$labels           = '';
			$overAllBenchmark = '';
			foreach ($performanceData as $performanceDataRow) {
				$data             .= $performanceDataRow->Performance_Value . ',';
				$labels           .= "'" . $performanceDataRow->Performance_CreatedOn . "',";
				$overAllBenchmark .= $performanceDataRow->max_value . ',';
			}
			$data             = rtrim($data, ',');
			$labels           = rtrim($labels, ',');
			$overAllBenchmark = rtrim($overAllBenchmark, ',');
			// print_r($data);
			// print_r($labels);
		?>
			$('#showPerformance').on('click', function() {
				$('#showPerformanceChart').toggle();
				downloadChartImage();
			});

			var ctx = $('#lineChart');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: [<?php echo $labels; ?>],
					datasets: [{
							label: "<?php echo $performanceGraphTitle; ?>",
							data: [<?php echo $data; ?>],
							backgroundColor: [
								// 'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								// 'rgba(255, 206, 86, 0.2)',
								// 'rgba(75, 192, 192, 0.2)',
								// 'rgba(153, 102, 255, 0.2)',
								// 'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								// 'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								// 'rgba(255, 206, 86, 1)',
								// 'rgba(75, 192, 192, 1)',
								// 'rgba(153, 102, 255, 1)',
								// 'rgba(255, 159, 64, 1)'
							],
							borderWidth: 2,
							// fill: false,
						},
						// if leaderboard button is hidden then don't show the top score
						<?php if ($gamedetails->Game_LeaderboardButton < 1) { ?> {
								label: "Top Score",
								data: [<?php echo $overAllBenchmark; ?>],
								backgroundColor: [
									// 'rgba(255, 99, 132, 0.2)',
									// 'rgba(54, 162, 235, 0.2)',
									'rgba(255, 206, 86, 0.2)',
									// 'rgba(75, 192, 192, 0.2)',
									// 'rgba(153, 102, 255, 0.2)',
									// 'rgba(255, 159, 64, 0.2)'
								],
								borderColor: [
									// 'rgba(255, 99, 132, 1)',
									// 'rgba(54, 162, 235, 1)',
									// 'rgba(255, 206, 86, 1)',
									// 'rgba(75, 192, 192, 1)',
									// 'rgba(153, 102, 255, 1)',
									'rgba(255, 159, 64, 1)'
								],
								borderWidth: 2,
								fill: false,
							}
						<?php } ?>
					],
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true,
							}
						}],
						xAxes: [{
							ticks: {
								autoSkip: false,
								// maxRotation: 90,
								minRotation: 60,
							}
						}]
					},
				}
			});
		<?php } ?>

		// show/download result output data when user request
		$('#showDownloadOutput').on('click', function() {
			// commenting the below line of code, to prevent the report download, and adding url to redirect the webpage to newly added report.php

			// $('#downloadReportForm').submit();
		});
	});

	function downloadChartImage() {
		$('#downloadPerformanceChart').on('click', function() {
			var url_base64 = document.getElementById('lineChart').toDataURL('image/png');
			$('#downloadPerformanceChart').attr('href', url_base64);
			// console.log($(this).attr('href'));
		});
	}
</script>
<?php include_once 'includes/footer.php' ?>