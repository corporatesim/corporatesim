<?php 

if(isset($cookie_name)){
	// Check if the cookie exists
	if(isset($_COOKIE[$cookie_name])){
		parse_str($_COOKIE[$cookie_name]);

		$fields = array();
		$where  = array("username='".$usr."'", "password='".$hash."'");
		$sql    = "SELECT
		u.*
		FROM
		".siteusers." as u
		INNER JOIN
		".logindetails." as l
		ON
		u.id = l.uid
		WHERE
		l.username='".$functionsObj->EscapeString($usr)."'
		OR
		u.email='".$functionsObj->EscapeString($usr)."'
		AND
		l.password='".$hash."'
		";
		$result = $functionsObj->ExecuteQuery($sql);
		if($result->num_rows > 0){
			$result                 = $functionsObj->FetchObject($result);
			$_SESSION['pizza_user'] = $result->id;
		}
	}
}
