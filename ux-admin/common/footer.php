
<!-- Confirm Delete Modal -->
<div id="cnf_del_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color:#0d85a2;">Confirm Delete?</h4>
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

<!-- Confirm Change Status Modal -->
<div id="cnf_stat_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="color:#0d85a2;">Confirm Change Status?</h4>
			</div>
			<form action="" method="post" name="forgotPass_frm" id="forgotPass_frm">
				<div class="modal-body">
					<div class="form-group">
						<label>Are you sure want to change status?</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default signUpBtn" id="cs_yes">Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--
	$("#select_All").change(function () {
	    $(".select_all").prop('checked', $(this).prop("checked"));
	});

	$('#username').blur(function(){
		var username = $(this).val();
		$.ajax({
			url: site_root + "ux-admin/model/ajax/usernameCheck.php",
			type: "POST",
			data: { username: username },
			beforeSend: function(){
				$('.username_error').html('<div class="col-sm-12 alert alert-info">Checking..</div>');
			},
			success: function(data){
				$('.username_error').html(data);
			}
		});
	});

	$('.dl_btn').click( function() {
		$('#cnf_yes').val($(this).attr('id'));
		$('#cnf_del_modal').modal('show');
	});

	$('#cnf_yes').click( function() {
		var val = $(this).val();
		var id = btoa(val);
		window.location.href = site_root + loc_url_del + id;
	});

	$('.cs_btn').click( function() {
		$('#cs_yes').val($(this).attr('id'));
		$('#cnf_stat_modal').modal('show');
	});

	$('#cs_yes').click( function() {
		var val = $(this).val();
		var id  = btoa(val);
		window.location.href = site_root + loc_url_stat + id;
	});
//-->
</script>

<div class="col-sm-12">
	<div class="col-sm-8">
		<p style="padding: 10px 0; margin:0px;">&copy; 2017.  All rights reserved</p>
    </div>
    <div class="col-sm-4">
	<!--
	    <p style="padding: 10px 0; margin:0px;" class="muted pull-right">Powered By:<b><a href="http://www.uxexpert.in" target="_blank">UxExpert.in</a></b></p>
		-->
    </div>
</div>