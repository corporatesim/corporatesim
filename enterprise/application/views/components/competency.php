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
						<div class="title">
							<h1>
								<a href="javascript:void(0);" data-toggle="tooltip" title="Add Items" id="addCompetency">
									<i class="fa fa-plus-circle text-blue"></i></a> Items
								</h1>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Items</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
									<div class="clearfix mb-20">
										<h5 class="text-blue">Items List</h5>
									</div>
									<div class="row" id="addTable">
										<table class="stripe hover multiple-select-row data-table-export nowrap">
											<thead>
												<tr>
													<th>ID</th>
                          <th>Enterprise</th>
													<th>Name/Level</th>
													<th>Description</th>
													<th class="datatable-nosort noExport">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php if(count($competency) < 1){ ?>
													<tr>
														<td class="text-danger text-center" colspan="4"> No Record Found </td>
													</tr>
													<!-- only if record exists -->
												<?php } else{ $i=1; foreach ($competency as $competencyRow) { ?>
													<tr id="parent__<?php echo $competencyRow->Compt_Id;?>">
														<!-- ID -->
														<td><?php echo $i;?></td>
                            <!-- Competency Enterprise Name -->
                            <td><?php echo $competencyRow->Enterprise_Name;?></td>
														<!-- Competency Name -->
														<td id="<?php echo $competencyRow->Compt_Id;?>__Compt_Name" class="editable"><?php echo $competencyRow->Compt_Name;?></td>
														<!-- Competency Description -->
														<td id="<?php echo $competencyRow->Compt_Id;?>__Compt_Description" class="editable"><?php echo ($competencyRow->Compt_Description)?$competencyRow->Compt_Description:'<span class="text-danger">No Description</span>';?></td>
														<!-- Action -->
														<td>
															<!-- edit icon -->
															<a href="javascript:void(0);" data-function="editCompetency" data-toggle="tooltip" title="Edit" data-pid="<?php echo $competencyRow->Compt_Id;?>" class="editIcon" id="<?php echo $competencyRow->Compt_Id;?>__edit">
																<i class="fa fa-pencil"></i>
															</a>

															<!-- save icon -->
															<a href="javascript:void(0);" data-function="editCompetency" data-toggle="tooltip" title="Save" data-pid="<?php echo $competencyRow->Compt_Id;?>" class="saveIcon d-none" id="<?php echo $competencyRow->Compt_Id;?>__save">
																<i class="fa fa-save"></i>
															</a>
															
															&nbsp;
															<!-- delete icon -->
															<a href="javascript:void(0);" data-col_table="Compt_Delete__items__Compt_Id__listCompetency" data-toggle="tooltip" title="Delete" data-pid="<?php echo $competencyRow->Compt_Id;?>" class="deleteIcon">
																<i class="fa fa-trash"></i>
															</a>

														</td>
													</tr>
													<?php $i++; } } ?>
												</tbody>
											</table>
										</div>
									</div>
									<!-- end of adding users -->
								</div>
							</div>

							<script>
								$(document).ready(function()
								{
									$('#addCompetency').on('click', function(){
                    var addCompetencyForm = "";
                    var entOptions = '<option value="">---Select Enterprise--- </option>';

                    <?php foreach ($enterpriseDetails as $row) { ?>
                    entOptions +='<option value="<?php echo $row->Enterprise_ID; ?>"><?php echo $row->Enterprise_Name; ?></option>';
                    <?php } ?>

                    addCompetencyForm +='<form id="competencyForm">  <select class="custom-select2 form-control" name="Compt_Enterprise_ID" id="Compt_Enterprise_ID">'+entOptions+'</select> <input required type="text" name="Compt_Name" placeholder="Item Name" class="swal2-input"> <textarea name="Compt_Description" class="swal2-input" placeholder="Item Description"></textarea><br> <button class="btn btn-primary">Add</button> <button type="button" class="btn btn-danger cancelPopup" onClick="return Swal.close();">Cancel</button></form>';
										Swal.fire({
										// icon: 'question',
										title            : 'Add Items',
										html             : addCompetencyForm,
										showConfirmButton: false,
									});
										addCompetency();
									});
								});

								function addCompetency()
								{
								// add competency via ajax
								$('#competencyForm').on('submit', function(e){
									e.preventDefault();
									var formData = $(this).serialize();
									var result   = triggerAjax("<?php echo base_url('Ajax/addCompetency'); ?>",formData);
									Swal.fire({
										position         : result.position,
										icon             : result.icon,
										title            : result.title,
										html             : result.message,
										showConfirmButton: result.showConfirmButton,
										timer            : result.timer,
									});
									listCompetency();
								});
							}
						</script>