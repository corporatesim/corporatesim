<?php

if($server == 'local'){
	//local db
	define("HST", "localhost");
	define("USR", "admin");
	define("PWD", "Admin@2020Mysql");
	define("DBN", "uxconsul_game");
	// user for testing (recomended)
	// define("HST", "develop.corpsim.in");
	// define("USR", "organiza_devuser");
	// define("PWD", "2GX7'_;rudyU");
	// define("DBN", "organiza_devGameData");
	// for live server (only if needed)
	// define("HST", "kiit.corpsim.in");
	// define("USR", "organiza_newGame");
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
	define("HST", "kiit.corpsim.in");
	define("USR", "organiza_game");
	define("PWD", "M^aAq&VLDt8Q");
	define("DBN", "organiza_game");

}
?>