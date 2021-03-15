<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">

            <div class="title">
              <h1>User Creation - Email Details</h1>
            </div>

            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Email Details</li>
              </ol>
            </nav>

          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <h5 class="text-blue">Email Details</h5>
                </div>
                <div class="row" id="addTable">
                  <table class="stripe hover multiple-select-row data-table-export">
                    <thead>
                      <tr>
                        <th>Sl.No.</th>
                        <th>Email</th>
                        <th class="datatable-nosort noExport">Details</th>
                        <th>Status</th>
                        <th>Enterprize</th>
                        <th>Date, Day, Time</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($details) < 1 || $details == '') { ?>
                      <tr>
                        <td class="text-danger text-center" colspan="15"> No Record Found </td>
                      </tr>
                      <!-- only if record exists -->
                    <?php } else if (!empty($details)) {
                      $slno = 0; // setting variable for table serial Number
                      
                      // print_r($details);
                      foreach ($details as $detailsRow) {
                        $slno++; // incrementing serial number

                        // Setting Status
                        // ESD_Status => 0->Not Sent, 1-> Sent
                        switch ($detailsRow->ESD_Status) {
                          case '0':
                            $status = 'Not Sent';
                            break;
                          case '1':
                            $status = 'Sent';
                            break;
                          default :
                            $status = '';
                        }
                    ?>
                      <tr>
                        <td><?php echo $slno; ?></td>
                        <td><?php echo $detailsRow->ESD_To; ?></td>
                        <td>
                          <button type="button" class="btn btn-link" title="" data-toggle="tooltip" data-original-title="Email Details" data-id="<?php echo $detailsRow->ESD_ID; ?>" onclick="callDetails(this)">
                            <i class="fa fa-eye text-info fa-2x"></i>
                          </button>
                        </td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $detailsRow->Enterprise_Name; ?></td>
                        <td><?php echo date('d-m-Y, l, g:i:s A', strtotime($detailsRow->ESD_DateTime)); ?></td>
                      </tr>
                    <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
<script>
  // Showing Email Details on pop up
  function callDetails(e) {
    // Email Details ID
    var ESD_ID = $(e).data('id');

    var result = triggerAjax("<?php echo base_url('AjaxNew/getEmailDetails/'); ?>"+ESD_ID);
    //console.log(result);

    if (result.status == 200) {
      // Bootstrap Model
      $('#model_Details_Header').html('Email Details');
      $('#model_Details_msg').html(result.description);
      $('#modal_Details').modal('show');
    }
  }
</script>
