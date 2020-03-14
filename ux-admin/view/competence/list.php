<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/manageCompetence/del/";
		var loc_url_stat = "ux-admin/manageCompetence/stat/";
  //-->
</script>
<style>
	<!--
	.dropdown-menu > li > button {
		display    : block;
		padding    : 3px 20px;
		clear      : both;
		font-weight: 400;
		line-height: 1.42857143;
		color      : #ffffff;
		white-space: nowrap;
	}
	#contact
	{
		width: auto!important;
	}
	#password
	{
		width: auto!important;
	}
	#action
	{
		width: 70px!important;
	}
	.drop_down{
		padding: 0 5px !important;
	}

	#upload-file-selector {
		display:none;
	}
	.margin-correction {
		margin-right: 10px;
	}

	@media screen and ( min-width: '361px' ){
		.resp_pull_right{
			float: right;
		}
	}

	@media screen and ( max-width: '360px' ){
		.resp_pull_right{
			float     : none;
			text-align: center;
			width     : 100%;
			padding   : 0 15px;
		}
	}
	-->
	#update-file-selector {
		display:none;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Compentency</h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active">Manage Compentency</li>
			</ul>
		</div>
	</div>
	<?php if(isset($msg)){echo "<div class=\"form-group alert-dismissible alert ". $type[1] ." \"><a href='#' class='close' data-dismiss='alert' arial-label='close' style='right:1%; top:5px;'>&times;</a><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="pull-right legend">
				<ul>
					<li><b>Legend : </b></li>
					<!-- <li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li> -->
					<!-- <li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li> -->
					<!-- <li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li> -->
					<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="You Can Edit the Record"> Edit		</a></li>
					<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="You Can Delete the Record"> Delete	</a></li>
					<!-- <li> <span class="glyphicon glyphicon-refresh">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User can replay the Game"> Replay	</a></li> -->
					<!-- <li> <span class="glyphicon glyphicon-ban-circle">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User games have been disabled"> Disable	</a></li> -->
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-default" id="loader">
			<div class="panel-heading">
				<label style="padding-top:7px;">Compentency List</label>
				<div class="pull-right">
					<a class="btn btn-primary" href="<?php echo site_root."ux-admin/manageCompetence/add/1"; ?>">Add Compentency</a>
				</div>
				<div class="pull-right">
					<!-- Modal -->
					<div id="Modal_Bulkupload" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Import Success</h4>
								</div>
								<div class="modal-body">
									<p id="bulk_u_msg"></p>
								</div>
								<div class="modal-footer">
									<button type="button" onclick="window.location='<?php echo $url; ?>';" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal -->
					<div id="Modal_BulkuploadError" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Error</h4>
								</div>
								<div class="modal-body">
									<p id="bulk_u_err"></p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>Sr. No</th>
								<th>Competence Id</th>
								<th>Competence Name</th>
								<th>Competence Games</th>
								<th class="no-sort" id="action">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=1; while($row = $object->fetch_object()){ ?>
								<tr>
									<th><?php echo $i;?></th>
									<th><?php echo $row->Compt_Id;?></th>
									<td><?php echo $row->Compt_Name; ?></td>
									<!-- show game name from game table -->
									<?php
									$compGameName = '';
									$gameSql      = "SELECT Game_Name FROM GAME_GAME WHERE Game_ID IN (".$row->Compt_Game.")";
									$gameObj      = $functionsObj->ExecuteQuery($gameSql);
									$countRows    = 0;
									while($gameName = $gameObj->fetch_object()){
										$countRows++;
	    							// print_r($gameName->Game_Name);
										$compGameName .= $gameName->Game_Name;
										if($countRows < $gameObj->num_rows)
										{
											$compGameName .= '<span style="color: #0000ff; font-weight:900;">,</span> ';
										}
									}
									?>
									<td><?php echo $compGameName;?></td>
									<td class="text-center">
										<a data-toggle="tooltip" href="<?php echo site_root."ux-admin/manageCompetence/edit/".base64_encode($row->Compt_Id); ?>"
											title="Edit"><span class="fa fa-pencil"></span></a> &nbsp;
											<a data-toggle="tooltip" href="javascript:void(0);" class="dl_btn" id="<?php echo $row->Compt_Id; ?>"
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