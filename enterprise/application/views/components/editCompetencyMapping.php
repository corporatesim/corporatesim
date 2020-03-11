<script type="text/javascript">
	var loc_url_del = "<?php echo base_url('Users/delete/');?>";
	var func        = "<?php echo $this->uri->segment(2);?>";
</script>
<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Competency Mapping</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
								<div class="clearfix mb-20">
									<h5 class="text-blue">Edit Competency Mapping</h5>
								</div>

								<?php echo form_open('', 'id="competencyMappingForm"', '');?>
								<div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
									<label for="Cmap_ComptId" class="col-sm-12 col-md-3 col-form-label">Select Competency </label>
									<div class="col-sm-12 col-md-9">
										<input name="Cmap_ComptId"  type="hidden" value="<?php echo $Cmap_ComptId; ?>">
										<select id="Cmap_ComptId" class="custom-select2 form-control" required="" disabled="">
											<option value="">--Select Competency--</option>
											<?php foreach ($competency as $competencyRow) { ?>
												<option value="<?php echo $competencyRow->Compt_Id;?>" title="<?php echo $competencyRow->Compt_Description; ?>" <?php echo ($competencyRow->Compt_Id == $Cmap_ComptId)?'selected':''; ?>> <?php echo $competencyRow->Compt_Name; ?> </option>
											<?php } ?>
										</select> <span class="text-danger">*</span>
									</div>
								</div>

								<div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
									<label for="Cmap_GameId" class="col-sm-12 col-md-3 col-form-label">Select Game </label>
									<div class="col-sm-12 col-md-9">
										<select name="Cmap_GameId[]" id="Cmap_GameId" class="custom-select2 form-control" multiple="" required="">
											<?php foreach ($games as $gamesRow) { ?>
												<option value="<?php echo $gamesRow->Game_ID;?>" title="<?php echo $gamesRow->Game_Comments; ?>" <?php echo (empty($gamesRow->Cmap_Id))?'':'selected';?>> <?php echo $gamesRow->Game_Name; ?> </option>
											<?php } ?>
										</select> <span class="text-danger">* (Click on the box to see games dropdown)</span>
									</div>
								</div>

								<div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="addCompSubcompOfGame">
									<!-- // on change of game list all the component and subcomponent here -->
									addCompSubcompOfGame
								</div>

								<div class="clearfix"></div>
								<div class="text-center">
									<button class="btn btn-primary" name="" type="submit">Create Mapping</button>
									<a href="<?php echo base_url('Competency/viewCompetencyMapping');?>" class="btn btn-outline-danger">Cancel</a>
								</div>

								<?php echo form_close();?>
							</div>
							<!-- end of adding users -->
						</div>
					</div>

					<script>
						$(document).ready(function(){
							<?php if(count($mappedCompSubcomp) > 0){ ?>
								appendCompetencyGameComponentSubcomponent('<?php echo implode('_', $mappedCompSubcomp); ?>');
								$('#Cmap_GameId').trigger('change');
							<?php } ?>
						});
					</script>