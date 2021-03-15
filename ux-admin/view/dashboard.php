<style>
	.morris-hover{
		position:absolute;
		z-index:1000
	}
	.morris-hover.morris-default-style{
		border-radius:10px;
		padding      :6px;
		color        :#666;
		background   :rgba(255,255,255,0.8);
		border       :solid 2px rgba(230,230,230,0.8);
		font-family  :sans-serif;font-size:12px;text-align:center}.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0}
		.morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0}
	</style>
	<div class="clearfix"></div>
	<?php
	$bodyArray      = array('testField', 'localhost', 'develop.corporatesim.com');
	$colorArray     = array('testField', 'rgba(153, 102, 255, 1)', 'rgba(75, 192, 192, 1)');
	$dashBoardArray = array('testField', 'Local Dashboard', 'Develop Dashboard');
	$bgcolor        = array_search($_SERVER['HTTP_HOST'],$bodyArray);
	// echo $_SERVER['HTTP_HOST'].' and '.$bgcolor.' and '.$dashBoardArray[$bgcolor];

	if($bgcolor)
	{
		$Dashboard = $dashBoardArray[$bgcolor];
		$bgcolor   = "style='background:".$colorArray[$bgcolor].";'";
	}
	else
	{
		$bgcolor   = '';
		$Dashboard = 'Dashboard';
	}
	// echo $_SERVER['HTTP_HOST']; var_dump(array_search($_SERVER['HTTP_HOST'],$bodyArray,true));
	?>

	<div class="row">
		<div class="col-sm-12">
			<h1 class="page-header"><?php echo $Dashboard?></h1>
		</div>
	</div>
	<div class="row" <?php echo $bgcolor?> >
		<div class="col-sm-3">
			<div class="panel panel-primary panel_blue">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-gamepad fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="num_users"><?php echo $totalGame; ?></div>
							<!-- <div><?php echo 'Normal: '.$num.'<br/>B2B: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageGame'?>" class="col-sm-12 col-xs-12">Games<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-green panel_green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-tag fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="deals"><?php echo $totalScen; ?></div>
							<!-- <div><?php echo 'Normal: '.$num.'<br/>Branching: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageScenario'?>" class="col-sm-12 col-xs-12">Scenario<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-yellow panel_yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-briefcase fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="business"><?php echo $totalArea; ?></div>
							<!-- <div><?php echo 'All: '.$num.'<br/>Used: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageArea'?>" class="col-sm-12 col-xs-12">Area<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-red panel_red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-credit-card fa-4x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" id="payments"><?php echo $totalComp; ?></div>
							<!-- <div><?php echo 'All: '.$num.'<br/>Used: '.$num;?></div> -->
						</div>
					</div>
				</div>
				<a href="<?php echo site_root.'ux-admin/ManageComponent'?>" class="col-sm-12 col-xs-12">Component<i class="pull-right fa fa-arrow-circle-right"></i></a>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- /.row -->
	<div class="row col-md-6">
		<canvas id="barChart" width="400" height="400"></canvas>
		<!-- <canvas id="lineChart" width="400" height="400"></canvas> -->
	</div>

	<div class="row col-md-6">
		<!-- <canvas id="barChart" width="400" height="400"></canvas> -->
		<canvas id="lineChart" width="400" height="400"></canvas>
	</div>

	<div class="clearfix row"><br></div>
	<br>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<b>Game Creator/Completion List</b>
			<a href="javascript:void(0);" class="pull-right" data-toggle="tooltip" title="Refresh Table Data" id="refreshServerSideDataTable">
				<i class="fa fa-refresh"></i>
			</a>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root.'ux-admin/model/ajax/dataTables.php';?>" data-action="Dashboard" data-function="addClickHandlerToGetComments();">
					<thead>
						<tr>
							<th class="no-sort">S.N.</th>
							<th>ID</th>
							<th>Game Name</th>
							<th>Game/eLearning: Type</th>
							<th>Creator</th>
							<th>Created On</th>
							<!-- <th>Game/eLearning</th> -->
							<!-- <th>Type</th> -->
							<th>Status</th>
							<th>Completed On</th>
							<th>Time Taken</th>
							<th class="no-sort">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
				// countInclick   = 0;
				// countOutclick  = 0;
				// animateInArray = ['bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'flipInX', 'flipInY', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'lightSpeedIn', 'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'flip', 'hinge', 'jackInTheBox', 'rollIn'];

				// animateOutArray = ['bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'flipOutX', 'flipOutY', 'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'lightSpeedOut', 'rollOut'];
				addClickHandlerToGetComments();
				// addEdieDeleteGameComments('Comment_Id','modificationType');
			});

		function addClickHandlerToGetComments()
		{
			$('.comments').each(function(){
				$(this).on('click',function(){
					if($(this).attr('id'))
					{
						var gameid       = $(this).attr('id');
						var notification = $(this).data('notification');
						var gamename     = $(this).data('gamename');
						callAjaxForGameComments(gameid,notification,gamename);
					}
					else
					{
						callAjaxForGameComments();
					}
				});
			});
		}

		function callAjaxForGameComments(gameid,notificationTo,gamename)
		{
				// triggering ajax to get the game comments
				var effectIn  = animateInArray[countInclick];
				var effectOut = animateOutArray[countOutclick];
				if(gameid)
				{
					$.ajax({
						url: "<?php echo site_root;?>" + "ux-admin/model/ajax/update_game_link.php",
						type: "POST",
						data: { "game_comments": "game_comments", 'gameid':gameid, 'userid':<?php echo $_SESSION['ux-admin-id']?> },
						success: function(result){
							try
							{
								jsonResult = JSON.parse(result); 
								Swal.fire({
									title: countInclick+' '+effectIn+' and '+effectOut+' '+countOutclick,
									icon : 'success',
									title: "Game Comments &nbsp; <a href='javascript:void(0);' title='Add comment' data-toggle='tooltip' class='addComment' data-gameid='"+gameid+"' data-modify='add'><i class='fa fa-plus-circle text-blue'></i></a>",
									html : jsonResult.message,
									showClass: {
										popup: 'animated '+effectIn+' faster'
									},
									hideClass: {
										popup: 'animated '+effectOut+' faster'
									}
								})
								$('[data-toggle="tooltip"]').tooltip();
								addClickHandler(notificationTo,gamename);
							}
							catch( e )
							{
								Swal.fire({
									title: countInclick+' '+effectIn+' and '+effectOut+' '+countOutclick,
									icon : 'error',
									title: 'Game Comments',
									html : 'Database error occured. Please try later.',
									showClass: {
										popup: 'animated '+effectIn+' faster'
									},
									hideClass: {
										popup: 'animated '+effectOut+' faster'
									}
								})
								console.log(e);
							}
						},
						error: function(result){
							alert(result);
						}
					});
				}
				else
				{
					Swal.fire({
						title: countInclick+' '+effectIn+' and '+effectOut+' '+countOutclick,
						icon : 'warning',
						title: 'Game Comments',
						html : "You don't have access to post or view comments to this game.",
						showClass: {
							popup: 'animated '+effectIn+' faster'
						},
						hideClass: {
							popup: 'animated '+effectOut+' faster'
						}
					})
				}
				countInclick++;
				countOutclick++;
				countInclick  = (countInclick == animateInArray.length)?0:countInclick;
				countOutclick = (countOutclick == animateOutArray.length)?0:countOutclick;
			}

			function addClickHandler(notificationTo,gamename)
			{
				$('.addComment, .editComment, .deleteComment').each(function(){
					$(this).on('click',function(){
						// use data-modify attribute to get the action to be performed like edit/delete/add
						var modify      = $(this).data('modify');
						var gameid      = $(this).data('gameid');
						var commentid   = $(this).data('commentid');
						var prevComment = $(this).parents('tr').find('td.textMessage').text().split(':- ');
						// console.log($(this).parents('tr').find('td.textMessage').text());
						addEdieDeleteGameComments(commentid,modify,gameid,prevComment[1],notificationTo,gamename);
					});
				});
				// show edit/delete icon only when user hover to them
				$('.textMessageRow').each(function(){
					// $(this).on('mouseenter',function(){
					// 	$(this).next('td').removeClass('hidden');
					// });
					$(this).hover(
						function()
						{
							if($(this).find('td.actionIcon').data('creator') == <?php echo $_SESSION['ux-admin-id']?>)
							{
								$(this).find('td.actionIcon').show();
							}
							// $(this).next('td').removeClass('hidden');
						},
						function()
						{
							$(this).find('td.actionIcon').hide(100);
							// $(this).next('td').addClass('hidden');
						}
						);
				});
			}

			function addEdieDeleteGameComments(Comment_Id,modificationType,gameid,prevComment,notificationTo,gamename)
			{
				if(modificationType == 'delete')
				{
					$.ajax({
						type: "POST",
						data: {'addComment':'addComment', 'Comment_GameId':gameid, 'Comment_Id':Comment_Id, 'modificationType':modificationType},
						url: "<?php echo site_root;?>" + "ux-admin/model/ajax/update_game_link.php",
						success: function(result) {
							// console.log(result);
							result = JSON.parse(result);
							// Swal.fire(result);
							if(result.status == 201)
							{
								Swal.fire("Error",result.message,"error");
							}
							else
							{
								Swal.fire("Done!",result.message,"success");
							}
						},
					});
				}
				else
				{
					Swal.fire({
						title           : 'Enter your comments below',
						input           : 'text',
						inputPlaceholder:'Add your comments here',
						inputValue      : prevComment,
						inputAttributes : {
							autocapitalize: 'off'
						},
						showCancelButton   : true,
						confirmButtonText  : 'Add',
						showLoaderOnConfirm: true,
						// preConfirm: (login) => {
						// 	return fetch(`//api.github.com/users/${login}`)
						// 	.then(response => {
						// 		if (!response.ok) {
						// 			throw new Error(response.statusText)
						// 		}
						// 		return response.json()
						// 	})
						// 	.catch(error => {
						// 		Swal.showValidationMessage(
						// 			`Request failed: ${error}`
						// 			)
						// 	})
						// },
						preConfirm: function(response) {
							// if there is Comment_Id then modification may be of type edit/delete, else add
							if(Comment_Id)
							{
								// edit delete
								var data = {'addComment':'addComment', 'Comment_Message':response, 'Comment_GameId':gameid, 'Comment_Id':Comment_Id, 'modificationType':modificationType, 'notificationTo':notificationTo, 'gamename':gamename};
							}
							else
							{
								// add
								var data = {'addComment':'addComment', 'Comment_Message':response, 'Comment_GameId':gameid, 'notificationTo':notificationTo, 'gamename':gamename};
							}
							if(response.trim().length>1)
							{
								$.ajax({
									type: "POST",
									data: data,
									url: "<?php echo site_root;?>" + "ux-admin/model/ajax/update_game_link.php",
									success: function(result) {
										// console.log(result);
										result = JSON.parse(result);
										// Swal.fire(result);
										if(result.status == 201)
										{
											Swal.fire("Error",result.message,"error");
										}
										else
										{
											Swal.fire("Done!",result.message,"success");
										}
									},
								});
							}
							else
							{
								Swal.showValidationMessage(
									"Error: Field can not be left blank"
									)
							}
						},
						allowOutsideClick: () => !Swal.isLoading()
					})
				}
			}

		</script>

		<script>
			var ctx = $('#barChart');
			var myBarChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['2017', '2018', '2019', '2020', '2021', '2022'],
					datasets: [
					<?php
					for($i=0; $i<count($chartData); $i++)
					{
						$dataCount            = '';
						$fetchBackgroundColor = '';
						$fetchBorderColor     = '';
						$countTitle           = 0;

						for($j=0; $j<count($chartData[$i]); $j++)
						{
							$dataCount            .= $chartData[$i][$j]->Count.',';
							$fetchBackgroundColor .= "'".$backgroundColor[$i]."',";
							$fetchBorderColor     .= "'".$borderColor[$i]."',";
							$countTitle           += $chartData[$i][$j]->Count;
						}
						echo "{label: '".$chartData[$i][0]->Title." (".$countTitle.")',";
						echo "data: [".trim($dataCount,',')."],";
						echo "backgroundColor: [".trim($fetchBackgroundColor,',')."],";
						echo "borderColor: [".trim($fetchBorderColor,',')."],";
						echo "borderWidth: 1 },";
					}
					?>
					// label: 'Game',
					// data: [12, 19, 3, 5, 2, 3],
					// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// ],
					// borderColor: [
					// 'rgba(255, 99, 132, 1)',
					// ],
					]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
		// var ctx = $('#lineChart');
		// var myChart = new Chart(ctx, {
		// 	type: 'line',
		// 	data: {
		// 		labels: ['2017', '2018', '2019', '2020', '2021'],
		// 		datasets: [{
		// 			label: 'Game',
		// 			data: [102, 19, 3, 5, 2, 3],
		// 			backgroundColor: [
		// 			'rgba(255, 99, 132, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(255, 99, 132, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Scenario',
		// 			data: [10, 109, 74, 7, 85, 1],
		// 			backgroundColor: [
		// 			'rgba(54, 162, 235, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(54, 162, 235, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Area',
		// 			data: [25, 5, 93, 23, 83, 18],
		// 			backgroundColor: [
		// 			'rgba(255, 206, 86, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(255, 206, 86, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Component',
		// 			data: [36, 25, 39, 15, 92, 83],
		// 			backgroundColor: [
		// 			'rgba(75, 192, 192, 0.2)',
		// 			],
		// 			borderColor: [
		// 			'rgba(75, 192, 192, 1)',
		// 			],
		// 			borderWidth: 1
		// 		},
		// 		{
		// 			label: 'Subcomponent',
		// 			data: [1, 19, 31, 51, 21, 31],
		// 			backgroundColor: [
		// 			'rgba(255, 159, 64, 0.2)'
		// 			],
		// 			borderColor: [
		// 			'rgba(255, 159, 64, 1)'
		// 			],
		// 			borderWidth: 1
		// 		}]
		// 	},
		// 	options: {
		// 		scales: {
		// 			yAxes: [{
		// 				ticks: {
		// 					beginAtZero: true
		// 				}
		// 			}]
		// 		}
		// 	}
		// });
	</script>
