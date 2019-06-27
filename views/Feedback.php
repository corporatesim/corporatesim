<?php 
include_once 'includes/headerNav.php'; 
  // include_once 'includes/header.php'; 
  // include_once 'includes/header2.php'; 
?>
<style>
  .text-errorMsg{
    background: white;
    color: red;
  }
</style>
<div class="row" style="margin-top:2%;">
  <div class="container col-md-7" style="margin-left:30%;" >
    <span class="anchor" id="formUserEdit"></span>
    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <?php if(isset($msg)) { ?>
          <div class="text-errorMsg text-center"><b><?php echo $msg;?></b></div>
        <?php unset($msg); } ?>
        <h3 style="color:#ffffff;" class="mb-0 text-center">Feedback</h3>
      </div>
      <div class="card-body" style="margin: 5%;" >
        <form class="form-group" role="form" autocomplete="off" method="post" action="">
          <div class="form-group row">
            <label class="col-lg-2 col-form-label form-control-label">Title</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" name="title" id="title" value="" required="" style="border-radius: 4px !important;">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label form-control-label">Message</label>
            <div class="col-lg-9">
              <textarea class="form-control" type="textarea" rows="5" name="message" id="message" value="" required=""></textarea>
            </div>
          </div>
          <center>
            <div class="form-group row">
              <div class="col-lg-12">
                <input type="submit" class="update btn btn-danger" name="submit" value="Sumbit" id="sumbit">
              </div>
            </div>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php' ?>
