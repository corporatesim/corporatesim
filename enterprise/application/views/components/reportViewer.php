<?php 
  // Setting Login user Role
  // superadmin, 1 = Enterprize, 2 = SubEnterprize, 3 = Report Viewer
  $userRole = $this->session->userdata('loginData')['User_Role'];
?>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <!-- <h1><i class="fa fa-user-secret text-blue"></i> Report Viewer</h1> -->
              <h1>Report Viewer</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report Viewer</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row pb-3">
          <div class="col-12">
            <!-- Start of Adding Report Viewer -->
            <h1 class="text-blue hideShowMap" id="removeColor" data-value="removeColor">
              <a href="javascript:void(0)" id="addList" data-toggle="collapse" value="removeColor" title="" ata-original-title="Add Report Viewer" data-target="#demo"><i class="fa fa-plus-circle"> Add Report Viewer</i></a>
            </h1>
            <h1 class="text-danger hideShowMap d-none" id="addColor" data-value="addColor">
              <a href="javascript:void(0)" id="addList" value="addColor" data-toggle="collapse" title="" ata-original-title="Add Report Viewer" data-target="#demo"><i class="fa fa-minus-circle text-danger"> Add Report Viewer</i></a>
            </h1>
   
            <div class="bg-white border-radius-4 box-shadow mb-30">
              <div id="demo" class="collapse py-5">
              <div class="col-12">
                <!-- Start Form -->
                <form action="#" method="POST" id="formHTML">

                  <?php if ($userRole == 'superadmin') { ?>
                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="enterprizeID">Select Enterprize <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select2 form-control" name="enterprizeID" id="enterprizeID" required>
                        <option value="">--Select Enterprize--</option>
                        <?php foreach ($enterprizeList as $detailsRow) { ?>
                          <option value="<?php echo $detailsRow->Enterprise_ID; ?>"><?php echo $detailsRow->Enterprise_Name; ?></option>
                        <?php } ?>
                      </select>
                      <span id="enterprizeIDError" class="removemsg text-danger"></span>
                    </div>
                  </div>
                  <?php } else { ?>
                    <input type="hidden" name="enterprizeID" value="<?php echo $this->session->userdata('loginData')['User_Id']; ?>">
                  <?php } ?>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="reportViewerName">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input class="form-control" type="text" name="reportViewerName" id="reportViewerName" required placeholder="Enter Full Name">
                      <span id="reportViewerNameError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="reportViewerEmailID">Email ID <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input class="form-control" type="text" name="reportViewerEmailID" id="reportViewerEmailID" required placeholder="Enter Email ID">
                      <span id="reportViewerEmailIDError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="reportViewerPassword">Password <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input class="form-control" type="text" name="reportViewerPassword" id="reportViewerPassword" required placeholder="Enter Password">
                      <span id="reportViewerPasswordError" class="removemsg text-danger"></span>
                    </div>
                  </div> 

                  <div class="clearfix"></div>
                  <div class="col-md-10 mt-2 text-center">
                    <button class="btn btn-success px-5" type="submit" id="submit" name="submit" value="submit"><span class="btn-label"><i class="fa fa-user-secret"></i></span>&nbsp;Add</button>
                    <button class="btn btn-danger px-5" type="reset" data-target="#demo" data-toggle="collapse" name="mapCancel" id="mapCancel"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button>
                  </div>

                </form>
                <!-- End Form -->
              </div>
              </div>
            </div>
            <!-- End of Adding Report Viewer -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <h5 class="text-blue">List</h5>
                </div>
                <div class="row" id="addTable">
                  <table class="stripe hover multiple-select-row data-table-export">
                    <thead>
                      <tr>
                        <th>Sl.No.</th>
                        <?php if ($userRole == 'superadmin') { ?>
                          <th>Enterprize Name</th>
                        <?php } ?>
                        <th>Name</th>
                        <th>Email ID</th>
                        <th>Password</th>
                        <th>Card Access</th>
                        <th>Added On</th>
                        <!-- <th data-orderable="false">Action</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (count($details) < 1 || $details == '') { ?>
                        <tr>
                          <?php if ($userRole == 'superadmin') { ?>
                            <td class="text-danger text-center" colspan="6"> No Record Found </td>
                          <?php } else { ?>
                            <td class="text-danger text-center" colspan="5"> No Record Found </td>
                          <?php } ?>
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
                          <?php if ($userRole == 'superadmin') { ?>
                            <!-- Enterprize Name -->
                            <td><?php echo $detailsRow->Enterprise_Name; ?></td>
                          <?php } ?>
                          <!-- Name -->
                          <td><?php echo $detailsRow->RV_Name; ?></td>
                          <!-- Email ID -->
                          <td><?php echo $detailsRow->RV_Email_ID; ?></td>
                          <!-- Password -->
                          <td><?php echo $detailsRow->RV_Password; ?></td>
                          <!-- Card Access -->
                          <td><strong><a href="<?php echo base_url('reportViewer/reportViewerCardAccess/'); echo base64_encode($detailsRow->RV_ID); ?>" style="color:#0029ff;"><?php echo $detailsRow->cardCount; ?></a></strong></td>
                          <!-- Added On (Date, Day, Time) -->
                          <td><?php echo date('d-m-Y, l, g:i:s A', strtotime($detailsRow->RV_Created_On)); ?></td>
                          <!-- Action -->
                          <!-- <td></td> -->
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

  $(document).ready(function() {
    // after click cancel it hides the form area
    $(document).on('click', '#mapCancel', function () {
      $('#addColor').addClass('d-none');
      $('#removeColor').removeClass('d-none');
    });

    $('.hideShowMap').click(function () {
      if($(this).data('value') == 'addColor') {
        $('#addColor').addClass('d-none');
        $('#removeColor').removeClass('d-none');
      }
      else if($(this).data('value') == 'removeColor') {
        $('#removeColor').addClass('d-none');
        $('#addColor').removeClass('d-none');
      }
    });

    // on form submit
    $('#formHTML').submit(function(e) {
      // removing all error message when form submit
      $(".removemsg").html('');

      // disable button
      $('#submit').prop("disabled", true);
      // adding spinner to button
      $('#submit').html('<span class="btn-label"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>');

      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('ReportViewer/AddReportViewer'); ?>",
        data: new FormData(document.getElementById('formHTML')),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        dataType: "html",
        processData: false,
        
        success: function(result) {
          result = JSON.parse(result);
          // console.log(result.message);

          // enabling button
          $('#submit').prop("disabled", false);
          // removing spinner from button
          $('#submit').html('<span class="btn-label"><i class="fa fa-user-secret"></i></span>&nbsp;Add');

          switch (result.status) {
            case 'error':
              // console.log(result.message);
              $("#enterprizeIDError").html(result.message.enterprizeIDError);
              $("#reportViewerNameError").html(result.message.reportViewerNameError);
              $("#reportViewerEmailIDError").html(result.message.reportViewerEmailIDError);
              $("#reportViewerPasswordError").html(result.message.reportViewerPasswordError);  
              break;

            case '200':
              Swal.fire(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              }).then(function(){
                  window.location = "<?php echo base_url('reportViewer'); ?>";
              });
              break;

            case '201':
              Swal.fire(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              });
              break;
          }
        }
      });
    }); // end of form submit
  });
</script>
