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
<script src="<?php echo base_url('common/vendors/scripts/script.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/jquery.dataTables.min.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/dataTables.bootstrap4.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/dataTables.responsive.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/responsive.bootstrap4.js?v=').file_version_cs;?>"></script>
<!-- buttons for Export datatable -->
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/dataTables.buttons.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/buttons.bootstrap4.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/buttons.print.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/buttons.html5.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/buttons.flash.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/pdfmake.min.js?v=').file_version_cs;?>"></script>
<script src="<?php echo base_url('common/src/plugins/datatables/media/js/button/vfs_fonts.js?v=').file_version_cs;?>">
</script>
<script src="<?php echo base_url('common/vendors/bootgrid/');?>jquery.bootgrid.min.js"></script>
<script src="<?php echo base_url('common/');?>src/plugins/highcharts-6.0.7/code/highcharts.js"></script>
<script src="<?php echo base_url('common/');?>src/plugins/highcharts-6.0.7/code/highcharts-more.js"></script>
<!-- datepicker js -->
<script src="<?php echo base_url('common/');?>datetimePicker/js/datepicker.min.js"></script>
<!-- Include English language -->
<script src="<?php echo base_url('common/');?>datetimePicker/js/i18n/datepicker.en.js"></script>
<!-- Show datatable -->
<script type="text/javascript">
	$(document).ready(function()
	{
		makeTableDataTable();

		$(document).ajaxStart(function(){
			$('[data-toggle="tooltip"]').tooltip('hide');
		});

		$(document).ajaxComplete(function(){
			$('[data-toggle="tooltip"]').tooltip();
			selectAll();
		});

		// only if user is logged in then only check
		<?php if($this->session->userdata('loginData') != NULL){ ?>
			// if user clicks on everyWhere in dom, page then check that user is logged in or not
			$(document).on('click',function(e){
				var loginStatus = triggerAjax("<?php echo base_url('Ajax/checkLoginStatus'); ?>",'');
				// console.log(loginStatus);
				if(loginStatus.length<1)
				{
					window.location.reload();
				}
				// toggleIcons();
				// deleteRow();
			});
		<?php } ?>
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

		selectAll();
		toggleIcons();
		deleteRow();
	});
	// document.ready function ends here

	function selectAll()
	{
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
	}
	// to show hide edit/save icon accordingly
	function toggleIcons()
	{
		//editIcon saveIcon
		$('.data-table-export').on('click', '.editIcon', function(){
			var pid              = $(this).data('pid');
			var callFunction     = $(this).data('function');
			$(this).toggleClass('d-none');
			// $('.saveIcon').addClass('d-none');
			$('#'+pid+'__save').removeClass('d-none');
			// if function exist then call this function
			makeEditable(pid,'edit',callFunction);
		});
		// $('.saveIcon').on('click', function(){
			$('.data-table-export').on('click', '.saveIcon', function(){
				var pid              = $(this).data('pid');
				var callFunction     = $(this).data('function');
				$(this).toggleClass('d-none');
			// $('.editIcon').addClass('d-none');
			$('#'+pid+'__edit').removeClass('d-none');
			// if function exist then call this function
			makeEditable(pid,'save',callFunction);
		});
		}

	// make html element editable
	function makeEditable(id,action,callNextFunction)
	{
		// action can be of edit or save, this will set the inline-edit border and editable option true or false
		if(action == 'save')
		{
			// console.log($('#parent__'+id).find('.editable').length);
			$('#parent__'+id).find('.editable').each(function(){
				$(this).attr('contenteditable',false);
				$(this).css({'border':'none'});
			});
			eval(callNextFunction+"("+id+", '<?php echo base_url('Ajax/');?>"+callNextFunction+"')");
		}

		if(action == 'edit') 
		{
			// console.log($('#parent__'+id).find('.editable').length+' and '+id);
			$('#parent__'+id).find('.editable').each(function(){
				$(this).attr('contenteditable',true);
				$(this).css({"border-color": "#dc3545", "border-width":"1px", "border-style":"solid", "max-width":"100px", "white-space":"pre-wrap"});
			});
		}
	}

	function appendCompetencyGameComponentSubcomponent(selectedCompSubcomps)
	{
		// console.log(selectedCompSubcomps);
		$('#Cmap_GameId').on('change', function(){
			var game_selected  = $(this).val();
			var waitStringText = "Please Wait While Loading Selected Game Components/Subcomponents";
			if(game_selected.length < 1)
			{
				// select game
				$('#addCompSubcompOfGame').html('<span class="text-danger text-center">Please Select Game To Select Components/Subcomponents</span>');
			}
			else
			{
				// show some wait text to users
				$('#addCompSubcompOfGame').html('<span class="text-success text-center">'+waitStringText+'</span>');
				// tirgger ajax and get the o/p comp and subcomponent which are visible
				var formData = $('#competencyMappingForm').serialize();
				// selectedCompSubcomps argument will be passed only when editing, comes from backend
				var compSubcompOfGame = triggerAjax("<?php echo base_url('Ajax/compSubcompCheckboxes/');?>"+selectedCompSubcomps,formData);
				// console.log(compSubcompOfGame);
				if(compSubcompOfGame.status == 201)
				{
					Swal.fire({
						position         : compSubcompOfGame.position,
						icon             : compSubcompOfGame.icon,
						title            : compSubcompOfGame.title,
						html             : compSubcompOfGame.message,
						showConfirmButton: compSubcompOfGame.showConfirmButton,
						timer            : compSubcompOfGame.timer,
					});
				}
				else
				{
					$('#addCompSubcompOfGame').html(compSubcompOfGame.data);
					$('[data-toggle="tooltip"]').tooltip();
				}
			}
		});
	}

	// this function will edit/update the competency data
	function editCompetency(parentid, url)
	{
		var ajaxData = {};
		// dataid is nothing but the parent_id which children are editable, so take data(text) of it
		// console.log(parentid+' and '+url); // 1_Compt_Name 1_Compt_Description
		ajaxData['Compt_Id'] = parentid;
		$('#parent__'+parentid).find('.editable').each(function(){
			var td_id = $(this).attr('id').split('__');
			ajaxData[td_id[1]] = $(this).text();
		});
		// console.log(decodeURIComponent($.param(ajaxData)));
		var result = triggerAjax(url,ajaxData);
		Swal.fire({
			position         : result.position,
			icon             : result.icon,
			title            : result.title,
			html             : result.message,
			showConfirmButton: result.showConfirmButton,
			timer            : result.timer,
		});
		listCompetency();
	}

	function listCompetency()
	{
		var table          = '<table class="stripe hover multiple-select-row data-table-export nowrap">';
		var tableHead      = '<thead><tr><th>ID</th><th>Enterprise</th><th>Name</th><th>Description</th><th class="datatable-nosort noExport">Action</th></tr></thead>';
		var tableBody      = '<tbody>';
		var ajaxWhere      = {'Compt_Delete':'0'};
		var competencyList = triggerAjax("<?php echo base_url('Ajax/listItems'); ?>",ajaxWhere);
		// Swal.fire({
		// 	position         : competencyList.position,
		// 	icon             : competencyList.icon,
		// 	title            : competencyList.title,
		// 	html             : competencyList.message,
		// 	showConfirmButton: competencyList.showConfirmButton,
		// 	timer            : competencyList.timer,
		// });
		// console.log(competencyList);
		if(competencyList.status == 200)
		{			
			$.each(competencyList.data, function(i,e){
				if(competencyList.data[i].Compt_Description.length < 1)
				{
					competencyList.data[i].Compt_Description = '<span class="text-danger">No Description</span>';
				}

				tableBody += '<tr id="parent__'+competencyList.data[i].Compt_Id+'"> <td>'+eval(i+1)+'</td> <td>'+competencyList.data[i].Enterprise_Name+'</td> <td id="'+competencyList.data[i].Compt_Id+'__Compt_Name" class="editable">'+competencyList.data[i].Compt_Name+'</td> <td id="'+competencyList.data[i].Compt_Id+'__Compt_Description" class="editable">'+competencyList.data[i].Compt_Description+'</td> <td><a href="javascript:void(0);" data-function="editCompetency" data-toggle="tooltip" title="Edit" data-pid="'+competencyList.data[i].Compt_Id+'" class="editIcon" id="'+competencyList.data[i].Compt_Id+'__edit"> <i class="fa fa-pencil"></i> </a> <a href="javascript:void(0);" data-function="editCompetency" data-toggle="tooltip" title="Save" data-pid="'+competencyList.data[i].Compt_Id+'" class="saveIcon d-none" id="'+competencyList.data[i].Compt_Id+'__save"> <i class="fa fa-save"></i> </a>&nbsp;<a href="javascript:void(0);" data-col_table="Compt_Delete__items__Compt_Id__listCompetency" data-toggle="tooltip" title="Delete" data-pid="'+competencyList.data[i].Compt_Id+'" class="deleteIcon"> <i class="fa fa-trash"></i> </a></td></tr>'
			});
			table += tableHead+tableBody+'</tbody>'+'</table>';
			$('#addTable').html(table);
			// console.log(table);
		}
		else
		{
			table += tableHead+'<tbody><tr><td class="text-danger text-center" colspan="4"> No Record Found </td></tr></tbody>'+'</table>';
			$('#addTable').html(table);
		}
		makeTableDataTable();
		toggleIcons();
		deleteRow();
	}

	// triggering ajax to fetch/modify data
	function triggerAjax(url,data)
	{
		var returnResult = '';
		$.ajax({
			type    : "POST",
			dataType: "json",
			data    : data,
			url     : url,
			async   : false,
			beforeSend: function() {
				// $('.pre-loader').show();
			},
			success: function(result) 
			{
				// console.log(result);
				returnResult = result;
			},
			error: function(jqXHR, exception)
			{
				{
					// $('.pre-loader').hide();
					// Swal.fire({
					// 	icon: 'error',
					// 	html: jqXHR.responseText,
					// });
					console.log(jqXHR.responseText);
					$("#input_loader").html('');
				}
			}

		});
		return returnResult;
	}

	// to delete the record
	function deleteRow()
	{
		// $('.deleteIcon').on('click', function(){
			$('.data-table-export').on('click', '.deleteIcon', function(){
			// show alert message, before proceeding
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value){
					// this is valid for all the purpose,
					var ajaxWhere         = {};
					var pid               = $(this).data('pid');
					// dataColTable = Compt_Delete__competency__Compt_Id__listCompetency , // this is nothing but updateColName__tableName__whereColName__nextExecutableFunctionName
					var dataColTable      = $(this).data('col_table').split('__');
					var dataCol           = dataColTable[0];
					var tableName         = dataColTable[1];
					var primaryCol        = dataColTable[2];
					var executeFunction   = dataColTable[3];
					ajaxWhere[primaryCol] = pid;
					var deleteRecord      = triggerAjax("<?php echo base_url('Ajax/deleteRecords/'); ?>"+tableName+"/"+dataCol,ajaxWhere);
					// console.log(deleteRecord);
					Swal.fire({
						position         : deleteRecord.position,
						icon             : deleteRecord.icon,
						title            : deleteRecord.title,
						html             : deleteRecord.message,
						showConfirmButton: deleteRecord.showConfirmButton,
						timer            : deleteRecord.timer,
					});
					eval(executeFunction+'()');
				}
			})
		});
		}

	// adding function to download completed games report
	function downloadCompletedGamesReport(userid)
	{
		if(!userid)
		{
			Swal.fire({
				icon: error,
				title: 'Error',
				text: 'Please select atleast one user to get report'
			});
			return false;
		}
		// trigger ajax to get the completed game data and create dialog for checkboxes
		$.ajax({
			url     : "<?php echo base_url('Ajax/getCompletedGames/')?>"+userid,
			type    : 'POST',
			success: function(result)
			{
				// console.log(result);
				var result = JSON.parse(result);
				if(result.status == 200)
				{
					Swal.fire({
						// icon : result.icon,
						title            : result.title,
						html             : result.message,
						showConfirmButton: false,
					});
				}
				else
				{
					Swal.fire({
						icon : result.icon,
						title: result.title,
						html : result.message,
						showClass: {
							popup: 'animated zoomInUp faster'
						},
						hideClass: {
							popup: 'animated zoomOutUp faster'
						}
					});
				}
			}
		})
	}

	function getCompleteReport(element,event)
	{
		Swal.close(); event.preventDefault(); console.log('form submitted');

		var formData = $('#completedGamesForm').serialize();
		$.ajax({
			url : "<?php echo base_url('Ajax/downloadCompletedGamesReport/')?>",
			type: 'POST',
			data: formData,
			success: function(result)
			{
				// console.log(result);
				var result = JSON.parse(result);
				if(result.status == 200)
				{
					// Swal.fire({
					// 	icon             : result.icon,
					// 	title            : result.title,
					// 	html             : result.message,
					// 	showConfirmButton: false,
					// });
					// download csv report here, and remove above alert
					var csvData = '';
					$.each(result.data,function(i,e){
						// console.log(result.data[i]['comp_subcomp']);
						csvData += '"'+result.data[i]['comp_subcomp']+'";'+result.data[i]['inputValue']+';'+result.data[i]['gameName']+';\n';
					});


					var createDownloadLink = document.createElement("a");
					var fileData           = ['\ufeff'+csvData];
					var blobObject         = new Blob(fileData,{
						type: "text/csv;charset=utf-8;"
					});

					var url                     = URL.createObjectURL(blobObject);
					createDownloadLink.href     = url;
					createDownloadLink.download = "consolidatedReport_<?php echo date('d-m-Y');?>.csv";
					document.body.appendChild(createDownloadLink);
					createDownloadLink.click();
					document.body.removeChild(createDownloadLink);
				}
				else
				{
					Swal.fire({
						icon : result.icon,
						title: result.title,
						html : result.message,
						showClass: {
							popup: 'animated zoomInUp faster'
						},
						hideClass: {
							popup: 'animated zoomOutUp faster'
						}
					});
				}
			}
		})
	}
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

	// this function will provide delay
	function sleep(milliseconds, returnString) {
		const date = Date.now();
		let currentDate = null;
		do {
			currentDate = Date.now();
		} while (currentDate - date < milliseconds){ console.log('printing delay value '+returnString);}
	}

	function makeTableDataTable()
	{
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
	}
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