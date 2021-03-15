

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">View Notifications</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root.'ux-admin/Dashboard';?>">Home</a></li>
			<li class="active"><a href="<?php echo site_root.'ux-admin/notification';?>">Notifications</a></li>
		</ul>
	</div>
</div>

<div class="row col-md-12">
	<div class="panel-body">
		<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<th class="text-center">S.N.</th>
					<th class="text-center">Notification Message</th>
					<th class="no-sort text-center">Action</th>
				</thead>
				<tbody>
					<?php $i=1; foreach($notificationData as $notificationDataRow) { ?>
						<tr>
							<td class="text-center"><?php echo $i;?></td>
							<td class="text-center"><?php echo $notificationDataRow->Notification_Message;?></td>
							<td class="text-center">
								<!-- if not seen then show only this -->
								<?php if($notificationDataRow->Notification_Seen == 0){ ?>
									<a href="javascript:void(0);" data-toggle="tooltip" title="Mark as seen" data-modify="seen" class="editDelete" data-notificationid="<?php echo $notificationDataRow->Notification_Id;?>" id="seen_<?php echo $notificationDataRow->Notification_Id;?>"><i class="fa fa-check"></i></a>
								<?php } ?>
								&nbsp;
								<a href="javascript:void(0);" data-toggle="tooltip" title="Delete Notification" data-modify="delete" class="editDelete" data-notificationid="<?php echo $notificationDataRow->Notification_Id;?>" id="delete_<?php echo $notificationDataRow->Notification_Id;?>"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$('.editDelete').each(function(){
				$(this).on('click',function(){
					var modify         = $(this).data('modify');
					var notificationid = $(this).data('notificationid');
					Swal.fire({
						title             : 'Are you sure?',
						text              : "You won't be able to revert this!",
						icon              : 'warning',
						showCancelButton  : true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor : '#d33',
						confirmButtonText : 'Yes, Proceed!'
					}).then((result) => {
						if (result.value) {
							$.ajax({
								type: "POST",
								data: {'notificationUpdate':'notificationUpdate', 'Notification_Id':notificationid, 'modify':modify},
								url: "<?php echo site_root;?>" + "ux-admin/model/ajax/update_game_link.php",
								success: function(result) {
									result = JSON.parse(result);
									if(result.status == 201)
									{
										Swal.fire("Error",result.message,"error");
									}
									else
									{
										switch(modify)
										{
											case 'seen':
											$('#'+modify+'_'+notificationid).hide();
											break;

											case 'delete':
											$('#'+modify+'_'+notificationid).parents('tr').hide();
											break;
										}
										// console.log('#'+modify+'_'+notificationid)
										Swal.fire("Done!",result.message,"success");
									}
								},
							});
						}
					})
				});
			});
		});
	</script>