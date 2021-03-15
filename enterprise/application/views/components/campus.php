<script type="text/javascript">
  var loc_url_del = "<?php echo base_url('Campus/deleteCampus/');?>";
  var func        = "<?php //echo $this->uri->segment(2);?>";
</script>
<style>
  #upload-file-selector {
    display:none;
  }
</style>
<div class="main-container">
  <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>
                <a href="javascript:void(0);" data-toggle="tooltip" title="Add Campus" id="addCampus">
                  <i class="fa fa-plus-circle text-blue"></i></a> Campus
              </h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Campus</li>
              </ol>
            </nav>
          </div>
        </div>

          <!--========================-->
          <!-- Start Bulk Import Modal -->
          <div class="modal fade bs-example-modal-lg" id="Modal_Bulkupload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">

                <div class="modal-header">
                  <h4 class="modal-title text-success" id="myLargeModalLabel">Import Success</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close" onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <p id="bulk_u_msg"></p>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-info" onclick="location.reload();">Close</button>
                </div>

              </div>
            </div>
          </div>
          <!--========================-->
          <div id="Modal_BulkuploadError" class="modal" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <h4 class="modal-title text-danger">Error</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <p id="bulk_u_err"></p>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>
          <!-- End Bulk Import Modal -->
          <!--========================-->

          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="title">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                  <div class="clearfix pb-3">
                    <div class="pull-left">
                      <h5 class="text-blue">Campus List</h5>
                    </div>
                    <div class="pull-right">
                      <!-- Upload Campus CSV -->
                      <form method="post" id="bulk_upload_csv" name="bulk_upload_csv" action="" enctype="multipart/form-data">
                        <span id="fileselector" class="btn btn-primary btn-sm">
                          <label class="btn btn-default" for="upload-file-selector">
                            <input id="upload-file-selector" type="file" name="upload_csv">
                            <i class="fa fa-upload"></i> Bulk Campus Upload
                          </label>
                        </span> 
                      </form>
                      <a href="<?php echo base_url()."csvdemofiles/Campus-upload-csv-demo-file.csv"; ?>" download="Campus-Bulk-Upload-CSV-Template.csv"><u>Campus Bulk Upload CSV Template</u></a>
                    </div>
                  </div>

                  <div class="row" id="addTable">
                    <table class="stripe hover multiple-select-row data-table-export">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Campus Name</th>
                          <th>Address</th>
                          <th>Email</th>
                          <th>Contact</th>
                          <th class="datatable-nosort noExport">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($campus) < 1){ ?>
                          <tr>
                            <td class="text-danger text-center" colspan="6"> No Record Found </td>
                          </tr>
                          <!-- only if record exists -->
                        <?php } else{ $i=1; foreach ($campus as $campusRow) { ?>
                          <tr id="parent__<?php echo $campusRow->UC_ID; ?>">
                            <!-- ID -->
                            <td><?php echo $i;?></td>
                            <!-- campus Name -->
                            <td id="<?php echo $campusRow->UC_Name; ?>__Campus_Name" class="editable"><?php echo $campusRow->UC_Name; ?></td>
                            <!-- Address -->
                            <td><?php echo $campusRow->UC_Address; ?></td>
                            <!-- E-mail -->
                            <td><?php echo $campusRow->UC_Email; ?></td>
                            <!-- Phone Number -->
                            <td><?php echo $campusRow->UC_Contact ;?></td>
                            <!-- Action -->
                            <td>
                                  
                              <!-- edit icon -->
                              <a href="javascript:void(0);" data-function="editCampus" data-toggle="tooltip" title="Edit" data-pid="<?php echo $campusRow->UC_ID; ?>" class="editIcon" id="<?php echo $campusRow->UC_ID; ?>__edit">
                                <i class="fa fa-pencil">_Edit</i>
                              </a>

                              <!-- save icon -->
                              <a href="javascript:void(0);" data-function="editCampus" data-toggle="tooltip" title="Save" data-pid="<?php echo $campusRow->UC_ID; ?>" class="saveIcon d-none" id="<?php echo $campusRow->UC_ID;?>__save">
                                <i class="fa fa-save">_Save</i>
                              </a>
                              
                              &nbsp;&nbsp;<!-- <br /> -->
                              <!-- delete icon -->
                              <!-- <a href="javascript:void(0);" data-col_table="campus_Delete__USER_CAMPUS__UC_ID__listcampus" data-toggle="tooltip" title="Delete" data-pid="<?php echo $campusRow->UC_ID; ?>" class="deleteIcon"><i class="fa fa-trash"></i> Delete</a> -->

                              <a href="javascript:void(0);" class="dl_btn" id="<?php echo $campusRow->UC_ID; ?>" title="Delete"><i class="fa fa-trash">_Delete</i></a>

                            </td>
                          </tr>
                          <?php $i++; } } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- end of adding Campus -->
                </div>
              </div>
            </div>

<script>
  $(document).ready(function(){
    $('#addCampus').on('click', function(){

      var addCampusForm ='<form id="campusForm"> <div class="form-group"><input type="text" required class="form-control" placeholder="Campus Name" name="Campus_Name"></div> <div class="form-group"><input type="text" required class="form-control" placeholder="Campus Address" name="Campus_Address"></div> <div class="form-group"><input type="email" required class="form-control" placeholder="Campus E-mail" name="Campus_Email"></div> <div class="form-group"><input type="text" required class="form-control" placeholder="Campus Contact" name="Campus_Contact"></div> <br> <button class="btn btn-primary">Add</button> <button type="button" class="btn btn-outline-danger cancelPopup" onClick="return Swal.close();">Cancel</button></form>';
      Swal.fire({
        // icon: 'question',
        title            : 'Add Campus',
        html             : addCampusForm,
        showConfirmButton: false,
        width: '600px',
        height: '500px',
      });
      addCampus();
    });
  });

  function addCampus(){
    // add Campus via ajax
    $('#campusForm').on('submit', function(e){
      e.preventDefault();
      var formData = $(this).serialize();
      var result   = triggerAjax("<?php echo base_url('Ajax/addCampus'); ?>",formData);
      Swal.fire({
        position         : result.position,
        icon             : result.icon,
        title            : result.title,
        html             : result.message,
        showConfirmButton: result.showConfirmButton,
        timer            : result.timer,
      });
      listCampus();
    });
  }

  $('#upload-file-selector').change( function(){
    $('#loader').addClass('hidden');
    var form = $('#bulk_upload_csv').get(0);                      
    $.ajax({
      url        : "<?php echo base_url('Ajax/ajax_bulk_upload_Campus/');?>",
      type       : "POST",
      data       : new FormData(form),
      cache      : false,
      contentType: false,
      processData: false,
      beforeSend: function(){
        $('#loader').addClass('loading');
      },
      success: function(result){
        try{
          //alert(result);
          var response = JSON.parse(result);
          //alert(response.status);
          if(response.status == 1){
            $('#bulk_u_msg').html(response.msg);
            $('#Modal_Bulkupload').modal('show');
          } else{
            $('#bulk_u_err').html(response.msg);
            $('#Modal_BulkuploadError').modal('show');
          }
        } catch(e){
          console.log(result);
        }
        $('#loader').removeClass('loading');
      }
    });
  });
</script>