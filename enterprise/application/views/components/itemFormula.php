<script type="text/javascript">
  var loc_url_del = "<?php echo base_url('Competence/deleteFormula/');?>";
  var func        = "<?php echo $this->uri->segment(2);?>";
</script>
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
              <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                <a href="<?php echo base_url('Competence/addItemFormula');?>" data-toggle="tooltip" title="Add Formula" id="addItemFormula">
                  <i class="fa fa-plus-circle text-blue"></i></a> Add Formula
              <?php } else{ ?>
                Formula
              <?php } ?>
              </h1>
            </div>
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Formula</li>
                </ol>
              </nav>
          </div>
        </div>

          <div class="row">

            <div class="col-md-12 col-sm-12">
              <div class="title">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                  <div class="clearfix mb-20">
                    <h5 class="text-blue">Formula List</h5>
                  </div>
                  <div class="row" id="addTable">
                    <table class="stripe hover multiple-select-row data-table-export">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                            <th>Enterprize</th>
                          <?php } ?>
                          <th>Formula Name</th>
                          <th>Formula expression</th>
                          <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                            <th class="datatable-nosort noExport">Report Title and Definition</th>
                            <th class="datatable-nosort noExport">Executive Summary</th>
                            <th class="datatable-nosort noExport">Detailed Report</th>
                            <th class="datatable-nosort noExport">Conclusion Section</th>
                            <th class="datatable-nosort noExport">Action</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($itemFormulaList) < 1 || $itemFormulaList == ''){ ?>
                          <tr>
                            <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                              <td class="text-danger text-center" colspan="8">No Record Found</td>
                            <?php } else { ?>
                              <td class="text-danger text-center" colspan="3">No Record Found</td>
                            <?php } ?>
                          </tr> 
                          <!-- only if record exists -->
                        <?php } else if(!empty($itemFormulaList)){
                          $i=1; 

                          // print_r($itemFormulaList);
                          foreach($itemFormulaList as $itemFormulaRow => $value){ ?>
                          <tr>
                            <!-- Sl.No. -->
                            <td><?php echo $i;?></td>
                            <!-- Item Enterprise Name -->
                            <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                              <td><?php echo $value[3];?></td>
                            <?php } ?>
                            <!-- Item Formula Title -->
                            <td><?php echo $value[1];?></td>
                            <!-- Item Formula Expression -->
                            <td><?php echo $value[2];?></td>
                            
                            <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                              
                            <!-- Report Title and Definition -->
                            <td>
                              <a href="<?php echo base_url('Competence/itemReportTitleDefinition/').base64_encode($value[0]).'/'.base64_encode($value[4]) ;?>" data-toggle="tooltip" title="Report Title and Definition">
                                <i class="fa fa-edit"></i>
                              </a>
                            </td>

                            <!-- Executive Summary -->
                            <td>
                              <div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                  <i class="fa fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-left">
                                  <!-- 1-> Average -->
                                  <a class="dropdown-item" href="<?php echo base_url('Competence/itemReportExecutiveSummary/').base64_encode($value[0]).'/'.base64_encode($value[4]); ?>">
                                    <i class="fa fa-edit"></i> Executive Summary 1
                                  </a>
                                  <!-- 2-> Individual -->
                                  <!-- CSI -> Executive Summary Individual -->
                                  <a class="dropdown-item" href="<?php echo base_url('Competence/itemReportESI/').base64_encode($value[0]).'/'.base64_encode($value[4]); ?>">
                                    <i class="fa fa-edit"></i> Executive Summary 2
                                  </a>
                                </div>
                              </div>
                            </td>

                            <!-- Detailed Report -->
                            <td>
                              <a href="<?php echo base_url('Competence/itemReportDetailedReport/').base64_encode($value[0]).'/'.base64_encode($value[4]) ;?>" data-toggle="tooltip" title="Detailed Report">
                                <i class="fa fa-edit"></i>
                              </a>
                            </td>

                            <!-- Conclusion Section -->
                            <td>
                              <div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                  <i class="fa fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-left">
                                  <!-- 2-> Individual -->
                                  <!-- CSI -> ConclusionSectionIndividual -->
                                  <a class="dropdown-item" href="<?php echo base_url('Competence/itemReportCSI/').base64_encode($value[0]).'/'.base64_encode($value[4]); ?>">
                                    <i class="fa fa-edit"></i> Conclusion 1
                                  </a>
                                  <!-- 1-> Average -->
                                  <a class="dropdown-item" href="<?php echo base_url('Competence/itemReportConclusionSection/').base64_encode($value[0]).'/'.base64_encode($value[4]); ?>">
                                    <i class="fa fa-edit"></i> Conclusion 2
                                  </a>
                                </div>
                              </div>
                            </td>

                            <!-- Action -->
                            <td>
                              <div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                  <i class="fa fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-left">
                                  <a class="dropdown-item" href="<?php echo base_url('Competence/editItemFormula/').base64_encode($value[0]);?>">
                                    <i class="fa fa-pencil"></i> Edit
                                  </a>
                                  <a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo $value[0]; ?>" title="Delete">
                                    <i class="fa fa-trash"></i> Delete
                                  </a>
                                </div>
                              </div>
                            </td>
                            <?php } ?>
                          </tr>
                        <?php $i++; } } ?> 
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- end of adding users -->
                