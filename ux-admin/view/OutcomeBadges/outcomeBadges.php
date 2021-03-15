<script type="text/javascript">
  var loc_url_del  = "ux-admin/outcomeBadges/delete/";
</script>

<style type="text/css">
  .da-card {
    position: relative;
  }

  .da-card .da-card-content {
    padding: 20px;
    background: #ffffff;
  }

  .da-card .da-card-photo {
    position: relative;
    overflow: hidden;
  }

  .da-card .da-card-photo img {
    position: relative;
    display: block;
    width: 100%;
    -webkit-transition: all 0.4s linear;
    transition: all 0.4s linear;
  }

  .da-card .da-overlay {
    position: absolute;
    border: 5px;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    opacity: 0;
    overflow: hidden;
    background: rgba(19, 30, 34, 0.7);
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out; 
  }

  .da-card .da-overlay.da-slide-left {
    left: -100%;
    -webkit-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out; 
  }

  .da-card .da-card-photo:hover .da-overlay.da-slide-left {
    left: 0; 
  }

  .da-card .da-overlay.da-slide-right {
    right: -100%;
    left: inherit;
    -webkit-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out; 
  }

  .da-card .da-card-photo:hover .da-overlay.da-slide-right {
    right: 0; 
  }

  .da-card .da-overlay.da-slide-top {
    top: -100%;
    -webkit-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out; 
  }

  .da-card .da-card-photo:hover .da-overlay.da-slide-top {
    top: 0;
  }

  .da-card .da-overlay.da-slide-bottom {
    top: 100%;
    -webkit-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out; 
  }

  .da-card .da-card-photo:hover .da-overlay.da-slide-bottom {
    top: 0; 
  }

  .da-card .da-card-photo:hover img {
    -webkit-transform: scale(1.2) translateZ(0);
    transform: scale(1.2) translateZ(0); 
  }

  .da-card .da-card-photo:hover .da-overlay {
    opacity: 1;
    filter: alpha(opacity=100);
    -webkit-transform: translateZ(0);
    transform: translateZ(0); 
  }

  .da-card .da-card-photo:hover .da-social {
    opacity: 1; 
  }

  .da-card .da-social {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    width: 100%;
    height: 100%;
    padding: 20px;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #ffffff;
    opacity: 0;
    -webkit-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out; 
  }

  .da-card .da-social h5 {
    position: absolute;
    top: 0;
    white-space: nowrap;
    overflow: hidden;
    width: 100%;
    text-overflow: ellipsis;
  }

  .da-card .da-social ul li {
    float: left; 
  }

  .da-card .da-social ul li a {
    display: block;
    width: 45px;
    height: 45px;
    border: 1px solid #ffffff;
    line-height: 43px;
    font-size: 20px;
    text-align: center;
    color: #ffffff;
    -webkit-box-shadow: 0px 0px 0px 1px #ffffff;
    box-shadow: 0px 0px 0px 1px #ffffff;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out; 
  }

  .da-card .da-social ul li a:hover {
   background: #ffffff;
   color: #0099ff; 
 }

 div.desc
 {
  padding: 15px;
  text-align: center;
}
</style>

<div class="row">
 <div class="col-lg-12">
  <h1 class="page-header">
    <?php if($functionsObj->checkModuleAuth('outcomeBadges','add')){ ?>
      <a href="<?php echo site_root."ux-admin/outcomeBadges/add/add";?>" data-toggle="tooltip" title="Add Outcome Badges">
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
    <li class="active"><a href="javascript:void(0);">Manage Outcome Badges</a></li>
    <!-- <li class="active"><?php echo $header; ?></li> -->
  </ul>
</div>
</div>

<!-- DISPLAY ERROR MESSAGE -->
<?php 
  if(!empty($_SESSION['tr_msg'])) { ?>
    <div class="alert-success alert"><?php echo $_SESSION['tr_msg']; ?></div>
<?php }
  if(!empty($_SESSION['er_msg'])) { ?> 
    <div class="alert-danger alert"><?php echo $_SESSION['er_msg']; ?></div>
<?php } ?> 
<!-- DISPLAY ERROR MESSAGE END -->

<style>
  span.alert-danger {
    background-color: #ffffff;
    font-size       : 18px;
  }
</style>

<div class="row">
  <div class="col-lg-12">
    <div class="pull-right legend">
      <ul>
        <li><b>Legend : </b></li>
        <li> <span class="glyphicon glyphicon-pencil">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit   </a></li>
        <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
      </ul>
    </div>
  </div>
</div>

<div class="row">
  <div class="panel panel-default" id="loader">
    <div class="panel-heading">
      <div class="clearfix"></div>
      <div class="panel-body">
        <div class="dataTable_wrapper">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
           <thead>
            <tr>
              <th>Sl. No</th>
              <th>Image</th>
              <th>Short Name</th>
              <th>Description</th>
              <th>Value</th>
              <th class="no-sort" id="action">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $slNo=0; 
            while ($badgesResult = $badges->fetch_object()) {
              $slNo++; ?>
              <tr>
                <th><?php echo $slNo; ?></th>
                <td>
                  <?php echo ($badgesResult->Badges_ImageName) ? "<img src='".site_root.'ux-admin/upload/Badges/'.$badgesResult->Badges_ImageName."' alt='Image' width='50' height='50'>" : 'No Image';?>
                </td>
                <td><?php echo $badgesResult->Badges_ShortName; ?></td>
                <td><?php echo $badgesResult->Badges_Description; ?></td>
                <!-- Start of Value -->
                <td>
                <?php
                  $var = explode(',',$badgesResult->Badges_Value);
                  //var_dump($var);
                  for ($i=0; $i <count($var) ; $i++) {
                    if (count($var)>2) {
                      if ($i==1)
                        echo "<label for='Minimum Value'>MinVal = </label> $var[$i]<br>";
                      if ($i==2)
                        echo "<label for='Maximum Value'>MaxVal = </label> $var[$i]<br>"; 
                    }
                    else {
                      if ($i==1)
                        echo "<label for='Value'>Value = </label> $var[$i]<br>";
                    }
                  }
                ?>
                </td>
                <!-- End of Value -->
                <!-- Start of Action -->
                <td>
                  <?php 
                  // Edit
                  if ($functionsObj->checkModuleAuth('outcomeBadges','edit')) { ?>
                    <a href="<?php echo site_root."ux-admin/outcomeBadges/edit/".$badgesResult->Badges_ID; ?>" title="Edit">
                      <span class="fa fa-pencil"></span>
                    </a> &nbsp;
                  <?php }
                  // Delete
                  if ($functionsObj->checkModuleAuth('outcomeBadges','delete')) { ?>
                     <a href="<?php echo site_root."ux-admin/outcomeBadges/delete/".$badgesResult->Badges_ID;?>" title="Delete">
                      <span class="fa fa-trash"></span>
                    </a>

                    <!-- <a href="javascript:void(0);" class="dl_btn" id="<?php echo $badgesResult->Badges_ID; ?>" title="Delete">
                      <span class="fa fa-trash"></span>
                    </a> -->
                  <?php } ?>
                </td>
                <!-- End of Action -->
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>

  <?php
    // unsetting session variable if it sets
    if ($_SESSION['tr_msg']) {
      unset($_SESSION['tr_msg']);
    }
    if ($_SESSION['er_msg']) {
      unset($_SESSION['er_msg']);
    }
  ?>
