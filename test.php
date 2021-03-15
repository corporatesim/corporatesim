<?php
include_once 'config/settings.php'; 
echo ini_get('allow_url_fopen');
phpinfo(); echo "<pre>"; print_r(openssl_get_cert_locations()); 
print_r($_SESSION); print_r($_SERVER); var_dump($localIP); print_r(get_loaded_extensions()); exit();

include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
// using domPdf library
require_once 'dompdf/autoload.inc.php';
set_time_limit(300);
$functionsObj = new Functions();
$sql          = 'SELECT * FROM GAME_SITE_USERS LIMIT 0,1000';
$resObject    = $functionsObj->ExecuteQuery($sql);
// create table format to download in pdf format
// echo "<pre>";
$data    = '';
$header  = "<table border='1'><tr><th>User_id</th><th>Name</th><th>UserName</th><th>Email</th><th>MobileNo</th></tr>";

while ($result = $resObject->Fetch_Object()) {
    // $html[] = $result->User_username;
    // print_r($result);
	$data .= "<tr><td>$result->User_id</td>	<td>$result->User_fname $result->User_lname</td>	<td>$result->User_username</td>	<td>$result->User_email</td>	<td>$result->User_mobile</td></tr>";
}

$html = $header.$data.'</tbody></table>';

echo $html;
// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
// $dompdf->stream();
// $dompdf->stream("table", array("Attachment" =>0));
