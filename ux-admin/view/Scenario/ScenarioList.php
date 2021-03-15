<script type="text/javascript">
	<!--
	var loc_url_del = "ux-admin/ManageScenario/del/";
	var loc_url_stat = "ux-admin/ManageScenario/stat/";
	//
	-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php if ($functionsObj->checkModuleAuth('scenario', 'add')) { ?>
				<a href="<?php echo site_root . "ux-admin/ManageScenario/add/1"; ?>" data-toggle="tooltip" title="Add Scenario">
					<i class="fa fa-plus-circle"></i>
				</a>
			<?php } ?>
			Scenario
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root . "ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Scenario</li>
		</ul>
	</div>
</div>

<?php if (isset($msg)) {
	echo "<div class=\"form-group " . $type[1] . " \"><div align=\"center\" class=\"form-control\" id=" . $type[0] . "><label class=\"control-label\" for=" . $type[0] . ">" . $msg . "</label></div></div>";
} ?>
<form method="post" action="">
	<div class="row">
		<div class="col-md-6">

			<a id="HideDownloadIcon"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="Download Scenario"></i></a>
			<div id="downloadScenario">
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
						<li> <span class="fa fa-code-fork"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Component Branching"> Branching </a></li>
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
			<label style="padding-top:7px;">Scenarios List</label>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root . 'ux-admin/model/ajax/dataTables.php'; ?>" data-action="listScenario">
					<thead>
						<tr>
							<th>#</th>
							<th class="no-sort">ID</th>
							<th>Name</th>
							<th>Comments</th>
							<th>Header</th>
							<th class="no-sort">Upload Option</th>
							<th>I/P Button Status</th>
							<th>Background Image</th>
							<th class="no-sort">Action</th>
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