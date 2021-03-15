<?php
# Session Logout after inactivity
function sessionX(){
	$functionsObj = new Functions();
	
	$logLength = 1800; # time in seconds :: 1800 = 30 minutes
	$ctime = strtotime("now"); # Create a time from a string
	
	if(isset($_SESSION['salesUser']) && isset($_SESSION['session_strt'])){
		# Check if they have exceded the time limit of inactivity
		if( ( ( $ctime - strtotime($_SESSION['session_strt']) ) > $logLength ) ){
			# If exceded the time, log the user out
			$logout_time = date("Y-m-d H:i:s", strtotime($_SESSION['session_strt'] . "+30 minutes"));
			$functionsObj->logout($logout_time);
			header("location: ".site_root."sales/login");
			exit(0);
		}else{
			# If they have not exceded the time limit of inactivity, keep them logged in
			$array = array(
					"session_strt"	=>	date('Y-m-d H:i:s')
			);
			
			// Fetch last login details
			$where = array("uid=".$_SESSION['salesUser'], "l_id = (SELECT MAX(l_id) FROM pizza_login_details)");
			$check_login_obj = $functionsObj->SelectData(array(), login_details, $where, '', '', '', '', 0);
			$login_details = $functionsObj->FetchObject($check_login_obj);
	
			// Update Database session time
			$result = $functionsObj->UpdateData(login_details, $array, "l_id", $login_details->l_id, 0);
			
			setcookie ($cookie_name, 'usr_id='.$_SESSION['salesUser'], time() + $cookie_time);
	
			// Set Session Variable
			$_SESSION['session_strt'] = date('Y-m-d H:i:s');
		}
	}else{
		if(isset($_COOKIE[$cookie_name])){
			parse_str($_COOKIE[$cookie_name]);
			echo $usr_id;
			$_SESSION['salesUser'] = $usr_id;
			$_SESSION['session_strt'] = date('Y-m-d H:i:s');
			
			setcookie ($cookie_name, 'usr_id='.$_SESSION['salesUser'], time() + $cookie_time);
			
			header("location: ".site_root."sales/home");
			exit(0);
		}else{
			echo "not logged in ".$cookie_name;
		}
	}	
}
