<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Select Campus</h1>
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

                  <div class="col-md-6 pull-left text-left">
                    <h5 class="text-blue">Campus List</h5>
                  </div>
                  <div class="col-md-4"></div>
                  <div class="col-md-2 custom-control custom-checkbox pull-right">
                    <input type="checkbox" class="custom-control-input" value="" id="select_all" name="select_all">
                    <label class="custom-control-label" for="select_all">Select All</label>
                  </div>
                  
                </div>
                  
                  <form action="campusSelectedByEnterprise" method="POST" enctype="multipart/form-data">
                  <div class="row" id="addTable">
                    <table class="stripe hover multiple-select-row data-table-export">
                      <thead>
                        <tr>
                          <th class="datatable-nosort noExport">Select</th>
                          <th>ID</th>
                          <th>Campus Name</th>
                          <th>Type</th>
                          <th>Address</th>
                          <!-- <th>Email</th>
                          <th>Contact</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (count($campus) < 1) { ?>
                          <tr>
                            <td class="text-danger text-center" colspan="4"> No Campus Found </td>
                          </tr>
                          <!-- only if record exists -->
                          <?php } else { $i=1; 
                          foreach ($campus as $campusRow) {
                            if ($campusRow->ECampus_Selected == 1) {
                              $checked = 'checked';
                            }
                            else {
                              $checked = ' ';
                            }
                          ?>
                          <tr>
                            <!-- check box -->
                            <td>
                              <!-- bootstrap checkbox -->
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="<?php echo $campusRow->UC_ID; ?>" id="<?php echo $campusRow->UC_ID; ?>" name="selectCampus[]" <?php echo $checked; ?>>
                                <label class="custom-control-label" for="<?php echo $campusRow->UC_ID; ?>"></label>
                              </div>
                            </td>
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
                    <br />
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="submit" value="submit" id="submit">SUBMIT</button>&nbsp;&nbsp;
                      <a href="<?php echo base_url('Dashboard/');?>" class="btn btn-outline-danger">CANCEL</a>
                    </div>
                  </div>
                  <!-- end of select Campus -->
                  </form>

                </div>
              </div>
            </div>
            <div class="clearfix"></div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#select_all').click(function(i,e){
      if($(this).is(':checked'))
      {
        $('input[type=checkbox]').each(function(i,e){
          $(this).prop('checked',true);
        });
      }
      else
      {
        $('input[type=checkbox]').each(function(i,e){
          $(this).prop('checked',false);
        });
      }
    });
  });
</script>