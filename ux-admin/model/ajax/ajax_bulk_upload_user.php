<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';


$funObj      = new Functions(); // Create Object

$maxFileSize = 2097152; // Set max upload file size [2MB]
$validext    = array ('csv');  // Allowed Extensions
//$uid = $_SESSION['siteuser'];


function check_ext($file)
{
	$ext = explode('.', $file);
	if($ext[count($ext)-1]=='csv')
		return true;
}


if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
{
	
	
	
	if($_FILES['upload_csv']['size']==0 || !check_ext($_FILES['upload_csv']['name'])) 
	{
		$_SESSION['err_msg'] = 'Please Upload CSV File Type!';
	}
	else 
	{
		$fileName     = $_FILES['upload_csv']['name']; 
		
		$ext          = substr(strrchr($fileName, "."), 1); 
		
		$array        = explode('.', $fileName);
		
		$first        = str_replace(' ','_',$array [0]);
		
		$filename_chh = $first.'-'.time().'.' . $ext;
		
		$path         = 'usercsvfile/'.$filename_chh;
		
		if(move_uploaded_file($_FILES['upload_csv']['tmp_name'], $path)) 
		{	
			$file = fopen($path, "r");

			if($_SERVER["DOCUMENT_ROOT"] == 'C:/xampp/htdocs')
			{
				// for local server
				$filename = doc_root.'/ux-admin/model/ajax/usercsvfile/'.$filename_chh;
			}
			else
			{
				//$filename = $_SERVER["DOCUMENT_ROOT"].'/organizationgames/sim/ux-admin/model/ajax/usercsvfile/'.$filename_chh;
				$filename = $_SERVER["DOCUMENT_ROOT"].'/ux-admin/model/ajax/usercsvfile/'.$filename_chh;
			}

			/* $sql =	"LOAD DATA INFILE '".$filename."'
					INTO TABLE `GAME_SITE_USERS`
					FIELDS TERMINATED BY ','
					OPTIONALLY ENCLOSED BY '\"' 
					LINES TERMINATED BY '\n' 
					IGNORE 1 LINES
				   (`User_fname`,`User_lname`,`User_username`,`User_mobile`,`User_email`)
				   ;"; */
				   
				   $sql = "LOAD DATA LOCAL INFILE '".$filename."'
				   INTO TABLE GAME_SITE_USERS COLUMNS TERMINATED BY ',' IGNORE 1 LINES (User_fname,User_lname,User_username,User_mobile,User_email,User_companyid,@User_GameStartDate,@User_GameEndDate) SET User_GameStartDate = STR_TO_DATE(@User_GameStartDate, '%m/%d/%Y'), User_GameEndDate = STR_TO_DATE(@User_GameEndDate, '%m/%d/%Y');";
				   
				   $res = $funObj->ExecuteQuery($sql);
				   // print_r($res); exit;
				   if($res)
				   {
				   	$password = $funObj->randomPassword(); 	
				   	$insert   = "INSERT INTO GAME_USER_AUTHENTICATION ( Auth_userid, Auth_username,Auth_password,Auth_date_time ) 
				   	SELECT User_id, User_username, 'pwd2018', User_datetime FROM GAME_SITE_USERS
				   	where User_csv_status = 0
				   	ORDER BY User_id ASC ";
				   	$resauth = $funObj->ExecuteQuery($insert);
				   	if($resauth)
				   	{
				   		$update    = "UPDATE GAME_SITE_USERS SET User_csv_status=1 WHERE User_csv_status=0 ";
				   		$resupdate = $funObj->ExecuteQuery($update);


				   		$result = array(
				   			"msg"    =>	"Successfully Added User CSV File!",
				   			"status" =>	1
				   		);
				   	}
				   	else
				   	{
				   		$result = array(
				   			"msg"    =>	"Not insert user authentication",
				   			"status" =>	0
				   		);
				   	}


				   }
				   else
				   {
				   	$result = array(
				   		"msg"    =>	"Not insert users",
				   		"status" =>	0
				   	);
				   }
				 }

				}

			} else {
				$result = array(
					"msg"    =>	"Please select a file to import",
					"status" =>	0
				);
			}

			echo json_encode($result);