<!-- <?php // echo "<pre>"; print_r($object->fetch_object()); exit; ?> -->
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/ScenarioBranching/linkdel/";
     var loc_url_stat = "ux-admin/ScenarioBranching/linkstat/";
  //-->
</script>
<!-- scenario branching Data table CSS -->
<style>
<!--
.dropdown-menu > li > button {
  display    : block;
  padding    : 3px 20px;
  clear      : both;
  font-weight: 400;
  line-height: 1.42857143;
  color      : #ffffff;
  white-space: nowrap;
}
#contact
{
  width: auto!important;
}
#password
{
  width: auto!important;
}
#action
{
  width: 70px!important;
}
.drop_down{
  padding: 0 5px !important;
}

#upload-file-selector {
  display:none;
}
.margin-correction {
  margin-right: 10px;
}

@media screen and ( min-width: '361px' ){
  .resp_pull_right{
    float: right;
  }
}

@media screen and ( max-width: '360px' ){
  .resp_pull_right{
    float     : none;
    text-align: center;
    width     : 100%;
    padding   : 0 15px;
  }
}
-->
#update-file-selector {
  display:none;
}
</style>
<!-- scenario branching Data table CSS ends -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $header; ?></h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="javascript:void(0);">Manage Scenario Branching</a></li>
      <!-- <li class="active"><?php echo $header; ?></li> -->
    </ul>
  </div>
</div>
<!-- DISPLAY ERROR MESSAGE -->
<?php  if(!empty($_SESSION['tr_msg'])) { ?>
  <div class="alert-success alert"><?php echo $_SESSION['tr_msg']; ?></div>
<?php } ?>
<?php  if(!empty($_SESSION['er_msg'])) { ?>
  <div class="alert-danger alert"><?php echo $_SESSION['er_msg']; ?></div>
<?php } ?>
<!-- DISPLAY ERROR MESSAGE END -->
<style>
span.alert-danger {
  background-color: #ffffff;
  font-size       : 18px;
}
</style>

<!-- data table starts here -->
<div class="row">
  <div class="col-lg-12">
    <div class="pull-right legend">
      <ul>
        <li><b>Legend : </b></li>
        <!-- <li> <span class="glyphicon glyphicon-ok">    </span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active  </a></li> -->
        <!-- <li> <span class="glyphicon glyphicon-remove">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive </a></li> -->
        <!-- <li> <span class="glyphicon glyphicon-search">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View   </a></li> -->
        <li> <span class="glyphicon glyphicon-pencil">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit   </a></li>
        <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
        <li> <span class="fa fa-ban"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="Final/End Scenario"> End Scenario </a></li>
        <!-- <li> <span class="glyphicon glyphicon-refresh"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User can replay the Game"> Replay </a></li> -->
        <!-- <li> <span class="glyphicon glyphicon-ban-circle">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User games have been disabled"> Disable </a></li> -->
      </ul>
    </div>
  </div>
</div>
<div class="row">
  <div class="panel panel-default" id="loader">
    <div class="panel-heading">
      <div class="pull-right">
        <!-- <form action="" method="post">
          <button class="btn btn-primary btn-lg btn-block" type="submit" value="addBranching" name="addBranching">Add Branching</button>
        </form> -->
        <a href="<?php echo site_root."ux-admin/ScenarioBranching/add/add";?>" class="btn btn-primary btn-lg btn-block">Add Branching</a>
      </div>
      <div class="clearfix"></div>
      <div class="panel-body">
        <div class="dataTable_wrapper">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Sr. No</th>
                <!-- <th>Branch_Id</th> -->
                <th>Game</th>
                <th>Scenario</th>
                <th id="password">Component</th>
                <th id="contact">Next Scenario</th>
                <!--<th>Last Login</th>-->
                <th>Minimum Value</th>
                <th class="no-sort">Maximum Value</th>
                <th class="no-sort">Order</th>
                <th class="no-sort" id="action">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i=1; while($row = $object->fetch_object()){ ?>
                <tr>
                  <th><?php echo $i;?></th>
                  <!-- <th><?php echo $row->Branch_Id;?></th> -->
                  <!-- <td><?php echo ucfirst($row->User_fname)." ".ucfirst($row->User_lname); ?></td> -->
                  <td><?php echo $row->Game_Name;?></td>
                  <td><?php echo $row->Scen_Name;?></td>
                  <td><?php echo $row->Comp_Name;?></td>
                  <td><?php echo $row->NextSceneName;?></td>
                  <td><?php echo $row->Branch_MinVal;?></td>
                  <td><?php echo $row->Branch_MaxVal;?></td>
                  <td><?php echo $row->Branch_Order;?></td>
                  <td>
                    <a href="<?php echo site_root."ux-admin/ScenarioBranching/edit/".$row->Branch_Id;?>" title="Edit"><span class="fa fa-pencil"></span></a> 
                    &nbsp;
                    <a href="<?php echo site_root."ux-admin/ScenarioBranching/delete/".$row->Branch_Id;?>" title="Delete"><span class="fa fa-trash"></span></a>
                    &nbsp;
                    <?php if($row->Branch_IsEndScenario == 1){ ;?>
                      <a href="javascript:void(0);" title="End Scenario"><span class="fa fa-ban"></span></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <!-- end of data table -->
    <?php 
    if($_SESSION['tr_msg'])
    {
      unset($_SESSION['tr_msg']);
    }
    if($_SESSION['er_msg'])
    {
      unset($_SESSION['er_msg']);
    }
    ?>