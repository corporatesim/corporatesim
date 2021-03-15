<?php 

if($_SERVER['HTTP_HOST'] == 'localhost')
{
	//local db
	define("HST", "localhost");
	define("USR", "root");
	define("PWD", "");
	define("DBN", "uxconsul_game");
	// live db
	// define("HST", "kiit.corporatesim.com");
	// define("USR", "organiza_game");
	// define("PWD", "M^aAq&VLDt8Q");
	// define("DBN", "organiza_game");
}
// elseif($_SERVER['HTTP_HOST'] == 'server')
// {
// 	//server
// 	define("HST", "simulation.uxconsultant.in");
// 	define("USR", "uxconsul_game");
// 	//organiza_game
// 	define("PWD", "5WuQpv,L{Su;");
// 	//M^aAq&VLDt8Q
// 	define("DBN", "uxconsul_game");
// }
else
{
	//live
	define("HST", "kiit.corporatesim.com");
	define("USR", "organiza_game");
	define("PWD", "M^aAq&VLDt8Q");
	define("DBN", "organiza_game");
}

$con = mysqli_connect(HST,USR,PWD,DBN);
if(!$con)
{
	die('Could not connect: <b>' . mysqli_connect_error().'</b>');
}
else
{
	// echo "<b>Conneted successfully</b>";
	$check_endDate = " SELECT User_id,User_GameEndDate FROM GAME_SITE_USERS WHERE 1 ";
	$result        = mysqli_query($con, $check_endDate);
	$resObje       = mysqli_fetch_object($result);
	// print_r($resObje);
	while ($resObje = mysqli_fetch_object($result))
	{
		if($resObje->User_GameEndDate <= date('Y-m-d'))
		{
			$update_gameStatus = "UPDATE GAME_SITE_USERS SET User_gameStatus=1 WHERE User_id=$resObje->User_id";
			$executeQuery      = mysqli_query($con, $update_gameStatus);
			// echo $executeQuery.'<br>';
		}
	}
}

