             <script type="text/javascript">
              <!--
                var loc_url_del  = "ux-admin/outcomeBadges/delete/";
                //var loc_url_stat = "ux-admin/outcomeBadges/linkstat/";
              //-->
            </script>
            <!-- <script>
             $('[data-fancybox="images"]').fancybox({
               afterLoad : function(instance, current) {
                 var pixelRatio = window.devicePixelRatio || 1;

                 if ( pixelRatio > 1.5 ) {
                   current.width  = current.width  / pixelRatio;
                   current.height = current.height / pixelRatio;
                 }
               }
             });
           </script> -->
           <style>
           div.gallery {
            margin: 5px;
            border: 2px solid #ccc;
            padding-left: 20px;
            background-color: skyblue;
            float:Left;
            width: 200px;
          }

          div.gallery:hover {
            border: 2px solid #777;
          }

          div.gallery img {
            width: 80%;
            height: auto;
          }

          div.desc {
            padding: 15px;
            text-align: center;
          }
          @media screen and ( min-width: '361px' ){
            .resp_pull_right{
              float: right;
            }
          }

          @media screen and ( max-width: '360px' ){
            .resp_pull_right{
              float     : none;
              text-align: center;
              width     : 100%;
              padding   : 0 15px;
            }
          }

          #update-file-selector {
            display:none;
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
              <a href="<?php echo site_root."ux-admin/outcomeBadges/add/add";?>" class="btn btn-primary btn-lg btn-block">Add Outcome</a>
            </div>
            <div class="jumbotron">
              <div class="row">
                <?php 
                $i=1; while($badgesResult = $badges->fetch_object()){ ?>
                  <div class="col-md-12 col-md-3">
                    <div class="gallery">
                      <div class="card img-fluid" style="">

                        <a href="<?php echo site_root."ux-admin/upload/Badges/"?><?php echo $badgesResult->Badges_ImageName;?>" data-fancybox="images" data-width="2048" data-height="1365" data-caption="<?php echo $badgesResult->Badges_ImageName; ?>" >
                          <img src="<?php echo site_root."ux-admin/upload/Badges/"?><?php echo $badgesResult->Badges_ImageName;?>" alt=""/>
                        </a>
                        <div class="card-img-overlay">
                          <div class="desc">
                            <h4 class ="card-title"><?php echo $badgesResult->Badges_ShortName;?></h4>
                            <p class  ="card-text"><?php echo $badgesResult->Badges_Description;?></p>
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
                             <a href="<?php echo site_root."ux-admin/outcomeBadges/edit/".$badgesResult->Badges_ID;?>" class="btn btn-primary"title="Edit"><span class="fa fa-pencil"></span></a></a>
                             <!-- <a href="<?php// echo site_root."ux-admin/outcomeBadges/delete/".$badgesResult->Badges_ID;?>" class="btn btn-primary" id="delete" title="Delete"><span class="fa fa-trash"></span></a></a> -->
                              <a href="javascript:void(0);" class="btn btn-primary dl_btn" id=<?php echo $badgesResult->Badges_ID;?> title="Delete"><span class="fa fa-trash"></span></a></a>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php $i++; } ?>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
   