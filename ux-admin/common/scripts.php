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
    $('#sandbox-container input').datepicker({
        format: "yyyy-mm-dd",
		endDate: '-d',
        weekStart: 0,
        daysOfWeekHighlighted: "0,6",
        autoclose: true,
        todayHighlight: true
    });
// -->
</script>

<script src="<?php echo site_root; ?>assets/components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo site_root; ?>assets/components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script>
<!--
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
				responsive: true,
				"columnDefs": [ {
				      "targets": 'no-sort',
				      "orderable": false,
				} ]
		});
	});
// -->
</script>