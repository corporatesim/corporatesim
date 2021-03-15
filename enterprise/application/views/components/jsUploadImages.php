<style>
  .avatar-image {
    width: 10.125rem;
    height: 6.125rem; 
  }
  .avatar-image .border {
    border-width: 3px !important; 
  }
  .avatar-image .rounded {
    border-radius: 4px !important; 
  }

  @media (max-width: 768px) {
    .avatar-image {
      width: 15.125rem;
      height: 11.125rem;
    }
    .avatar-image .border {
      border-width: 3px !important; 
    }
    .avatar-image .rounded {
      border-radius: 4px !important; 
    }
    .avatar-image .avatar-title {
      font-size: 42px; 
    }
  }
</style>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>JS Upload Images</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">JS Upload Images</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row pb-3">
          <div class="col-12">
            <!-- Start of Image Adding -->
            <h1 class="text-blue hideShowMap" id="removeColor" data-value="removeColor">
              <a href="javascript:void(0)" id="addList" data-toggle="collapse" value="removeColor" title="" ata-original-title="Upload New Image" data-target="#demo"><i class="fa fa-plus-circle"> Upload Image</i></a>
            </h1>
            <h1 class="text-danger hideShowMap d-none" id="addColor" data-value="addColor">
              <a href="javascript:void(0)" id="addList" value="addColor" data-toggle="collapse" title="" ata-original-title="Upload New Image" data-target="#demo"><i class="fa fa-minus-circle text-danger"> Upload Image</i></a>
            </h1>
   
            <div class="bg-white border-radius-4 box-shadow mb-30">
              <div id="demo" class="collapse py-5">
              <div class="col-12">
                <!-- Start Form -->
                <form action="<?php echo site_url('JSUploadImages/uploadImages'); ?>" method="POST" id="formHTML">

                  <div class="form-group row text-left">
                    <div class="form-group col-12 col-md-6">
                      <label for="folderName">Select Folder</label>
                      <div class="input-group">
                        <select name="folderName" id="folderName" class="form-control">
                          <option value="">--Select--</option>
                          <?php foreach ($detailsFolderList as $detailsRow) { ?>
                            <option value="<?php echo $detailsRow->JS_FD_Name; ?>"> 
                              <?php echo $detailsRow->JS_FD_Name; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <span id="folderNameError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="form-group row text-left">
                    <div class="form-group col-12 col-md-6">
                      <label>Image <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fa fa-image"></i>
                          </div>
                        </div>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="fileUpload" name="fileUpload" multiple="multiple" accept="image/*" required onchange="document.getElementById('imageShow').src = window.URL.createObjectURL(this.files[0])">
                          <label class="custom-file-label" for="fileUpload">Choose Image...</label>
                        </div>
                      </div>
                      <span id="fileUploadError" class="removemsg text-danger"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 d-none" id="imageShowHide">
                      <label>Selected Image</label>
                      <div class="input-group">
                        <div class="avatar-image">
                          <img id="imageShow" src="" alt="image" class="avatar-image rounded">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="clearfix"></div>
                  <div class="col-md-6 mt-2 text-center">
                    <button class="btn btn-success px-5" type="submit" id="submit" name="submit" value="submit"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Upload</button>
                    <button class="btn btn-danger px-5" type="reset" data-target="#demo" data-toggle="collapse" name="mapCancel" id="mapCancel"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button>
                  </div>

                </form>
                <!-- End Form -->
              </div>
              </div>
            </div>
            <!-- End of Image Adding -->
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
                        <th data-orderable="false">Images</th>
                        <th>Image url</th>
                        <th>Image Size</th>
                        <th>Image Height</th>
                        <th>Image Width</th>
                        <th>Uploaded On</th>
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

                          // Setting image URL, height and width
                          if (!empty($detailsRow->JS_IMG_Folder)) 
                            $folderName = $detailsRow->JS_IMG_Folder.'/';
                          else
                            $folderName = '';

                          $imagePath  = base_url('../jsGame/gameData/'.$folderName);
                          $imageName  = $detailsRow->JS_IMG_FileName;
                          $imageURL   = $imagePath . $imageName;
                          list($width, $height) = getimagesize($imageURL);
                      ?>
                        <tr>
                          <!-- Sl.No. -->
                          <td><?php echo $slno; ?></td>
                          <!-- Images -->
                          <td>
                            <div class="avatar-image">
                              <img id="imageView" src="<?php echo $imageURL; ?>" alt="image" class="avatar-image rounded" style="cursor: pointer;">
                            </div>
                          </td>
                          <!-- Image url -->
                          <td>
                            <?php if ($_SERVER['SERVER_NAME'] == 'localhost') { ?>
                              https://<?php echo $_SERVER['SERVER_NAME']; echo '/corp_simulation/jsGame/gameData/'; echo $folderName; echo $detailsRow->JS_IMG_FileName; ?>
                            <?php } else { ?>
                              https://<?php echo $_SERVER['SERVER_NAME']; echo '/jsGame/gameData/'; echo $folderName; echo $detailsRow->JS_IMG_FileName; ?>
                            <?php } ?>  
                          </td>
                          <!-- Image Size -->
                          <td><?php echo $detailsRow->JS_IMG_FileSize; ?> KB</td>
                          <!-- Image Height -->
                          <td><?php echo $height; ?> px</td>
                          <!-- Image Width -->
                          <td><?php echo $width; ?> px</td>
                          <!-- Uploaded On (Date, Day, Time) -->
                          <td><?php echo date('d-m-Y, l, g:i:s A', strtotime($detailsRow->JS_IMG_Uploaded_On)); ?></td>
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
      $('#fileUpload').next('.custom-file-label').html('Choose Image...');
      $('#imageShowHide').addClass("d-none");
    });

    $('.hideShowMap').click(function () {
      if($(this).data('value') == 'addColor') {
        $('#addColor').addClass('d-none');
        $('#removeColor').removeClass('d-none');
        $('#fileUpload').next('.custom-file-label').html('Choose Image...');
        $('#imageShowHide').addClass("d-none");
      }
      else if($(this).data('value') == 'removeColor') {
        $('#removeColor').addClass('d-none');
        $('#addColor').removeClass('d-none');
      }
    });

    // appending file name after choosing file
    $(document).on('change', '.custom-file-input', function (event) {
      $(this).next('.custom-file-label').html(event.target.files[0].name);
      $('#imageShowHide').removeClass("d-none");
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
        url: "<?php echo base_url('JSUploadImages/uploadImages'); ?>",
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
          $('#submit').html('<span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Upload');

          switch (result.status) {
            case 'error':
              // console.log(result.message);
              $("#fileUploadError").html(result.message.fileUploadError);
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
                  window.location = "<?php echo base_url('JSUploadImages'); ?>";
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