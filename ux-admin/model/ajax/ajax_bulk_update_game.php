<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';
//require_once doc_root . 'ux-admin/model/model.php';
//$functionsObj = new Model ();
// echo 'Test message';
// exit();

$funObj      = new Functions(); // Create Object
$maxFileSize = 2097152; // Set max upload file size [2MB]
$validext    = array ('xls', 'xlsx', 'csv');  // Allowed Extensions
//$uid = $_SESSION['siteuser'];

if( isset( $_FILES['updategame_csv']['name'] ) && !empty( $_FILES['updategame_csv']['name'] ) )
{
	$explode_filename = explode(".", $_FILES['updategame_csv']['name']);
	//echo $explode_filename[0];
	//exit();
	$ext = strtolower( end($explode_filename) );
		//echo $ext."\n";
	if(in_array( $ext, $validext ) )
	{
		try{	
			$file              = $_FILES['updategame_csv']['tmp_name'];
			$handle            = fopen($file, "r");

			$not_inserted_data = array();
			$inserted_data     = array();
			$c                 = 0;
			$flag              = true;

			while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
			{
				if($flag) { $flag = false; continue; }
					//echo $filesop[1];
				$uid        = $filesop[0];
				$gameid     = $filesop[1];

				$where  = array("`User_id` ='".$uid."' AND User_Delete=0 ");
				$object = $funObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);
				if($object->num_rows > 0)
				{
					if( !empty($filesop) )
					{
						$objectgame = $object->fetch_object();
						$gameids    = $objectgame->User_games;
						$gameidsval = array(
							"User_games"	=>	$gameids.$filesop[1].',',
							"User_status"	=>	$filesop[2],
						);
						// $result = $funObj->UpdateData('GAME_SITE_USERS', $gameidsval, 'User_id', $uid, 0);
						// adding this function to replace the above commented function for bulk upload for user game values
						$result = $funObj->UpdateGame('GAME_SITE_USERS', $gameidsval, 'User_id', $uid, 0);
						if($result){
							$gamedetails = (object) array(
								'UG_UserID' => $uid,
								'UG_GameID'	=> $gameid
							);	
							$result              = $funObj->InsertData('GAME_USERGAMES', $gamedetails, 0, 0);	
							$_SESSION['msg']     = "User game updated successfully";
							$_SESSION['type[0]'] = "inputSuccess";
							$_SESSION['type[1]'] = "has-success";
							$c++;
						}
					}
				}					
			}
			$result = array(
				"msg"    =>	"Import successful. You have imported ".$c." User game entries.".$msg,
				"status" =>	1
			);

		} catch (Exception $e) {
			$result = array(
				"msg"    =>	"Error: ".$e,
				"status" =>	0
			);
		}
	}
	
	//exit();	
} else {
	$result = array(
		"msg"    =>	"Please select a file to import",
		"status" =>	0
	);
}

echo json_encode($result);