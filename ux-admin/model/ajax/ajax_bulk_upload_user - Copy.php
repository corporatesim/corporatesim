<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';
//require_once doc_root . 'ux-admin/model/model.php';
//$functionsObj = new Model ();
// echo 'Test message';
// exit();

$funObj = new Functions(); // Create Object

$maxFileSize = 2097152; // Set max upload file size [2MB]
$validext = array ('xls', 'xlsx', 'csv');  // Allowed Extensions
//$uid = $_SESSION['siteuser'];

if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) ){
	$explode_filename = explode(".", $_FILES['upload_csv']['name']);
	//echo $explode_filename[0];
	//exit();
		$ext = strtolower( end($explode_filename) );
		//echo $ext."\n";
		if(in_array( $ext, $validext ) ){
			try{	
				$file = $_FILES['upload_csv']['tmp_name'];
				$handle = fopen($file, "r");
				
				$not_inserted_data = array();
				$inserted_data = array();
				$c = 0;
				$flag = true;
				
				while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false ){
					if($flag) { $flag = false; continue; }
					//echo $filesop[1];
					$email = $filesop[6];
					$username = $filesop[3];
					
					$where = array("`User_email` ='".$email."' OR `User_username` ='".$username."' AND User_Delete=0 ");
					$object = $funObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);
					if($object->num_rows > 0){
						//insert email into not_inserted_data
						array_push($not_inserted_data,$filesop[6]);
					}else{
						if( !empty($filesop) ){
							$array = array(
								"User_fname"	=>	$filesop[1],
								"User_lname"	=>	$filesop[2],
								"User_username"		=>	$filesop[3],
								"User_companyid"	=>	$filesop[4],
								"User_mobile"		=>	$filesop[5],
								"User_email"		=>	$filesop[6],
								"User_datetime"		=>	date("Y-m-d H:i:s")
							);
							$result = $funObj->InsertData("GAME_SITE_USERS", $array, 0, 0);
							$c++;
							if($result){
								$uid = $funObj->InsertID();
								$to = $filesop[6];								
								
								$password = $funObj->randomPassword(); 
								$login_details = array(
									'Auth_userid'	=> $uid,
									'Auth_password'	=> $password,
									'Auth_date_time'	=>	date('Y-m-d H:i:s')
								);
			
								$result1 = $funObj->InsertData('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
								if($result1){
									$from = "webmaster@simulation.com";
									$subject = "New Account created for Simulation Game";
									$message = "Dear User";
									$message .= "<p>Username : ".$username;
									$message .= "<p>Password : ".$password;

									$header = "From:" . $from . "\r\n";
									$header .= "MIME-Version: 1.0\r\n";
									$header .= "Content-type: text/html; charset: utf8\r\n";
									
									mail($to, $subject, $message, $header);
												
									$_SESSION['msg'] = "User account created successfully";
									$_SESSION['type[0]'] = "inputSuccess";
									$_SESSION['type[1]'] = "has-success";
									//header("Location: ".site_root."ux-admin/siteusers");
									//exit(0);
								}else{
									$msg = "Error: ".$result1;
									//echo $msg;
									//exit();
									$type[0] = "inputError";
									$type[1] = "has-error";
								}	 
							}
						}
					}					
				}
				//echo $c;
				if (!empty($not_inserted_data))
				{
					$msg = "</br>Email id not imported -> ".implode(" , ",$not_inserted_data);
				}
				
				$result = array(
					"msg"	=>	"Import successful. You have imported ".$c." User entries.".$msg,
					"status"	=>	1
				);

			} catch (Exception $e) {
				$result = array(
						"msg"	=>	"Error: ".$e,
						"status"	=>	0
				);
			}
		}
	
	//exit();	
} else {
	$result = array(
			"msg"	=>	"Please select a file to import",
			"status"	=>	0
	);
}

echo json_encode($result);