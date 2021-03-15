<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1><?php echo $reportType; ?></h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('Competence/itemFormula');?>">Formula</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $reportType; ?></li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="clearfix mb-20">
                  <h5 class="text-blue"><?php echo $reportType; ?></h5>
                </div>

                <form method="POST" action="" id="formData">
                  <!-- Enterprize Name -->
                  <div class="row col-10 form-group">
                    <label class="col-sm-12 col-md-3 col-form-label">Enterprize</label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value=""><?php echo $reportDetails[0]->Enterprise_Name; ?></option>
                      </select>
                    </div>
                  </div>

                  <!-- Formula Name -->
                  <div class="row col-10 form-group">
                    <label class="col-sm-12 col-md-3 col-form-label">Formula</label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value=""><?php echo $reportDetails[0]->Items_Formula_Title; ?></option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-10">
                      <label for="details">Details:</label>
                      <div class="input-group">
                        <textarea id="" name="details" class="form-control details">
                          <?php
                            if  ($reportType == 'Report Title and Definition') {
                              echo $reportDetails[0]->Items_Formula_Report_Name_Definition; 
                            }
                            else if ($reportType == 'Detailed Report') {
                              echo $reportDetails[0]->Items_Formula_Detailed_Report; 
                            }
                          ?>
                        </textarea>
                      </div>
                      <div class="details_error"></div>
                    </div>
                  </div>

                  <div class="clearfix"></div>
                  <div class="text-center">
                    <button  type="submit"class="btn btn-primary" name="" id="AddUpdatedReport">Save</button>
                    <a href="<?php echo base_url('Competence/itemFormula');?>" class="btn btn-outline-danger">Cancel</a>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>

<script type="text/javascript">
  $(document).ready(function() {
    CKEDITOR.replaceAll('details');
  });
</script>

