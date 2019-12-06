  <div class="left-side-bar">
    <div class="brand-logo">
      <a href="<?php echo base_url('Dashboard');?>">
        <?php if(isset($this->session->userdata('loginData')['User_profile_pic'])) { ?>
          <img src="<?php echo base_url('common/Logo/'.$this->session->userdata('loginData')['User_profile_pic']); ?>" alt="CorporateSim">
        <?php } else { ?>
          <img src="<?php echo base_url('common/'); ?>vendors/images/cs_logo.jpg" alt="CorporateSim">
        <?php } ?>
      </a> 
    </div>
    <div class="menu-block customscroll">
      <div class="sidebar-menu">
        <ul id="accordion-menu">
          <li class="dropdown">
            <a href="<?php echo base_url('Dashboard');?>" class="dropdown-toggle no-arrow">
              <span class="fa fa-dashboard fa-fw"></span><span class="mtext">Dashboard</span>
            </a>
          </li>
          <!-- show profile only to enterprise or subenterprise -->
          <?php if(($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) ==2) { ?>
            <li class="dropdown">
              <a href="<?php echo base_url('Profile');?>" class="dropdown-toggle no-arrow">
                <span class="fa fa fa-user-md"></span><span class="mtext">Profile</span>
              </a>
            </li>
          <?php } ?>
          <!-- show option to manage enterprise only for superadmin -->
          <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
            <li class="dropdown">
             <a href="<?php echo base_url('Enterprise/');?>" class="dropdown-toggle no-arrow">
              <span class="fa fa-institution"></span><span class="mtext">Manage Enterprize</span>
            </a>
          </li>
        <?php } ?>
        <!-- show option to manage subenterprise only for admin or enterprise -->
        <?php if(($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 'superadmin') { ?>
          <li class="dropdown">
           <a href="<?php echo base_url('SubEnterprise/');?>" class="dropdown-toggle no-arrow">
            <span class="fa fa-building"></span><span class="mtext">Manage SubEnterprize</span>
          </a>
        </li>
      <?php } ?>
      <!-- show option to manage ent/subent users only for admin and enterprise -->
      <?php if(($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 'superadmin') { ?>
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="fa fa-users"></span><span class="mtext">Manage Users</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="<?php echo base_url('Users/EnterpriseUsers');?>">
                <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                  <!-- admin then -->
                  <span class='fa fa-user-circle-o'></span> Enterprize Users
                <?php } else { ?>
                  <!-- enterprise then -->
                  <span class='fa fa-user-circle-o'></span> My Users
                <?php } ?>
              </a>
            </li>
            <li><a href="<?php echo base_url('Users/SubEnterpriseUsers');?>"><span class="fa fa-user-circle-o"></span> SubEnterprize Users</a></li>
            <!-- <li><a href="<?php echo base_url('Users/addUsers/');?>"><span class="fa fa-plus-circle"></span> Add Users</a></li> -->
          </ul>
        </li>
        <!-- if user of type subenterprise then show only subenterprise users -->
      <?php } else { ?>
       <li class="dropdown">
         <a href="<?php echo base_url('Users/SubEnterpriseUsers/');?>" class="dropdown-toggle no-arrow">
          <span class="fa fa-user-circle-o"></span><span class="mtext">Manage Users</span>
        </a>
      </li>
    <?php } ?>
    <!-- to see the mis and analytics -->
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle">
        <span class="fa fa-book fa-fw"></span><span class="mtext">MIS & Analytics</span>
      </a>

      <ul class="submenu">
        <li>
         <a href="<?php echo base_url('OfflineReports/');?>">
          <span class="fa fa-file"></span> Offline Reports
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('OnlineReport');?>">
          <span class='fa fa-file-code-o'></span> Online Reports
        </a>
      </li>
      <li class="d-none">
        <a href="<?php echo base_url('Analytics/');?>">
        <span class="fa fa-bar-chart"></span> Analytics
      </a>
    </li>
  </ul>

</li>

</ul>

</div>
</div>
</div>