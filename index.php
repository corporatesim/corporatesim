<?php 

include_once 'config/settings.php';
include_once doc_root.'config/functions.php';
$funObj = new Functions();

$enterpriseDomain = 'https://'.$_SERVER['SERVER_NAME'];

$_SESSION['userpage'] ='index';

if(empty($_SESSION['siteuser'])){
	if(!empty($_REQUEST['entUsrLogin']))
	{
		parse_str(base64_decode($_REQUEST['entUsrLogin']), $arr);
		$username = trim($arr['email']);
		$password = trim($arr['password']);
		$returnUrl = trim($arr['returnUrl']).'?user_Email='.base64_encode($username).'&user_Password='.base64_encode($password);
		// print_r($arr); die($returnUrl);// setCookie 
		
		// autologin starts here
		$sql = "SELECT u.*, CONCAT( u.User_fname, ' ', u.User_lname ) AS FullName, ge.Enterprise_Logo ,gse.SubEnterprise_Logo,gd.Domain_Name FROM GAME_SITE_USERS u INNER JOIN GAME_USER_AUTHENTICATION ua ON u.User_id = ua.Auth_userid LEFT JOIN GAME_ENTERPRISE ge ON u.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_SUBENTERPRISE gse ON u.User_SubParentId=gse.SubEnterprise_ID LEFT JOIN GAME_DOMAIN gd ON ge.Enterprise_ID = gd.Domain_EnterpriseId AND gd.Domain_Status=0  AND( CASE WHEN u.User_Role = 1 THEN gd.Domain_EnterpriseId = u.User_ParentId WHEN u.User_Role = 2 THEN gd.Domain_SubEnterpriseId = u.User_SubParentId END ) WHERE (u.User_username='".$username."' OR u.User_email='".$username."')	AND ua.Auth_password='".$password."'";
		// echo $sql; exit();
		$object = $funObj->ExecuteQuery($sql);
		// echo "<pre>";	print_r($object);exit;

		if($object->num_rows > 0){
			$res = $funObj->FetchObject($object);
		  // echo "<pre>";	print_r($res);exit;
			$domain = $res->Domain_Name;
			if(($_SERVER['SERVER_NAME'] != 'localhost') && ($domain != '' && $domain != $enterpriseDomain))
			{
				$msg  = "Sorry, Please login to your own domain";
				$type = "alert alert-danger alert-dismissible";
			}
			else
			{
				if($res->User_Delete == 0)
				{
					if($res->User_status == 1)
					{
            //updating user game end date
            $uid = (int) $res->User_id;

            //$sql = "SELECT gug.UG_GameEndDate, gug.UG_GameID, gug.UG_ParentId, gug.UG_SubParentId, gsu.User_companyid FROM GAME_USERGAMES gug LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id=gug.UG_UserID WHERE gug.UG_UserID = $uid AND gg.Game_ID IS NOT NULL AND gug.UG_ParentId=".$res->User_ParentId." AND gug.UG_SubParentId=".$res->User_SubParentId." ORDER BY `gg`.`Game_Name` ASC";

            $sql = "SELECT * FROM GAME_USERGAMES gug LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gug.UG_UserID LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_ID = gsu.User_SubParentId LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_EnterpriseID = ge.Enterprise_ID AND geg.EG_GameID = gug.UG_GameID LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID = gsu.User_SubParentId AND gsg.SG_GameID = gug.UG_GameID WHERE gsu.User_id = $uid AND gug.UG_ParentId = ".$res->User_ParentId." AND gug.UG_SubParentId = ".$res->User_SubParentId;

            $result = $funObj->ExecuteQuery($sql);
            //print_r($sql); exit();

            //looping for each game user having
            while ($row = mysqli_fetch_assoc($result)) {

              //randam query so that if not true any condition execute query will get query to execute
              $query = "SELECT * FROM GAME_USERGAMES WHERE UG_ID = ".$row['UG_ID'];

              if ($row['UG_GameID'] == $row['EG_GameID']) {
                //if user and enterprise both having same game

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['User_GameEndDate']) && !empty(strtotime($row['User_GameEndDate']))) {
                  //if user game game end date is greater than user end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['User_GameEndDate']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['Enterprise_EndDate']) && !empty(strtotime($row['Enterprise_EndDate']))) {
                  //if user game game end date is greater than enterprise end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['Enterprise_EndDate']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['SubEnterprise_EndDate']) && !empty(strtotime($row['SubEnterprise_EndDate']))) {
                  //if user game game end date is greater than subenterprise end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['SubEnterprise_EndDate']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['EG_Game_End_Date']) && !empty(strtotime($row['EG_Game_End_Date']))) {
                  //if user game game end date is greater than enterprise game end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['EG_Game_End_Date']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['SG_Game_End_Date']) && !empty(strtotime($row['SG_Game_End_Date']))) {
                  //if user game game end date is greater than subenterprise game end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['SG_Game_End_Date']."' WHERE UG_ID = ".$row['UG_ID'];
                }

              }
              else {
                //if not present game for enterprise and present for user then delete game form user
                $query = "DELETE FROM GAME_USERGAMES WHERE UG_ID = ".$row['UG_ID'];
              }
							//executing Query
							// commenting this line to test properly
              // $queryResult = $funObj->ExecuteQuery($query);
              //print_r($query); echo "<br />";
            }
            //exit();

            //setting session
						$_SESSION['userid']           = (int) $res->User_id;
						$_SESSION['FullName']         = $res->FullName;
						$_SESSION['username']         = $res->User_username;
						$_SESSION['companyid']        = $res->User_companyid;
						$_SESSION['User_profile_pic'] = $res->User_profile_pic;
						$_SESSION['User_ParentId']    = $res->User_ParentId;
						$_SESSION['User_SubParentId'] = $res->User_SubParentId;
						
						if(empty($_SESSION['logo']))
						{
							if($res->User_Role == 1)
							{
								$_SESSION['logo'] = $res->Enterprise_Logo;
							}
							elseif($res->User_Role == 2)
							{
								$_SESSION['logo'] = $res->SubEnterprise_Logo;
							}
						}
						//unset($_SESSION['logo']);
						//header("Location:".site_root."my_profile.php");
						//echo '<script>window.location = "http://simulation.uxconsultant.in/my_profile.php"; </script>';
						// echo "<pre>"; print_r($_SESSION);die('here');
						if(!empty($returnUrl))
						{
							setcookie('returnUrl', $returnUrl, time() + (86400 * 30), "/");
						}
						echo '<script>window.location = "'.site_root.'selectgame.php"; </script>';
						exit(0);
					}
					else
					{
						$msg  = "Your account is pending for email id confirmation. Please confirm your email address by clicking on link sent to your email address.";
						$type = "alert alert-danger alert-dismissible";
					}
				}

				else
				{
					$msg  = "Your account has been deactivated by siteadmin";
					$type = "alert alert-danger alert-dismissible";
				}
			}
		}
		else
		{
			$msg              = "Wrong username or password";
			$_SESSION['msg']  = $msg;
			$type             = "alert alert-danger alert-dismissible";
			$_SESSION['type'] = $type;
		}
		// autologin ends here
	}
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