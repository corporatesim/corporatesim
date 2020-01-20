<?php
session_start();
ob_start();

date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL & ~E_NOTICE | E_ERROR | E_WARNING | E_PARSE);

$server = 'local';
//$server = 'server';
// $server = 'live';
// defining this contatant for css and js file versioning(clearing cookies)
define("version",1.1);

if($server == 'local')
{
	define("site_root","http://".$_SERVER['HTTP_HOST']."/corp_simulation/");
	define("doc_root",$_SERVER['DOCUMENT_ROOT']."/corp_simulation/");
}
else
{
	define('site_root','https://'.$_SERVER['HTTP_HOST']."/");
	define('doc_root',$_SERVER['DOCUMENT_ROOT']."/");
}
require_once doc_root.'config/configuration.php';
require_once doc_root.'config/dbconnect.php';
require_once doc_root.'config/tbl-names.php';

//header('Cache-control: private'); // IE 6 FIX
 
// always modified
//header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
// HTTP/1.1
//header('Cache-Control: no-store, no-cache, must-revalidate');
//header('Cache-Control: post-check=0, pre-check=0', false);
// HTTP/1.0
//header('Pragma: no-cache');
$cookie_name = 'siteAuth';
$cookie_time = (3600 * 24 * 30); // 30 days

?>