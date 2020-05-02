<script type="text/javascript">
  var func = " ";
  var loc_url_del  = "<?php echo base_url('Enterprise/delete/');?>";
</script>
<div class="main-container">
  <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1><a href="<?php echo base_url('Enterprise/addEnterprise/');?>" data-toggle="tooltip" title="Add Enterprise"><i class="fa fa-plus-circle text-blue"> 
              </i></a> Manage Enterprize</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Enterprize</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <!-- <div class="pull-right">
                  <form method="post" id="uploadUser" name="uploadUser" action="" enctype="multipart/form-data">
                    <span id="fileselector">
                      <label class="btn btn-default" for="upload-file">
                        <input id="upload-file" type="file" name="upload_csv" style="display: none">
                        <span class="btn btn-primary"><i class="fa fa-upload"></i> Upload</span>
                      </label>
                    </span>
                  </form>
                   <a href="<?php //echo base_url()."csvdemofiles/enterprise-upload-csv-demo-file.csv"; ?>" download="DemoEnterprise.csv"><u>Demo Users CSV</u></a>
                 </div> -->
                 <div class="clearfix mb-20">
                  <div class="pull-left">
                    <h5 class="text-blue mb-20">Enterprize Details</h5>
                  </div>
                </div>
                <div class="row">
                  <table class="stripe hover multiple-select-row data-table-export nowrap">
                    <thead>
                      <tr>
                        <th class="">S.No</th>
                        <th class="">Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Address</th>
                        <th>Games</th>
                        <!-- only superadmin can view cards -->
                        <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                        <th>Assign Card</th>
                        <?php } ?>
                        <th>Domain</th>
                        <th>Duration(DD-MM-YYYY)</th>
                        <!-- <th>Created By</th> -->
                        <!-- <th>Created On</th> -->
                        <th class="datatable-nosort noExport">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $rowNum = 1;
                      foreach ($EnterpriseDetails as $enterprisedetails)
                      { 
                        $address1 = ($enterprisedetails->Enterprise_Address1)?$enterprisedetails->Enterprise_Address1:'';
                        $address2 = ($enterprisedetails->Enterprise_Address2)?'<br>'.$enterprisedetails->Enterprise_Address2:'';
                        $province = ($enterprisedetails->Enterprise_Province)?', '.$enterprisedetails->Enterprise_Province:'';
                        $state    = ($enterprisedetails->State_Name)?'<br>'.$enterprisedetails->State_Name.', ':'';
                        $pincode  = ($enterprisedetails->Enterprise_Pincode)?$enterprisedetails->Enterprise_Pincode:'';
                        $country  = ($enterprisedetails->Country_Name)?'<br><b>'.$enterprisedetails->Country_Name.'</b>':'';
                        $address  = $address1.$address2.$province.$state.$pincode.$country;
                        ?>
                        <tr>
                          <td>
                            <?php echo $rowNum; ?>
                          </td>
                          <td>
                            <?php echo $enterprisedetails->Enterprise_Name; ?>
                          </td>
                          <td>
                            <?php echo $enterprisedetails->Enterprise_Email; ?>
                          </td>
                          <td>
                            <?php echo $enterprisedetails->Enterprise_Password; ?>
                          </td>
                          <td>
                            <?php echo $address; ?>
                          </td>
                          <td>
                            <a class="dropdown-item" href="<?php echo base_url('Games/assignGames/').base64_encode($enterprisedetails->Enterprise_ID).'/'.base64_encode($this->uri->segment(1)); ?>" title="Allocate/Deallocate Games"><?php if($enterprisedetails->gamecount>0){echo "<b style='color:#0029ff;'>".$enterprisedetails->gamecount."</b>"; }else{echo "<b style='color:#0029ff;'>0</b>"; }?></a>
                          </td>
                          <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                          <td>
                            <a class="dropdown-item" href="<?php echo base_url('Card/assignCards/').base64_encode($enterprisedetails->Enterprise_ID).'/'.base64_encode($this->uri->segment(1)); ?>" title="Allocate/Deallocate Cards"><?php if($enterprisedetails->cardcount > 0){echo "<b style='color:#0029ff;'>".$enterprisedetails->cardcount."</b>"; }else{echo "<b style='color:#0029ff;'>0</b>";} ?></a>
                          </td> 
                          <?php } ?>

                          <td>
                            <?php if ($enterprisedetails->Domain_Name != '')
                            {
                              echo $enterprisedetails->Domain_Name;
                            }
                            else
                            {
                              echo "No Domain";
                            }
                            ?>
                          </td>

                          <td>
                            <?php echo date('d-M-y',strtotime($enterprisedetails->Enterprise_StartDate)).' <b>To</b> '.date('d-M-y',strtotime($enterprisedetails->Enterprise_EndDate));?>
                          </td>
                          <!-- <td><?php echo $enterprisedetails->User_Name;?></td> -->
                          <!-- <td class="table-plus"><?php
                          echo date('Y-m-d',strtotime($enterprisedetails->Enterprise_CreatedOn));
                          ?>
                        </td> -->
                        <td>
                          <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button"data-toggle="dropdown">
                              <i class="fa fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left">
                              <!-- <a class="dropdown-item" href="#"><i class="fa fa-eye"></i> View</a> -->
                              <a class="dropdown-item" href="<?php echo base_url('Enterprise/edit/');?><?php echo base64_encode($enterprisedetails->Enterprise_ID); ?>" title="Edit"><i class="fa fa-pencil">
                              </i> Edit</a>
                              <a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo 
                              $enterprisedetails->Enterprise_ID; ?>" title="Delete" onclick="deleteEnt()"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php $rowNum++; } ?>
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
                    <button type="button" onclick="window.location='<?php echo $url; ?>';" class="btn btn-default" data-dismiss="modal">Close</button>
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
                $('#enterprise').on('change',function(){
                  $('#filterForm').submit();
                });
              });
              function deleteEnt()
              {
                  $('.dl_btn').click( function() {
                  $('#cnf_yes').val($(this).attr('id'));
                  $('#cnf_del_modal').modal('show');
                  });
                
                $('#cnf_yes').click( function() {
                  var val              = $(this).val();
                  var id               = btoa(val);
                  window.location.href = loc_url_del + id +"/"+ func;   
                });
              }
            </script>




