<?php 
  // echo "<pre>"; print_r(json_decode($scendetails->Scen_Json, true)); exit();
  $Scen_Json                = json_decode($scendetails->Scen_Json, true);
  $aliasStoryline           = $Scen_Json['aliasStoryline'];
  $aliasStorylineVisibility = $Scen_Json['aliasStorylineVisibility'];
  $aliasVideo               = $Scen_Json['aliasVideo'];
  $aliasVideoVisibility     = $Scen_Json['aliasVideoVisibility'];
  $aliasImage               = $Scen_Json['aliasImage'];
  $aliasImageVisibility     = $Scen_Json['aliasImageVisibility'];
  $aliasDocument            = $Scen_Json['aliasDocument'];
  $aliasDocumentVisibility  = $Scen_Json['aliasDocumentVisibility'];

  $aliasStorylineColorCode  = $Scen_Json['aliasStorylineColorCode'];
  $aliasVideoColorCode      = $Scen_Json['aliasVideoColorCode'];
  $aliasImageColorCode      = $Scen_Json['aliasImageColorCode'];
  $aliasDocumentColorCode   = $Scen_Json['aliasDocumentColorCode'];
?>
<style type="text/css">
  span.alert-danger {
    background-color: #ffffff;
    font-size: 18px;
  }
</style>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $header; ?></h1>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="javascript:void(0);">Master Management</a></li>
      <li class="active"><a	href="<?php echo site_root."ux-admin/ManageGame"; ?>"> Manage Scenario</a></li>
      <li class="active"><?php echo $header; ?></li>
    </ul>
  </div>
</div>

