<!-- <script type="text/javascript">
	var loc_url_del = "<?php //echo base_url('Competence/deleteMaster/');?>";
	var func        = "<?php //echo $this->uri->segment(2);?>";
</script> -->
<div class="main-container">
	<!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">

				<div class="row">
					<div class="col-md-6 col-sm-12">

						<div class="title">
							<h1>
								<a href="javascript:void(0);" data-toggle="tooltip" title="Add Master" id="addCompetence">
									<i class="fa fa-plus-circle text-blue"></i></a> Master
							</h1>
						</div>

						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Master</li>
							</ol>
						</nav>

					</div>
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
								<div class="clearfix mb-20">
									<h5 class="text-blue">Master List</h5>
								</div>
								<div class="row" id="addTable">
									<table class="stripe hover multiple-select-row data-table-export">
										<thead>
											<tr>
												<th>ID</th>
                        <th>Enterprize</th>
                        <th>Factor Type</th>
												<th>Sub-factor</th>
												<th>Description</th>
                        <th class="datatable-nosort noExport">Report Creator</th>
												<th class="datatable-nosort noExport">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($competence) < 1){ ?>
												<tr>
													<td class="text-danger text-center" colspan="7"> No Record Found </td>
												</tr>
												<!-- only if record exists -->
											<?php } else{ $i=1; foreach ($competence as $competenceRow) { ?>
												<tr id="parent__<?php echo $competenceRow->Compt_Id;?>">
													<!-- ID -->
													<td><?php echo $i;?></td>
                          <!-- Competence Enterprise Name -->
                          <td><?php echo $competenceRow->Enterprise_Name;?></td>
                          <!-- Performance Type -->
                          <?php 
                            switch($competenceRow->Compt_PerformanceType) {
                              case 4:
                                $PerformanceType = 'Competence Readiness';
                                break;
                              case 5:
                                $PerformanceType = 'Competence Application';
                                break;
                              default:
                                $PerformanceType = 'Simulated Performance';
                            }
                          ?>
                          <td><?php echo $PerformanceType; ?></td>
													<!-- Competence Name -->
													<td id="<?php echo $competenceRow->Compt_Id;?>__Compt_Name" class="editable"><?php echo $competenceRow->Compt_Name;?></td>
													<!-- Competence Description -->
													<td id="<?php echo $competenceRow->Compt_Id;?>__Compt_Description" class="editable"><?php echo ($competenceRow->Compt_Description)?$competenceRow->Compt_Description:'<span class="text-danger">No Description</span>';?></td>
                          <!-- Conditions Text -->
                          <td>
                            <a href="<?php echo base_url('Competence/itemConditionText/').$competenceRow->Compt_Id; ?>" title="Item Conditions Text"><i class="fa fa-book"></i></a>
                          </td>
													<!-- Action -->
													<td style="width:70px;">
                                
														<!-- edit icon -->
														<a href="javascript:void(0);" data-function="editCompetence" data-toggle="tooltip" title="Edit" data-pid="<?php echo $competenceRow->Compt_Id;?>" class="editIcon" id="<?php echo $competenceRow->Compt_Id;?>__edit">
															<i class="fa fa-pencil"></i> Edit
														</a>

														<!-- save icon -->
														<a href="javascript:void(0);" data-function="editCompetence" data-toggle="tooltip" title="Save" data-pid="<?php echo $competenceRow->Compt_Id;?>" class="saveIcon d-none" id="<?php echo $competenceRow->Compt_Id;?>__save">
															<i class="fa fa-save"></i> Save
														</a>
														
														<!-- &nbsp; --><br />
														<!-- delete icon -->
														<a href="javascript:void(0);" data-col_table="Compt_Delete__ITEMS__Compt_Id__listCompetence" data-toggle="tooltip" title="Delete" data-pid="<?php echo $competenceRow->Compt_Id;?>" class="deleteIcon">
															<i class="fa fa-trash"></i> Delete
														</a>

													</td>
												</tr>
												<?php $i++; } } ?>
											</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
        </div>

<script>
	$(document).ready(function() {
		$('#addCompetence').on('click', function() {
      var addCompetenceForm = "";
      var entOptions = '<option value="">---Select Enterprize---</option>';

      <?php foreach ($enterpriseDetails as $row) { ?>
      entOptions +='<option value="<?php echo $row->Enterprise_ID; ?>"><?php echo $row->Enterprise_Name; ?></option>';
      <?php } ?>

      var radioOptions = '<div class="col-xs-12 h5 text-left"><div class="custom-control custom-radio"><input type="radio" id="Competence" name="Compt_PerformanceType" class="custom-control-input" value="4"><label class="custom-control-label" for="Competence">Competence Readiness</label></div></div> <div class="col-xs-12 h5 text-left"><div class="custom-control custom-radio"><input type="radio" id="Application" name="Compt_PerformanceType" class="custom-control-input" value="5"><label class="custom-control-label" for="Application">Competence Application</label></div></div> <div class="col-xs-12 h5 text-left"><div class="custom-control custom-radio"><input type="radio" id="SimulatedPerformance" name="Compt_PerformanceType" class="custom-control-input" checked value="3"><label class="custom-control-label" for="SimulatedPerformance">Simulated Performance</label></div></div>';

      addCompetenceForm +='<form id="competenceForm"> '+radioOptions+' <select name="Compt_Enterprise_ID" id="Compt_Enterprise_ID" class="custom-select2 form-control mt-4" required>'+entOptions+'</select> <input required type="text" name="Compt_Name" placeholder="Master Name" class="swal2-input"> <textarea name="Compt_Description" class="swal2-input" placeholder="Master Description"></textarea><br> <button class="btn btn-primary">Add</button> <button type="button" class="btn btn-outline-danger cancelPopup" onClick="return Swal.close();">Cancel</button></form>';

			Swal.fire({
			  //icon             : 'question',
			  title            : 'Add Master',
			  html             : addCompetenceForm,
			  showConfirmButton: false,
		  });
			addCompetence();
		});
	});

	function addCompetence() {
  	// add competence via ajax
  	$('#competenceForm').on('submit', function(e) {
  		e.preventDefault();
  		var formData = $(this).serialize();
  		var result   = triggerAjax("<?php echo base_url('Ajax/addCompetence'); ?>",formData);
  		Swal.fire({
  			position         : result.position,
  			icon             : result.icon,
  			title            : result.title,
  			html             : result.message,
  			showConfirmButton: result.showConfirmButton,
  			timer            : result.timer,
  		});
  		listCompetence();
  	});
  }
</script>