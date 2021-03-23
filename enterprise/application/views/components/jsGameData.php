<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>JS Game Data</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">JS Game Data</li>
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
                        <th>Name</th>
                        <th>Played on</th>
                        <th>Game Name</th>
                        <th>Scenario Name</th>
                        <th>JS Game Name</th>
                        <th class="datatable-nosort noExport">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (count($details) < 1 || $details == '') { ?>
                        <tr>
                          <td class="text-danger text-center" colspan="7"> No Record Found </td>
                        </tr>
                      <?php 
                      } // only if record exists
                      else if (!empty($details)) {
                        $slno = 0; // setting variable for table serial Number
                        
                        // print_r($details);
                        foreach ($details as $detailsRow) { 
                          $slno++; // incrementing serial number
                      ?>
                        <tr>
                          <!-- Sl.No. -->
                          <td><?php echo $slno; ?></td>
                          <!-- Name -->
                          <td data-toggle="tooltip" data-original-title="<?php echo $detailsRow->User_username; ?>"><?php echo $detailsRow->User_fname.' '.$detailsRow->User_lname.' ('.$detailsRow->User_email.')'; ?></td>
                          <!-- Played On (Date, Time) -->
                          <td><?php echo date('d-m-Y, g:i:s A', strtotime($detailsRow->JSDATA_CreatedOn)); ?></td>
                          <!-- Game Name -->
                          <td><?php echo $detailsRow->Game_Name; ?></td>
                          <!-- Scenario Name -->
                          <td><?php echo $detailsRow->Scen_Name; ?></td>
                          <!-- JS Game Name -->
                          <td><?php echo $detailsRow->Js_Name; ?></td>
                          <!-- Action -->
                          <td>
                            <button type="button" class="btn btn-link" title="" data-toggle="tooltip" data-original-title="Details" data-id="<?php echo $detailsRow->JSDATA_Id; ?>" onclick="callDetails(this)">
                              <i class="fa fa-eye text-info fa-2x"></i>
                            </button>
                          </td>
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
  // Showing Details on pop up
  function callDetails(e) {
    var id = $(e).data('id');

    var result = triggerAjax("<?php echo base_url('AjaxNew/getJSGameDetails/'); ?>"+id);
    // console.log(result);

    if (result.status == 200) {
      // Bootstrap Model
      $('#model_Details_Header').html('Details');
      $('#model_Details_msg').html(result.description);
      $('#modal_Details').modal('show');
    }
  }
</script>