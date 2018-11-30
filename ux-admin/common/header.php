<nav class="navbar navbar-default navbar-static-top" role="navigation"
style="margin-bottom: 0">
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse"
	data-target=".navbar-collapse">
	<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
	<span class="icon-bar"></span> <span class="icon-bar"></span>
</button>
<a style="padding: 2px 15px;" class="navbar-brand"
href="<?php echo site_root."ux-admin/index";?>"> <img height="100%"
src="<?php echo site_root."images/logo.png";?>" />
</a>
<p class="pull-left wel_note"><?php echo $siteDetails[2]['value']; ?></p>
</div>
<!-- Profile & SeoSetting Drop down Navigation -->
<ul class="nav navbar-top-links navbar-right text-right">
	<li><a href="<?php echo site_root."login.php"; ?>" target="_blank">View Website</a>
	</li>
	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"
		href="#"> <i class="fa fa-user fa-fw"></i> <i
		class="fa fa-caret-down"></i>
	</a>
	<ul class="dropdown-menu dropdown-user">
		<li><a href="<?php echo site_root."ux-admin/MyProfile";?>"><i
			class="fa fa-user fa-fw"></i> My Profile</a></li>

			<?php if($_SESSION['ux-admin-id'] == 1){ ?>
				<li><a href="<?php echo site_root."ux-admin/SiteSettings"?>"><i
					class="fa fa-gear fa-fw"></i> Site Settings</a>

				<!--<li><a href="<?php //echo site_root."ux-admin/SeoSettings"?>"><i
						class="fa fa-gear fa-fw"></i> SEO Settings</a></li>
						<li class="divider"></li> -->
					<?php } ?>

					<li><a href="<?php echo site_root."ux-admin/Logout"?>"><i
						class="fa fa-sign-out fa-fw"></i> Logout</a></li>
					</ul>
				</li>
			</ul>

			<!-- Left Side Main Navigation -->
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">

					<ul class="nav" id="side-menu">

						<li><a href="<?php echo site_root."ux-admin/Dashboard";?>"><i
							class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
<!--
				<li><a href="<?php //echo site_root."ux-admin/Dashboard";?>"><i
						class="fa fa-dashboard fa-fw"></i> Manage Company</a></li>				
					-->
					<?php if($_SESSION['admin_usertype']=='superadmin') {?>
						<li>
							<a href="<?php echo site_root."ux-admin/adminlist";?>">
								<i class="fa fa-dashboard fa-fw"></i> Manage Admin User
							</a>
						</li>
					<?php }?>



					<li><a href="<?php echo site_root."ux-admin/siteusers";?>"><i
						class="fa fa-dashboard fa-fw"></i> Manage User</a></li>
						

						<li id="manageCMS"><a href="#"><i class="fa fa-wrench fa-fw"></i> Master 
							Management<span class="fa arrow"></span></a>
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

								<?php } if($functionsObj->checkModuleAuth('formulas','enable')){ ?>

									<li>
										<a href="<?php echo site_root."ux-admin/Formulas";?>">
											Formulas
										</a>
									</li>	

								<?php } if($functionsObj->checkModuleAuth('linkage','enable')){ ?>

									<li><a 
										href="<?php echo site_root."ux-admin/linkage";?>">
									Linkage</a></li>

								<?php  } if($functionsObj->checkModuleAuth('chart','enable')){ ?>

									<li><a 
										href="<?php echo site_root."ux-admin/chart";?>">
									Chart</a></li>

								<?php } if($functionsObj->checkModuleAuth('chartComp','enable')){ ?>

									<li><a 
										href="<?php echo site_root."ux-admin/chartComp";?>">
									Chart Component</a></li>

								<?php } if($functionsObj->checkModuleAuth('UserReport','enable')){ ?>

									<li><a 
										href="<?php echo site_root."ux-admin/UserReport";?>">
									User Report</a></li>


								<?php } if($functionsObj->checkModuleAuth('ReplayPermission','enable')){ ?>

									<li><a 
										href="<?php echo site_root."ux-admin/ReplayPermission";?>">
									Replay Permission</a></li>

								<?php } if($functionsObj->checkModuleAuth('ReplayPermission','enable')){ ?>

									<li><a 
										href="<?php echo site_root."ux-admin/ScenarioBranching";?>">
									Scenario Branching</a></li>

								<?php } ?>					

							</ul>
						</li>

					</ul>
				</div>
			</div>
		</nav>
