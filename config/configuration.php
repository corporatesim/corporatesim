<?php

if($server == 'local'){
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
	// for new server details
	// define("HST", "live.corporatesim.com");
	// define("USR", "organizationgame");
	// define("PWD", "2GX7'_;rudyU");
	// define("DBN", "organiza_game");
}elseif($server == 'server'){
	//server
	define("HST", "simulation.uxconsultant.in");
	define("USR", "uxconsul_game");
	//organiza_game
	define("PWD", "5WuQpv,L{Su;");
	//M^aAq&VLDt8Q
	define("DBN", "uxconsul_game");
}else{
	//live
	define("HST", "kiit.corporatesim.com");
	define("USR", "organiza_game");
	define("PWD", "M^aAq&VLDt8Q");
	define("DBN", "organiza_game");

}
?>