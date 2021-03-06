<!DOCTYPE html>
<html>
<head>
  <!-- Basic Page Info -->
  <meta charset="utf-8">
  <title><?php echo ucfirst($this->uri->segment(1));?></title>
  <!-- Site favicon -->
  <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
  <!-- Mobile Specific Metas -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('common/vendors/images/favicon.ico');?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- bootstrap css -->
  <!-- <link rel="stylesheet" href="<?php //echo base_url('common/');?>loginSignup/vendor/bootstrap/css/bootstrap.css"> -->
  <link rel="stylesheet" href="<?php echo base_url('common/bootstrap4/dist/css/bootstrap.css?v=').file_version_cs;?>"> 
  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo base_url('common/vendors/styles/style.css?v=').file_version_cs;?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('common/src/plugins/datatables/media/css/jquery.dataTables.css?v=').file_version_cs;?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('common/src/plugins/datatables/media/css/dataTables.bootstrap4.css?v=').file_version_cs;?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('common/src/plugins/datatables/media/css/responsive.dataTables.css?v=').file_version_cs;?>"> 

  <!-- datepicker css -->
  <link href="<?php echo base_url('common/datetimePicker/css/datepicker.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script src="<?php echo base_url('common/src/jquery/dist/jquery.min.js?v=').file_version_cs;?>"></script>
  <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script> -->
  <!-- material icons for bootgrid -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link href="<?php echo base_url('common/vendors/bootgrid/jquery.bootgrid.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">

  <link href="<?php echo base_url('common/vendors/sweetalert/sweetalert2.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('common/vendors/sweetalert/animate.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"> -->

  <script src="<?php echo base_url('common/vendors/sweetalert/sweetalert2.all.min.js?v=').file_version_cs;?>"></script>
 
  <!-- adding these links to include chart.js -->
  <script src="<?php echo base_url('common/vendors/chartjs/chart.bundle.min.js?v=').file_version_cs;?>"></script>
  <link href="<?php echo base_url('common/vendors/chartjs/chart.min.css?v=').file_version_cs;?>" rel="stylesheet" type="text/css">
  <script src="<?php echo base_url('common/vendors/chartjs/chart.min.js?v=').file_version_cs;?>"></script>


  <script src="<?php echo base_url('common/jspdf/jspdf.js?v=').file_version_cs; ?>"></script>
  <script src="<?php echo base_url('common/jspdf/dist/jspdf.min.js?v=').file_version_cs; ?>"></script>
  <script src="<?php echo base_url('common/jspdf/libs/html2pdf.js?v=').file_version_cs; ?>"></script>
  <script src="<?php echo base_url('common/jspdf/plugins/from_html.js?v=').file_version_cs; ?>"></script>
  <script src="<?php echo base_url('common/jspdf/plugins/split_text_to_size.js?v=').file_version_cs; ?>"></script>
  <script src="<?php echo base_url('common/jspdf/plugins/standard_fonts_metrics.js?v=').file_version_cs; ?>"></script>
  

  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    
    gtag('config', 'UA-119386393-1');
  </script>
  <style>
    .swal2-container.swal2-backdrop-show
    {
      background: #00000066;
    }
    .dot-success {
      height          : 15px;
      width           : 15px;
      background-color: #bbb;
      border-radius   : 50%;
      display         : inline-block;
      background      : #1cc88a;
    }
    .dot-danger {
      height          : 15px;
      width           : 15px;
      background-color: #bbb;
      border-radius   : 50%;
      display         : inline-block;
      background      : #e74a3b;
    }
  </style>
