<?php 
include_once '../config/settings.php';
include_once doc_root.'config/functions.php';

// Create object
$functionsObj = new Functions();






	
	
	$sql = "SELECT * FROM `GAME_SITE_USERS` WHERE `User_status`=1 and User_id > 801";
	$objlink = $functionsObj->ExecuteQuery($sql);
	if($objlink->num_rows > 0){
		while($row= $objlink->fetch_object())
		{
			
				
				
				
				$userreportdetails = (object) array(
				'UG_UserID'			=>	$row->User_id,
				'UG_GameID'			=> '27'
				);
				
				$result = $functionsObj->InsertData('GAME_USERGAMES', $userreportdetails);
				
			

			
		}
	}
	
	
//print_r($userreportdetails);	
	
	
	

?>