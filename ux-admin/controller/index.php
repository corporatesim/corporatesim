<?php
include_once doc_root."ux-admin/controller/logout.php";
require_once doc_root.'ux-admin/model/model.php';

$functionsObj = new Model();

// Analytic code ----
$fields = array();
$where  = array();
$object = $functionsObj->SelectData($fields, 'GAME_SEOSETTINGS', $where, '', '', '', '', 0);
$i      = 1;

if($object->num_rows > 0)
{
	while($row = $object->fetch_assoc())
	{
		$Global_values[$i] = $row;
		$i++;
	}
}

// Site Settings
$siteData = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array(), '', '', '', '', 0);
$i        = 1;

if($siteData->num_rows > 0)
{
	while($row = $siteData->fetch_assoc())
	{
		$siteDetails[$row['id']] = $row;
		$i++;
	}
}

// Error Msg or success msg
if(isset($_SESSION['msg']))
{
	$msg     = $_SESSION['msg'];
	$type[0] = $_SESSION['type[0]'];
	$type[1] = $_SESSION['type[1]'];
	unset($_SESSION['msg']);
	unset($_SESSION['type[0]']);
	unset($_SESSION['type[1]']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $siteDetails[4]['value']; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta name="description" content="">
	<meta name="author" content="">
	
	<?php 
	foreach($Global_values as $key => $value){
		if($value['type'] == 'script'){
			echo $value['content'];
		}
		if($value['type'] == 'meta'){
			echo "<meta name=\"google-site-verification\" content=\"".$value['content']."\">";
		}
	}
	
	include_once doc_root.'ux-admin/common/links.php';
	?>
	<style type="text/css">
	.legend ul{
		float: left;
		list-style: outside none none;
		margin: 0 0 0 20px;
		padding: 0;
	}
	.legend ul li {
		float: left;
		margin-right: 10px;
	}
	.legend ul li span{
		color:rgb(255, 153, 51);
	}
	.legend ul li a{
		text-decoration: none;
		color:#111111;
	}
	.legend ul li a:hover{
		text-decoration: none;
		color:#079ebf;
	}
	input[type="file"] {
		padding:3px 12px;
		height:auto !important;
	}
	
	.wel_note{
		padding-top:15px;
		margin:0; 
	}
	
	@media screen and (min-width:320px){
		.wel_note{
			font-size:17px;
			font-weight: bold;
		}
	}
	
	@media screen and (min-width:768px){
		.wel_note{
			padding-top: 5px;
			font-size: 26px;
			font-weight: bold;
		}
	}
	
	.mandatory:before{
		content: "*";
		color: red;
	}
	
</style>
</head>

<body>
	<div id="wrapper">
		<?php include_once doc_root.'ux-admin/common/header.php'; ?>
		<div id="page-wrapper">
			<?php include_once doc_root.'ux-admin/common/includes.php'; ?>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="footer">
		<?php include_once doc_root.'ux-admin/common/footer.php'; ?>
	</div>
	<?php include_once doc_root.'ux-admin/common/scripts.php'; ?>
</body>
</html>