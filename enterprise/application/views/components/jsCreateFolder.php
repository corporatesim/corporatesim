<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>JS Create Folder</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">JS Create Folder</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row pb-3">
          <div class="col-12">
            <!-- Start of Creating Folder -->
            <h1 class="text-blue hideShowMap" id="removeColor" data-value="removeColor">
              <a href="javascript:void(0)" id="addList" data-toggle="collapse" value="removeColor" title="" ata-original-title="Create New Folder" data-target="#demo"><i class="fa fa-plus-circle"> Create Folder</i></a>
            </h1>
            <h1 class="text-danger hideShowMap d-none" id="addColor" data-value="addColor">
              <a href="javascript:void(0)" id="addList" value="addColor" data-toggle="collapse" title="" ata-original-title="Create New Folder" data-target="#demo"><i class="fa fa-minus-circle text-danger"> Create Folder</i></a>
            </h1>
   
            <div class="bg-white border-radius-4 box-shadow mb-30">
              <div id="demo" class="collapse py-5">
              <div class="col-12">
                <!-- Start Form -->
                <form action="" method="POST" id="formHTML">

                  <div class="form-group row text-left">
                    <div class="form-group col-12 col-md-6">
                      <label>Create Folder <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fa fa-folder"></i>
                          </div>
                        </div>
                        <div class="custom-file">
                          <input type="text" class="form-control" required id="folderTitle" name="folderTitle" placeholder="Enter Folder Name">
                        </div>
                      </div>
                      <span id="folderTitleError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="clearfix"></div>
                  <div class="col-md-6 mt-2 text-center">
                    <button class="btn btn-success px-5" type="submit" id="submit" name="submit" value="submit"><span class="btn-label"><i class="fa fa-folder"></i></span>&nbsp;Create</button>
                    <button class="btn btn-danger px-5" type="reset" data-target="#demo" data-toggle="collapse" name="mapCancel" id="mapCancel"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button>
                  </div>

                </form>
                <!-- End Form -->
              </div>
              </div>
            </div>
            <!-- End of Creating Folder -->
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
                        <th>Folder Name</th>
                        <th>Created On</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (count($details) < 1 || $details == '') { ?>
                        <tr>
                          <td class="text-danger text-center" colspan="3"> No Record Found </td>
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
                          <!-- Folder Name -->
                          <td><?php echo $detailsRow->JS_FD_Name; ?></td>
                          <!-- Created On (Date, Day, Time) -->
                          <td><?php echo date('d-m-Y, l, g:i:s A', strtotime($detailsRow->JS_FD_Created_On)); ?></td>
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
        url: "<?php echo base_url('JSCreateFolder/createFolder'); ?>",
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
          $('#submit').html('<span class="btn-label"><i class="fa fa-folder"></i></span>&nbsp;Create');

          switch (result.status) {
            case 'error':
              // console.log(result.message);
              $("#folderTitleError").html(result.message.folderTitleError);
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
                  window.location = "<?php echo base_url('JSCreateFolder'); ?>";
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