<style>
	.morris-hover{
		position:absolute;
		z-index:1000
	}
	.morris-hover.morris-default-style{
		border-radius:10px;
		padding      :6px;
		color        :#666;
		background   :rgba(255,255,255,0.8);
		border       :solid 2px rgba(230,230,230,0.8);
		font-family  :sans-serif;font-size:12px;text-align:center}.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0}
		.morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0}
	</style>
	<div class="clearfix"></div>
	<?php
	$bodyArray      = array('mksahu', 'localhost', 'develop.corporatesim.com');
	$colorArray     = array('mksahu', 'rgba(153, 102, 255, 1)', 'rgba(75, 192, 192, 1)');
	$dashBoardArray = array('mksahu', 'Local Dashboard', 'Develop Dashboard');
	$bgcolor        = array_search($_SERVER['HTTP_HOST'],$bodyArray);
	// echo $_SERVER['HTTP_HOST'].' and '.$bgcolor.' and '.$dashBoardArray[$bgcolor];

	if($bgcolor)
	{
		$Dashboard = $dashBoardArray[$bgcolor];
		$bgcolor   = "style='background:".$colorArray[$bgcolor].";'";
	}
	else
	{
		$bgcolor   = '';
		$Dashboard = 'Dashboard';
	}
	// echo $_SERVER['HTTP_HOST']; var_dump(array_search($_SERVER['HTTP_HOST'],$bodyArray,true));
	?>

	<div class="row">
		<div class="col-sm-12">
			<h1 class="page-header"><?php echo $Dashboard?></h1>
		</div>
	</div>
	<div class="row" <?php echo $bgcolor?> >
		<div class="col-sm-3">
			<div class="panel panel-primary panel_blue">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-gamepad fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="num_users"><?php echo $totalGame; ?></div>
							<!-- <div><?php echo 'Normal: '.$num.'<br/>B2B: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageGame'?>" class="col-sm-12 col-xs-12">Games<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-green panel_green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-tag fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="deals"><?php echo $totalScen; ?></div>
							<!-- <div><?php echo 'Normal: '.$num.'<br/>Branching: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageScenario'?>" class="col-sm-12 col-xs-12">Scenario<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-yellow panel_yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-briefcase fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="business"><?php echo $totalArea; ?></div>
							<!-- <div><?php echo 'All: '.$num.'<br/>Used: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageArea'?>" class="col-sm-12 col-xs-12">Area<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-red panel_red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-credit-card fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="payments"><?php echo $totalComp; ?></div>
							<!-- <div><?php echo 'All: '.$num.'<br/>Used: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageComponent'?>" class="col-sm-12 col-xs-12">Component<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- /.row -->
	<div class="row col-md-6">
		<canvas id="barChart" width="400" height="400"></canvas>
		<!-- <canvas id="lineChart" width="400" height="400"></canvas> -->
	</div>

	<script>
		var ctx = $('#barChart');
		var myBarChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ['2017', '2018', '2019', '2020', '2021', '2022'],
				datasets: [
				<?php
				for($i=0; $i<count($chartData); $i++)
				{
					echo "{label: '".$chartData[$i][0]->Title."',";
					$dataCount            = '';
					$fetchBackgroundColor = '';
					$fetchBorderColor     = '';

					for($j=0; $j<count($chartData[$i]); $j++)
					{
						$dataCount            .= $chartData[$i][$j]->Count.',';
						$fetchBackgroundColor .= "'".$backgroundColor[$i]."',";
						$fetchBorderColor     .= "'".$borderColor[$i]."',";
					}
					echo "data: [".trim($dataCount,',')."],";
					echo "backgroundColor: [".trim($fetchBackgroundColor,',')."],";
					echo "borderColor: [".trim($fetchBorderColor,',')."],";
					echo "borderWidth: 1 },";
				}
				?>
					// label: 'Game',
					// data: [12, 19, 3, 5, 2, 3],
					// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// ],
					// borderColor: [
					// 'rgba(255, 99, 132, 1)',
					// ],
					]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
		// var ctx = $('#lineChart');
		// var myChart = new Chart(ctx, {
		// 	type: 'line',
		// 	data: {
		// 		labels: ['2017', '2018', '2019', '2020', '2021'],
		// 		datasets: [{
		// 			label: 'Game',
		// 			data: [102, 19, 3, 5, 2, 3],
		// 			backgroundColor: [
		// 			'rgba(255, 99, 132, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(255, 99, 132, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Scenario',
		// 			data: [10, 109, 74, 7, 85, 1],
		// 			backgroundColor: [
		// 			'rgba(54, 162, 235, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(54, 162, 235, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Area',
		// 			data: [25, 5, 93, 23, 83, 18],
		// 			backgroundColor: [
		// 			'rgba(255, 206, 86, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(255, 206, 86, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Component',
		// 			data: [36, 25, 39, 15, 92, 83],
		// 			backgroundColor: [
		// 			'rgba(75, 192, 192, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(75, 192, 192, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Subcomponent',
		// 			data: [1, 19, 31, 51, 21, 31],
		// 			backgroundColor: [
		// 			'rgba(255, 159, 64, 0.2)'
		// 			],
		// 			borderColor: [
		// 			'rgba(255, 159, 64, 1)'
		// 			],
		// 			borderWidth: 1
		// 		}]
		// 	},
		// 	options: {
		// 		scales: {
		// 			yAxes: [{
		// 				ticks: {
		// 					beginAtZero: true
		// 				}
		// 			}]
		// 		}
		// 	}
		// });
	</script>
