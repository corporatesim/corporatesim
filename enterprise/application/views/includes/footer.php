	<div id="cnf_del_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="color:#0d85a2;">Confirm Delete?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form action="" method="post" name="forgotPass_frm" id="forgotPass_frm">
					<div class="modal-body">
						<div class="form-group">
							<label>Are you sure want to delete?</label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default signUpBtn" id="cnf_yes">Yes</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="footer-wrap bg-white pd-20 mb-20 border-radius-5 box-shadow">
		&copy; 2017.  All rights reserved By<a href="https://www.corporatesim.com/" target="_blank">  Corporatesim</a>
	</div>
</div>
</div>
<script src="<?php echo base_url('common/'); ?>vendors/scripts/script.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
<!-- buttons for Export datatable -->
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/buttons.print.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/buttons.html5.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/buttons.flash.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/pdfmake.min.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/datatables/media/js/button/vfs_fonts.js">
</script>
<script src="<?php echo base_url('common/'); ?>src/plugins/highcharts-6.0.7/code/highcharts.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/highcharts-6.0.7/code/highcharts-more.js"></script>
<!-- datepicker js -->
<script src="<?php echo base_url('common/'); ?>datetimePicker/js/datepicker.min.js"></script>
<!-- Include English language -->
<script src="<?php echo base_url('common/'); ?>datetimePicker/js/i18n/datepicker.en.js"></script>
<!-- Show datatable -->
<script type="text/javascript">
	$('document').ready(function()
	{
		$('.datepicker-here').each(function(i,e){
			var startDate   = new Date($(this).data('startdate')*1000);
			var endDate     = new Date($(this).data('enddate')*1000);
			var currentDate = new Date($(this).data('value')*1000);
			var selDate     = $(e).datepicker().data('datepicker');
			selDate.selectDate(currentDate);
			// alert(currentDate);
			$(this).datepicker({
				minDate    : startDate,
				maxDate    : endDate,
				autoClose  : true,
				clearButton: true,
				setDate    : new Date(),
				// todayButton: new Date(),
			});
		});

		$('.data-table').DataTable({
			scrollCollapse: true,
			autoWidth     : false,
			responsive    : true,
			columnDefs    : [{
				targets       : "datatable-nosort",
				orderable     : false,
			}],
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		});
	});
	$('.data-table-export').DataTable({
		scrollCollapse: true,
		autoWidth     : false,
		responsive    : true,
		columnDefs    : [{
			targets       : "datatable-nosort",
			orderable     : false,
		}],
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search"
		},
		dom    : 'Bfrtip',
		buttons: [
		'copy', 'csv', 'pdf', 'print'
		]
	});
</script>
<!-- For delete record-->
<script type="text/javascript">
	$('.dl_btn').click( function() {
		$('#cnf_yes').val($(this).attr('id'));
		$('#cnf_del_modal').modal('show');
	});

	$('#cnf_yes').click( function() {
		var val = $(this).val();
		var id  = btoa(val);
		window.location.href = loc_url_del + id +"/"+ func;		
	});
</script>
<!-- End Delete -->

