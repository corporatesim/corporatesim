<script type="text/javascript">
  <!--
   var loc_url_del  = "ux-admin/outcomeBadges/linkdel/";
   var loc_url_stat = "ux-admin/outcomeBadges/linkstat/";
  //-->
</script>

<style>
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

#update-file-selector {
  display:none;
}
</style>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $header; ?></h1>
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
      <div class="pull-right">
        <a href="<?php echo site_root."ux-admin/outcomeBadges/add/add";?>" class="btn btn-primary btn-lg btn-block">Add Outcome</a>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="card-block">
           <div class="card img-fluid" style="">
            <img class="card-img-top" src="<?php echo site_root."ux-admin/upload/gold.jpg"?>" alt="Card image" style="width:100%">
            <div class="card-img-overlay">
              <h4 class="card-title"> Gold Image</h4>
              <p class="card-text">Some example text some example text. Some example text some example text.</p>
              <p class="card-text">value</p>
              <a href="#" class="btn btn-primary">Edit Image</a>
            </div>
          </div>
        </div>
      </div>
        <div class="col-md-3">
          <div class="card">
         <div class="card img-fluid" style="">
          <img class="card-img-top" src="<?php echo site_root."ux-admin/upload/gold.jpg"?>" alt="Card image" style="width:100%">
            <h4 class="card-title">Gold Image</h4>
            <p class="card-text">Some example text some example text. Some example text some example text.</p>
            <p class="card-text">value</p>
          <div class="card-img-overlay">
            <a href="#" class="btn btn-primary">Edit Image</a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
</div>
</div>
