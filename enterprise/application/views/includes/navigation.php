  <div class="left-side-bar">
    <div class="brand-logo">
      <a href="<?php echo base_url('Dashboard');?>">
        <img src="<?php echo base_url('common/'); ?>vendors/images/cs_logo.jpg" alt="">
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
          <li class="dropdown">
            <?php  if(($this->session->userdata('loginData')['User_Role'])> 0) {?>
              <a href="<?php echo base_url('Profile');?>" class="dropdown-toggle no-arrow">
                <span class="fa fa fa-user-md"></span><span class="mtext">Profile</span>
              </a>
            <?php }?>
          </li>
          <?php if(($this->session->userdata('loginData')['User_Role'])==1) {?>
            <li class="dropdown">
             <a href="javascript:;" class="dropdown-toggle">
              <span class="fa fa-building-o custom"></span><span class="mtext">Manage SubEnterprise</span>
            </a>
            <ul class="submenu">
              <li><a href="<?php echo base_url('SubEnterprise/');?>"><span class="fa fa-building"></span> SubEnterprise</a></li>
              <li><a href="<?php echo base_url('SubEnterprise/addSubEnterprise/');?>"><span class="fa fa-plus-circle"></span> Add SubEnterprise</a></li>
            </ul> 
          </li> 
        <?php }else if(($this->session->userdata('loginData')['User_Role'])<1){?>
         <li class="dropdown">
           <a href="<?php echo base_url('Enterprise/');?>" class="dropdown-toggle no-arrow">
            <span class="fa fa-institution"></span><span class="mtext">Manage Enterprise</span>
          </a>
        </li>
        <li class="dropdown">
         <a href="<?php echo base_url('SubEnterprise/');?>" class="dropdown-toggle no-arrow">
          <span class="fa fa-building"></span><span class="mtext">Manage SubEnterprise</span>
        </a>
      </li>
    <?php }?>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle">
        <span class="fa fa-users"></span><span class="mtext">Manage Users</span>
      </a>
      <ul class="submenu">
        <?php if(($this->session->userdata('loginData')['User_Role'])<1) {?>
          <li>
            <a href="<?php echo base_url('Users/EnterpriseUsers');?>">
              <span class='fa fa-user-circle-o'></span> Enterprise Users
            </a>
          </li>
          <li><a href="<?php echo base_url('Users/SubEnterpriseUsers');?>"><span class="fa fa-user-circle-o"></span> SubEnterprise Users</a></li>
        <?php } else if(($this->session->userdata('loginData')['User_Role'])==1 ) {?>
          <li>
            <a href="<?php echo base_url('Users/EnterpriseUsers');?>">
              <span class='fa fa-user-circle-o'></span> Enterprise Users
            </a>
          </li>
          <li><a href="<?php echo base_url('Users/SubEnterpriseUsers');?>"><span class="fa fa-user-circle-o"></span> SubEnterprise Users</a></li>
          <li><a href="<?php echo base_url('Users/addUsers/');?>"><span class="fa fa-plus-circle"></span> Add Users</a></li>
        <?php } else{?>
          <li><a href="<?php echo base_url('Users/SubEnterpriseUsers');?>"><span class="fa fa-user-circle-o"></span> SubEnterprise Users</a></li>
          <li><a href="<?php echo base_url('Users/addUsers/');?>"><span class="fa fa-plus-circle"></span> Add Users</a></li>
        <?php }?>
      </ul>
    </li>
  </ul>
</div>
</div>
</div>