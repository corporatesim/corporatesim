<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Edit SubEnterprise</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit SubEnterprise</li>
              </ol>
            </nav>
          </div>  
        </div>
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
          <div class="clearfix">
            <div class="pull-left">
              <!-- <h4 class="text-blue">Edit SubEnterprise</h4><br> -->
            </div>
          </div>
          <form method="post" action=""enctype="multipart/form-data">
            <input type="hidden" name="type" value="subenterprise">
            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Name</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" type="text" value="<?php echo $userDetails->SubEnterprise_Name?>" 
                name="SubEnterprise_Name">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Contact Number</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Number" value="<?php echo $userDetails->SubEnterprise_Number;?>" type="text" placeholder="Enter SubEnterprise Number" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Email ID</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Email" value="<?php echo $userDetails->SubEnterprise_Email;?>" type="email" placeholder="Enter SubEnterprise Email" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Address1</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Address1" value="<?php echo $userDetails->SubEnterprise_Address1;?>" type="text" placeholder="Enter SubEnterprise Address1" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Address2</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Address2" value="<?php echo $userDetails->SubEnterprise_Address2;?>" type="text" placeholder="Enter SubEnterprise Address2">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Country</label>
              <div class="col-sm-12 col-md-6">
                <select class="form-control" name="SubEnterprise_Country" required="" id="country">
                  <option value="">--Select Country--</option>
                  <?php foreach ($country as $row) { ?>
                    <option value="<?php echo $row->Country_Id;?>" <?php echo ($userDetails->SubEnterprise_Country==$row->Country_Id)?'selected':'';?>><?php echo $row->Country_Name;?></option>
                  <?php } ?>
                </select>
                <?php if($userDetails->SubEnterprise_Country){ ?>
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
                <select class="form-control" name="SubEnterprise_State" required="" id="state" data-stateid="<?php echo $userDetails->SubEnterprise_State;?>">
                  <option value="">--Select State--</option>
                </select>
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label"> SubEnterprise Province</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Province" value="<?php echo $userDetails->SubEnterprise_Province;?>" type="text" placeholder="Enter SubEnterprise Province">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Pincode</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Pincode" value="<?php echo $userDetails->SubEnterprise_Pincode;?>" type="text" placeholder="Enter SubEnterprise Pincode" required="">
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Password</label>
              <div class="col-sm-12 col-md-6">
                <input class="form-control" name="SubEnterprise_Password" type="text" placeholder="Enter SubEnterprise Password" required="" value="<?php echo $userDetails->SubEnterprise_Password;?>">
              </div>
            </div> 


            <!-- <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Account Duration</label>
              <div id="assignDate"class="col-sm-12 col-md-6">
                <div class="input-group" name="gamedate" id="datepicker">
                  <input type="text" class="form-control datepicker-here" id="SubEnterprise_StartDate" name="SubEnterprise_StartDate" value="<?php echo $userDetails->SubEnterprise_StartDate ?>" data-value="<?php echo strtotime($userDetails->SubEnterprise_StartDate);?>" placeholder="Select Start Date" required="" readonly="" data-startDate="<?php echo strtotime($userDetails->SubEnterprise_StartDate);?>" data-endDate="<?php echo strtotime($userDetails->SubEnterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">

                  <span class="input-group-addon" >To</span>

                  <input type ="text" class="form-control datepicker-here" id="SubEnterprise_EndDate" name="SubEnterprise_EndDate" value="<?php echo $userDetails->SubEnterprise_EndDate ?>" data-value="<?php echo strtotime($userDetails->SubEnterprise_EndDate);?>" placeholder="Select End Date" required="" readonly="" data-startDate="<?php echo strtotime($userDetails->SubEnterprise_StartDate);?>" data-endDate="<?php echo strtotime($userDetails->SubEnterprise_EndDate);?>" data-language='en' data-date-format="dd-mm-yyyy">
                </div>
              </div>
            </div> -->

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Choose Logo</label>
              <div class="col-sm-12 col-md-6">
                <input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-12 col-md-4 col-form-label">Current SubEnterprise Logo</label>
              <div class="col-sm-12 col-md-6">
                <img src="<?php echo base_url('common/Logo/'.$userDetails->SubEnterprise_Logo);?>" width="100px"height="100px" alternate="SubEnterprise_Logo">
              </div>
            </div>
            <div class="text-center">
              <button type="submit" name="submit"class="btn btn-primary">UPDATE</button>
              <a href="<?php echo base_url();?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
            </div>
          </form>
        </div>
      </div>
