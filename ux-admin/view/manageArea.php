<script type="text/javascript">
  <!--
  	var loc_url_del = "ux-admin/ManageArea/Delete/";
  //-->
</script>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Area</h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a
        href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
        <li class="active">Master Management</li>
        <li class="active">Area</li>
      </ul>
    </div>
  </div>
  <?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
  <div class="row">
    <div class="col-sm-12">
      <?php if($functionsObj->checkModuleAuth('area','add')){ ?>
        <div class="panel panel-default">
          <div class="panel-heading">Add Area</div>
          <div class="panel-body">
            <div class="col-sm-6 col-sm-offset-3">
              <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Enter Area Name</label>
                  <input type="hidden" name="id" value="<?php if(isset($_GET['Edit'])){ echo $result->Area_ID; } ?>" >
                  <input class="form-control" type="text" name="Area_Name" value="<?php if(isset($_GET['Edit'])){ echo $result->Area_Name; } ?>" title="Space between characters not allowed" required>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label>Background Color</label>
                    <input type="color" class="form-control" name="Area_BackgroundColor" id="Area_BackgroundColor" value="<?php echo ($Area_BackgroundColor == NULL)?'#ffffff':$Area_BackgroundColor;?>">
                  </div>
                  <div class="col-md-6">
                    <label>Text Color</label>
                    <input type="color" class="form-control" name="Area_TextColor" id="Area_TextColor" value="<?php echo ($Area_TextColor == NULL)?'#6e6e6e':$Area_TextColor;?>">
                  </div>
                </div>
                <br><br>

                <div class="form-group text-center">
                  <?php if(isset($_GET['Edit'])){ ?>
                    <button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
                    <button class="btn btn-danger" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageArea"; ?>';">Cancel</button>
                  <?php }else{ ?>
                    <button class="btn btn-primary" type="submit" name="submit" value="Submit">Submit</button>
                  <?php } ?>
                </div>

              </div>
            </div>
          </div>
        <?php } ?> 
      </form>

      <form method="post" action="">
        <div class="row">
          <div class="col-md-6">

           <a id="HideDownloadIcon"><i class="fa fa-download" aria-hidden="true" title="Download"></i></a>
           <div id="downloadArea">
            <div class="row" id="sandbox-container">
              <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="input-sm form-control" id="fromdate" name="fromdate" placeholder="Select Start Date" required readonly/>
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" id="enddate" name="enddate" placeholder="Select End Date" required readonly/>
              </div>
            </div>
            <br>
            <button type="submit" name="download_excel" id="download_excel" class="btn btn-primary" value="Download"> Download </button>
          </div>

        </div>
        <div class="col-md-6">
          <div class="col-sm-12">
            <div class="pull-right legend">
              <ul>
                <li><b>Legend : </b></li>
                <li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
                <li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
                <li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>
                <li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
                <li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="form-group"></div>
    <div class="panel panel-default">
      <div class="panel-heading">Area List
        <a href="javascript:void(0);" class="pull-right" data-toggle="tooltip" title="Refresh Table Data" id="refreshServerSideDataTable">
          <i class="fa fa-refresh"></i>
        </a>
      </div>
      <div class="panel-body">
        <div class="dataTable_wrapper">
          <table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root.'ux-admin/model/ajax/dataTables.php';?>" data-action="manageArea">
            <thead>
              <tr>
                <th class="no-sort">S.N.</th>
                <th>Area ID</th>
                <th>Area Name</th>
                <th>Background Color</th>
                <th>Text Color</th>
                <th class="no-sort">Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
