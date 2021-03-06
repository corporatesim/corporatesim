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
		<h1 class="page-header">
			<a href="<?php echo site_root."ux-admin/siteusers/add/1"; ?>" data-toggle="tooltip" title="Add Site Users">
				<i class="fa fa-plus-circle"></i>
			</a>			
			Site Users
		</h1>
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
    		<table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root.'ux-admin/model/ajax/dataTables.php';?>" data-action="siteusers">
    			<thead>
    				<tr>
    					<th class="no-sort">Sr. No</th>
    					<th>User Id</th>
    					<th>Name</th>
    					<th class="no-sort">User Type</th>
    					<th>E-mail</th>
    					<th class="no-sort" id="password">Password</th>
    					<th class="no-sort" id="contact">Contact</th>
    					<!--<th>Last Login</th>-->
    					<th>Date</th>
    					<th class="no-sort">Games</th>
    					<th class="no-sort" id="action">Action</th>
    				</tr>
    			</thead>
    			
    		</table>
    	</div>
    </div>
  </div>
</div>
<div class="clearfix"></div>