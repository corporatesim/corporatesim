<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/siteusers/del/";
		var loc_url_stat = "ux-admin/siteusers/stat/";
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
		<h1 class="page-header">Site Users</h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active">Manage Users</li>
			</ul>
		</div>
	</div>
	<?php if(isset($msg)){echo "<div class=\"form-group alert-dismissible alert ". $type[1] ." \"><a href='#' class='close' data-dismiss='alert' arial-label='close' style='right:1%; top:5px;'>&times;</a><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
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
					<li> <span class="glyphicon glyphicon-refresh">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User can replay the Game"> Replay	</a></li>
					<li> <span class="glyphicon glyphicon-ban-circle">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User games have been disabled"> Disable	</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-default" id="loader">
			<div class="panel-heading">
				<label style="padding-top:7px;">Site Users List</label>
				<div class="pull-right">
					<form method="post"  action="" enctype="multipart/form-data">
						<input class="btn btn-primary" type="button" name="addsiteuser" value="Add Site User"
						onclick="window.location.href='<?php echo site_root."ux-admin/siteusers/add/1"; ?>';"/>
						<button type="submit" name="submit" id="user_download" class="btn btn-primary"
						value="Download"> Download </button>
					</form>
				</div>
				<div class="pull-right">
					<form method="post" id="bulk_upload_csv" name="bulk_upload_csv" action="" enctype="multipart/form-data">
						<span id="fileselector">
							<label class="btn btn-default" for="upload-file-selector">
								<input id="upload-file-selector" type="file" name="upload_csv">
								<i class="fa fa-upload"></i> Bulk Upload Users
							</label>
						</span>	
					</form>
					<a href="<?php echo site_root."ux-admin/user-upload-csv-demo-file.csv"; ?>" download="demouser.csv"><u>Demo Users CSV</u></a>
				</div>
				<div class="pull-right">
					<form method="post" id="bulk_updateGame_csv" name="bulk_updateGame_csv" action="" enctype="multipart/form-data">
						<span id="fileselector">
							<label class="btn btn-default" for="update-file-selector">
								<input id="update-file-selector" type="file" name="updategame_csv">
								<i class="fa fa-upload"></i> Bulk Update Game
							</label>
						</span>
					</form>
					<a href="<?php echo site_root."ux-admin/user-updete-game-csv-demo-file.csv"; ?>" download="update-user-game.csv"><u>Demo user Game CSV</u></a>
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
					<script type="text/javascript">
						<!--
							
							$('#upload-file-selector').change( function(){
								var form = $('#bulk_upload_csv').get(0);											
								$.ajax({
									url        : site_root + "ux-admin/model/ajax/ajax_bulk_upload_user.php",
									type       : "POST",
									data       : new FormData(form),
									cache      : false,
									contentType: false,
									processData: false,
									beforeSend : function(){
										$('#loader').addClass('loading');
									},
									success: function( result ){
										try {		
          			//alert(result);														
          			var response = JSON.parse( result );
          			//alert(response.status);
          			if( response.status == 1 ){
          				//alert('in status = 1 ');
          				$('#bulk_u_msg').html( response.msg );
          				$('#Modal_Bulkupload').modal( 'show' );
          			} else {
          				$('#bulk_u_err').html( response.msg );
          				$('#Modal_BulkuploadError').modal( 'show' );
          			}
          		} catch ( e ) {
          			console.log( result );
          		}
          		$('#loader').removeClass('loading');
          	}
          });
							});
          //-->
        </script>
        <script type="text/javascript">
        	<!--
        		
        		$('#update-file-selector').change( function(){
          	var form = $('#bulk_updateGame_csv').get(0);	//alert(form);										
          	$.ajax({
          		url        : site_root + "ux-admin/model/ajax/ajax_bulk_update_game.php",
          		type       : "POST",
          		data       : new FormData(form),
          		cache      : false,
          		contentType: false,
          		processData: false,
          		beforeSend : function(){
          			$('#loader').addClass('loading');
          		},
          		success: function( result ){
          			try {		
          				//alert(result);														
          				var response = JSON.parse( result );
          				//alert(response.status);
          				if( response.status == 1 ){
          					//alert('in status = 1 ');
          					$('#bulk_u_msg').html( response.msg );
          					$('#Modal_Bulkupload').modal( 'show' );
          				} else {
          					$('#bulk_u_err').html( response.msg );
          					$('#Modal_BulkuploadError').modal( 'show' );
          				}
          			} catch ( e ) {
          				console.log( result );
          			}
          			$('#loader').removeClass('loading');
          		}
          	});
          });
          //-->
        </script>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    	<div class="dataTable_wrapper">
    		<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    			<thead>
    				<tr>
    					<th>Sr. No</th>
    					<th>User Id</th>
    					<th>Name</th>
    					<th>E-mail</th>
    					<th id="password">Password</th>
    					<th id="contact">Contact</th>
    					<!--<th>Last Login</th>-->
    					<th>Date</th>
    					<th class="no-sort">Games</th>
    					<th class="no-sort" id="action">Action</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php 
    				$i=1; while($row = $object->fetch_object()){ ?>
    					<tr>
    						<th><?php echo $i;?></th>
    						<th><?php echo $row->User_id;?></th>
    						<td><?php echo ucfirst($row->User_fname)." ".ucfirst($row->User_lname); ?></td>
    						<td><?php echo $row->User_email;?></td>
    						<td><?php echo $row->pwd;?></td>
    						<td><?php echo "+91".$row->User_mobile;?></td>
    						<!--<td><?php if(!empty($row->User_last_login)){ echo date("Y-m-d H:i:s", strtotime($row->User_last_login)); }else{ echo "-"; } ?></td>-->
    						<td><?php echo date('d-m-Y',strtotime($row->User_datetime)); ?></td>
    						<td class="text-center">
    							<a href="<?php echo site_root."ux-admin/addUserGame/edit/".base64_encode($row->User_id); ?>"
    								title="Game"><?php if($row->gamecount >0){ echo $row->gamecount;} else echo "0"; ?></a>
    							</td>
    							<td class="text-center">
    								<?php if($row->User_status == 0){?>
    									<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->User_id; ?>"
    										title="Deactive"><span class="fa fa-times"></span></a>
    									<?php }else{?>
    										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->User_id; ?>"
    											title="Active"><span class="fa fa-check"></span></a>
    										<?php }?>
    										<a href="<?php echo site_root."ux-admin/siteusers/edit/".base64_encode($row->User_id); ?>"
    											title="Edit"><span class="fa fa-pencil"></span></a>
    											<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->User_id; ?>"
    												title="Delete"><span class="fa fa-trash"></span></a>
    												<!-- for replay status -->
    												<?php
    												$statusSql = "SELECT Game_Name FROM GAME_USERSTATUS LEFT JOIN GAME_GAME ON Game_ID=US_GameID WHERE US_UserID=$row->User_id AND US_ReplayStatus=1";

														$resObject = $functionsObj->ExecuteQuery($statusSql);
														$count     = $resObject->num_rows;
    												if($resObject->num_rows > 0) { ?>
    													<?php
    														$gameName = [];
    														while($nameGame = $resObject->fetch_object())
    														{
    															$gameName[] = $nameGame->Game_Name;
    														}
    														// print_r($gameName);
    														if(count($gameName) > 1)
    														{
																	$userGames = implode(', ',$gameName);
																	$title     = 'Replay allowed for '.$userGames.' games';
    														}
    														else
    														{
																	$userGames = $gameName[0];
																	$title     = 'Replay allowed only for '.$userGames;
    														}
    													?>
    													<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $title; ?>" id="replay_<?php echo $row->User_id; ?>"><span class="glyphicon glyphicon-refresh"></span></a>
    												<?php } ?>
    												<!-- for game enable/disable status -->
    												<?php if($row->User_gameStatus == 1) { ?>
    													<a href="javascript:void(0)" title="Disable" id="disable_<?php echo $row->User_id; ?>"><span class="glyphicon glyphicon-ban-circle"></span></a>
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