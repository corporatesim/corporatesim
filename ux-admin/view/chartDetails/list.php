<script type="text/javascript">
<!--
	var loc_url_del  = "ux-admin/addChartDetails/del/";
	var loc_url_stat = "ux-admin/addChartDetails/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Chart List</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Chart List</li>			
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-lg-12">
		<div class="pull-right legend">
			<ul>
				<li><b>Legend : </b></li>
				<li data-toggle="tooltip" title="Edit"><span class="glyphicon glyphicon-pencil"> </span><a href="javascript:void(0);"> Edit </a></li>
				<li data-toggle="tooltip" title="Delete"><span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);"> Delete </a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Chart List</label>
			<div class="pull-right">
				<input class="btn btn-primary" type="button" name="addlink" value="Add Chart List"
					onclick="window.location.href='<?php echo site_root."ux-admin/addChartDetails/add/1"; ?>';"/>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
					    <tr>
							<th>#</th>
							<th>Title</th>
				      		<th>Name</th>
				      		<th>Value</th>
				      		<th>Modify Status</th>
				      		<th class="no-sort">Action</th>
				    	</tr>
			    	</thead>
			    	<tbody>
						<?php 
							$i=1; while($row = $object->fetch_object()){ ?>
							<tr>
								<th><?php echo $i;?></th>
								<td><?php echo $row->Title_Name; ?></td>
								<td><?php echo ucfirst($row->List_Name)?></td>
								<td><?php echo $row->List_Value;?></td>
								<td><?php echo ($row->List_UpdatedOn == '')?'Not Yet':$row->List_UpdatedOn;?></td>
								
								<td class="text-center">
									<a data-toggle="tooltip" href="<?php echo site_root."ux-admin/addChartDetails/edit/".$row->List_ID; ?>"
										title="Edit"><span class="fa fa-pencil"></span></a>
										&nbsp;
									<a data-toggle="tooltip" href="javascript:void(0);" class="dl_btn" id="<?php echo $row->List_ID; ?>"
										title="Delete"><span class="fa fa-trash"></span></a>
								</td>
							</tr>
						<?php $i++; } ?>
					</tbody>
			    </table>
			</div>
		</div>
    </div>
</div>
<div class="clearfix"></div>