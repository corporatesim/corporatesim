<!-- <?php // echo "<pre>"; print_r($_SESSION); exit;
      ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Page Info -->
  <meta charset="utf-8">
  <title>Corporate Sim</title>

  <!-- Site favicon -->
  <link rel="shortcut icon" type="image/x-icon"  href="<?php echo site_root; ?>images/favicon.ico">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo site_root; ?>assets-simulation/vendors/styles/style.css?v=<?php echo version; ?>">

  <script src="<?php echo site_root; ?>js/jquery.min.js?v=<?php echo version; ?>"></script>

  <!-- adding sweet alert -->
  <link href="<?php echo site_root; ?>dist/sweetalert/sweetalert2.min.css?v=<?php echo version; ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo site_root; ?>dist/sweetalert/animate.min.css?v=<?php echo version; ?>" rel="stylesheet" type="text/css">

  <script src="<?php echo site_root; ?>dist/sweetalert/sweetalert2.all.min.js?v=<?php echo version; ?>"></script>

  <style>
    .swal2-container.swal2-backdrop-show {
      background: #00000066;
    }

    .img-circle {
      border-radius: 50%;
    }
    .table-borderless td, .table-borderless th {
      border: none;
    }
  </style>

  <center>
    <div id="imageModal" class="modal">
      <span class="close" id="close" style="font-size: 50px; opacity: 1; color:#f00;">
        &times;
      </span>
      <img class="modal-content" id="showImageHere">
      <div id="caption"></div>
    </div>
  </center>
</head>
<body>
  <div class="pre-loader"></div>
  <div class="header clearfix">
    <div class="header-right">
      <div class="brand-logo">
        <a href="<?php echo site_root; ?>">
        <?php if (isset($_SESSION['logo'])) { ?>
          <img src="<?php echo site_root.'enterprise/common/Logo/'.$_SESSION['logo']; ?>" style="max-width: 300px; height: 45px;" alt="logo" class="mobile-logo">
        <?php } else { ?>
          <img src="<?php echo site_root; ?>images/logo-main.png" width="40px" alt="logo" class="mobile-logo">
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
      <?php
        if ($_REQUEST['act'] != 'chart') {
          if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      ?>
        <div class="dropdown">
          <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <?php
              // Setting Login User Name and Profile Picture
              $imageSrc = ($_SESSION['User_profile_pic']) ? $_SESSION['User_profile_pic'] : 'avatar.png';
              $userName = ucfirst(strtolower($_SESSION['username']));
            ?>
            <span class="user-icon">
              <img src="<?php echo site_root.'images/userProfile/'.$imageSrc; ?>" width="40px" height="40px" class="img-circle" alt="<?php echo $userName; ?>">
            </span>
            <span class="user-name"><?php echo $userName; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo site_root; ?>my_profile.php"><i class="fa fa fa-user" aria-hidden="true"></i> My Profile</a>
            <a class="dropdown-item" href="<?php echo site_root; ?>settings.php"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</a>
            <!-- <a class="dropdown-item" href="#" id="showGuide"><i class="fa fa-book" aria-hidden="true"></i> Guide</a> -->
            <!-- <a class="dropdown-item" href="<?php echo site_root; ?>feedback.php"><i class="fa fa-comments" aria-hidden="true"></i> Feedback</a> -->
            <a class="dropdown-item" href="<?php echo site_root; ?>logout.php?q=Logout"><i class="fa fa-power-off" aria-hidden="true"></i> Log Out</a>
          </div>
        </div>
      <?php } else { ?>
        <a href="<?php echo site_root; ?>registration.php" class="btn btn-primary px-5"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
      <?php } } ?>
      </div>
      <div class="user-notification">
        <a href="<?php echo site_root; ?>gameCatalogue.php" class="btn btn-primary px-3"><i class="fa fa-home" aria-hidden="true"></i></a>
        <a href="<?php echo site_root; ?>cart.php" class="btn btn-primary px-3"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php if ($_SESSION['User_CartCount'] > 0) { echo $_SESSION['User_CartCount']; } ?></a>
        <a href="#" id="showGuide" class="btn btn-primary px-3"><i class="fa fa-book" aria-hidden="true"></i> Guide</a>
      </div>
    </div>
  </div>

    <div class="left-side-bar">
    <div class="brand-logo">
      <a href="<?php echo site_root; ?>">
        <?php if (isset($_SESSION['logo'])) { ?>
          <img src="<?php echo site_root.'enterprise/common/Logo/'.$_SESSION['logo']; ?>" style="max-width: 300px; height: 45px;" alt="logo">
        <?php } else { ?>
          <img src="<?php echo site_root; ?>images/logo-main.png" width="40px" alt="logo">
        <?php } ?>
      </a>
    </div>
    <div class="menu-block customscroll">
      <div class="sidebar-menu">
        <ul id="accordion-menu">

          <!-- <li>
            <a href="<?php echo site_root; ?>gameCatalogue.php" class="dropdown-toggle no-arrow">
              <span class="fa fa-home"></span><span class="mtext">Home</span>
            </a>
          </li> -->
          
          <li>
            <a href="<?php echo site_root; ?>gameCatalogue.php" class="dropdown-toggle no-arrow <?php echo ($_SESSION['userpage'] == 'gameCatalogue') ? 'active' : ''; ?>">
              <span class="fa fa-th"></span><span class="mtext">Catalogue</span>
            </a>
          </li>

          <li>
            <a href="<?php echo site_root; ?>selectgame.php" class="dropdown-toggle no-arrow <?php echo ($_SESSION['userpage'] == 'selectgame') ? 'active' : ''; ?>">
              <span class="fa fa-th-large"></span><span class="mtext">Cards</span>
            </a>
          </li>

          <li>
            <a href="<?php echo site_root; ?>feedback.php" class="dropdown-toggle no-arrow <?php echo ($_SESSION['userpage'] == 'Feedback') ? 'active' : ''; ?>">
              <span class="fa fa-comments"></span><span class="mtext">Feedback</span>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </div>

  <div class="main-container">
    <div class="pd-ltr-20 height-100-p xs-pd-20-10">
      <div class="min-height-200px">
