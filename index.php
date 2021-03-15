<?php 

include_once 'config/settings.php';

$_SESSION['userpage'] ='index';

if(empty($_SESSION['siteuser'])){
	header("location:".site_root."login.php");
	exit(0);
}

include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 


?>

<div class="col-sm-10">
	
	<div class="col-sm-12"><h2 class="InnerPageHeader">Wellcome!</h2></div>

	<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">

		<div class="col-sm-12 shadow profile_setting_BG" style="height:300px;">
			
			
			
			
		</div>
	</form>
</div>

</div>
</div>
</section>	

<?php include_once 'includes/footer.php'; ?>	