<style>

  input[type=text]{
    width        : 90px!important;
    color        : #151515;
    text-align   : center !important;
    border-radius: 18px !important;
  }
  .affix-nav{
    top     : 73px;
    width   : 100%;
    z-index : 100 !important;
    position: fixed;
    border-color: #00000000;
  }
  .container img {
    float        : left;
    max-width    : 60px;
    width        : 100%;
    margin-right : 20px;
    border-radius: 50%;
  }
</style>
<section style="margin-top: 35px!important;">
  <?php $this->load->view('components/trErAlert'); ?>
  
  <?php
  if(count($findLinkageSub)<1)
  {
    echo '<center><br><img src="'.base_url().'../images/notFound.gif" alt="No output found"><br><br><marquee class="alert-danger" behavior="" direction="">No output exist/found for the current scenario</marquee></center>';
    die();
  }
  ?>
  <div class="container" <?php echo ($findLinkageSub[0]->Scen_Image)?"style='width:auto;min-height:100vh; background-image:url(".base_url('../images/'.$findLinkageSub[0]->Scen_Image).")'":"style:width:auto; min-height:100vh;" ?>>
    <!-- <div class="row clearfix">show timing here</div> -->
    <ul class="nav nav-tabs affix-nav" id="myTab" role="tablist">
      <?php
      $active   = "active"; 
      $showArea = 'true';
      foreach ($findLinkageSub as $findLinkageSubRow) { ?>
        <li class="nav-item">
          <!-- as bot-enabled game can have only one area, and it will not be shown, also set the area style -->
          <?php
          $areaTabId = $findLinkageSubRow->SubLink_AreaName;
          $areaStyle = ($findLinkageSubRow->Area_BackgroundColor || $findLinkageSubRow->Area_TextColor)?"style='background-color:".$findLinkageSubRow->Area_BackgroundColor."; color:".$findLinkageSubRow->Area_TextColor."'":'';
          ?>
          <a class="nav-link <?php echo $active; ?>" id="<?php echo $areaTabId;?>tab" data-toggle="tab" href="#<?php echo $areaTabId;?>" role="tab" aria-controls="<?php echo $areaTabId;?>" aria-selected="<?php echo $showArea;?>" <?php echo $areaStyle;?>>
            <?php echo $findLinkageSubRow->SubLink_AreaName; ?>
          </a>
        </li>
        <?php $active = ""; $showArea = 'false'; } ?>
      <!-- <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
      </li> -->
    </ul>
    <div class="row"><br><br></div>
    <!-- if this scenario has background image then show that image -->
    <form action="" method="post">
      <input type="hidden" name="gameid" value="<?php echo $gameId;?>" id="outputGameid">
      <input type="hidden" name="linkid" value="<?php echo ($findLinkageSub[0]->SubLink_LinkID);?>" id="outputLinkid">

      <div class="tab-content row col-md-12 m-1" id="myTabContent">
        <?php
        $active = "show active";
        foreach ($findLinkageSub as $findLinkageSubRow) { 
          $areaTabId = $findLinkageSubRow->SubLink_AreaName;
          ?>
          <!-- creating div for area tabs -->
          <div class="row col-md-12 tab-pane fade <?php echo $active; ?>" id="<?php echo $areaTabId;?>" role="tabpanel" aria-labelledby="<?php echo $areaTabId;?>tab" style="width:auto; margin-top: 3%;">
            <!-- get all components and subcomponents as per the linkage and area and show here -->
            <span class="getComponent d-none" data-href="<?php echo base_url('Ajax/getAllOutputComponentsOfArea/'.$findLinkageSubRow->SubLink_LinkID.'/'.$findLinkageSubRow->SubLink_AreaID);?>" data-id="<?php echo $areaTabId;?>"></span>

          </div>

          <?php $active = ""; } ?>
        </div>

      </form>
    </div>
  </section>

  <script>
    $(document).ready(function(){
      csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
      csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
      $('#submitLink').removeClass('d-none');
      // getComponent for different areas
      $('.getComponent').each(function(i,e){
        var divId   = $(this).data('id');
        var ajaxUrl = $(this).data('href');
        $(e).remove();
        // after getting the data remove all the data-holder span, trigger ajax and get components Data and then append html to parent Div
        $.ajax({
          url     : ajaxUrl,
          type    : 'POST',
          // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
          // data    : $("form").serialize(),
          data    : {[csrfName]: csrfHash},
          success: function(result){
            try
            {
              var result = JSON.parse( result );
              // updating csrf token value
              csrfHash = result.csrfHash;
              // console.log(result);
              if(result.status == 200)
              {
                // getting the html for components and append it to areaTab related Div
                $('#'+divId).html(result.returnHtml);
                submitOutputPage();
              }
              else
              {
                swal.fire('Connection Error. Please try later.');
                console.log(result);
              }
            }
            catch ( e )
            {
              // swal.fire('Something went wrong. Please try later.');
              Swal.fire({
                title: 'Something went wrong. Please try later.',
                showClass: {
                  popup: 'animated fadeInDown faster'
                },
                hideClass: {
                  popup: 'animated fadeOutUp faster'
                }
              })
              console.log(e + "\n" + result);
            }
          }
        });
      });
      submitOutputPage();
    });

    function submitOutputPage()
    {
      // submit the page
      $('#submitPage, #submitPageViaCkEditor').on('click',function(){
        var gameid   = $('#outputGameid').val();
        var linkid   = $('#outputLinkid').val();
        var formData = $("form").serialize();
        $.ajax({
          url : "<?php echo base_url('Ajax/submitOutput/'); ?>"+gameid+'/'+linkid,
          type: 'POST',
          // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
          // data    : $("form").serialize(),
          data: {[csrfName]: csrfHash},
          success: function(result){
            try
            {
              var result = JSON.parse( result );
              // updating csrf token value
              csrfHash = result.csrfHash;
              // console.log(result);
              if(result.status == 200)
              {
                // redirect to rsult or next scenario accordigly
                window.location.href = result.redirect;
                // console.log(result);
              }
              else
              {
                var alertMessage = (result.message)?result.message:'Connection Error. Please try later.';
                swal.fire(alertMessage);
                console.log(result);
              }
            }
            catch ( e )
            {
              // swal.fire('Something went wrong. Please try later.');
              Swal.fire({
                title: 'Something went wrong. Please try later.',
                showClass: {
                  popup: 'animated fadeInDown faster'
                },
                hideClass: {
                  popup: 'animated fadeOutUp faster'
                }
              })
              console.log(e + "\n" + result);
            }
          }
        });
      });
    }

  </script>