</head>
<body <?php if($this->uri->segment(2) == 'viewUserReport'){ echo 'style="background-color:white;"'; } ?>>
  <div class="pre-loader"></div>

  <div class="header clearfix">
    <div class="header-right" style="width:100%">
      <div class="brand-logo">
        <a href="<?php echo base_url('Dashboard');?>">
          <?php if (isset($this->session->userdata('loginData')['User_profile_pic'])) { ?>
            <img src="<?php echo base_url('common/Logo/'.$this->session->userdata('loginData')['User_profile_pic']); ?>" alt="CorporateSim">
          <?php } else { ?>
            <img src="<?php echo base_url('common/'); ?>vendors/images/cs_logo.jpg" alt="CorporateSim">
          <?php } ?>
        </a> 
      </div>
      <div class="menu-icon">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>

      <div class="user-info-dropdown">
        <div class="dropdown">
          <a class="dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown">
            <!-- <?php
            if ($this->session->userdata('loginData')['User_Role'] > 0 ) {

              if ($this->session->userdata('loginData')['User_profile_pic']) {
                echo "<img id='image'  name='file_name' src='".base_url('common/profileImages/').$this->session->userdata('loginData')['User_profile_pic']."' alt='Picture' width='50px' class='avatar-photo' style='border-radius: 50%;'>";
              }
            }
            else {
              echo "<span class='user-icon'><i class='fa fa-user-o'></i></span>";
            } 
            ?> -->
            <span class="user-name"><?php echo ucfirst($this->session->userdata('loginData')['User_FullName']); ?>

            <?php if ($this->session->userdata('loginData')['User_Role'] == 1) { ?>
              <br><span class="small"><center><code>Enterprize: <?php echo $this->session->userdata('loginData')['Enterprise_Name']; ?> </code></center></span>
            <?php } else if ($this->session->userdata('loginData')['User_Role'] == 2) { ?> 
              <br><span class="small"><center><code>Subenterprize: <?php echo $this->session->userdata('loginData')['SubEnterprise_Name']; ?></code></center></span>
            <?php } else if ($this->session->userdata('loginData')['User_Role'] == 3) { ?> 
              <br><span class="small"><center><code>Report Viewer</code></center></span>
            <?php } ?>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <?php if ($this->session->userdata('loginData')['User_Role'] == 1 || $this->session->userdata('loginData')['User_Role'] == 2) { ?>
            <a class="dropdown-item" href="<?php echo base_url('Profile'); ?>"><i class="fa fa-user-md" aria-hidden="true"></i> Profile</a>
          <?php } ?>
          <!-- <a class="dropdown-item" href="#" data-toggle="modal"data-target="#Enterprisemodal"><i class="fa fa-edit" aria-hidden="true"></i> Choose Logo</a> -->
          <!-- <a class="dropdown-item" href="#"><i class="fa fa-question" aria-hidden="true"></i> Help</a> -->
          <a class="dropdown-item" href="<?php echo base_url('Dashboard/logout'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
        </div>
      </div>
    </div>
    
    <!-- Notification -->
    <div class="user-notification d-none">
      <div class="dropdown">
        <a class="dropdown-toggle no-arrow" href="javascript:void(0);" role="button">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <span class="notification">4</span>
        </a>
      </div>
    </div>
    <!-- hiding user notification -->
    <div class="user-notification" style="display: none;">
      <div class="dropdown">
        <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <span class="badge notification-active"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="notification-list mx-h-350 customscroll">
            <ul>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="<?php echo base_url('common/');?>vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Modal for upload Logo of Enterprise and SubEnterprise -->
<div class="modal" id="Enterprisemodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-body pd-30">
  <form method="post" action="<?php echo base_url('Dashboard/uploadLogo')?> "enctype="multipart/form-data">
    <div class="form-group row">
      <label class="col-sm-12 col-md-4 col-form-label"><span style="color: red">*</span>Choose Logo</label>
      <div class="col-sm-12 col-md-8">
        <input type="file" name="logo" multiple="multiple" accept="image/*" id="logo" value="" class="form-control">
      </div>
    </div>
    <!-- <div class="img-container"></div> -->
    <div class="modal-footer">
      <input type="submit" name="Upload" value="Upload" class="btn btn-primary">
      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
    </div>
  </form>
</div>
</div>
</div>
</div>

<!-- general purpose modal -->
<div id="randomModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
