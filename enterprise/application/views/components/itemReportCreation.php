<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">

            <div class="title">
              <h1>Report Creation</h1>
            </div>

            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report Creation</li>
              </ol>
            </nav>

          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <h5 class="text-blue">Report Creation</h5>
                </div>
                <div class="row" id="addTable">
                  <table class="stripe hover multiple-select-row data-table-export">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Report Section</th>
                        <th>Info</th>
                        <th class="datatable-nosort noExport">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- 1st Row -->
                      <tr>
                        <!-- ID -->
                        <td>1</td>
                        <!-- Report Section Name -->
                        <td>Header Section</td>
                        <!-- Info -->
                        <td>Title of the report and any other standard text (will show in all reports if used)</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemReportHeaderSection'); ?>" data-toggle="tooltip" title="Edit Header Section of Report">
                            <i class="fa fa-edit text-primary fa-2x"></i>
                          </a>
                        </td>
                      </tr>

                      <!-- 2nd Row -->
                      <tr>
                        <!-- ID -->
                        <td>2</td>
                        <!-- Report Section Name -->
                        <td>Title and Definition</td>
                        <!-- Info -->
                        <td>Title (if 1 is not used), about this report and the factors/sub-factors in the report</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>

                      <!-- =========== -->
                      <!-- 3rd Row -->
                      <tr>
                        <!-- ID -->
                        <td>3</td>
                        <!-- Report Section Name -->
                        <td>Executive Summary 1</td>
                        <!-- Info -->
                        <td>Summary of the report, factors/sub-factors used, overall score, highlights and recommendation</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>
                      <!-- 4rd Row -->
                      <tr>
                        <!-- ID -->
                        <td>4</td>
                        <!-- Report Section Name -->
                        <td>Executive Summary 2</td>
                        <!-- Info -->
                        <td>Summary of the report, factors/sub-factors used, overall score, highlights and recommendation</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>
                      <!-- =========== -->

                      <!-- 5th Row -->
                      <tr>
                        <!-- ID -->
                        <td>5</td>
                        <!-- Report Section Name -->
                        <td>Detailed Report</td>
                        <!-- Info -->
                        <td>Use this report Section from Formula Tab on right side of table for each formula under Detailed Report Column</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>

                      <!-- 6th Row -->
                      <tr>
                        <!-- ID -->
                        <td>6</td>
                        <!-- Report Section Name -->
                        <td>Competence Readiness (CR)<br />Competence Application (CA)<br />Simulated Performance (SP)</td>
                        <!-- Info -->
                        <td>Score range based explanation of each sub-factor that appears in the overall score calculation</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>

                      <!-- =========== -->
                      <!-- 7th Row -->
                      <tr>
                        <!-- ID -->
                        <td>7</td>
                        <!-- Report Section Name -->
                        <td>Conclusion Section 1</td>
                        <!-- Info -->
                        <td>Concluding remarks,overall score, individual limits, recommendations etc.</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>
                      <!-- 8th Row -->
                      <tr>
                        <!-- ID -->
                        <td>8</td>
                        <!-- Report Section Name -->
                        <td>Conclusion Section 2</td>
                        <!-- Info -->
                        <td>Concluding remarks,overall score, average limits, recommendations etc.</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Go to this Report Section" target="_blank">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </a>
                        </td>
                      </tr>
                      <!-- =========== -->

                      <!-- 9th Row -->
                      <tr>
                        <!-- ID -->
                        <td>9</td>
                        <!-- Report Section Name -->
                        <td>Disclaimer Section</td>
                        <!-- Info -->
                        <td>Disclaimer section is used in all report</td>
                        <!-- Action -->
                        <td>
                          <a href="<?php echo base_url('Competence/itemReportDisclaimerSection'); ?>" data-toggle="tooltip" title="Edit Disclaimer Section of Report">
                            <i class="fa fa-edit text-primary fa-2x"></i>
                          </a>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
