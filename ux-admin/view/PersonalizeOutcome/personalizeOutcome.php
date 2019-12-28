<!-- <?php // echo "<pre>"; print_r($object->fetch_object()); exit; ?> -->
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/personalizeOutcome/delete/";
     //var loc_url_stat = "ux-admin/personalizeOutcome/linkstat/";
  //-->
</script>

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
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">

     <?php if($functionsObj->checkModuleAuth('personalizeOutcome','add')){ ?>
      <a href="<?php echo site_root."ux-admin/personalizeOutcome/add/add";?>" data-toggle="tooltip" title="Add personalize Outcome">
        <i class="fa fa-plus-circle"></i>
      </a>
    <?php } ?>

    <?php echo $header; ?>
  </h1>
</div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="javascript:void(0);">Manage Personalized Outcome</a></li>
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
<form method="post" action="">
  <div class="row">
    <div class="col-md-6">
     <a id="HideDownloadIcon">
      <i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="Download personalize Outcome"></i>
    </a>
    <br>
    <div id="downloadPersonalizeOutcome">
      <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
        <label>Select Game</label> 
        <select class="form-control"
        name="game" id="game">
        <option value="">-- SELECT --</option>
        <?php while($row = $execute->fetch_object()){?>
          <option value="<?php echo $row->Game_ID;?>">
            <?php echo $row->Game_Name;?>
          </option>
        <?php }?>
      </select>
    </div>

    <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
      <label>Select Scenario</label> <select class="form-control"
      name="scenario[]" id="scenario" multiple>
      <option value="">-- SELECT --</option>
      <option value="">
      </option>
    </select>
  </div>
  <button type="submit" name="download_excel" id="download_excel" class="btn btn-primary" value="Download"> Download </button>
</div>

</div>
<div class="col-md-6">
  <div class="col-sm-12">
    <div class="pull-right legend">
      <ul>
        <li><b>Legend : </b></li>
        <!-- <li> <span class="glyphicon glyphicon-ok">    </span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active  </a></li> -->
        <!-- <li> <span class="glyphicon glyphicon-remove">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive </a></li> -->
        <!-- <li> <span class="glyphicon glyphicon-search">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View   </a></li> -->
        <li> <span class="glyphicon glyphicon-pencil">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit   </a></li>
        <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
        <!-- <li> <span class="glyphicon glyphicon-refresh"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User can replay the Game"> Replay </a></li> -->
        <!-- <li> <span class="glyphicon glyphicon-ban-circle">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User games have been disabled"> Disable </a></li> -->
      </ul>
    </div>
  </div>
</div>
</div>
</form>
<br>
<div class="row">
  <div class="panel panel-default" id="loader">
    <div class="panel-heading">
      <div class="clearfix"></div>
      <div class="panel-body">
        <div class="dataTable_wrapper">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
           <thead>
            <tr>
              <th>Sr. No</th>
              <th>Game</th>
              <th>Scenario</th>
              <th id="password">OutputComponent</th>
              <th>MinValue</th>
              <th>MaxValue</th>
              <th>Description</th>
              <th>Order</th>
              <th>OutcomeType</th>
              <th>OutcomeName</th>
              <th class="no-sort" id="action">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i=1; while($row = $object->fetch_object()){ ?>
              <tr>
                <th><?php echo $i;?></th>
                <td><?php echo $row->Game_Name;?></td>
                <td><?php echo $row->Scen_Name;?></td>
                <td><?php echo $row->Comp_Name;?></td>
                <td><?php echo $row->Outcome_MinVal;?></td>
                <td><?php echo $row->Outcome_MaxVal;?></td>
                <td><?php echo $row->Outcome_Description;?></td>
                <td><?php echo $row->Outcome_Order;?></td>
                <td><?php echo $row->Outcome_Name;?></td>
                <td><?php echo ($row->Outcome_FileName)?"<img src='".site_root.'ux-admin/upload/Badges/'.$row->Outcome_FileName."' alt='No Image' width='50' height='50'>":'No Image';?></td>
                <td>
                  <?php if($functionsObj->checkModuleAuth('personalizeOutcome','edit')){ ?>
                    <a href="<?php echo site_root."ux-admin/personalizeOutcome/edit/".$row->OutcomeID;?>" title="Edit"><span class="fa fa-pencil"></span></a> &nbsp;
                  <?php } ?>
                  <!--  <a href="<?php //echo site_root."ux-admin/personalizeOutcome/delete/".$row->OutcomeID;?>" title="Delete"><span class="fa fa-trash"></span></a> -->
                  <?php if($functionsObj->checkModuleAuth('personalizeOutcome','delete')){ ?>
                    <a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->OutcomeID;?>" title="Delete"><span class="fa fa-trash"></span></a></a>
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

