<script type="text/javascript">
	<!--
		var loc_url_del = "ux-admin/Formulas/del/";
		var loc_url_stat = "ux-admin/Formulas/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			<?php if($functionsObj->checkModuleAuth('formulas','add')){ ?>
				<a href="<?php echo site_root."ux-admin/Formulas/add/1"; ?>" data-toggle="tooltip" title="Add Formula">
					<i class="fa fa-plus-circle"></i>
				</a>
			<?php } ?>
			Formulas
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="completed">
					<a href="javascript:void(0);"> Formulas</a></li>
					<li class="active">Formulas</li>
				</ul>
			</div>
		</div>

		<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

		<div class="row">
			<div class="col-lg-12 form-group">
				<div class="pull-right legend">
					<ul>
						<li><b>Legend : </b></li>
						<li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
						<li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
						<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> View </a></li>
						<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
						<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<label style="padding-top:7px;">Formulas List</label>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						<div class="dataTable_wrapper">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>Formula</th>
										<th class="no-sort">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1; while($row = $f_list->fetch_object()){ ?>
										<tr>
											<th><?php echo $i;?></th>
											<td><?php echo $row->formula_title; ?></td>
											<td class="text-center">
												<?php if($functionsObj->checkModuleAuth('formulas','edit')){ ?>
													<a href="<?php echo site_root."ux-admin/Formulas/edit/".base64_encode($row->f_id); ?>"
														title="Edit"><span class="fa fa-pencil"></span></a>
													<?php } if($functionsObj->checkModuleAuth('formulas','delete')){ ?>
														<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->f_id; ?>"
															title="Delete"><span class="fa fa-trash"></span></a>
														<?php } ?>
													</td>
												</tr>
												<?php $i++; } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
