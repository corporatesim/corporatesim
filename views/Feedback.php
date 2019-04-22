<?php 
  include_once 'includes/header.php'; 
  include_once 'includes/header2.php'; 
  ?>
<div class="row" style="margin-top:50px;">
  <div class="container col-md-7" style="margin-top:60px; margin-left:160px;" >
    <span class="anchor" id="formUserEdit"></span>
    <!-- form user info -->
    <div class="card card-outline-secondary" style="height:400px; width:800px;">
      <div class="card-header">
        <?php if(isset($msg))
          {?>
        <div class="text-danger text-center"><?php echo $msg;?></div>
        <?php }?>
        <h3 style="color:#ffffff;" class="mb-0 text-center">Feedback</h3>
      </div>
      <div class="card-body profile_card" style="margin-top:30px;" >
        <form class="form" role="form" autocomplete="off" method="post" action="">
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Title</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" name="title" id="title" value="" required="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label">Message</label>
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