<script type="text/javascript">
	Highcharts.chart('areaspline-chart', {
		chart: {
			type: 'areaspline'
		},
		title: {
			text: ''
		},
		legend: {
			layout         : 'vertical',
			align          : 'left',
			verticalAlign  : 'top',
			x              : 70,
			y              : 20,
			floating       : true,
			borderWidth    : 1,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
		},
		xAxis: {
			categories: [
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Sunday'
			],
			plotBands: [{
				from: 4.5,
				to  : 6.5,
			}],
			gridLineDashStyle: 'longdash',
			gridLineWidth    : 1,
			crosshair        : true
		},
		yAxis: {
			title: {
				text: ''
			},
			gridLineDashStyle: 'longdash',
		},
		tooltip: {
			shared     : true,
			valueSuffix: ' units'
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			areaspline: {
				fillOpacity: 0.6
			}
		},
		series: [{
			name : 'John',
			data : [0, 5, 8, 6, 3, 10, 8],
			color: '#f5956c'
		}, {
			name : 'Jane',
			data : [0, 3, 6, 3, 7, 5, 9],
			color: '#f56767'
		}, {
			name : 'Johnny',
			data : [0, 2, 5, 3, 2, 4, 0],
			color: '#a683eb'
		}, {
			name : 'Daniel',
			data : [0, 4, 7, 3, 0, 7, 4],
			color: '#41ccba'
		}]
	});


		// Device Usage chart
		Highcharts.chart('device-usage', {
			chart: {
				type: 'pie'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				series: {
					dataLabels: {
						enabled: false,
						format : '{point.name}: {point.y:.1f}%'
					}
				},
				pie: {
					innerSize: 127,
					depth    : 45
				}
			},

			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat : '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
			},
			series: [{
				name        : 'Brands',
				colorByPoint: true,
				data: [{
					name : 'IE',
					y    : 10,
					color: '#ecc72f'
				}, {
					name: 'Chrome',
					y    : 40,
					color: '#46be8a'
				}, {
					name: 'Firefox',
					y    : 30,
					color: '#f2a654'
				}, {
					name: 'Safari',
					y    : 10,
					color: '#62a8ea'
				}, {
					name: 'Opera',
					y    : 10,
					color: '#e14e50'
				}]
			}]
		});

		// gauge chart
		Highcharts.chart('ram', {

			chart: {
				type               : 'gauge',
				plotBackgroundColor: null,
				plotBackgroundImage: null,
				plotBorderWidth    : 0,
				plotShadow         : false
			},
			title: {
				text: ''
			},
			credits: {
				enabled: false
			},
			pane: {
				startAngle: -150,
				endAngle  : 150,
				background: [{
					borderWidth: 0,
					outerRadius: '109%'
				}, {
					borderWidth: 0,
					outerRadius: '107%'
				}, {
				}, {
					backgroundColor: '#fff',
					borderWidth    : 0,
					outerRadius    : '105%',
					innerRadius    : '103%'
				}]
			},

			yAxis: {
				min              : 0,
				max              : 200,
				
				minorTickInterval: 'auto',
				minorTickWidth   : 1,
				minorTickLength  : 10,
				minorTickPosition: 'inside',
				minorTickColor   : '#666',
				
				tickPixelInterval: 30,
				tickWidth        : 2,
				tickPosition     : 'inside',
				tickLength       : 10,
				tickColor        : '#666',
				labels           : {
					step    : 2,
					rotation: 'auto'
				},
				title: {
					text: 'RAM'
				},
				plotBands: [{
					from : 0,
					to   : 120,
					color: '#55BF3B'
				}, {
					from : 120,
					to   : 160,
					color: '#DDDF0D'
				}, {
					from : 160,
					to   : 200,
					color: '#DF5353'
				}]
			},

			series: [{
				name   : 'Speed',
				data   : [80],
				tooltip: {
					valueSuffix: '%'
				}
			}]
		});
		Highcharts.chart('cpu', {

			chart: {
				type               : 'gauge',
				plotBackgroundColor: null,
				plotBackgroundImage: null,
				plotBorderWidth    : 0,
				plotShadow         : false
			},
			title: {
				text: ''
			},
			credits: {
				enabled: false
			},
			pane: {
				startAngle: -150,
				endAngle  : 150,
				background: [{
					borderWidth: 0,
					outerRadius: '109%'
				}, {
					borderWidth: 0,
					outerRadius: '107%'
				}, {
				}, {
					backgroundColor: '#fff',
					borderWidth    : 0,
					outerRadius    : '105%',
					innerRadius    : '103%'
				}]
			},

			yAxis: {
				min: 0,
				max: 200,

				minorTickInterval: 'auto',
				minorTickWidth   : 1,
				minorTickLength  : 10,
				minorTickPosition: 'inside',
				minorTickColor   : '#666',

				tickPixelInterval: 30,
				tickWidth        : 2,
				tickPosition     : 'inside',
				tickLength       : 10,
				tickColor        : '#666',
				labels: {
					step: 2,
					rotation: 'auto'
				},
				title: {
					text: 'CPU'
				},
				plotBands: [{
					from : 0,
					to   : 120,
					color: '#55BF3B'
				}, {
					from : 120,
					to   : 160,
					color: '#DDDF0D'
				}, {
					from : 160,
					to   : 200,
					color: '#DF5353'
				}]
			},

			series: [{
				name: 'Speed',
				data: [120],
				tooltip: {
					valueSuffix: ' %'
				}
			}]
		});
	</script>
</body>
</html>