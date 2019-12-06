<?php 
$tr_msg = $this->session->flashdata('tr_msg');
$er_msg = $this->session->flashdata('er_msg');
if(!empty($tr_msg)){ ?>
	<!-- <div class="content animate-panel">
		<div class="row">
			<div class="col-md-12">
				<div class="hpanel">
					<div class="alert alert-success alert-dismissable alert1 text-center"> <i class="fa fa-check"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $this->session->flashdata('tr_msg');?>. </div>
					</div>
				</div>
			</div>
		</div> -->
		<script>
			// removing the normal bootstrap alerts and adding the sweetalert2 alerts for $tr_msg
			Swal.fire({
				title    : "<?php echo $tr_msg;?>",
				icon     : 'success',
				showClass: {
					popup: 'animated fadeInDown faster'
				},
				hideClass: {
					popup: 'animated fadeOutUp faster'
				}
			})
		</script>
	<?php } else if(!empty($er_msg)){?>
		<!-- <div class="content animate-panel">
			<div class="row">
				<div class="col-md-12">
					<div class="hpanel">
						<div class="alert alert-danger alert-dismissable alert1 text-center"> <i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $this->session->flashdata('er_msg');?>. </div>
						</div>
					</div>
				</div>
			</div> -->
			<script>
			// removing the normal bootstrap alerts and adding the sweetalert2 alerts for $tr_msg
			Swal.fire({
				title    : "<?php echo $er_msg;?>",
				icon     : 'error',
				showClass: {
					popup: 'animated fadeInDown faster'
				},
				hideClass: {
					popup: 'animated fadeOutUp faster'
				}
			})
		</script>
		<?php } ?>	