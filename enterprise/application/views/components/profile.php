<div class="main-container">
	<!-- <?php //echo $error;?> -->
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
  <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <h1>User Profile</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mb-30">
          <div class="pd-20 bg-white border-radius-4 box-shadow">
            <div class="profile-photo">
              <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-external-link"></i></a>
              <?php
              if($this->session->userdata('loginData')['User_profile_pic'])
              {
                echo "<img id='image'  name='file_name' src='".base_url('common/profileImages/').$this->session->userdata('loginData')['User_profile_pic']."' alt='Picture' class='avatar-photo'>";
              }
              else
              {
                echo "<img id='image'  name='file_name' src='".base_url('common/profileImages/photo2.jpg')."' alt='Picture' class='avatar-photo'>";
              } 
              ?>
              <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-body pd-5">
                      <div class="img-container">
                        <?php
                        if($this->session->userdata('loginData')['User_profile_pic'])
                        {
                          echo "<img id='image'  name='file_name' src='".base_url('common/profileImages/').$this->session->userdata('loginData')['User_profile_pic']."' alt='Picture' class='avatar-photo'>";
                        }
                        else
                        {
                          echo "<img id='image'  name='file_name' src='".base_url('common/profileImages/photo2.jpg')."' alt='Picture' class='avatar-photo'>";
                        } 
                        ?>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <!-- <input type="submit" name="Upload" value="Upload" class="btn btn-primary"> -->
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <!-- </form> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h5 class="text-center">Enterprise:</h5>
            <h5 class="text-center text-muted"><?php echo $this->session->userdata('loginData')['Enterprise_Name']?></h5><br>
            <h5 class="text-center">User Profile</h5>
            <p class="text-center text-muted"><?php echo $userDetails->User_username; ?></p>
            <div class="profile-info">
              <h5 class="mb-20 weight-500">Contact Information</h5>
              <ul>
                <li>
                  <span>User Name:</span>
                  <?php echo $userDetails->User_username; ?>
                </li>
                <li>
                  <span>Email Address:</span>
                  <?php echo $userDetails->User_email; ?>
                </li>
                <li>
                  <span>Phone Number:</span>
                  <?php echo $userDetails->User_mobile; ?>
                </li>
                <!-- <li>
                  <span>Country:</span>
                  India
                </li>
                <li>
                  <span>Address:</span>
                  Gurgaon<br>
                </li> -->
              </ul>
            </div>
          <!--   <div class="profile-social">
              <h5 class="mb-20 weight-500">Social Links</h5>
              <ul class="clearfix">
                <li><a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#c32361" data-color="#ffffff"><i class="fa fa-dribbble"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#3d464d" data-color="#ffffff"><i class="fa fa-dropbox"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#db4437" data-color="#ffffff"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#bd081c" data-color="#ffffff"><i class="fa fa-pinterest-p"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#00aff0" data-color="#ffffff"><i class="fa fa-skype"></i></a></li>
                <li><a href="#" class="btn" data-bgcolor="#00b489" data-color="#ffffff"><i class="fa fa-vine"></i></a></li>
              </ul>
            </div>
            <div class="profile-skills">
              <h5 class="mb-20 weight-500">Key Skills</h5>
              <h6 class="mb-5">HTML</h6>
              <div class="progress mb-20" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h6 class="mb-5">Css</h6>
              <div class="progress mb-20" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h6 class="mb-5">jQuery</h6>
              <div class="progress mb-20" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h6 class="mb-5">Bootstrap</h6>
              <div class="progress mb-20" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div> -->
          </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 mb-30">
          <div class="bg-white border-radius-4 box-shadow height-100-p">
            <div class="profile-tab height-100-p">
              <div class="tab height-100-p">
                <ul class="nav nav-tabs customtab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Manage Profile</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <!-- Setting Tab start -->
                  <div class="tab-pane fade show active" id="setting" role="tabpanel">
                    <div class="profile-setting">
                      <!-- <form method="post" action="" enctype="multipart/form-data"> -->
                      	<?php echo form_open_multipart('Profile');?>
                        <ul class="profile-edit-list row">
                          <li class="weight-500 col-md-10">
                            <h4 class="text-blue mb-20">Edit Your Personal Setting</h4>
                            <div class="form-group">
                              <label>First Name</label>
                              <input class="form-control " type="text" name="User_fname" value="<?php echo $userDetails->User_fname; ?>">
                            </div>
                            <div class="form-group">
                              <label>Last Name</label>
                              <input class="form-control" type="text"  name="User_lname" value="<?php echo $userDetails->User_lname; ?>">
                            </div>
                            <div class="form-group">
                              <label>User Name</label>
                              <input class="form-control" type="text"  name="User_username" value="<?php echo $userDetails->User_username; ?>">
                            </div>
                            <div class="form-group">
                              <label>Contact</label>
                              <input class="form-control" type="tel"  name="User_mobile" value="<?php echo $userDetails->User_mobile; ?>">
                            </div>
                            <div class="form-group">
                              <label>Email</label>
                              <input class="form-control" type="email"  name="User_email" value="<?php echo 
                              $userDetails->User_email; ?>">
                            </div>
                            <div class="form-group">
                              <label >Password</label>
                              <input class="form-control" type="text" name="password" value="<?php echo $editPassword->Auth_password ?>"> 
                            </div>
                            <div class="form-group">
                              <label>User Profile</label>
                              <input class="form-control" type="file" 
                              name="User_profile_pic" value="<?php echo 
                              $userDetails->User_profile_pic;?>">
                            </div>
                            <div class="form-group text-center">
                              <button type="submit"  name="submit" class="btn btn-primary">UPDATE</button>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Setting Tab End -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>