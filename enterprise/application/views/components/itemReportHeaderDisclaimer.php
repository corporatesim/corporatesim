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
                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-10">
                      <label for="details">Details:</label>
                      <div class="input-group">
                        <textarea id="" name="details" class="form-control details"><?php echo $headerDetails[0]->IR_Text; ?></textarea>
                      </div>
                      <div class="details_error"></div>
                    </div>
                  </div>

                  <div class="clearfix"></div>
                  <div class="text-center">
                    <button  type="submit"class="btn btn-primary" name="" id="AddUpdatedReport">Save</button>
                    <a href="<?php echo base_url('Competence/itemReportCreation');?>" class="btn btn-outline-danger">Cancel</a>
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

