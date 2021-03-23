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
              <h1>Report Viewer Card Access</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('reportViewer'); ?>">Report Viewer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report Viewer Card Access</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <!-- <h5 class="text-blue">List</h5> -->
                  <?php 
                    echo 'Name : '.$details[0]->RV_Name.'<br />';
                    echo 'Email ID : '.$details[0]->RV_Email_ID.'<br />';
                    echo 'Enterprize Name : '.$details[0]->Enterprise_Name.'<br />';
                  ?>
                </div>

                <!-- Start Form -->
                <form action="#" method="POST" id="formHTML">

                <div class="clearfix pb-2">
                  <div class="col-md-2 custom-control custom-checkbox pull-right">
                    <input type="checkbox" class="custom-control-input" value="" id="select_all" name="select_all">&nbsp;
                    <label class="custom-control-label" for="select_all">Select/Unselect All</label>
                  </div>
                </div>

                <table class="table table-striped table-bordered table-hover table-sm table-responsive-md"> 
                  <thead> 
                    <tr> 
                      <th>Select</th>
                      <th>Sl.No.</th>
                      <th>Card Name</th>
                      <th>Card Category</th>
                    </tr> 
                  </thead> 

                  <?php if (count($gameList) < 1 || $gameList == '') { ?>
                    <tr>
                      <td class="text-danger text-center" colspan="4"> No Record Found </td>
                    </tr>
                  <?php 
                  } // only if record exists
                  else if (!empty($gameList)) {
                    $slno = 0; // setting variable for table serial Number
                    
                    // print_r($gameList);
                    foreach ($gameList as $detailsRow) { 
                      $slno++; // incrementing serial number

                      if ($detailsRow->RVCA_Game_ID) {
                        $checked = 'checked';
                      }
                      else {
                        $checked = '';
                      }
                  ?>
                  <tbody>
                    <tr> 
                      <!-- Select -->
                      <td><!-- bootstrap checkbox --> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" value="<?php echo $detailsRow->Game_ID; ?>" id="<?php echo $detailsRow->Game_ID; ?>" name="selectedGames[]" <?php echo $checked; ?>> <label class="custom-control-label" for="<?php echo $detailsRow->Game_ID; ?>"></label> </div> </td> 
                      <!-- Sl.No. -->
                      <td><?php echo $slno; ?></td> 
                      <!-- Card Name -->
                      <td><?php echo $detailsRow->Game_Name; ?></td> 
                      <!-- Card Category -->
                      <td><?php echo $detailsRow->Game_Category; ?></td>
                    </tr>
                  <?php } } ?>
                  </tbody>
                </table>

                <div class="clearfix"></div>
                <div class="text-center">
                  <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary px-5"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Submit</button>
                  <a href="<?php echo base_url('reportViewer'); ?>"><button type="button" name="submit"class="btn btn-danger px-5"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button></a>
                </div>

                </form>
                <!-- End Form -->

              </div>
            </div>
          </div>
        </div>

<script>
  // for selecting all users at ones or removing all selected users at once
  $('#select_all').click(function(i,e) {
    if($(this).is(':checked')) {
      $('input[type=checkbox]').each(function(i,e) {
        $(this).prop('checked',true);
      });
    }
    else {
      $('input[type=checkbox]').each(function(i,e) {
        $(this).prop('checked',false);
      });
    }
  }); // end of On Click select_all function

  // on form submit
  $('#formHTML').submit(function(e) {
    // removing all error message when form submit
    $(".removemsg").html('');
    // console.log('inside form submit');

    // disable button
    //$('#submit').prop("disabled", true);
    // adding spinner to button
    //$('#submit').html('<span class="btn-label"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>');

    var enterprizeID   = '<?php echo $details[0]->RV_EnterpriseID; ?>';
    var reportViewerID = '<?php echo $details[0]->RV_ID; ?>';

    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('ReportViewer/giveCardAccess/'); ?>"+enterprizeID+"/"+reportViewerID,
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
        $('#submit').html('<span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Submit');

        switch (result.status) {
          case 'error':
            // console.log(result.message);
            // $("#enterprizeIDError").html(result.message.enterprizeIDError);
            // $("#cardIDError").html(result.message.cardIDError);
            // $("#replayCountError").html(result.message.replayCountError);
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
</script>