<?php if(isset($_GET['edit'])){ ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
        <a href="<?php echo site_root."ux-admin/ManageScenario"; ?>"
          title="Scenario List"> Back</a> | 
          <a href="<?php echo site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($scendetails->Scen_ID); ?>"
            title="General"><span class="fa fa-book"></span> Content</a> | 				
            <a href="<?php echo site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($scendetails->Scen_ID); ?>"
              title="Document"><span class="fa fa-image"></span> Document</a> | 
              <a href="<?php echo site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($scendetails->Scen_ID); ?>"
                title="Image"><span class="fa fa-image"></span> Image</a> |
                <a href="<?php echo site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($scendetails->Scen_ID); ?>"
                  title="Video"><span class="fa fa-video-camera"></span> Video</a>	
                </div>
              </div>
            </div>
          <?php } ?>		
          <!-- DISPLAY ERROR MESSAGE -->
          <?php if(isset($msg)){ ?>
            <div class="form-group <?php echo $type[1]; ?>">
              <div align="center" id="<?php echo $type[0]; ?>">
                <label class="control-label" for="<?php echo $type[0]; ?>">
                  <?php echo $msg; ?>
                </label>
              </div>
            </div>
          <?php } ?>
          <!-- DISPLAY ERROR MESSAGE END -->
          <div class="col-sm-10">
            <form method="POST" action="" id="scen_frm" name="scen_frm" enctype="multipart/form-data">
              <div class="row name" id="name">
                <div class="col-sm-6">
                  <input type="hidden" name="id" value="<?php if(isset($_GET['edit'])){ echo $scendetails->Scen_ID; } ?>">
                  <div class="form-group">
                    <label for="name"><span class="alert-danger">*</span>Name</label>
                    <input type="text" name="name" value="<?php if(!empty($scendetails->Scen_Name)) echo $scendetails->Scen_Name; ?>"
                    class="form-control" placeholder="Scenario Name" required>
                  </div>
                </div>
              </div>
              <div class="row name col-sm-12" id="Scen_InputButton">
                <!-- <input type="hidden" name="id" value="<?php // if(isset($_GET['edit'])){ echo $scendetails->Scen_ID; } ?>"> -->
                <label for="Scen_InputButton"><span class="alert-danger">*</span>Input (Proceed) Button Status</label><br>

                <div class="col-md-2">
                  <label for="radioHide" class="containerRadio">
                    <input type="radio" id="radioHide" name="Scen_InputButton" value="0" placeholder="Scenario Name" required <?php echo ($scendetails->Scen_InputButton == 0)?'checked':'';?>> Hide
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>

                <div class="col-md-2">
                  <label for="radioShow" class="containerRadio">
                    <input type="radio" id="radioShow" name="Scen_InputButton" value="1" placeholder="Scenario Name" required <?php echo ($scendetails->Scen_InputButton == 1)?'checked':'';?>> Show
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>
              </div>
              <!-- adding this checkbox for component branching -->
              <div class="row name" id="Scen_Branching">
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="form-check">
                      <label class="form-check-label containerCheckbox" for="Scen_Branchings">
                        <input type="checkbox" class="form-check-input" id="Scen_Branchings" name="Scen_Branching" value="1" <?php echo ($scendetails->Scen_Branching == 1)?'checked':'25';?>> Component Branching
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row name">
                <div class="col-sm-12">
                  <h3><strong>To view color codes <a href="https://material.io/resources/color/" target="_blank">click here!</a></strong></h3>
                </div>
              </div>
              <br />

              <!-- storyline alias -->
              <div class="row" id="renameStoryline">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="aliasStoryline">Alias Storyline</label>
                    <input type="text" name="aliasStoryline" value="<?php echo ($aliasStoryline) ? $aliasStoryline : 'Storyline'; ?>" class="form-control" placeholder="Put Alias Storyline">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="aliasStorylineColorCode">Storyline Color Code</label>
                    <input type="text" name="aliasStorylineColorCode" value="<?php echo ($aliasStorylineColorCode) ? $aliasStorylineColorCode : 'lightcyan'; ?>" class="form-control" placeholder="Storyline Color Code">
                  </div>
                </div>
                <br>
                
                <div class="col-md-1">
                  <label for="aliasStorylineVisibility" class="containerRadio">
                    <input type="radio" id="aliasStorylineVisibility" name="aliasStorylineVisibility" value="0" <?php echo ($aliasStorylineVisibility == 0) ? 'checked' : ''; ?>> Show
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>

                <div class="col-md-1">
                  <label for="aliasStorylineHide" class="containerRadio">
                    <input type="radio" id="aliasStorylineHide" name="aliasStorylineVisibility" value="1" <?php echo ($aliasStorylineVisibility == 1) ? 'checked' : ''; ?>> Hide
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>
              </div>

              <!-- Video alias -->
              <div class="row" id="renameVideo">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="aliasVideo">Alias Video</label>
                    <input type="text" name="aliasVideo" value="<?php echo ($aliasVideo) ? $aliasVideo : 'Video'; ?>" class="form-control" placeholder="Put Alias Video">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="aliasVideoColorCode">Video Color Code</label>
                    <input type="text" name="aliasVideoColorCode" value="<?php echo ($aliasVideoColorCode) ? $aliasVideoColorCode : 'lavender'; ?>" class="form-control" placeholder="Video Color Code">
                  </div>
                </div>
                <br>
                
                <div class="col-md-1">
                  <label foaliasVideoVisibility="aliasRadioShow" class="containerRadio">
                    <input type="radio" id="aliasVideoVisibility" name="aliasVideoVisibility" value="0" <?php echo ($aliasVideoVisibility == 0) ? 'checked' : ''; ?>> Show
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>

                <div class="col-md-1">
                  <label for="aliasVideoHide" class="containerRadio">
                    <input type="radio" id="aliasVideoHide" name="aliasVideoVisibility" value="1" <?php echo ($aliasVideoVisibility == 1) ? 'checked' : ''; ?>> Hide
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>
              </div>

              <!-- Image alias -->
              <div class="row" id="renameImage">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="aliasImage">Alias Image</label>
                    <input type="text" name="aliasImage" value="<?php echo ($aliasImage) ? $aliasImage : 'Image'; ?>" class="form-control" placeholder="Put Alias Image">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="aliasImageColorCode">Image Color Code</label>
                    <input type="text" name="aliasImageColorCode" value="<?php echo ($aliasImageColorCode) ? $aliasImageColorCode : 'lavenderblush'; ?>" class="form-control" placeholder="Image Color Code">
                  </div>
                </div>
                <br>
                
                <div class="col-md-1">
                  <label foaliasImageVisibility="aliasRadioShow" class="containerRadio">
                    <input type="radio" id="aliasImageVisibility" name="aliasImageVisibility" value="0" <?php echo ($aliasImageVisibility == 0) ? 'checked' : ''; ?>> Show
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>

                <div class="col-md-1">
                  <label for="aliasImageHide" class="containerRadio">
                    <input type="radio" id="aliasImageHide" name="aliasImageVisibility" value="1" <?php echo ($aliasImageVisibility == 1) ? 'checked' : ''; ?>> Hide
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>
              </div>

              <!-- Document alias -->
              <div class="row" id="renameDocument">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="aliasDocument">Alias Document</label>
                    <input type="text" name="aliasDocument" value="<?php echo ($aliasDocument) ? $aliasDocument : 'Documents'; ?>" class="form-control" placeholder="Put Alias Document">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="aliasDocumentColorCode">Document Color Code</label>
                    <input type="text" name="aliasDocumentColorCode" value="<?php echo ($aliasDocumentColorCode) ? $aliasDocumentColorCode : 'lemonchiffon'; ?>" class="form-control" placeholder="Document Color Code">
                  </div>
                </div>
                <br>
                
                <div class="col-md-1">
                  <label foaliasDocumentVisibility="aliasRadioShow" class="containerRadio">
                    <input type="radio" id="aliasDocumentVisibility" name="aliasDocumentVisibility" value="0" <?php echo ($aliasDocumentVisibility == 0) ? 'checked' : ''; ?>> Show
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>

                <div class="col-md-1">
                  <label for="aliasDocumentHide" class="containerRadio">
                    <input type="radio" id="aliasDocumentHide" name="aliasDocumentVisibility" value="1" <?php echo ($aliasDocumentVisibility == 1) ? 'checked' : ''; ?>> Hide
                    <span class="checkmarkRadio"></span>
                  </label>
                </div>
              </div>

              <div class="row name" id="comments">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name"><span class="alert-danger">*</span>Comments</label>
                    <textarea id="comments" name="comments" class="form-control" placeholder="Comments" required=""><?php if(!empty($scendetails->Scen_Comments)) echo $scendetails->Scen_Comments; ?></textarea>
                  </div>
                </div>
              </div>

              <div class="row name" id="Header">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name"><span class="alert-danger">*</span>Header</label>
                    <textarea id="Scen_Header" name="Scen_Header" class="form-control" placeholder="Comments" required=""><?php if(!empty($scendetails->Scen_Header)) echo $scendetails->Scen_Header; ?></textarea>
                  </div>
                </div>
              </div>

              <div class="row name" id="Header">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">Background Image</label>
                    <input name="Scen_Image" type="file" id="Scen_Image" class="form-control" value="<?php if(isset($_GET['tab'])){ echo $resultdoc->ScenImg_Name; } ?>">
                  </div>
                </div>
                <?php if(!empty($scendetails->Scen_Image)){ ?>
                  <div class="col-sm-6" data-toggle="tooltip" title="Uncheck to remove the existing image">
                    <label class="form-check-label containerCheckbox" for="Scen_Back_Image">
                      <input type="checkbox" class="form-check-input" id="Scen_Back_Image" name="Scen_Back_Image" value="<?php echo $scendetails->Scen_Image;?>" checked>
                      <span class="checkmark"></span>
                    </label>
                    <img src="<?php echo site_root.'/images/'.$scendetails->Scen_Image; ?>" alt="Scenario Background Image" width=150>
                  </div>
                <?php } ?>
              </div>
              <div class="clearfix"><br></div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group text-center">
                    <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
                      <button type="button" id="scen_btn_update" class="btn btn-primary"> Update </button>
                      <button type="submit" name="submit" id="scen_update" class="btn btn-primary hidden" value="Update"> Update </button>
                      <button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel</button>
                    <?php }else{?>
                      <button type="button" id="scen_btn" class="btn btn-primary" value="Submit"> Add </button>
                      <button type="submit" name="submit" id="scen_sbmit" class="btn btn-primary hidden" value="Submit"> Add </button>
                      <button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel</button>
                    <?php }?>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="clearfix"></div>
          <script>
            $('#scen_btn').click( function(){
  	//	if($("#siteuser_frm").valid()){		
  		$( "#scen_sbmit" ).trigger( "click" );
  	//	}
  });

            $('#scen_btn_update').click( function(){
  	//	if($("#siteuser_frm").valid()){
  		$( "#scen_update" ).trigger( "click" );
  	//	}
  });

  // -->
</script>