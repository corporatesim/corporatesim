<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>My Campus</h1>
            </div>

            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Campus</li>
              </ol>
            </nav>
          </div>
        </div>

          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="title">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix pb-3">

                  <div class="col-md-6 pull-left text-left d-none">
                    <h5 class="text-blue">Campus List</h5>
                  </div>
                  
                </div>
                  
                  <div class="row" id="addTable">
                    <table class="stripe hover multiple-select-row data-table-export">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Campus Name</th>
                          <th>Type</th>
                          <th>Address</th>
                          <!-- <th>Email</th>
                          <th>Contact</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($campus) < 1){ ?>
                          <tr>
                            <td class="text-danger text-center" colspan="4"> No Record Found </td>
                          </tr>
                          <!-- only if record exists -->
                        <?php } else{ $i=1; 
                          foreach ($campus as $campusRow) { 
                        ?>
                          <tr>
                            <!-- ID -->
                            <td><?php echo $i;?></td>
                            <!-- campus Name -->
                            <td><?php echo $campusRow->UC_Name; ?></td>
                            <!-- Type -->
                            <td>
                              <?php
                                switch ($campusRow->UC_Type) {
                                  case 1:
                                    echo 'Management';
                                    break;
                                  case 2:
                                    echo 'Engineering';
                                    break;
                                  default:
                                    echo 'Other';
                                }
                              ?>
                            </td>
                            <!-- Address -->
                            <td><?php echo $campusRow->UC_Address; ?></td>
                            <!-- E-mail -->
                            <!-- <td><?php echo $campusRow->UC_Email; ?></td> -->
                            <!-- Phone Number -->
                            <!-- <td><?php echo $campusRow->UC_Contact ;?></td> -->
                          </tr>
                          <?php $i++; } } ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="clearfix"></div>       
                  </div>
                  <!-- end of list Campus -->
                  </form>

                </div>
              </div>
            </div>
            <div class="clearfix"></div>
