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

	<div class="row">
		<div class="col-sm-12">
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div>

	<div class="row">
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
	<div class="row">
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i>Example Text
				<!-- <div class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							Actions
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="#">Action</a>
							</li>
							<li><a href="#">Another action</a>
							</li>
							<li><a href="#">Something else here</a>
							</li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a>
							</li>
						</ul>
					</div>
				</div> -->
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="area" style="height: 300px;"></div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-8 -->
</div>

<script type="text/javascript">
	<!--
//Morris charts snippet - js
$.getScript('http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',function(){
	$.getScript('http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js',function(){
		Morris.Area({
			element: 'area',
			data: [
			{ y: '1.1.', a: 100, b: 90 },
			{ y: '2.1.', a: 75,  b: 65 },
			{ y: '3.1.', a: 50,  b: 40 },
			{ y: '4.1.', a: 75,  b: 65 },
			{ y: '5.1.', a: 50,  b: 40 },
			{ y: '6.1.', a: 75,  b: 65 },
			{ y: '7.1.', a: 100, b: 90 }
			],
			xkey: 'y',
			ykeys: ['a', 'b'],
			labels: ['Series A', 'Series B']
		});
		
		Morris.Line({
			element: 'line-example',
			data: [
			{year: '2010', value: 20},
			{year: '2011', value: 10},
			{year: '2012', value: 5},
			{year: '2013', value: 2},
			{year: '2014', value: 20}
			],
			xkey: 'year',
			ykeys: ['value'],
			labels: ['Value']
		});
		
		Morris.Donut({
			element: 'donut-example',
			data: [
			{label: "Android", value: 12},
			{label: "iPhone", value: 30},
			{label: "Other", value: 20}
			]
		});
		
		Morris.Bar({
			element: 'bar-example',
			data: [
			{y: 'Jan 2014', a: 100},
			{y: 'Feb 2014', a: 75},
			{y: 'Mar 2014', a: 50},
			{y: 'Apr 2014', a: 75},
			{y: 'May 2014', a: 50},
			{y: 'Jun 2014', a: 75}
			],
			xkey: 'y',
			ykeys: ['a'],
			labels: ['Visitors', 'Conversions']
		});
	});
});
//-->
</script>