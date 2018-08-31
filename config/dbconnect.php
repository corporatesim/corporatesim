<?php

class database{
	
	function __construct(){
		$this->conn = new mysqli(HST,USR,PWD,DBN);
		// Check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		} 
	}
	function connection(){
		return $this->conn;
	}
}

?>