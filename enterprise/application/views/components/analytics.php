<!-- <?php // echo "<pre>"; print_r($editUser->User_SubParentId); exit;?> -->
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<?php $this->load->view('components/trErMsg');?>
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h1>Analytics
								</h1>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Analytics</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
						<div class="clearfix">
						</div>
						<!-- show page content here -->
						<div class="row col-md-12">

							<form action="" method="post" id="">

								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="leaderboard" name="analyticsType" class="custom-control-input">
									<label class="custom-control-label" for="leaderboard">Leaderboard</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="graph" name="analyticsType" class="custom-control-input">
									<label class="custom-control-label" for="graph">Graph</label>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

