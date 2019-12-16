<!-- Bootstrap Core JavaScript -->
<script src="<?php echo site_root; ?>assets/components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo site_root; ?>assets/components/metisMenu/dist/metisMenu.min.js"></script>

<!--<script src="../components/morrisjs/morris.min.js"></script>
	<script src="../js/morris-data.js"></script>-->
	<!-- Custom Theme JavaScript -->
	<script src="<?php echo site_root; ?>assets/dist/js/sb-admin-2.js"></script>

	<script type="text/javascript">
		<!--
// Tooltip function
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});

//Tooltip function
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	if($(window).width() < 1155){
		$( "div.dataTable_wrapper" ).addClass( "table-responsive" );
	}
});
$(window).resize(function() {
	if($(window).width() < 1155){
		$( "div.dataTable_wrapper" ).addClass( "table-responsive" );
	}
	if($(window).width() > 1155){
		$( "div.dataTable_wrapper" ).removeClass( "table-responsive" );
	}
});

$("#selectAll").change(function () {
	$(".selectcheck").prop('checked', $(this).prop("checked"));
});
// -->
</script>

<script src="<?php echo site_root; ?>assets/js/datetimepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo site_root; ?>assets/js/datetimepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	<!--
		// $enableEndDate = 'enableEndDate';
		if('<?php echo $enableEndDate; ?>')
		{
			$('#sandbox-container input').datepicker({
				format               : "yyyy-mm-dd",
				// endDate              : '-d',
				weekStart            : 0,
				daysOfWeekHighlighted: "0,6",
				autoclose            : true,
				todayHighlight       : true
			});
		}
		else
		{
			$('#sandbox-container input').datepicker({
				format               : "yyyy-mm-dd",
				endDate              : '-d',
				weekStart            : 0,
				daysOfWeekHighlighted: "0,6",
				autoclose            : true,
				todayHighlight       : true
			});
		}
// -->
</script>

<script src="<?php echo site_root; ?>assets/components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo site_root; ?>assets/components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script>
	<!--
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true,
				"scrollX": true,
				"columnDefs": [ {
					"targets"   : 'no-sort',
					"orderable" : false,
				} ]
			});

			// making the data-table clickable
			// var table = $('#dataTables-example').DataTable();
			// $('#dataTables-example tbody').on( 'click', 'tr', function () {
			// 	if ( $(this).hasClass('selected') ) {
			// 		$(this).removeClass('selected');
			// 		$(this).css({'background':''});
			// 	}
			// 	else {
			// 		// table.$('tr.selected').removeClass('selected');
			// 		$(this).addClass('selected');
			// 		$(this).css({'background':'#aab7d1'});
			// 	}
			// });

			// $('#button').click( function () {
			// 	table.row('.selected').remove().draw( false );
			// } );

			// for server side enabled tables
			var ajaxUrl      = $('#dataTables-serverSide').data('url');
			var action       = $('#dataTables-serverSide').data('action');
			var runFunctions = $('#dataTables-serverSide').data('function');
			$('#dataTables-serverSide').DataTable({
				responsive: true,
				"scrollX": true,
				"columnDefs": [ {
					"targets"   : 'no-sort',
					"orderable" : false,
				} ],
				"processing": true,
				"serverSide": true,
				"ajax": {
					url : ajaxUrl,
					type: 'POST',
					data: {action: action},
					complete: function(){
						$('[data-toggle="tooltip"]').tooltip();
						// run these functions
						if(runFunctions)
						{
							// print(runFunctions);
							eval(runFunctions);

							// console.log(runFunctions);
							// addClickHandlerToGetComments();
						}
						$('.dl_btn').click( function() {
							$('#cnf_yes').val($(this).attr('id'));
							$('#cnf_del_modal').modal('show');
						});

						$('#cnf_yes').click( function() {
							var val = $(this).val();
							var id  = btoa(val);
							window.location.href = site_root + loc_url_del + id;
						});
					}
				}
			});
		});
// -->
</script>