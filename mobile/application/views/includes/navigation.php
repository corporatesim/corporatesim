<style>
  #rotateTimerClock {
    -webkit-animation: rotation 8s infinite linear;
  }
  @-webkit-keyframes rotation {
    from {
      -webkit-transform: rotate(0deg);
    }
    to {
      -webkit-transform: rotate(359deg);
    }
  }

  .affix {
    top     : 0;
    width   : 100%;
    z-index : 9999 !important;
    position: fixed;
  }

</style>
<nav class="navbar navbar-expand-md navbar-light affix" style="background-color: #e3f2fd;">
  <!-- Brand -->
  <a class="navbar-brand" href="">
    <img src="<?php echo base_url('../enterprise/common/Logo/'.$this->Common_Model->fetchLogo('http://'.$_SERVER['SERVER_NAME'])); ?>" alt="Logo" style="height: 45px; max-width: 300px;">
  </a>
  <a class="navbar-brand d-none" href="#" id="clockTimeHolder"><i class="fa fa-clock-o" id="rotateTimerClock"></i> <span id="showTimer"></span></a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>"><button class="btn btn-outline-primary">Hi, <?php echo ucfirst($this->session->userdata('botUserData')->User_username); ?></button></a>
      </li>
      <li class="nav-item d-none" id="submitLink">
        <a class="nav-link" href="javaScript:void(0);"><button class="btn btn-danger" id="submitPage">Submit</button></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('SelectSimulation/logout');?>"><button class="btn btn-outline-danger">Logout</button></a>
      </li>
    </ul>
  </div>

</nav>
<div class="clearfix"><br></div>
