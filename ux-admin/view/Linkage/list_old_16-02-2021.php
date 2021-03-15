<style>
	.swal-size-sm {
		width: auto;
	}
</style>
<script type="text/javascript">
	<!--
	var loc_url_del = "ux-admin/linkage/del/";
	var loc_url_stat = "ux-admin/linkage/stat/";
	// -->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php if ($functionsObj->checkModuleAuth('linkage', 'add')) { ?>
				<a href="<?php echo site_root . "ux-admin/linkage/add/1"; ?>" data-toggle="tooltip" title="Add Linkage">
					<i class="fa fa-plus-circle"></i>
				</a>
			<?php } ?>
			Linkage
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root . "ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Linkage</li>
		</ul>
	</div>
</div>

<?php if (isset($msg)) {
	echo "<div class=\"form-group " . $type[1] . " \"><div align=\"center\" class=\"form-control\" id=" . $type[0] . "><label class=\"control-label\" for=" . $type[0] . ">" . $msg . "</label></div></div>";
} ?>

<div class="row">
	<div class="col-lg-12">
		<div class="pull-right legend">
			<ul>
				<li><b>Legend : </b></li>
				<li> <span class="glyphicon glyphicon-ok"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active </a></li>
				<li> <span class="glyphicon glyphicon-remove"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive </a></li>
				<li> <span class="glyphicon glyphicon-search"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View </a></li>
				<li> <span class="glyphicon glyphicon-pencil"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit </a></li>
				<li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
				<li> <span class="fa fa-code-fork"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Component Branching"> Branching </a></li>
				<li> <span class="fa fa-save"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Manual Save Enabled"> Manual Save Button </a></li>
				<li> <span class="fa fa-bell"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Skip Confirmation Alert For I/P Page Submit"> Skip Submit Alert </a></li>
				<li> <span class="fa fa-paper-plane"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This will auto Submit O/P Page"> Skip Output </a></li>
				<li> <span class="fa fa-font"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Change submit button text for I/P and O/P page"> Button Text </a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Linkage List</label>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<?php // echo "<pre>"; print_r($object->fetch_object()); exit(); 
				?>
				<table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root . 'ux-admin/model/ajax/dataTables.php'; ?>" data-action="getlinkage">
					<thead>
						<tr>
							<th>#</th>
							<th>Game</th>
							<th>Scenario</th>
							<th>Order</th>
							<th>Introduction</th>
							<th>Introduction Link</th>
							<th>Description</th>
							<th>Description Link</th>
							<th>Back To Intro</th>
							<th>Creator/Status</th>
							<th class="no-sort text-center">Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<script>
	$(document).ready(function() {
		var effectIn = animateInArray[countInclick];
		var effectOut = animateOutArray[countOutclick];
		$("a").each(function() {
			var gamedata = $(this).data('gamedata');
			if (typeof gamedata !== typeof undefined && gamedata !== false) {
				$(this).unbind('click');
				$(this).attr('href', 'javascript:void(0);');
				$(this).on('click', function(e) {
					e.preventDefault();
					Swal.fire({
						icon: 'error',
						title: 'Game Comments',
						html: $(this).data('gamedata'),
						showClass: {
							popup: 'animated ' + effectIn + ' faster'
						},
						hideClass: {
							popup: 'animated ' + effectOut + ' faster'
						}
					});
					// console.log(gamedata+' and '+ typeof gamedata)
					countInclick++;
					countOutclick++;
					countInclick = (countInclick == animateInArray.length) ? 0 : countInclick;
					countOutclick = (countOutclick == animateOutArray.length) ? 0 : countOutclick;
					return false;
				});
			}
		});

	});

	function changeButtonText(element) {
		// to change the input, output button text and description , introduction button text and color 
		var linkid = $(element).data('linkid');
		var formData = {};

    // input button 
		let inputdefaultvalue       = $(element).data('inputdefaultvalue');
    let inputbuttonactionvalue  = $(element).data('inputbuttonactionvalue');
    // output button 
    let outputdefaultvalue      = $(element).data('outputdefaultvalue');
    let outputbuttonactionvalue = $(element).data('outputbuttonactionvalue');
    // introduction button 
    let introductionbuttontext  = $(element).data('introductionbuttontext');
    let introductionbuttoncolor = $(element).data('introductionbuttoncolor');
    // description button 
    let descriptionbuttontext   = $(element).data('descriptionbuttontext');
    let descriptionbuttoncolor  = $(element).data('descriptionbuttoncolor');


    // selecting dropdown
    // buttonAction -> 1-Show Side Button, 2-Show Bottom Button, 3-Remove Both Buttons
    let selectInput1 = '';
    let selectInput2 = '';
    let selectInput3 = '';
    
    if (Number(inputbuttonactionvalue) == 1) {
      selectInput1 += 'selected';
    }
    else if (Number(inputbuttonactionvalue) == 3) {
      selectInput3 += 'selected';
    }
    else {
      selectInput2 += 'selected';
    }

    // buttonActionOutput -> 1-Show Side Button, 2-Show Bottom Button
    let selectOutput1 = ' ';
    let selectOutput2 = ' ';
    if (Number(outputbuttonactionvalue) == 1) {
      selectOutput1 += 'selected';
    }
    else {
      selectOutput2 += 'selected';
    }

		Swal.fire({
			// title: 'Enter button text below',
			confirmButtonText: 'Update',
			showCancelButton: true,

      html: "<form id='buttonForm' name='buttonForm'> <div class='col-auto'> <label>Select Input Button Action<code>*</code></label>  <select class='form-control' name='buttonAction' id='buttonAction' required> <option value='1' "+ selectInput1 +">Show Side Button</option> <option value='2' "+ selectInput2 +">Show Bottom Button</option> <option value='3' "+ selectInput3 +">Remove Both Buttons</option> </select> </div><br> <label>Input Button Text<code>*</code></label> <input type='text' name='inputbuttontext' id='inputbuttontext' class='form-control' placeholder='Input button text' required value='"+ inputdefaultvalue +"'><br> <div class='col-auto'> <label>Select Output Button Action<code>*</code></label>  <select class='form-control' name='buttonActionOutput' id='buttonActionOutput' required> <option value='1' "+ selectOutput1 +">Show Side Button</option> <option value='2' "+ selectOutput2 +">Show Bottom Button</option> </select> </div><br> <label>Output Button Text<code>*</code></label> <input type='text' name='outputbuttontext' id='outputbuttontext' class='form-control' placeholder='Output button text' required value='"+ outputdefaultvalue +"'><br /> <label>Introduction Button Text<code>*</code></label> <input type='text' name='introductionbuttontext' id='introductionbuttontext' class='form-control' placeholder='Output button text' required value='"+ introductionbuttontext +"'><br /> <label>Introduction Button Color<code>*</code></label> <input type='text' name='introductionbuttoncolorcode' id='introductionbuttoncolorcode' class='form-control' placeholder='Output button text' required value='"+ introductionbuttoncolor +"'><br /> <label>Description Button Text<code>*</code></label> <input type='text' name='descriptionbuttontext' id='descriptionbuttontext' class='form-control' placeholder='Output button text' required value='"+ descriptionbuttontext +"'><br /> <label>Description Button Color<code>*</code></label> <input type='text' name='descriptionbuttoncolorcode' id='descriptionbuttoncolorcode' class='form-control' placeholder='Output button text' required value='"+ descriptionbuttoncolor +"'><br /><input type='hidden' name='linkid' id='linkid' value='"+ linkid +"'> <input type='hidden' name='action' id='action' value='updateButtonText'> </form>",

			preConfirm: function() {
				// console.log($('#inputbuttontext').val()); console.log($('#outputbuttontext').val());
				// return [$('#inputbuttontext').val()+', '+$('#outputbuttontext').val()];
				// formData['input'] = $('#inputbuttontext').val();
				// formData['output'] = $('#inputbuttontext').val();
				return $('#buttonForm').serialize();
			}
		}).then(function(fieldData) {
			if (fieldData.value == undefined) {
				// console.log('cancel');
				return 'cancel';
			}
			// console.log(fieldData.value); console.log(JSON.stringify(fieldData.value));
			return fetch('<?php echo site_root . 'ux-admin/model/ajax/ScenarioBranching.php'; ?>', {
				method: 'POST',
				async: false,
				headers: {
					'Content-Type': "application/x-www-form-urlencoded",
					// 'Content-Type': "text/html; charset=UTF-8",
					// 'Content-Type': "application/json",
					// 'Accept': "application/json",
				},
				body: fieldData.value,
			})
		}).then(function(response) {
			if (response == 'cancel') {
				return 'cancel';
			} else {
				return response.json();
			}
		}).then((result) => {
			// console.log(result);
			if (result == 'cancel') {
				return '';
			} else {
				Swal.fire({
					icon: result.icon,
					html: result.statusText
				});
				// if (result.code == 200) {
				// 	$(element).data('inputdefaultvalue', result.inputdefaultvalue);
				// 	$(element).data('outputdefaultvalue', result.outputdefaultvalue);
				// }
        $('#dataTables-serverSide').DataTable().ajax.reload();
			}
		});
	}

	function showJsMapping(element) {
		console.log(element);
		var formData = "action=fetchScenarioJsMapping&Js_LinkId=" + $(element).data('linkid');
		var showMapping = triggerAjax("<?php echo site_root . 'ux-admin/model/ajax/gameAddMapping.php'; ?>", formData, 'show');
	}

	function triggerAjax(url, data, showAlert) {
		// console.log(showAlert); console.log(url); console.log(data); return false; // triggering ajax for various operations
		var returnResult = [];
		fetch(url, {
			method: 'post',
			headers: {
				'Accept': 'application/json, text/plain, */*',
				"Content-type": "application/x-www-form-urlencoded;"
				// "Content-type": "application/json;"
			},
			body: data,
		}).then(function(response) {
			return response.json();
		}).then(function(result) {
			// show returned response here
			if (showAlert == 'show') {
				if (result.status == 200) {
					const swalWithBootstrapButtons = Swal.mixin({
						customClass: {
							confirmButton: 'btn btn-success',
							cancelButton: 'btn btn-danger',
							popup: 'swal-size-sm',
						},
						buttonsStyling: false,
					});
					swalWithBootstrapButtons.fire({
						icon: result.icon,
						html: result.msg,
						position: result.position,
						timer: result.timer,
						showConfirmButton: false,
						showClass: {
							popup: result.showclass
						},
						hideClass: {
							popup: result.hideclass
						},
						showCancelButton: true,
					});
				} else {
					alert(result.msg);
				}
			} else if (showAlert == 'return') {
				returnResult.push(result);
			} else {
				console.log(result);
			}
			$('#dataTables-serverSide').DataTable().ajax.reload();
		}).catch(function(err) {
			console.log('Fetch Error :-S', err);
		});
		return returnResult;
	}
</script>