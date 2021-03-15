<script type="text/javascript">
	var loc_url_del = "<?php echo base_url('Competence/deleteMapping/');?>";
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
              <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                <a href="<?php echo base_url('Competence/addCompetenceMapping');?>" data-toggle="tooltip" title="Add Mapping" id="addCompetence">
                  <i class="fa fa-plus-circle text-blue"></i></a> Add Mapping
              <?php } else{ ?>
                Mapping
              <?php } ?>
              </h1>
						</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Mapping</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
									<div class="clearfix mb-20">
										<h5 class="text-blue">Mapping List</h5>
									</div>
									<div class="row" id="addTable">
										<table class="stripe hover multiple-select-row data-table-export nowrap">
											<thead>
												<tr>
													<th>ID</th>
                          <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                            <th>Enterprize</th>
                          <?php } ?>
                          <th>Factor</th>
													<th>Sub-factor</th>
													<th>Card</th>
													<th class="datatable-nosort noExport">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php if(count($competenceMapping) < 1){ ?>
													<tr>
														<td class="text-danger text-center" colspan="4"> No Record Found </td>
													</tr>
													<!-- only if record exists -->
												<?php } else{ $i=1; 

                          // print_r($competenceMapping);
                          foreach ($competenceMapping as $competenceMappingRow => $value) { ?>
													<tr>
														<!-- ID -->
														<td><?php echo $i;?></td>
                            <!-- Competence Enterprise Name -->
                            <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                              <td><?php echo $value[2];?></td>
                            <?php } ?>
                            <!-- Performance Type -->
                            <?php 
                              switch($value[3]) {
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
														<td><?php echo $competenceMappingRow;?></td>
														<!-- Competence Description -->
														<td><?php echo $value[0];?></td>
														<!-- Action -->
                            <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
														<td>

															<div class="dropdown">
																<a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
																	<i class="fa fa-ellipsis-h"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-left">
																	<a class="dropdown-item" href="<?php echo base_url('Competence/editCompetenceMapping/').base64_encode($value[1]);?>">
																		<i class="fa fa-pencil"></i> Edit</a>

																		<a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo $value[1]; ?>" title="Delete">
																		<i class="fa fa-trash"></i> Delete</a>

																	</div>
																</div>

															</td>
                            <?php } else{ ?>
                              <td>
                                <a href="<?php echo base_url('Competence/editCompetenceMapping/').base64_encode($value[1]);?>">
                                <i class="fa fa-eye"></i> View</a>
                              </td>
                            <?php } ?>
														</tr>
														<?php $i++; } } ?>
													</tbody>
												</table>
											</div>
										</div>
										<!-- end of adding users -->
									</div>
								</div>