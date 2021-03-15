<script type="text/javascript">
	<!--
	var loc_url_del = "ux-admin/ManageGame/del/";
	var loc_url_stat = "ux-admin/ManageGame/stat/";
	//
	-->
</script>

<style>
	.swal-size-sm {
		width: auto;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php if ($functionsObj->checkModuleAuth('game', 'add')) { ?>
				<a href="<?php echo site_root . "ux-admin/ManageGame/add/1"; ?>" data-toggle="tooltip" title="Add Game">
					<i class="fa fa-plus-circle"></i>
				</a>
			<?php } ?>
			Game
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class=""><a href="<?php echo site_root . "ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Game</li>
		</ul>
	</div>
</div>

<?php if (isset($msg)) {
	echo "<div class=\"form-group " . $type[1] . " \"><div align=\"center\" class=\"form-control\" id=" . $type[0] . "><label class=\"control-label\" for=" . $type[0] . ">" . $msg . "</label></div></div>";
} ?>
<form method="post" action="">
	<div class="row">
		<div class="col-md-6">
			<a id="HideDownloadIcon"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="Download Game"></i></a>
			<div id="downloadGame">
				<div class="row" id="sandbox-container">
					<div class="input-daterange input-group" id="datepicker">
						<input type="text" class="input-sm form-control" id="fromdate" name="fromdate" placeholder="Select Start Date" required readonly />
						<span class="input-group-addon">to</span>
						<input type="text" class="input-sm form-control" id="enddate" name="enddate" placeholder="Select End Date" required readonly />
					</div>
				</div>
				<br>
				<button type="submit" name="download_excel" id="download_excel" class="btn btn-primary" value="Download"> Download </button>
			</div>

		</div>
		<div class="col-md-6">
			<div class="col-sm-12">
				<div class="pull-right legend">
					<ul>
						<li><b>Legend : </b></li>
						<li> <span class="glyphicon glyphicon-ok"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active </a></li>
						<li> <span class="glyphicon glyphicon-remove"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive </a></li>
						<!--<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>-->
						<li> <span class="glyphicon glyphicon-pencil"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit </a></li>
						<li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
						<li> <span class="fa fa-book"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Content"> General </a></li>
						<li> <span class="fa fa-file-o"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Document"> Document </a></li>
						<li> <span class="fa fa-image"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Image"> Image </a></li>
						<li> <span class="fa fa-video-camera"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Video"> Video </a></li>
						<li> <span class="fa fa-thumbs-o-up"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Game Completed"> Completed </a></li>
						<li> <span class="fa fa-thumbs-o-down"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Game In Progress"> Not Completed </a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</form>
<br>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Games List</label>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<!-- <table class="table table-striped table-bordered table-hover" id="dataTables-example"> -->
				<table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root . 'ux-admin/model/ajax/dataTables.php'; ?>" data-action="listgame">
					<thead>
						<tr>
							<th>#</th>
							<th>ID</th>
							<th>Name</th>
							<th>Comments</th>
							<th>Header</th>
							<th>Type</th>
							<!-- <th>Mobile</th> -->
							<th>Introduction</th>
							<th>Introduction Link</th>
							<th>Description</th>
							<th>Description Link</th>
							<th>Back To Intro Link</th>
							<th>Game Image</th>
							<th class="no-sort">Upload Option</th>
							<th>Creator/Status</th>
							<th class="no-sort">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<script>

	function preventEdit(element)
	{
		// if game is completed then don't allow user to edit, only active/deactive/delete will be allowed
		if ($(element).attr('href') == 'javascript:void(0);') {
			Swal.fire({
				icon: 'error',
				title: '',
				html: 'This game is completed. So, editing is not allowed.',
				// position: 'tpo corner',
				timer: 2000,
			});
		}
	}
	function notAllowToComplete(element)
	{
		// if user is not the creator then don't allow to complete
		Swal.fire('Only (' + $(element).data('cancomplete') + ') or superadmin can change the status of this game as complete.');
	}

	function game_progress(element)
	{
		var creator = $(element).data('cancomplete')
		var eid = $(element).attr('id').split('_');
		var Game_ID = eid[1];
		var scenbranching = ($(element).data('scenbranching')) ? $(element).data('scenbranching') : '';
		if (scenbranching > 2) {
			var textMsg = "You won't be able to make any changes to this game, after you complete!<br><a onclick='return checkScenarioBranching(" + Game_ID + ")'; href='javascript:void(0);' id='scenarioBranching_" + Game_ID + "'>Check Scenario Branching</a>";
		} else {
			var textMsg = "You won't be able to make any changes to this game, after you complete!";
		}
		confirmAndTriggerAjax(Game_ID, 1, textMsg, creator);
	}

	function game_complete(element)
	{
		var Game_ID = $(element).data('gameid');
		var createdby = $(element).data('createdby');
		var creator = $(element).data('creator');
		var completedby = $(element).data('completedby');
		var scenbranching = ($(element).data('scenbranching')) ? $(element).data('scenbranching') : '';
		if (scenbranching > 2) {
			var textMsg = "This game was completed by " + completedby + ". Do you really want to make it incomplete?<br><a onclick='return checkScenarioBranching(" + Game_ID + ")'; href='javascript:void(0);' id='scenarioBranching_" + Game_ID + "'>Check Scenario Branching</a>";
		} else {
			var textMsg = "This game was completed by " + completedby + ". Do you really want to make it incomplete?"
		}

		// console.log(createdby+' '+creator+' '+completedby);
		if (creator == <?php echo $_SESSION['ux-admin-id']; ?> || <?php echo $_SESSION['ux-admin-id']; ?> == 1) {
			// if creator or super admin, then only allow to change the status to incomplete
			confirmAndTriggerAjax(Game_ID, 0, textMsg, creator);
		} else {
			Swal.fire('Completed By:- ' + $(element).data('completedby') + '<br>Completed On:- ' + $(element).data('completedon'));
		}
	}

	function changeStatus(gameid, status) {
		var ajaxUrl = "<?php echo site_root; ?>ux-admin/model/ajax/update_game_link.php";
		Swal.fire({
			icon: 'question',
			title: 'Confirmation',
			html: "Are you sure want to change status?",
			showCancelButton: true,
		}).then((result) => {
			if (result.value) {
				var changeStatus = triggerAjax(ajaxUrl, "action=changeStatus&Game_ID=" + gameid + "&Game_Delete=" + status, "show");
				$('#dataTables-serverSide').DataTable().ajax.reload();
			}
		});
	}

	function confirmAndTriggerAjax(Game_ID, gameStatus, textMsg, creator) {
		Swal.fire({
			title: 'Are you sure?',
			html: textMsg,
			icon: 'question',
			showCancelButton: true,
			showCloseButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Proceed!',
			cancelButtonText: 'No, Cancel!',
			footer: "<b>Creator: <code>" + creator + "</code></b>"
		}).then((result) => {
			if (result.value) {
				// trigger ajax to change the status to mark as complted
				$.ajax({
					type: "POST",
					dataType: "json",
					data: {
						'Game_Complete': 'updateStatus',
						'Game_ID': Game_ID,
						'gameStatus': gameStatus
					},
					url: "<?php echo site_root; ?>ux-admin/model/ajax/update_game_link.php",
					success: function(result) {
						if (result.status == 200) {
							Swal.fire(
								'Success!',
								result.message,
								'success'
							)
							$('#dataTables-serverSide').DataTable().ajax.reload();
						} else {
							Swal.fire(result.message);
						}
					},
					error: function(jqXHR, exception) {
						{
							Swal.fire(jqXHR.responseText);
						}
					}
				});
			}
		})
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
          Swal.fire({
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
            }
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

	function checkScenarioBranching(Game_ID) {
		// triggering ajax to check the scenario branching for the game exist or not if yes then show branching
		$.ajax({
			type: "POST",
			dataType: "json",
			data: {
				'branchingStatus': 'branchingStatus',
				'Game_ID': Game_ID
			},
			url: "<?php echo site_root; ?>ux-admin/model/ajax/update_game_link.php",
			success: function(result) {
				if (result.status == 200) {
					Swal.fire({
						title: 'Check Scenario Branching For {' + result.gamename + '}',
						html: result.message,
						icon: 'success',
						showConfirmButton: false,
						showCancelButton: true,
						showCloseButton: true,
						// confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						customClass: 'swal-size-sm',
						// confirmButtonText : 'Yes, Proceed!',
						cancelButtonText  : 'Close',
						// footer            : "<b>Creator: "+creator+"</b>",
					});
				} else {
					console.log('no scenario branching found for the games');
					console.log(result);
				}
			},
			error: function(jqXHR, exception) {
				{
					Swal.fire(jqXHR.responseText);
				}
			}
		});
	}
</script>