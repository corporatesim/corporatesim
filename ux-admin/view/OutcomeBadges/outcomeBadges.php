<script type="text/javascript">
  var loc_url_del  = "ux-admin/outcomeBadges/delete/";
</script>

<style type="text/css">
  .da-card {
    position: relative; }

    .da-card .da-card-content {
      padding: 20px;
      background: #ffffff; }

      .da-card .da-card-photo {
        position: relative;
        overflow: hidden; }

        .da-card .da-card-photo img {
          position: relative;
          display: block;
          width: 100%;
          -webkit-transition: all 0.4s linear;
          transition: all 0.4s linear; }

          .da-card .da-overlay {
            position: absolute;
            border: 5px;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            opacity: 0;
            overflow: hidden;
            background: rgba(19, 30, 34, 0.7);
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out; 
          }

          .da-card .da-overlay.da-slide-left {
            left: -100%;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out; 
          }

          .da-card .da-card-photo:hover .da-overlay.da-slide-left {
            left: 0; 
          }

          .da-card .da-overlay.da-slide-right {
            right: -100%;
            left: inherit;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out; 
          }

          .da-card .da-card-photo:hover .da-overlay.da-slide-right {
            right: 0; 
          }

          .da-card .da-overlay.da-slide-top {
            top: -100%;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out; 
          }

          .da-card .da-card-photo:hover .da-overlay.da-slide-top {
            top: 0; }

            .da-card .da-overlay.da-slide-bottom {
              top: 100%;
              -webkit-transition: all 0.5s ease-in-out;
              transition: all 0.5s ease-in-out; 
            }

            .da-card .da-card-photo:hover .da-overlay.da-slide-bottom {
              top: 0; 
            }

            .da-card .da-card-photo:hover img {
              -webkit-transform: scale(1.2) translateZ(0);
              transform: scale(1.2) translateZ(0); 
            }

            .da-card .da-card-photo:hover .da-overlay {
              opacity: 1;
              filter: alpha(opacity=100);
              -webkit-transform: translateZ(0);
              transform: translateZ(0); 
            }

            .da-card .da-card-photo:hover .da-social {
              opacity: 1; 
            }

            .da-card .da-social {
              display: -webkit-box;
              display: -ms-flexbox;
              display: flex;
              -webkit-box-align: center;
              -ms-flex-align: center;
              align-items: center;
              width: 100%;
              height: 100%;
              padding: 20px;
              -webkit-box-pack: center;
              -ms-flex-pack: center;
              justify-content: center;
              color: #ffffff;
              opacity: 0;
              -webkit-transition: all 0.4s ease-in-out;
              transition: all 0.4s ease-in-out; 
            }

            .da-card .da-social h5 {
              position: absolute;
              top: 0;
              white-space: nowrap;
              overflow: hidden;
              width: 100%;
              text-overflow: ellipsis;
            }

            .da-card .da-social ul li {
              float: left; 
            }

            .da-card .da-social ul li a {
              display: block;
              width: 45px;
              height: 45px;
              border: 1px solid #ffffff;
              line-height: 43px;
              font-size: 20px;
              text-align: center;
              color: #ffffff;
              -webkit-box-shadow: 0px 0px 0px 1px #ffffff;
              box-shadow: 0px 0px 0px 1px #ffffff;
              -webkit-transition: all 0.3s ease-in-out;
              transition: all 0.3s ease-in-out; 
            }

            .da-card .da-social ul li a:hover {
             background: #ffffff;
             color: #0099ff; 
           }

           div.desc
           {
            padding: 15px;
            text-align: center;
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
          <li class="active"><a href="javascript:void(0);">Manage Outcome Badges</a></li>
          <!-- <li class="active"><?php echo $header; ?></li> -->
        </ul>
      </div>
    </div> 
    <!-- DISPLAY ERROR MESSAGE -->
    <?php  if(!empty($_SESSION['tr_msg'])) { ?>
     <div class="alert-success alert"><?php echo $_SESSION['tr_msg']; ?></div>
   <?php } ?>
   <?php  if(!empty($er_msg)) { ?>
    <div class="alert-danger alert"><?php echo $er_msg; ?></div>
  <?php } ?> 
  <!-- DISPLAY ERROR MESSAGE END -->
  <style>
    span.alert-danger {
      background-color: #ffffff;
      font-size       : 18px;
    }
  </style>   
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right legend">
        <ul>
          <li><b>Legend : </b></li>
          <li> <span class="glyphicon glyphicon-pencil">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit   </a></li>
          <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="panel panel-default" id="loader">
      <div class="panel-heading">
        <div class="pull-right">
          <?php if($functionsObj->checkModuleAuth('outcomeBadges','add')){ ?>
            <a href="<?php echo site_root."ux-admin/outcomeBadges/add/add";?>" class="btn btn-primary btn-lg btn-block">Add Outcome</a>
          <?php } ?>
        </div>
        <div class="jumbotron">
          <div class="row clearfix">
            <?php 
            $i=1; while($badgesResult = $badges->fetch_object()){ ?>
              <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <div class="da-card box-shadow">
                  <div class="da-card-photo" style="">
                    <a href="<?php echo site_root."ux-admin/upload/Badges/"?><?php echo $badgesResult->Badges_ImageName;?>" data-fancybox="images" data-width="2048" data-height="1365" data-caption="<?php echo $badgesResult->Badges_ImageName; ?>" >
                      <img src="<?php echo site_root."ux-admin/upload/Badges/"?><?php echo $badgesResult->Badges_ImageName;?>" 
                      alt="" width=50 height=150/>
                    </a>
                    <div class="da-overlay">
                     <div class="da-social">
                      <?php if($functionsObj->checkModuleAuth('outcomeBadges','edit')){ ?>
                        <ul class="clearfix" style="list-style-type: none; align:center;">
                          <li>
                            <a href="<?php echo site_root."ux-admin/outcomeBadges/edit/".$badgesResult->Badges_ID;?>" title="Edit"> <i class="fa fa-pencil"></i>
                            </a>
                          </li>
                          <!-- <li><a href="javascript:void(0);" class="dl_btn" id=<?php echo $badgesResult->Badges_ID;?> title="Delete"><span class="fa fa-trash"></span></a></a></li> -->
                        </ul>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="da-card-content">
                    <div class="desc">
                      <h4 class ="weight-500 mb-10"><?php echo $badgesResult->Badges_ShortName;?></h4>
                      <p class  ="mb-0"><?php echo $badgesResult->Badges_Description;?></p>
                      <?php
                      $var = explode(',',$badgesResult->Badges_Value);
                             //var_dump($var);
                      for ($i=0; $i <count($var) ; $i++) { 
                        if(count($var)>2)
                        {
                         if($i==1)
                           echo "<label for='Minimum Value'>MinVal = </label> $var[$i]<br>";
                         if($i==2)
                           echo "<label for='Maximum Value'>MaxVal = </label> $var[$i]<br>"; 
                       }
                       else 
                       {
                        if($i==1)
                         echo "<label for='Value'>Value = </label> $var[$i]<br>";
                     }
                   }
                   ?>
                 </div>
               </div>
             </div>
           </div>
         </div>
         <?php $i++; } ?>
       </div><br><br><br>
     </div>
     <div class="clearfix"></div>
   </div>
 </div>
</div>

