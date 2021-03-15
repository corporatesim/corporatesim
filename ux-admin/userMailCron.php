<?php 
error_reporting(0);
//require 'http://kiit.corporatesim.com/config/settings.php';
//require 'http://kiit.corporatesim.com/config/functions.php';
require '../config/settings.php';
require '../config/functions.php';

// Create object
$functionsObj = new Functions();


	
	$sql = "SELECT u.User_id,u.User_fname,u.User_username,u.User_mobile,u.User_email,a.Auth_password
			FROM `GAME_SITE_USERS` u
			LEFT OUTER JOIN GAME_USER_AUTHENTICATION a ON u.User_id=a.Auth_userid
			WHERE u.User_csv_status=1 ";
			
	$objlink = $functionsObj->ExecuteQuery($sql);
	if($objlink->num_rows > 0){
		while($row= $objlink->fetch_object())
		{
			//$to			= $row->User_email;
			$to			= "sanjaygupta2310@gmail.com";
			$subject	= "New Account created for Simulation Game";
			$fromname	= "Simulation";
			$fromemail 	= "webmaster@simulation.com";
			
			
		
	
			$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Simulation Game</title>
					<style>
					body { margin:0px; padding:0px; font-size:14px; font-family:Verdana, Geneva, sans-serif; color:#402c23;}
					table, tbody, tr, td { margin:0px; padding:0px; border:0;}
					img{ border:none;}
					a img { border:none;}
					</style>
					</head>
					
					<body style="margin:0px; padding:0px;">
					
					<table cellpadding="0" cellspacing="0" border="0" width="600">
						<tr>
							<td align="left" valign="top" colspan="3" style="width:600px; text-align:center; background-color:#402c21; height:48px;"></td>
						</tr>
						
						<tr>
							<td align="left" valign="top" colspan="3"  style="width:100%; height:30px; background-color:#fff;"></td>
						</tr>
						<tr>
							<td align="left" valign="top" style="width:50px;"></td>
							<td align="left" valign="top" style="width:500px; font-family:Verdana, Geneva, sans-serif;">Dear '.ucfirst($row->User_fname).',</td>
							<td align="left" valign="top" style="width:50px;"></td>
						</tr>
						<tr>
							<td align="left" valign="top" colspan="3"  style="width:100%; height:30px; background-color:#fff;"></td>
						</tr>
						<tr>
							<td align="left" valign="top" style="width:50px;"></td>
							<td align="left" valign="top" style="width:500px; font-family:Verdana, Geneva, sans-serif;">Your authentication details :</td>
							<td align="left" valign="top" style="width:50px;"></td>
						</tr>
						<tr>
							<td align="left" valign="top" colspan="3"  style="width:100%; height:30px; background-color:#fff;"></td>
						</tr>
						<tr>
							<td align="left" valign="top" style="width:50px;"></td>
							<td align="left" valign="top" style="width:500px;">
								<table cellpadding="0" cellspacing="0" border="0" width="500">
								   
									<tr>
										<td align="left" valign="top" style="width:100px; font-family:Verdana, Geneva, sans-serif; font-weight:bold;">User Name</td>
										<td align="left" valign="top" style="width:30px; font-family:Verdana, Geneva, sans-serif;">:</td>
										<td align="left" valign="top" style="width:350px; font-family:Verdana, Geneva, sans-serif;">'.$row->User_username.'</td>
									</tr>
									<tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:5px;"></td>
									</tr>
									<tr>
										<td align="left" valign="top" style="width:100px; font-family:Verdana, Geneva, sans-serif; font-weight:bold;">Email Id</td>
										<td align="left" valign="top" style="width:30px; font-family:Verdana, Geneva, sans-serif;">:</td>
										<td align="left" valign="top" style="width:350px; font-family:Verdana, Geneva, sans-serif;">'.$row->User_email.'</td>
									</tr>
									<tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:5px;"></td>
									</tr>
									 <tr>
										<td align="left" valign="top" style="width:100px; font-family:Verdana, Geneva, sans-serif; font-weight:bold;">Contact No</td>
										<td align="left" valign="top" style="width:30px; font-family:Verdana, Geneva, sans-serif;">:</td>
										<td align="left" valign="top" style="width:350px; font-family:Verdana, Geneva, sans-serif;">'.$row->User_mobile.'</td>
									</tr>
									<tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:5px;"></td>
									</tr>
									 <tr>
										<td align="left" valign="top" style="width:100px; font-family:Verdana, Geneva, sans-serif; font-weight:bold;">Password</td>
										<td align="left" valign="top" style="width:30px; font-family:Verdana, Geneva, sans-serif;">:</td>
										<td align="left" valign="top" style="width:350px; font-family:Verdana, Geneva, sans-serif;">'.$row->Auth_password.'</td>
									</tr>
									<tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:30px;"></td>
									</tr>
									<tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; font-family:Verdana, Geneva, sans-serif;">Thanks &amp; Regards</td>
									</tr>
									 <tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:5px;"></td>
									</tr>
									<tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:5px; font-family:Verdana, Geneva, sans-serif;">Simulation Game</td>
									</tr>
									 <tr>
									   <td align="left" valign="top" colspan="3" style="width:500px; height:30px;"></td>
									</tr>
								</table>
							</td>
							<td align="left" valign="top" style="width:50px;"></td>
						</tr>
						<tr>
						   <td align="left" valign="top" colspan="3" style="width:600px; height:5px; background-color:#422c21;"></td>
						 </tr>
					</table>
					
					</body>
					</html>'; 
	
				
			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
			$headers .= "from:$fromname<$fromemail>" . "\r\n";
			//$headers .= "Cc: $ccemail" . "\r\n";
			$sendMail = @mail($to, $subject, $body, $headers);
			
			
			if($sendMail){	
				$status = (object) array(
				'User_csv_status'	=>	2
				);	
				$result = $functionsObj->UpdateData('GAME_SITE_USERS', $status, 'User_id', $row->User_id, 0);
				
			}
		}
			
	}
	
	


?>