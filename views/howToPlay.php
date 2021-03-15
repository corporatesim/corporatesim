<?php 
include_once 'includes/headerNav.php';
?>
<style>
	h4{
		color:#ffffff;
	}
	li{
		margin-top: 3%;
	}
</style>
<div class="row" style="margin-top:2%;">
	<div class="container col-md-7" style="margin-left:30%;" >
		<span class="anchor" id="formUserEdit"></span>
		<!-- form user info -->
		<div class="card card-outline-secondary">
			<div class="clearfix"></div>
			<div class="card-header">
				<h3 style="color:#ffffff;" class="mb-0 text-center">How To Play</h3>
			</div>
			<div class="card-body" style="margin: 5%;" >
				<div class="clearfix"></div>
				<ul>
					<?php for($i=2; $i<=18; $i++){ ?>
						<li>
							<img class="showImageModal" src="<?php echo site_root.'images/htp/'.$i.'.png'?>" alt="How To Play Simulation" width='100%'>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'includes/footer.php';
// put html for view page here
?>