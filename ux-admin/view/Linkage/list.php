<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/linkage/del/";
		var loc_url_stat = "ux-admin/linkage/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Linkage</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Linkage</li>			
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-lg-12">
		<div class="pull-right legend">
			<ul>
				<li><b>Legend : </b></li>
				<li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
				<li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
				<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>
				<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
				<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
				<li> <span class="fa fa-code-fork">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Component Branching"> Branching	</a></li>
				<li> <span class="fa fa-save">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Manual Save Enabled"> Manual Save Button </a></li>
				<li> <span class="fa fa-bell">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Skip Confirmation Alert For I/P Page Submit"> Skip Submit Alert </a></li>
				<li> <span class="fa fa-paper-plane">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This will auto Submit O/P Page"> Skip Output </a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Linkage List</label>
			<div class="pull-right">
				<?php if($functionsObj->checkModuleAuth('linkage','add')){ ?>
					<input class="btn btn-primary" type="button" name="addlink" value="Add Linkage"
					onclick="window.location.href='<?php echo site_root."ux-admin/linkage/add/1"; ?>';"/>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
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
							<th>Back To Intro Link</th>
							<th>Creator/Status</th>
							<th class="no-sort">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=1; while($row = $object->fetch_object()){ ?>
							<tr>
								<th><?php echo $i;?></th>
								<td><?php echo ($row->BotEnabled==1)?$row->Game.' (<strong>Bot</strong>)':$row->Game   ; ?></td>
								<td><?php echo $row->Scenario;?></td>
								<td><?php echo $row->Link_Order;?></td>
								<td><?php echo ($row->Link_Introduction>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Link_IntroductionLink>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Link_Description>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Link_DescriptionLink>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Link_BackToIntro>0)?'Skipped':'Default';?></td>

								<td>
									<?php if(empty($row->name)) $row->name='Admin'; echo ($row->Game_Complete)?'Creator: <b>'.$row->name.'</b> <span class="alert-success">(Completed)</span>':'Creator: <b>'.$row->name.'</b> <span class="alert-danger">(In-Progress)</span>' ?>
								</td>

								<td class="text-center">
									<!-- if game is completed then don't allow to edit, also allow only creator or superadmin to make changes Creator, Game_Complete, nameEmail -->
									<?php
									if($row->Game_Complete)
									{
										// if game is completed then no one can make any changes
										$allowEdit    = "data-gamedata='This game is completed. So, no changes are allowed.'";
										if(($row->Creator == $_SESSION['ux-admin-id']) || $_SESSION['ux-admin-id'] == 1)
										{
											$activeDelete = " ";
										}
										else
										{
											$activeDelete = "data-gamedata='Only admin or creator (".$row->nameEmail.") can make the changes.'";
										}
									}
									else
									{
										// if game is not completed then only creater or superadmin can make the changes
										if(($row->Creator == $_SESSION['ux-admin-id']) || $_SESSION['ux-admin-id'] == 1)
										{
											$allowEdit    = ' ';
											$activeDelete = " ";
										}
										else
										{
											$allowEdit    = "data-gamedata='Only admin or creator (".$row->nameEmail.") can make the changes.'";
											$activeDelete = $allowEdit;
										}

										// if game is completed then no one can make any changes, apart from associates like designers
										if($row->AssociateAccess == $_SESSION['ux-admin-id'])
										{
											$allowEdit = ' ';
										}
									}
									?>
									<a href="<?php echo site_root."ux-admin/linkage/tab/".$row->Link_ID; ?>" <?php echo $allowEdit;?> data-toggle="tooltip" title="Area Tab Sequencing">
										<span class="fa fa-gear fa-fw"></span>
									</a>
									<?php if($functionsObj->checkModuleAuth('innerlinkage','enable')){ ?>
										<a href="<?php echo site_root."ux-admin/linkage/link/".$row->Link_ID; ?>" <?php echo $allowEdit;?> data-toggle="tooltip" title="Link Game - Comp/Subcomp">
											<span class="fa fa-link"></span>
										</a>
									<?php } ?>
									<?php if($row->Link_Status == 0){ ?>
										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->Link_ID; ?>" <?php echo $activeDelete;?> data-toggle="tooltip" title="Deactive">
											<span class="fa fa-times"></span>
										</a>
									<?php } else { ?>
										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->Link_ID; ?>" <?php echo $activeDelete;?> data-toggle="tooltip" title="Active">
											<span class="fa fa-check"></span>
										</a>
									<?php } ?>
									<?php if($functionsObj->checkModuleAuth('linkage','edit')){ ?>
										<a href="<?php echo site_root."ux-admin/linkage/edit/".$row->Link_ID; ?>" <?php echo $allowEdit;?> data-toggle="tooltip" title="Edit">
											<span class="fa fa-pencil"></span>
										</a>
									<?php } if($functionsObj->checkModuleAuth('linkage','delete')){ ?>
										<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->Link_ID; ?>" <?php echo $activeDelete;?> data-toggle="tooltip" title="Delete">
											<span class="fa fa-trash"></span>
										</a>
									<?php } ?>
									<?php if($row->Link_Branching == 1){ ?>
										&nbsp;
										<a href="<?php echo site_root."ux-admin/componentBranching/link/".$row->Link_ID; ?>" <?php echo $allowEdit;?> data-toggle="tooltip" title="Component Branching">
											<span class="fa fa-code-fork"></span>
										</a>
									<?php } ?>
									<?php if($row->Link_SaveStatic == 1){ ?>
										&nbsp;
										<a href="javascript:void(0);" data-toggle="tooltip" title="Static Save Button Enabled">
											<span class="fa fa-save"></span>
										</a>
									<?php } ?>
									<?php if($row->Link_SkipAlert == 1){ ?>
										&nbsp;
										<a href="javascript:void(0);" data-toggle="tooltip" title="Confirmation Alert For I/P Page Submission Skipped">
											<span class="fa fa-bell"></span>
										</a>
									<?php } ?>
									<?php if($row->Link_Enabled == 1){ ?>
										&nbsp;
										<a href="javascript:void(0);" data-toggle="tooltip" title="AutoSubmit O/P Page">
											<span class="fa fa-paper-plane"></span>
										</a>
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
	<div class="clearfix"></div>
	<script>
		$(document).ready(function(){
			$("a").each(function(){
				var gamedata = $(this).data('gamedata');
				if(typeof gamedata !== typeof undefined && gamedata !== false)
				{
					$(this).unbind('click');
					$(this).attr('href','javascript:void(0);');
					$(this).on('click',function(e)
					{
						e.preventDefault();
						var effectIn  = animateInArray[countInclick];
						var effectOut = animateOutArray[countOutclick];
						Swal.fire({
							icon : 'error',
							title: 'Game Comments',
							html : $(this).data('gamedata'),
							showClass: {
								popup: 'animated '+effectIn+' faster'
							},
							hideClass: {
								popup: 'animated '+effectOut+' faster'
							}
						});
						// console.log(gamedata+' and '+ typeof gamedata)
						countInclick++;
						countOutclick++;
						countInclick  = (countInclick == animateInArray.length)?0:countInclick;
						countOutclick = (countOutclick == animateOutArray.length)?0:countOutclick;
						return false;
					});
				}
			});
		});
	</script>