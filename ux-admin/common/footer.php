
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
	// adding select2 function to make dropdown searchable
	$('select').each(function(){
		$('select').select2();
	});
	$('select').on('change',function(){
	// alert($(this).val());
	$('select').select2();
});
//-->
</script>

<script>
	<!--
		$(document).ready(function(){
			$('#select_all_checkbox').on('click',function(){
				$(this).children('#select_all').trigger('click');
			});
	// selecte all
	$('#select_all').on('click',function(){
		if($(this).is(':checked')){
			$('input[type="checkbox"]').prop('checked',true);
			$('.checkbox').each(function(index, el){
				$(this).css({'background-color':'#ccc'});
			});
		}
		else
		{
			$('input[type="checkbox"]').prop('checked',false);
			$('.checkbox').each(function(index, el){
				$(this).css({'background-color':'#ffffff'});
			});
			$('.enableDisable').css({'background-color':'#d3d3d3'});
			$('.enableDisableSub').css({'background-color':'#d3d3d3'});
		}
	});

	$('#siteuser_btn').click( function(){
		$( "#siteuser_sbmit" ).trigger( "click" );
	});
	$('#siteuser_btn_update').click( function(){
		var User_GameStartDate = $('#User_GameStartDate').val();
		var User_GameEndDate   = $('#User_GameEndDate').val();
		if(User_GameEndDate < User_GameStartDate)
		{
			alert('End date must be greate than start date.');
			return false;
		}

		$("#siteuser_update").trigger("click");
	});
	// changing back ground color of checkbox for checked and not checked
	$('.usergame').each(function(index, el)
	{
		$(el).on('click',function(){
			if($(this).is(':checked'))
			{
				$(this).parent('label').css({'background-color':'#ccc'});
			}
			else
			{
				$(this).parent('label').css({'background-color':'#ffffff'});
				$('#select_all').prop('checked',false);
				$('#select_all_checkbox').css({'background-color':'#ffffff'});
			}
		});
	});
});

// -->
</script>
<!-- to download area,compo,subcompo,game,scenario,personalize outcomes in excelsheet -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#downloadArea").hide();
		$("#downloadCompo").hide();
		$("#downloadSubCompo").hide();
		$("#downloadGame").hide();
		$("#downloadScenario").hide();
		$("#downloadPersonalizeOutcome").hide();
		$("#downloadScenarioBranching").hide();
		
		$("#HideDownloadIcon").on('click',function(){
			$("#downloadArea").toggle();
			$("#downloadCompo").toggle();
			$("#downloadSubCompo").toggle();
			$("#downloadGame").toggle();
			$("#downloadScenario").toggle();
			$("#downloadPersonalizeOutcome").toggle();
			$("#downloadScenarioBranching").toggle();
			
			$("#download_excel").click(function(){
				var fromdate = $('input[name="fromdate"]').val()
				var enddate  = $('input[name="enddate"]').val()
				//alert(enddate);
				if(fromdate == '' || enddate == '')
				{//alert("empty");
			var yes = confirm("Startdate and Enddate is empty,This will download all data");
			if(yes)
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		if(fromdate > enddate)
		{
			alert("Please select the valid date");
			return false;
		}
				//alert(fromdate);
			});
		/*	$("#HideDownloadIcon").addClass("hidden");
			$("#downloadArea").removeClass("hidden");
			$("#downloadCompo").removeClass("hidden");
			$("#downloadSubCompo").removeClass("hidden");*/
		});
	});
</script>

<!-- dropdown for personalize outcome and scenario branching download in excel -->
  <script type="text/javascript">
  $('#game').change( function(){
    var game = $(this).val();
    //alert(game_id);
    $('#scenario').html('<option value="">-- SELECT --</option>');
  
    $.ajax({
      url: "<?php echo site_root; ?>ux-admin/model/ajax/populate_dropdown.php",
      type: "POST",
      data: { game: game },
      success: function(data){
        $('#scenario').html(data);
      }
    });
  });
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
