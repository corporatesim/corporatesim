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
              <h1><a href="<?php echo base_url('Enterprise/addEnterprise/');?>"><i class="fa fa-plus-circle text-blue" title="Add Enterprise"> 
              </i></a> Manage Enterprise</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Enterprise</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="pull-right">
                  <form method="post" id="uploadUser" name="uploadUser" action="" enctype="multipart/form-data">
                    <span id="fileselector">
                      <label class="btn btn-default" for="upload-file">
                        <input id="upload-file" type="file" name="upload_csv" style="display: none">
                        <span class="btn btn-primary"><i class="fa fa-upload"></i> Upload</span>
                      </label>
                    </span>
                  </form>
                  <!--  <a href="<?php //echo base_url()."csvdemofiles/enterprise-upload-csv-demo-file.csv"; ?>" download="DemoEnterprise.csv"><u>Demo Users CSV</u></a> -->
                </div>
                <div class="clearfix mb-20">
                  <div class="pull-left">
                    <h5 class="text-blue mb-20">Enterprise Details</h5>
                    <form method="post" action="" id="filterForm">
                      <div class="form-group row"id="selectenterprise">
                        <label for="Select Enterprise" class="col-sm-12 col-md-4 col-form-label">Choose Filter</label>
                        <div class="col-sm-12 col-md-8">
                          <select name='Enterprise_ID' id='enterprise' class='form-control'>
                            <option value=''>--Select Enterprise--</option>
                            <?php foreach ($Enterprise as $row) { ?> <option value="<?php echo $row->Enterprise_ID;?>"<?php echo ($filterID==$row->Enterprise_ID)?'selected':'';?>><?php echo $row->Enterprise_Name; ?></option>
                          <?php } ?> 
                        </select>
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
                      <th>CreatedBy</th>
                      <th>CreatedOn</th>
                      <th>UpdatedBy</th>
                      <th>UpdatedOn</th>
                      <th>Games</th>
                      <th class="datatable-nosort">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($EnterpriseDetails as 
                      $enterprisedetails) { ?>
                        <tr>
                          <td><?php echo $enterprisedetails->Enterprise_Name; ?></td>
                          <td><?php echo $enterprisedetails->User_Name;?>
                        </td>
                        <td class="table-plus"><?php
                        echo date('Y-m-d',strtotime($enterprisedetails->Enterprise_CreatedOn));
                        ?></td>
                        <td class="table-plus"><?php if($enterprisedetails->Enterprise_UpdatedBy==0){ echo "NOT NOW";}else{ ?><?php echo $enterprisedetails->User_Name;}?></td>
                        <td class="table-plus"><?php echo  $enterprisedetails->Enterprise_UpdatedOn ; ?></td>
                        <td><a class="dropdown-item" href="<?php echo base_url('Games/assignGames/').base64_encode($enterprisedetails->Enterprise_ID).'/'.base64_encode($this->uri->segment(1));?>" title="Allocate/Deallocate Games"><?php if($enterprisedetails->gamecount>0){echo $enterprisedetails->gamecount; }else{echo "0";}?></a></td>
                        <td>
                          <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button"data-toggle="dropdown">
                              <i class="fa fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="#"><i class="fa fa-eye"></i> View</a>
                              <a class="dropdown-item" href="<?php echo base_url('Enterprise/edit/');?><?php echo base64_encode($enterprisedetails->Enterprise_ID); ?>"title="   Edit"><i class="fa fa-pencil">
                              </i> Edit</a>
                              <a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo 
                              $enterprisedetails->Enterprise_ID; ?>" title="Delete"><i class="fa fa-trash"></i> Delete</a>
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
          </script>
          



