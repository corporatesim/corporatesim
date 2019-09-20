
<div class="main-container">
  <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="row clearfix progress-box">
      <!-- total enterprise -->
      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
        <a href="<?php echo base_url('Enterprise'); ?>">
          <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header bg-transparent border-success"><b>Total Enterprize</b></div>
            <div class="card-body text-success">
              <!-- <h5 class="card-title"></h5> -->
              <div class="project-info clearfix">
                <div class="project-info-left">
                  <div class="icon box-shadow bg-blue text-white">
                    <i class="fa fa-institution"></i>
                  </div>
                </div>
                <div class="project-info-right">
                  <span class="no text-blue weight-500 font-24"><?php echo $totalEnterprise; ?></span>
                  <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                </div>
              </div>
            </div>
            <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
          </div>
        </a>
      </div>
      <!-- Enterprise users -->
      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
        <a href="<?php echo base_url('Users/EnterpriseUsers'); ?>">
          <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header bg-transparent border-success"><b>Total Enterprize Users</b></div>
            <div class="card-body text-success">
              <div class="project-info clearfix">
                <div class="project-info-left">
                  <div class="icon box-shadow bg-light-green text-white">
                    <i class="fa fa-users"></i>
                  </div>
                </div>
                <div class="project-info-right">
                  <span class="no text-light-green weight-500 font-24"><?php echo $totalEnterpriseUsers; ?></span>
                  <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                </div>
              </div>
            </div>
            <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
          </div>
        </a>
      </div>
      <!-- total subenterprise -->
      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
        <a href="<?php echo base_url('SubEnterprise'); ?>">
          <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header bg-transparent border-success"><b>Total Sub Enterprize</b></div>
            <div class="card-body text-success">
              <div class="project-info clearfix">
                <div class="project-info-left">
                  <div class="icon box-shadow bg-light-orange text-white">
                    <i class="fa fa-building"></i>
                  </div>
                </div>
                <div class="project-info-right">
                  <span class="no text-light-orange weight-500 font-24"><?php echo $totalSubEnterprise; ?></span>
                  <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                </div>
              </div>
            </div>
            <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
          </div>
        </a>
      </div>
      <!-- subenterprise users -->
      <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
        <a href="<?php echo base_url('Users/SubEnterpriseUsers'); ?>">
          <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header bg-transparent border-success"><b>Total Sub Enterprize Users</b></div>
            <div class="card-body text-success">
              <div class="project-info clearfix">
                <div class="project-info-left">
                  <div class="icon box-shadow bg-light-purple text-white">
                    <i class="fa fa-user-circle-o"></i>
                  </div>
                </div>
                <div class="project-info-right">
                  <span class="no text-light-purple weight-500 font-24"><?php echo $totalSubEnterpriseUsers; ?></span>
                  <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                </div>
              </div>
            </div>
            <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
          </div>
        </a>
      </div>
    </div>
    <div class="bg-white pd-20 box-shadow border-radius-5 mb-30">
      <h4 class="mb-30">Area Spline Chart</h4>
      <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-9 xs-mb-20">
          <div id="areaspline-chart" style="min-width: 210px; height: 400px; margin: 0 auto"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
          <h5 class="mb-30 weight-500">Top Campaign Performance</h5>
          <div class="mb-30">
            <p class="mb-5 font-18">John Campaign</p>
            <div class="progress border-radius-0" style="height: 10px;">
              <div class="progress-bar bg-orange" role="progressbar" style="width: 40%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="mb-30">
            <p class="mb-5 font-18">Jane Campaign</p>
            <div class="progress border-radius-0" style="height: 10px;">
              <div class="progress-bar bg-light-orange" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="mb-30">
            <p class="mb-5 font-18">Johnny Campaign</p>
            <div class="progress border-radius-0" style="height: 10px;">
              <div class="progress-bar bg-light-purple" role="progressbar" style="width: 70%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="mb-30 font-18">
            <p class="mb-5">Daniel Campaign</p>
            <div class="progress border-radius-0" style="height: 10px;">
              <div class="progress-bar bg-light-green" role="progressbar" style="width: 80%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row clearfix">
      <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 mb-30">
        <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
          <h4 class="mb-30">Devices Managed</h4>
          <div class="device-manage-progress-chart">
            <ul>
              <li class="clearfix">
                <div class="device-name">Window</div>
                <div class="device-progress">
                  <div class="progress">
                    <div class="progress-bar window border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                    </div>
                  </div>
                </div>
                <div class="device-total">60</div>
              </li>
              <li class="clearfix">
                <div class="device-name">Mac</div>
                <div class="device-progress">
                  <div class="progress">
                    <div class="progress-bar mac border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                    </div>
                  </div>
                </div>
                <div class="device-total">20</div>
              </li>
              <li class="clearfix">
                <div class="device-name">Android</div>
                <div class="device-progress">
                  <div class="progress">
                    <div class="progress-bar android border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                    </div>
                  </div>
                </div>
                <div class="device-total">30</div>
              </li>
              <li class="clearfix">
                <div class="device-name">Linux</div>
                <div class="device-progress">
                  <div class="progress">
                    <div class="progress-bar linux border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                    </div>
                  </div>
                </div>
                <div class="device-total">10</div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-30">
        <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
          <h4 class="mb-30">Device Usage</h4>
          <div class="clearfix device-usage-chart">
            <div class="width-50-p pull-left">
              <div id="device-usage" style="min-width: 180px; height: 200px; margin: 0 auto"></div>
            </div>
            <div class="width-50-p pull-left">
              <table style="width: 100%;">
                <thead>
                  <tr>
                    <th class="weight-500"><p>Device</p></th>
                    <th class="text-right weight-500"><p>Usage</p></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-yellow"></i> IE</p></td>
                    <td class="text-right weight-400">10%</td>
                  </tr>
                  <tr>
                    <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-green"></i> Chrome</p></td>
                    <td class="text-right weight-400">40%</td>
                  </tr>
                  <tr>
                    <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-orange-50"></i> Firefox</p></td>
                    <td class="text-right weight-400">30%</td>
                  </tr>
                  <tr>
                    <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-blue-50"></i> Safari</p></td>
                    <td class="text-right weight-400">10%</td>
                  </tr>
                  <tr>
                    <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-red-50"></i> Opera</p></td>
                    <td class="text-right weight-400">10%</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-30">
        <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
          <h4 class="mb-30">Profile Completion</h4>
          <div class="clearfix device-usage-chart">
            <div class="width-50-p pull-left">
              <div id="ram" style="min-width: 160px; max-width: 180px; height: 200px; margin: 0 auto"></div>
            </div>
            <div class="width-50-p pull-left">
              <div id="cpu" style="min-width: 160px; max-width: 180px; height: 200px; margin: 0 auto"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row clearfix">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
        <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
          <h4 class="mb-20">Recent Messages</h4>
          <div class="notification-list mx-h-450 customscroll">
            <ul>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
              <li>
                <a href="#">
                  <img src="vendors/images/img.jpg" alt="">
                  <h3 class="clearfix">John Doe <span>3 mins ago</span></h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
        <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
          <h4 class="mb-30">To Do list</h4>
          <div class="to-do-list mx-h-450 customscroll">
            <ul>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck2">
                  <label class="custom-control-label" for="customCheck2">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck3">
                  <label class="custom-control-label" for="customCheck3">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck4">
                  <label class="custom-control-label" for="customCheck4">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck5">
                  <label class="custom-control-label" for="customCheck5">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck6">
                  <label class="custom-control-label" for="customCheck6">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck7">
                  <label class="custom-control-label" for="customCheck7">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck8">
                  <label class="custom-control-label" for="customCheck8">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck9">
                  <label class="custom-control-label" for="customCheck9">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck10">
                  <label class="custom-control-label" for="customCheck10">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck11">
                  <label class="custom-control-label" for="customCheck11">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck12">
                  <label class="custom-control-label" for="customCheck12">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck13">
                  <label class="custom-control-label" for="customCheck13">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck14">
                  <label class="custom-control-label" for="customCheck14">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck15">
                  <label class="custom-control-label" for="customCheck15">Check this custom checkbox</label>
                </div>
              </li>
              <li>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck16">
                  <label class="custom-control-label" for="customCheck16">Check this custom checkbox</label>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    