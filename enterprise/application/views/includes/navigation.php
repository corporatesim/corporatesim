  <div class="left-side-bar">
    <div class="brand-logo">
      <a href="<?php echo base_url('Dashboard'); ?>">
        <?php if (isset($this->session->userdata('loginData')['User_profile_pic'])) { ?>
          <img src="<?php echo base_url('common/Logo/' . $this->session->userdata('loginData')['User_profile_pic']); ?>" alt="CorporateSim">
        <?php } else { ?>
          <img src="<?php echo base_url('common/'); ?>vendors/images/cs_logo.jpg" alt="CorporateSim">
        <?php } ?>
      </a>
    </div>
    <div class="menu-block customscroll">
      <div class="sidebar-menu">
        <ul id="accordion-menu">

          <li class="dropdown">
            <a href="<?php echo base_url('Dashboard'); ?>" class="dropdown-toggle no-arrow">
              <span class="fa fa-dashboard"></span><span class="mtext">Dashboard</span>
            </a>
          </li>

          <!-- show profile only to enterprise or subenterprise -->
          <?php if (($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 2) { ?>
            <li class="dropdown">
              <a href="<?php echo base_url('Profile'); ?>" class="dropdown-toggle no-arrow">
                <span class="fa fa-user-md"></span><span class="mtext">Profile</span>
              </a>
            </li>
          <?php } ?>

          <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
          <li class="dropdown">
            <a href="<?php echo base_url('Specialization'); ?>" class="dropdown-toggle no-arrow">
              <span class="fa fa-adjust"></span><span class="mtext">Specialization</span>
            </a>
          </li>

          <li class="dropdown">
            <a href="<?php echo base_url('Campus'); ?>" class="dropdown-toggle no-arrow">
              <span class="fa fa-adjust"></span><span class="mtext">Campus</span>
            </a>
          </li>
          <?php } ?>

          <?php if($this->session->userdata('loginData')['User_Role'] == 1){ ?>
            <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle">
                <span class="fa fa-adjust"></span><span class="mtext">Campus Box</span>
              </a>
              <ul class="submenu">
                <li>
                  <a href="<?php echo base_url('Campus/SelectCampus'); ?>">       
                    <span class='fa fa-folder'></span> Select Campus
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('Campus/myCampus'); ?>">
                    <span class="fa fa-folder-open"></span> My Campus
                  </a>
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle">
                <span class="fa fa-folder"></span><span class="mtext">Card Box</span>
              </a>
              <ul class="submenu">
                <li>
                  <a href="<?php echo base_url('Card/'); ?>">       
                    <span class='fa fa-folder'></span> Select Cards
                  </a>
                </li>
                <li>
                  <a href="<?php echo base_url('Card/myAssociatedCard'); ?>">
                    <span class="fa fa-folder-open"></span> My Cards
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <!-- show option to manage enterprise only for superadmin -->
          <?php if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
            <li class="dropdown">
              <a href="<?php echo base_url('Enterprise/'); ?>" class="dropdown-toggle no-arrow">
                <span class="fa fa-institution"></span><span class="mtext">Manage Enterprize</span>
              </a>
            </li>
          <?php } ?>
          <!-- show option to manage subenterprise only for admin or enterprise -->
          <?php if (($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 'superadmin') { ?>
            <li class="dropdown">
              <a href="<?php echo base_url('SubEnterprise/'); ?>" class="dropdown-toggle no-arrow">
                <span class="fa fa-building"></span><span class="mtext">Manage SubEnterprize</span>
              </a>
            </li>
          <?php } ?>
          <!-- show option to manage ent/subent users only for admin and enterprise -->
          <?php if (($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 'superadmin') { ?>
            <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle">
                <span class="fa fa-users"></span><span class="mtext">Manage Users</span>
              </a>
              <ul class="submenu">
                <li>
                  <a href="<?php echo base_url('Users/EnterpriseUsers'); ?>">
                    <?php if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
                      <!-- admin then -->
                      <span class='fa fa-user-circle-o'></span> Enterprize Users
                    <?php } else { ?>
                      <!-- enterprise then -->
                      <span class='fa fa-user-circle-o'></span> My Users
                    <?php } ?>
                  </a>
                </li>
                <li><a href="<?php echo base_url('Users/SubEnterpriseUsers'); ?>"><span class="fa fa-user-circle-o"></span> SubEnterprize Users</a></li>
                <!-- <li><a href="<?php echo base_url('Users/addUsers/'); ?>"><span class="fa fa-plus-circle"></span> Add Users</a></li> -->
              </ul>
            </li>
            <!-- if user of type subenterprise then show only subenterprise users -->
          <?php } else { ?>
            <li class="dropdown">
              <a href="<?php echo base_url('Users/SubEnterpriseUsers/'); ?>" class="dropdown-toggle no-arrow">
                <span class="fa fa-user-circle-o"></span><span class="mtext">Manage Users</span>
              </a>
            </li>
          <?php } ?>

          <li class="dropdown">
            <a href="<?php echo base_url('Collaboration/'); ?>" class="dropdown-toggle no-arrow">
              <i class="fa fa-handshake-o" aria-hidden="true"></i>
              <span class="mtext">P2P</span>
            </a>
          </li>

          <!-- to see the mis and analytics -->
          <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle">
              <span class="fa fa-book fa-fw"></span><span class="mtext">MIS & Analytics</span>
            </a>

            <ul class="submenu">
              <li>
                <a href="<?php echo base_url('OfflineReports/'); ?>">
                  <span class="fa fa-file"></span> Report-One
                </a>
              </li>
              <li>
                <a href="<?php echo base_url('OnlineReport'); ?>">
                  <span class='fa fa-file-code-o'></span> Report-Two
                </a>
              </li>
              <!-- <li class="d-none">
      <a href="<?php echo base_url('Analytics/'); ?>">
        <span class="fa fa-bar-chart"></span> Analytics
      </a>
    </li> -->
              <li>
                <a href="<?php echo base_url('Collaboration/viewGroupReport'); ?>">
                  <span class="fa fa-bar-chart"></span> Report-Three
                </a>
              </li>
              <!-- show report 4 only for admin or enterprise -->
              <?php if (($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 'superadmin') { ?>
              <li>
                <a href="<?php echo base_url('Competence/competenceReport'); ?>">
                  <span class="fa fa-superpowers"></span> Report-Four
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>

          <!-- show Factors only for admin or enterprise -->
          <?php if (($this->session->userdata('loginData')['User_Role']) == 1 || ($this->session->userdata('loginData')['User_Role']) == 'superadmin') { ?>
          <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle">
              <span class="fa fa-superpowers"></span><span class="mtext">Factors</span>
            </a>

            <ul class="submenu">
              <?php if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
                <li>
                  <a href="<?php echo base_url('Competence'); ?>" data-toggle="tooltip" title="Add Master">
                    <span class="fa fa-plus-circle"></span> Master
                  </a>
                </li>
              <?php } ?>
              <li>
                <a href="<?php echo base_url('Competence/viewCompetenceMapping'); ?>" data-toggle="tooltip" title="View/Edit Mapping">
                  <span class='fa fa-eye'></span> Mapping
                </a>
              </li>
              <li>
                <a href="<?php echo base_url('Competence/itemFormula'); ?>" data-toggle="tooltip" title="Add/Edit Formula">
                  <span class='fa fa-plus-circle'></span> Formula
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

        </ul>

      </div>
    </div>
    <!-- <div class="footer-wrap bg-white pd-20 mb-20 border-radius-5 box-shadow" style="bottom: 0; position: absolute;
">
      <a href="https://www.corporatesim.com/" target="_blank">
        Copyright &copy; Humanlinks Learning Pvt. Ltd.- All rights reserved
      </a>
    </div> -->
  </div>