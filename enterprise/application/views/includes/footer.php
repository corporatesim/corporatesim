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
		<a href="https://www.corporatesim.com/" target="_blank">
			Copyright &copy; Humanlinks Learning Pvt. Ltd.- All rights reserved
		</a>
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
<script src="<?php echo base_url('common/vendors/bootgrid/');?>jquery.bootgrid.min.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/highcharts-6.0.7/code/highcharts.js"></script>
<script src="<?php echo base_url('common/'); ?>src/plugins/highcharts-6.0.7/code/highcharts-more.js"></script>
<!-- datepicker js -->
<script src="<?php echo base_url('common/'); ?>datetimePicker/js/datepicker.min.js"></script>
<!-- Include English language -->
<script src="<?php echo base_url('common/'); ?>datetimePicker/js/i18n/datepicker.en.js"></script>
<!-- Show datatable -->
<script type="text/javascript">
	$(document).ready(function()
	{
		// increasing the width of scroll-bar
		setTimeout(function(){
			$('div.mCSB_dragger_bar').css({'width':'90%'});
		},1000);
		// to manage domain/sub-domain field accordingly
		// $('input[name=Sub-Domain]').on('change',function(){
		// 	if($(this).val() == 'Specific')
		// 	{
		// 		$('#addDomainField').empty();
		// 		$('#addDomainField').append('<input type="url" name="commonDomain" id="commonDomain" class="form-control" value="" placeholder="http://exampleAbc.com">');
		// 	}
		// 	else
		// 	{
		// 		$('#addDomainField').empty();
		// 		$('#addDomainField').append('<input type="text" name="commonDomain" id="commonDomain" class="form-control" value="" placeholder="http://abcExample.corporatesim.com">');
		// 	}
		// });
		// show domain name
		$('#commonDomain').on('keypress keyup', function(e){
			var domainName = $(this).val().trim();
			// console.log(e+' and '+domainName.length);
			if(domainName.length > 2)
			{
				// trigger ajax to find that domain already exist or not
				$.ajax({
					url     : "<?php echo base_url('Ajax/getDomainName/')?>"+domainName,
					type    : 'POST',
					// dataType: 'json',
					success: function(result)
					{
						// console.log(result);
						if(result == 'success')
						{
							$('#showDomain').empty();
							$('#showDomain').html('Your Domain will be: <span class="alert-success"><b>'+domainName+'.corporatesim.com</b></span>');
							$('#showDomain').append('<input type="hidden" name="allow" value="allow">');
						}
						else
						{
							$('#showDomain').empty();
							$('#showDomain').html('Domain: <span class="alert-danger">"<b>'+domainName+'.corporatesim.com</b>" already taken. Please try different domain.</span>');
						}
					}
				})
			}
			else
			{
				$('#showDomain').empty();
				$('#showDomain').html('<b class="alert-danger">Only Alphabates are allowed. Min 3 Characters.</b>');
			}
			
		});
		// to manipulate csv form and normal form to insert/upload data
		$('#showCsvForm').on('click',function(){
			if($(this).is(':checked'))
			{
				$('#addByCsv').removeClass('d-none');
				$('#addByForm').addClass('d-none');
			}
			else
			{
				$('#addByCsv').addClass('d-none');
				$('#addByForm').removeClass('d-none');
			}
		});
		// set date range while createing the subenterprise accordingly
		$('.enterprise').on('change',function(){
			var Enterprise_ID = $(this).val();
			$.ajax({
				url     : "<?php echo base_url('Ajax/get_dateRange/')?>"+Enterprise_ID,
				type    : 'POST',
				dataType: 'json',
				// data    : {param1: 'value1'},
				success: function(result)
				{
					if(result == 'no')
					{
						console.log(result);
					}
					else
					{
						// console.log(result.Enterprise_StartDate+' '+result.Enterprise_EndDate);
						$('#SubEnterprise_StartDate').data('startdate', result.Enterprise_StartDate);
						$('#SubEnterprise_StartDate').data('enddate', result.Enterprise_EndDate);
						$('#SubEnterprise_EndDate').data('startdate', result.Enterprise_StartDate);
						$('#SubEnterprise_EndDate').data('enddate', result.Enterprise_EndDate);
						// set the data attribute value here and then call datepickerBindHere()
						datepickerBindHere();
					}
				}
			})
		});

		// add country change function
		$('#country').on('change',function(){
			var stateid    = $('#state').data('stateid');
			var Country_Id = $(this).val();
			var options    = "<option>--Select State--</option>";
			if(!Country_Id)
			{
				Swal.fire('Please Select Country.');
				return false;
			}
			$.ajax({
				url     : "<?php echo base_url('Ajax/get_states/')?>"+Country_Id,
				type    : 'POST',
				dataType: 'json',
				// data    : {param1: 'value1'},
				success: function(result)
				{
					if(result == 'no')
					{
						Swal.fire('Please Select Country.');
					}
					else if(result == 'nos')
					{
						Swal.fire('Threre are no states regarding the selected country');
					}
					else
					{
						$.each(result, function (index, val){
							options += "<option value='"+result[index].State_Id+"'>"+result[index].State_Name+"</option>"
						});
						$('#state').html(options);
						if(stateid)
						{
							$('#state').val(stateid);
						}
					}
				}
			})			
		});
		// end of adding country state on change
		datepickerBindHere();

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

		//Show Subenterprise on change of enterprise
		$('.Enterprise').on('change',function(){
			$this             = $(this);
			var option        = '<option value="">--Select SubEnterprise--</option>';
			var Enterprise_ID = $(this).val();
			if($(this).val())
			{ 
      	// triggering ajax to show the subenterprise linked with this enterprise
      	$.ajax({
      		url :"<?php echo base_url();?>Ajax/get_subenterprise/"+Enterprise_ID,
      		type: "POST",
      		success: function( result )
      		{
      			result = JSON.parse(result);
      			if(result.length > 0)
      			{
      				$(result).each(function(i,e)
      				{
      					option += ("<option value='"+result[i].SubEnterprise_ID+"'>"+result[i].SubEnterprise_Name+"</option>");
      				});
      				$this.parents('form').find('select.subenterprise').html(option);
      				option = '<option value="">--Select SubEnterprise--</option>';
            	// $('.SubEnterprise').html(option);
            }
            else
            {
            	$this.parents('form').find('select.subenterprise').html(option);
            	// Swal.fire('No SubEnterprise Associated With The Selected Enterprise');
            }
          },
        });          
      }
      else
      {
      	$this.parents('form').find('select.subenterprise').html(option);
      	Swal.fire('Please Select Enterprise...');
      	return false;
      }
    });

		// to manage allocate and de-allocate the games
		$('.allocateDeallocate').each(function(){
			$(this).on('click', function(){
				var gamedata  = $(this).data('gamedata');
				var startdate = $(this).prev().data('startdate');
				var enddate   = $(this).prev().data('enddate');
				// console.log(startdate+' and '+enddate);
				showPopup(gamedata,startdate,enddate);
			});
		});
		$('#select_all').click(function(i,e){
			if($(this).is(':checked'))
			{
				$('input[type=checkbox]').each(function(i,e){
					if($(this).is(":not(:disabled)"))
					{
						$(this).prop('checked',true);
					}
				});
			}
			else
			{
				$('input[type=checkbox]').each(function(i,e){
					if($(this).is(":not(:disabled)"))
					{
						$(this).prop('checked',false);
					}
				});
			}
		});
	});
	// document.ready function ends here

	function showPopup(gamedata,startdate,enddate)
	{
		// if logged-in as superAdmin then show 4 options to allocate/de-allocate games
		<?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
			Swal.fire({
				title: 'Allocate/De-Allocate Game To',
				html:
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('enterprise')+'" id="enterprise" class="btn btn-outline-primary">' +
				'Enterprise' +
				'</a><br/>' +
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('subEnterprise')+'" id="subEnterprise" class="btn btn-outline-info">' +
				'Subenterprise' +
				'</a><br/>' +
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('entErpriseUsers')+'" id="entErpriseUsers" class="btn btn-outline-warning">' +
				'Enterprise Users' +
				'</a><br/>' +
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('subEnterpriseUsers')+'" id="subEnterpriseUsers" class="btn btn-outline-dark">' +
				'Subenterprise Users' +
				'</a>',
				showConfirmButton: false,
				showCancelButton : true,
				cancelButtonColor: '#dc3545',
			})
		<?php } ?>
		// if logged-in as enterpruse then show 3 options to allocate/de-allocate games
		<?php if($this->session->userdata('loginData')['User_Role'] == 1){ ?>
			Swal.fire({
				title: 'Allocate/De-Allocate Game To',
				html:
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('entErpriseUsers')+'/'+btoa(startdate)+'/'+btoa(enddate)+'" id="entErpriseUsers" class="btn btn-outline-warning">' +
				'My Users' +
				'</a><br/>' +
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('subEnterprise')+'/'+btoa(startdate)+'/'+btoa(enddate)+'" id="subEnterprise" class="btn btn-outline-info">' +
				'Subenterprise' +
				'</a><br/>' +
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('subEnterpriseUsers')+'/'+btoa(startdate)+'/'+btoa(enddate)+'" id="subEnterpriseUsers" class="btn btn-outline-dark">' +
				'Subenterprise Users' +
				'</a>',
				showConfirmButton: false,
				showCancelButton : true,
				cancelButtonColor: '#dc3545',
			})
		<?php } ?>
		// if logged-in as subEnterprise then show 1 options to allocate/de-allocate games
		<?php if($this->session->userdata('loginData')['User_Role'] == 2){ ?>
			Swal.fire({
				title: 'Allocate/De-Allocate Game To',
				html:
				'<a href="<?php echo base_url('AllocateDeallocateGame/index/');?>'+gamedata+'/'+btoa('subEnterpriseUsers')+'/'+btoa(startdate)+'/'+btoa(enddate)+'" id="subEnterpriseUsers" class="btn btn-outline-dark">' +
				'My Users' +
				'</a>',
				showConfirmButton: false,
				showCancelButton : true,
				cancelButtonColor: '#dc3545',
			})
		<?php } ?>
	}

	// add datepicker here
	function datepickerBindHere()
	{
		$('.datepicker-here').each(function(i,e){
			var startDate   = new Date($(this).data('startdate')*1000);
			var endDate     = new Date($(this).data('enddate')*1000);
			var currentDate = new Date($(this).data('value')*1000);
			var selDate     = $(e).datepicker().data('datepicker');
			selDate.selectDate(currentDate);
			// console.log($(this).data('startdate')*1000+' '+$(this).data('enddate')*1000);
			$(this).datepicker({
				minDate    : startDate,
				maxDate    : endDate,
				autoClose  : true,
				clearButton: true,
				setDate    : new Date(),
				// todayButton: new Date(),
			});
		});
	}
	// datepicker ends here
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
		
		{
			extend: 'copy',
			footer: false
			
		},
		{
			extend: 'csv',
			footer: true,
			exportOptions: {
				columns: "thead th:not(.noExport)"
			}
		},
		// {
		// 	extend: 'pdf',
		// 	footer: true,
		// },
		{
			extend: 'print',
			footer: false
		},
		// {
		// 	extend: 'excel',
		// 	footer: false
		// }
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
</body>
</html>