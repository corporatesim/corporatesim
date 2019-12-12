<style>
	.swal2-container.swal2-backdrop-show{
		background: #00000066;
	}
</style>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>
		<a style="padding: 2px 15px;" class="navbar-brand" href="<?php echo site_root."ux-admin/index";?>"> 
			<img height="100%" src="<?php echo site_root."images/logo.png";?>" />
		</a>
		<p class="pull-left wel_note"><?php echo $siteDetails[2]['value']; ?></p>
	</div>
	<!-- Profile & SeoSetting Drop down Navigation -->
	<ul class="nav navbar-top-links navbar-right text-right">
		<!-- <li><a href="<?php echo site_root."login.php"; ?>" target="_blank">View Website</a></li> -->

		<!-- dropdown div for notification starts here -->
		<!-- below li will open Counter - Alerts -->
		<!-- <li class="nav-item dropdown no-arrow mx-1">
			<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-bell fa-fw"></i>
				<span class="badge badge-danger badge-counter">3+</span>
			</a> -->

			<!-- Dropdown - Alerts -->
			<!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
				<h6 class="dropdown-header">
					Alerts Center
				</h6>
				<a class="dropdown-item d-flex align-items-center" href="#">
					<div class="mr-3">
						<div class="icon-circle bg-primary">
							<i class="fas fa-file-alt text-white"></i>
						</div>
					</div>
					<div>
						<div class="small text-gray-500">December 12, 2019</div>
						<span class="font-weight-bold">A new monthly report is ready to download!</span>
					</div>
				</a>
				<a class="dropdown-item d-flex align-items-center" href="#">
					<div class="mr-3">
						<div class="icon-circle bg-success">
							<i class="fas fa-donate text-white"></i>
						</div>
					</div>
					<div>
						<div class="small text-gray-500">December 7, 2019</div>
						$290.29 has been deposited into your account!
					</div>
				</a>
				<a class="dropdown-item d-flex align-items-center" href="#">
					<div class="mr-3">
						<div class="icon-circle bg-warning">
							<i class="fas fa-exclamation-triangle text-white"></i>
						</div>
					</div>
					<div>
						<div class="small text-gray-500">December 2, 2019</div>
						Spending Alert: We've noticed unusually high spending for your account.
					</div>
				</a>
				<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
			</div>
		</li> -->
		<!-- dropdown div for notification starts here -->

		<li class="nav-item dropdown no-arrow mx-1"><a href="javascript:void(0);">Hi, <?php echo $_SESSION['admin_fname'].' '.$_SESSION['admin_lname'];?></a></li>
		<?php
		$notificationSql = "SELECT * FROM GAME_NOTIFICATION WHERE Notification_Delete=0 AND Notification_Seen=0 AND Notification_To=".$_SESSION['ux-admin-id'];
		$notificationCount = $functionsObj->RunQueryFetchCount($notificationSql);
		?>
		<li class="nav-item dropdown no-arrow mx-1" title="Show Notification">
			<a href="<?php echo site_root.'ux-admin/notification';?>" id="showNotification" class="nav-link dropdown-toggle">
				<i class="fa fa-bell"></i>
				<span class="badge badge-danger badge-counter"><?php echo $notificationCount;?></span>
			</a>
		</li>

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user fa-fw"></i>
				<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="<?php echo site_root."ux-admin/MyProfile";?>"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
				<?php if($_SESSION['ux-admin-id'] == 1){ ?>
					<li><a href="<?php echo site_root."ux-admin/SiteSettings"?>">
						<i class="fa fa-gear fa-fw"></i> Site Settings</a>
		<!--<li><a href="<?php //echo site_root."ux-admin/SeoSettings"?>">
		<i class="fa fa-gear fa-fw"></i> SEO Settings</a></li>
		<li class="divider"></li> -->
	<?php } ?>
	<li><a href="<?php echo site_root."ux-admin/Logout"?>">
		<i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
	</ul>
</li>
</ul>

