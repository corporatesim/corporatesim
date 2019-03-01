	<style>
	@media only screen and (max-width: 768px) {
		.dashboardList{
			margin-top:25px;
		}
	}
</style>

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-2 dashboardList"style="margin-top:40px; margin-left:-30px;">
				<ul>
					<li <?php if(isset($_SESSION['userpage']) && $_SESSION['userpage']==='profile') { ?> class="active" <?php } ?>>
						<a href="my_profile.php">My Profile</a>
					</li>

					<li <?php if(isset($_SESSION['userpage']) && $_SESSION['userpage']==='settings') { ?> class="active" <?php } ?>>
						<a href="settings.php">Settings</a>
					</li>

					<li <?php if(isset($_SESSION['userpage']) && $_SESSION['userpage']==='game') { ?> class="active" <?php } ?>>
						<a href="selectgame.php" >Assign Games</a>
					</li>

					<li <?php if(isset($_SESSION['userpage']) && $_SESSION['userpage']==='registration') { ?> class="active" <?php } ?>>
						<a href="registerMore.php" >Game Catelogue</a>
					</li>

				</ul>
			</div>

