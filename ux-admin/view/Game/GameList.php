<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/ManageGame/del/";
		var loc_url_stat = "ux-admin/ManageGame/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Game</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Game</li>			
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
<form method="post" action="">
	<div class="row">
		<div class="col-md-6">
			<a id="HideDownloadIcon"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="Download Game"></i></a>
			<div id="downloadGame">
				<div class="row" id="sandbox-container">
					<div class="input-daterange input-group" id="datepicker">
						<input type="text" class="input-sm form-control" id="fromdate" name="fromdate" placeholder="Select Start Date" required readonly/>
						<span class="input-group-addon">to</span>
						<input type="text" class="input-sm form-control" id="enddate" name="enddate" placeholder="Select End Date" required readonly/>
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
						<li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
						<li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
						<!--<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>-->
						<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
						<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
						<li> <span class="fa fa-book">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Content"> General	</a></li>
						<li> <span class="fa fa-file-o">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Document"> Document	</a></li>
						<li> <span class="fa fa-image">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Image"> Image	</a></li>
						<li> <span class="fa fa-video-camera">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Video"> Video	</a></li>
						<li> <span class="fa fa-thumbs-o-up">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Game Completed"> Completed	</a></li>
						<li> <span class="fa fa-thumbs-o-down">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Game In Progress"> Not Completed	</a></li>
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
			<div class="pull-right">
				<?php if($functionsObj->checkModuleAuth('game','add')){ ?>
					<input class="btn btn-primary" type="button" name="addsiteuser" value="Add Game"
					onclick="window.location.href='<?php echo site_root."ux-admin/ManageGame/add/1"; ?>';"/>
				<?php }?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>ID</th>
							<th>Name</th>
							<th>Comments</th>
							<th>Header</th>
							<th>Type</th>
							<th>Bot</th>
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
					<tbody>
						<?php 
						$i=1; while($row = $object->fetch_object()){ ?>
							<tr>
								<th><?php echo $i;?></th>
								<td><?php echo $row->Game_ID; ?></td>
								<td><?php echo $row->Game_Name; ?></td>
								<td><?php echo $row->Game_Comments;?></td>
								<td><?php echo $row->Game_Header;?></td>
								<td><?php echo ($row->Game_Elearning==1)?'eLearning':'Game'?></td>
								<td><?php echo ($row->Game_Type==1)?'<strong>Bot-Enabled</strong>':'Normal Game'?></td>
								<td><?php echo ($row->Game_Introduction>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Game_IntroductionLink>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Game_Description>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Game_DescriptionLink>0)?'Skipped':'Default';?></td>
								<td><?php echo ($row->Game_BackToIntro>0)?'Skipped':'Default';?></td>
								<td>
									<?php if($row->Game_Image){ ?>
										<img src="<?php echo site_root.'images/'.$row->Game_Image;?>" alt="No Image" width='25' height='25'>
									<?php } else { ?>
										No image
									<?php } ?>
								</td>

								<td>
									<?php if(empty($row->name)) $row->name='Admin'; echo ($row->Game_Complete)?'Creator: <b>'.$row->name.'</b> <span class="alert-success">(Completed)</span>':'Creator: <b>'.$row->name.'</b> <span class="alert-danger">(In-Progress)</span>' ?>
								</td>

								<td class="text-center">
									<a href="<?php echo site_root."ux-admin/ManageGameContent/Edit/".base64_encode($row->Game_ID); ?>" data-toggle="tooltip" title="General"><span class="fa fa-book"></span></a>
									<a href="<?php echo site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($row->Game_ID); ?>" data-toggle="tooltip" title="Document"><span class="fa fa-file-o"></span></a>
									<a href="<?php echo site_root."ux-admin/ManageGameImage/Edit/".base64_encode($row->Game_ID); ?>" data-toggle="tooltip" title="Image"><span class="fa fa-image"></span></a>								
									<a href="<?php echo site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($row->Game_ID); ?>" data-toggle="tooltip" title="Video"><span class="fa fa-video-camera"></span></a>
								</td>
								<td class="text-center">
									<?php if($row->Game_Delete > 0){?>
										<a href="javascript:void(0);" data-createdby="<?php echo $row->Game_CreatedBy;?>" class="cs_btn" id="<?php echo $row->Game_ID; ?>" data-toggle="tooltip" title="Deactive"><span class="fa fa-times"></span></a>
									<?php }else{?>
										<a href="javascript:void(0);" data-createdby="<?php echo $row->Game_CreatedBy;?>" class="cs_btn" id="<?php echo $row->Game_ID; ?>" data-toggle="tooltip" title="Active"><span class="fa fa-check"></span></a>
									<?php }?>
									<?php if($functionsObj->checkModuleAuth('game','edit')){?>
										<a href="<?php echo ($row->Game_Complete<1)?site_root."ux-admin/ManageGame/edit/".base64_encode($row->Game_ID):'javascript:void(0);'; ?>" data-createdby="<?php echo $row->Game_CreatedBy;?>" data-toggle="tooltip" title="Edit" class="editGame"><span class="fa fa-pencil"></span></a>
									<?php }
									if($functionsObj->checkModuleAuth('game','delete')){?>
										<a href="javascript:void(0);" data-createdby="<?php echo $row->Game_CreatedBy;?>" class="dl_btn" id="<?php echo $row->Game_ID; ?>" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>
									<?php } ?>
									<?php if($row->Game_Complete) { ?>
										<a href="javascript:void(0);" data-toggle="tooltip" title="Game: Completed" class="completed" data-gameid="<?php echo $row->Game_ID;?>" data-createdby="<?php echo $row->Game_CreatedBy;?>" data-creator="<?php echo $row->name;?>" data-completedby="<?php echo $row->nameEmail;?>" data-completedon="<?php echo date('d-m-Y H:i:s',strtotime($row->Game_UpdatedOn));?>">
											<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
										</a>
									<?php } else { ?>
										<a href="javascript:void(0);" data-toggle="tooltip" title="Game: In-Progress" id="progress_<?php echo $row->Game_ID;?>" class="<?php echo (($row->Game_CreatedBy == $_SESSION['ux-admin-id']) || ($_SESSION['admin_usertype'] == 'superadmin'))?'progress':'notAllow';?>" data-cancomplete="<?php echo $row->nameEmail;?>">
											<i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
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
			$(".progress").each(function(){
				$(this).on('click',function(){
					var creator = $(this).data('cancomplete')
					var eid     = $(this).attr('id').split('_');
					var Game_ID = eid[1];
					var textMsg = "You won't be able to make any changes to this game, after you complete!";
					confirmAndTriggerAjax(Game_ID,1,textMsg,creator);
				});
			});
			$(".completed").each(function()
			{
				$(this).on('click',function()
				{
					var Game_ID     = $(this).data('gameid');
					var createdby   = $(this).data('createdby');
					var creator     = $(this).data('creator');	
					var completedby = $(this).data('completedby');
					var textMsg     = "This game was completed by "+completedby+". Do you really want to make it incomplete?"

					// console.log(createdby+' '+creator+' '+completedby);
					if(creator == <?php echo $_SESSION['ux-admin-id']; ?> || <?php echo $_SESSION['ux-admin-id']; ?> == 1)
					{
						// if creator or super admin, then only allow to change the status to incomplete
						confirmAndTriggerAjax(Game_ID,0,textMsg,creator);
					}
					else
					{
						Swal.fire('Completed By:- '+$(this).data('completedby')+'<br>Completed On:- '+$(this).data('completedon'));
					}
				});
			});

			$(".notAllow").each(function()
			{
				$(this).on('click',function()
				{
					Swal.fire('Only ('+$(this).data('cancomplete')+') or superadmin can change the status of this game as complete.');
				});
			});
			// if game is completed then don't allow user to edit, only active/deactive/delete will be allowed
			$(".editGame").each(function()
			{
				$(this).on('click',function()
				{
					if($(this).attr('href') == 'javascript:void(0);')
					{
						Swal.fire('This game is completed. So, editing is not allowed.');
					}
				});
			});
		});

		function confirmAndTriggerAjax(Game_ID,gameStatus,textMsg,creator)
		{
			Swal.fire({
				title             : 'Are you sure?',
				text              : textMsg,
				icon              : 'warning',
				showCancelButton  : true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Yes, Proceed!',
				cancelButtonText  : 'No, Cancel!',
				footer            : "<b>Creator: "+creator+"</b>"
			}).then((result) => {
				if (result.value)
				{
					// trigger ajax to change the status to mark as complted
					$.ajax({
						type    : "POST",
						dataType: "json",
						data    : {'Game_Complete':'updateStatus','Game_ID':Game_ID,'gameStatus':gameStatus},
						url     : "<?php echo site_root;?>ux-admin/model/ajax/update_game_link.php",
						success: function(result) 
						{
							if(result.status == 200)
							{
								Swal.fire(
									'Success!',
									result.message,
									'success'
									)
								window.location = " ";
							}
							else
							{
								Swal.fire(result.message);
							}
						},
						error: function(jqXHR, exception)
						{
							{
								Swal.fire(jqXHR.responseText);
							}
						}
					});
				}
			})
		}

	</script>