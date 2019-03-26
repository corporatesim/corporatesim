<script type="text/javascript">
  var func = " ";
  var loc_url_del  = "<?php echo base_url('SubEnterprise/delete/');?>";
</script>
<div class="main-container">
  <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1><a href="<?php echo base_url('SubEnterprise/addSubEnterprise/');?>"><i class="fa fa-plus-circle text-blue" title="Add SubEnterprise"> 
              </i></a> Manage SubEnterprise</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage SubEnterprise</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="pull-right">
                  <form method="post"  action="<?php echo base_url('excel_export/downloadSubEnterprise/'.$filterID); ?>" enctype="multipart/form-data">
                    <button type="submit" name="submit" id="user_download" class="btn btn-primary"
                    value="Download" style="display: none"><span class="fa fa-download"></span> Download </button>
                  </form>
                  <form method="post" id="uploadUser" name="uploadUser" action="" enctype="multipart/form-data">
                    <span id="fileselector">
                      <label class="btn btn-default" for="upload-file">
                        <input id="upload-file" type="file" name="upload_csv" style="display: none">
                        <span class="btn btn-primary"><i class="fa fa-upload"></i> Upload</span>
                      </label>
                    </span>
                  </form>
                  <a href="<?php echo base_url()."csvdemofiles/subenterprise-upload-csv-demo-file.csv"; ?>" download="DemoSubEnterprise.csv"><u>Demo Subenterprise</u></a>
                </div>
                <div class="clearfix mb-20">
                  <div class="pull-left">
                    <h5 class="text-blue mb-20">SubEnterprise Details</h5>
                    <form method="post" action="" id="filterForm">
                      <div class="form-group row"id="selectSubenterprise">
                        <label for="Select SubEnterprise" class="col-sm-12 col-md-4 col-form-label">Choose Filter</label>
                        <div class="col-sm-12 col-md-8">
                          <?php if($this->session->userdata('loginData')['User_Role']<1) {?>
                            <select name='Enterprise_ID' id='enterprise' class='form-control'>
                              <option value=''>--Select Enterprise--</option>
                              <?php foreach ($EnterpriseDetails as $row) { ?> <option value="<?php echo $row->Enterprise_ID;?>"<?php echo ($filterID==$row->Enterprise_ID)?'selected':'';?>><?php echo $row->Enterprise_Name; ?></option>
                            <?php } ?> 
                          </select>
                        <?php }else{?>
                          <select name='SubEnterprise_ID' id='subenterprise' class='form-control'>
                            <option value=''>--Select SubEnterprise--</option>
                            <?php foreach ($Subenterprise as $row) { ?> <option value="<?php echo $row->SubEnterprise_ID;?>"<?php echo ($filterID==$row->SubEnterprise_ID)?'selected':'';?>><?php echo $row->SubEnterprise_Name; ?></option>
                          <?php } ?> 
                        </select>
                      <?php }?>
                    </div>
                  </div>    
                </form>
              </div>
            </div>
            <div class="row">
              <table class="stripe hover multiple-select-row data-table-export nowrap">
                <thead>
                  <tr>
                    <th class="">Enterprise Name</th>
                    <th class="">SubEnterprise Name</th>
                    <th>CreatedBy</th>
                    <th>CreatedOn</th>
                    <th>UpdatedBy</th>
                    <th>UpdatedOn</th>
                    <th>Games</th>
                    <th class="datatable-nosort">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($subEnterpriseDetails as $subEnterpriseDetails) { ?>
                    <tr>
                      <td><?php echo $subEnterpriseDetails->Enterprise_Name; ?></td>
                      <td><?php echo $subEnterpriseDetails->SubEnterprise_Name; ?></td>
                      <td><?php if($subEnterpriseDetails->SubEnterprise_Owner==1){
                        echo $subEnterpriseDetails->fname.' '.$subEnterpriseDetails->lname;
                      }else{ echo $subEnterpriseDetails->User_fname.' '.$subEnterpriseDetails->User_lname;}?>
                    </td>
                    <td class="table-plus"><?php echo $subEnterpriseDetails->SubEnterprise_CreatedOn ; ?></td>
                    <td><?php if($subEnterpriseDetails->SubEnterprise_UpdatedBy==$subEnterpriseDetails->User_id){echo $subEnterpriseDetails->User_fname.' '.$subEnterpriseDetails->User_lname;}else if($subEnterpriseDetails->SubEnterprise_UpdatedBy==$subEnterpriseDetails->id){echo $subEnterpriseDetails->fname.' '.$subEnterpriseDetails->lname;}else{echo "NOT NOW";}?> </td>
                    <td><?php if(!empty($subEnterpriseDetails->SubEnterprise_UpdatedOn))
                    { echo $subEnterpriseDetails->SubEnterprise_UpdatedOn;
                    }else {echo "NOT NOW" ;} ?></td>
                    <td><a class="dropdown-item" href="<?php echo base_url('Games/assignGames/');?><?php echo base64_encode($subEnterpriseDetails->SubEnterprise_ID).'/'.base64_encode($this->uri->segment(1)); ?>" title="Allocate/Deallocate Games"><?php echo $subEnterpriseDetails->gamecount; ?></a></td>
                    <td>
                      <div class="dropdown">
                        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                          <i class="fa fa-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="#"><i class="fa fa-eye"></i> View</a>
                          <a class="dropdown-item" href="<?php echo base_url('SubEnterprise/edit/');?><?php echo base64_encode($subEnterpriseDetails->SubEnterprise_ID); ?>"title="   Edit"><i class="fa fa-pencil">
                          </i> Edit</a>
                          <!-- <a class="dropdown-item" href="<?php //echo base_url('SubEnterprise/assignGames/');?><?php //echo base64_encode($subEnterpriseDetails->SubEnterprise_ID); ?>" title="Allocate/Deallocate Games"><i class="fa fa-gamepad"></i> Allocate/Deallocate Games</a> -->
                          <a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo 
                          $subEnterpriseDetails->SubEnterprise_ID; ?>" title="Delete"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="Modal_Bulkupload" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Import Success</h4>
            </div>
            <div class="modal-body">
              <p id="bulk_u_msg"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div id="Modal_BulkuploadError" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <p id="bulk_u_err"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <script type="text/javascript">
        $(document).ready(function(){
          //select subenterprize
          $('#subenterprise').on('change',function(){
            $('#filterForm').submit();
          });
        });
        //select enterprize
        $('#enterprise').on('change',function(){
          $('#filterForm').submit();
        });

      </script>

      <script type="text/javascript">
        <!--

          $('#upload-file').change( function(){
            var form = $('#uploadUser').get(0);                     
            $.ajax({
              url        : "<?php echo base_url();?>Subenterprise/subenterprisecsv",
              type       : "POST",
              data       : new FormData(form),
              cache      : false,
              contentType: false,
              processData: false,
              beforeSend : function(){
                $('#loader').addClass('loading');
              },
              success: function( result ){
                try {   
                //alert(result);                            
                var response = JSON.parse( result );
                //alert(response.status);
                if( response.status == 1 ){
                  //alert('in status = 1 ');
                  $('#bulk_u_msg').html( response.msg );
                  $('#Modal_Bulkupload').modal( 'show' );
                } else {
                  $('#bulk_u_err').html( response.msg );
                  $('#Modal_BulkuploadError').modal( 'show' );
                }
              } catch ( e ) {
                console.log( result );
              }
              $('#loader').removeClass('loading');
            }
          });
          });
          //-->
        </script>



