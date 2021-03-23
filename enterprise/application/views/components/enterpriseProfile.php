<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Edit Enterprize</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Enterprize</li>
              </ol>
            </nav>
          </div>  
        </div>
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
          <div class="clearfix">
            <div class="pull-left">
              <!-- <h4 class="text-blue">Edit Enterprize</h4><br> -->
            </div>
          </div>
          <form method="post" action=""enctype="multipart/form-data">
            <input type="hidden" name="type" value="enterprise">
            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Name</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" type="text" value="<?php echo $userDetails->Enterprise_Name?>" 
                name="Enterprise_Name">
              </div>
            </div>
            <!-- adding more field -->
            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Contact Number</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Number" value="<?php echo $userDetails->Enterprise_Number;?>" type="text" placeholder="Enter Enterprize Number" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Email ID</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Email" value="<?php echo $userDetails->Enterprise_Email;?>" type="email" placeholder="Enter Enterprize Email" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Address1</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Address1" value="<?php echo $userDetails->Enterprise_Address1;?>" type="text" placeholder="Enter Enterprize Address1" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Address2</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Address2" value="<?php echo $userDetails->Enterprise_Address2;?>" type="text" placeholder="Enter Enterprize Address2">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Country</label>
              <div class="col-sm-12 col-md-6">
                <select class="form-control" name="Enterprise_Country" required="" id="country">
                  <option value="">--Select Country--</option>
                  <?php foreach ($country as $row) { ?>
                    <option value="<?php echo $row->Country_Id;?>" <?php echo ($userDetails->Enterprise_Country==$row->Country_Id)?'selected':'';?>><?php echo $row->Country_Name;?></option>
                  <?php } ?>
                </select>
                <?php if($userDetails->Enterprise_Country){ ?>
                  <script>
                    setTimeout(function(){
                      $('#country').trigger('change');
                    },1000);
                  </script>
                <?php } ?>
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">State</label>
              <div class="col-sm-12 col-md-6">
                <select class="form-control" name="Enterprise_State" required="" id="state" data-stateid="<?php echo $userDetails->Enterprise_State;?>">
                  <option value="">--Select State--</option>
                </select>
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Province</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Province" value="<?php echo $userDetails->Enterprise_Province;?>" type="text" placeholder="Enter Enterprize Province">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Pincode</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Pincode" value="<?php echo $userDetails->Enterprise_Pincode;?>" type="text" placeholder="Enter Enterprize Pincode" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Password</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="Enterprise_Password" type="text" placeholder="Enter Enterprize Password" required="" value="<?php echo $userDetails->Enterprise_Password;?>">
              </div>
            </div> 
            <!-- end of adding field -->
            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Choose Logo</label>
              <div class="col-sm-12 col-md-6">
                <input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
              </div>
            </div>

           <!-- <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Account Duration</label>
              <div id="assignDate"class="col-sm-12 col-md-6">
                <div class="input-group" name="gamedate" id="datepicker">
                  <input type="text" class="form-control datepicker-here" id="Enterprise_StartDate" name="Enterprise_StartDate" value="<?php echo $userDetails->Enterprise_StartDate ?>" data-value="<?php echo strtotime($userDetails->Enterprise_StartDate);?>" placeholder="Select Start Date" required="" readonly="" data-startDate="<?php echo strtotime($userDetails->Enterprise_StartDate);?>" data-endDate="<?php echo strtotime($userDetails->Enterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">

                  <span class="input-group-addon" >To</span>

                  <input type ="text" class="form-control datepicker-here" id="Enterprise_EndDate" name="Enterprise_EndDate" value="<?php echo $userDetails->Enterprise_EndDate ?>" data-value="<?php echo strtotime($userDetails->Enterprise_EndDate);?>" placeholder="Select End Date" required="" readonly="" data-startDate="<?php echo strtotime($userDetails->Enterprise_StartDate);?>" data-endDate="<?php echo strtotime($userDetails->Enterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">
                </div>
              </div>
            </div> -->

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Current Logo</label>
              <div class="col-sm-12 col-md-6">
                <img src="<?php echo base_url('common/Logo/'.$userDetails->Enterprise_Logo);?>" width="100px"height="100px" alternate="Enterprise_Logo">
              </div>
            </div>
            <div class="text-center">
              <button type="submit" name="submit"class="btn btn-primary">UPDATE</button>
              <a href="<?php echo base_url();?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
            </div>
          </form>
        </div>
      </div>