<!-- Left Side Main Navigation -->
<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li><a href="<?php echo site_root."ux-admin/Dashboard";?>">
				<i class="fa fa-dashboard fa-fw"></i>  Dashboard</a></li>
				<?php if($_SESSION['admin_usertype']=='superadmin') {?>
					<li>
						<a href="<?php echo site_root."ux-admin/adminlist";?>">
							<i class="fa fa-user fa-fw"></i> Manage Admin User</a>
						</li>
					<?php }?>
					<!-- Enteprise/SubEnterprise Management -->
					<li id="manageCMS" class="hidden"><a href="#"><i class="fa fa-institution"></i> Enterprise/SubEnterprise
						<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<?php if($functionsObj->checkModuleAuth('ManageEnterprise','enable')){ ?>
								<li><a href="<?php echo site_root."ux-admin/ManageEnterprise";?>">
								Manage Enterprise</a></li>
							<?php } if($functionsObj->checkModuleAuth('ManageSubEnterprise','enable')){ ?>
								<li><a href="<?php echo site_root."ux-admin/ManageSubEnterprise";?>">
								Manage SubEnterprise</a></li>
							<?php } if($functionsObj->checkModuleAuth('EntSubEnterpriseUsers','enable')){ ?>
								<li><a href="<?php echo site_root."ux-admin/EntSubEnterpriseUsers";?>">
								Enterprise/SubEntprise Users</a></li>
							<?php } ?>					
						</ul>
					</li>
					<!-- User Management -->
					<li id="manageUser"><a href="#"><i class="fa fa-users fa-fw"></i> User Management
						<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<?php if($functionsObj->checkModuleAuth('SiteUsers','enable')){ ?>
								<li><a href="<?php echo site_root."ux-admin/siteusers";?>">
								Site Users</a></li>
							<?php } if($functionsObj->checkModuleAuth('UserReport','enable')){ ?>
								<li><a href="<?php echo site_root."ux-admin/UserReport";?>">
								User Report</a></li>
							<?php } if($functionsObj->checkModuleAuth('ReplayPermission','enable')){ ?>
								<li><a href="<?php echo site_root."ux-admin/ReplayPermission";?>">
								Replay Permission</a></li>
							<?php } ?>
						</ul>
					</li>

					<!-- Master Management -->
					<li id="manageCMS"><a href="#"><i class="fa fa-wrench fa-fw"></i> Master Management<span class="fa arrow">
					</span></a>
					<ul class="nav nav-second-level">
						<?php if($functionsObj->checkModuleAuth('area','enable')){ ?>
							<li><a
								href="<?php echo site_root."ux-admin/ManageArea";?>">
							Area</a></li>
						<?php } if($functionsObj->checkModuleAuth('component','enable')){ ?>
							<li><a
								href="<?php echo site_root."ux-admin/ManageComponent";?>">
							Component</a></li>
						<?php } if($functionsObj->checkModuleAuth('sub component','enable')){ ?>
							<li><a 
								href="<?php echo site_root."ux-admin/ManageSubComponent";?>">
							Sub Component</a></li>
						<?php } if($functionsObj->checkModuleAuth('game','enable')){ ?>
							<li><a 
								href="<?php echo site_root."ux-admin/ManageGame";?>">
							Game</a></li>
						<?php } if($functionsObj->checkModuleAuth('scenario','enable')){ ?>
							<li><a 
								href="<?php echo site_root."ux-admin/ManageScenario";?>">
							Scenario</a></li>
						<?php } ?>					
					</ul>
				</li>

				<!-- Link Managemet -->
				<li id="manageCMS"><a href="#"><i class="fa fa-link fa-fw"></i> Link Management<span class="fa arrow">
				</span></a>
				<ul class="nav nav-second-level">
					<?php if($functionsObj->checkModuleAuth('formulas','enable')){ ?>
						<li><a href="<?php echo site_root."ux-admin/Formulas";?>">
						Formulas</a>
					</li>
				<?php } if($functionsObj->checkModuleAuth('linkage','enable')){ ?>
					<li><a href="<?php echo site_root."ux-admin/linkage";?>">
					Linkage</a></li>
				<?php } if($functionsObj->checkModuleAuth('chartComp','enable')){ ?>
					<li><a href="<?php echo site_root."ux-admin/chartComp";?>">
					Chart Component</a></li>
				<?php  } if($functionsObj->checkModuleAuth('chart','enable')){ ?>
					<li><a href="<?php echo site_root."ux-admin/chart";?>">
					Chart Subcomponent</a></li>
				<?php } ?>					
			</ul>
		</li>

		<!--  Outcome management -->
		<li id="manageCMS"><a href="#"><i class="fa fa-tasks fa-fw"></i> Outcome Management <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<?php if($functionsObj->checkModuleAuth('ScenarioBranching','enable')){ ?>
					<li><a 
						href="<?php echo site_root."ux-admin/ScenarioBranching";?>">
					Scenario Branching</a></li>
				<?php } if($functionsObj->checkModuleAuth('outcomeBadges','enable')){ ?>
					<li><a 
						href="<?php echo site_root."ux-admin/outcomeBadges";?>">
					Outcome Badges</a></li>					
				<?php } if($functionsObj->checkModuleAuth('personalizeOutcome','enable')){ ?>
					<li><a 
						href="<?php echo site_root."ux-admin/personalizeOutcome";?>">
					Personalized Outcome</a></li>									
				<?php } ?>					
			</ul>
		</li>			

		<!-- Mis Report -->
		<li id="manageCMSmis"><a href="#"><i class="fa fa-file"></i> MIS Report <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<?php if($functionsObj->checkModuleAuth('createMis','enable')){ ?>
					<!-- <li>
						<a href="<?php // echo site_root."ux-admin/createMis";?>">Create MIS</a>
					</li> -->
					<li>
						<a href="<?php echo site_root."ux-admin/manageCompetency";?>">Manage Competency</a>
					</li>
					<li>
						<a href="<?php echo site_root."ux-admin/competencyFormula";?>">Manag Competency Formula</a>
					</li>
				<?php } ?>
			</ul>
		</li>
	</ul>
</div>
</div>
</nav>
<script>
	$(document).ready(function(){
		countInclick   = 0;
		countOutclick  = 0;
		animateInArray = ['bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'flipInX', 'flipInY', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'lightSpeedIn', 'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'flip', 'hinge', 'jackInTheBox', 'rollIn'];

		animateOutArray = ['bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'flipOutX', 'flipOutY', 'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'lightSpeedOut', 'rollOut'];
	});
</script>
