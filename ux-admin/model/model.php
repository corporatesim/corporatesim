<?php
class Model extends database{
	private $iv;
	private $key;

	function __construct(){
		parent::__construct();
	}

	function EscapeString($string){
		return $this->conn->real_escape_string($string);
	}
	
	function InsertID(){
		return $this->conn->insert_id;
	}
	
	function ExecuteQuery($sql){
		$result = $this->conn->query($sql) or die($this->conn->error."<br>".$sql);
		return $result;
	}
	
	function MySqliError(){
		return $this->conn->error;
	}
	
	function Protect($val){
		$value = stripslashes($val);
		$value = addslashes($value);
		return $value;
	}

	function FetchData($object){
		$data = $object->fetch_assoc() or die($this->conn->error);
		return $data;
	}
	
	function FetchObject($object){
		$data = $object->fetch_object() or die($this->conn->error);
		return $data;
	}

	function FetchCount($object){
		$count = $object->num_rows or die($this->conn->error);
		return $count;
	}
	
	function AffectedRows(){
		return $this->conn->affected_rows;
	}

	function SelectData($fields, $tables, $where, $order=array(), $group=array(),$limit='',$offset='',$print_flag=0){
		if(is_array($fields)){
			$fields = implode(",",$fields);
		}
		if(is_array($tables)){
			$tables = implode(",",$tables);
		}
		
		if(!empty($where)){
			if(is_array($where)){
				$where = implode(" AND ", $where);
			}
		}
		
		if(!empty($order)){
			if(is_array($order)){
				$order = implode(",",$order);
			}
		}
		
		if(!empty($fields)){
			$sql = "SELECT $fields FROM $tables ";
		}
		else{
			$sql = "SELECT * FROM $tables ";
		}
		if(!empty($where)){
			$sql .= ' WHERE '.$where;
		}
		
		if(!empty($group)){
			if(is_array($group)){
				$group = implode(",",$group);
			}
			$sql .= ' GROUP BY '.$group;
		}
		if(!empty($order)){
			$sql .= ' ORDER BY '.$order;
		}
		if(!empty($limit)){
			if(!empty($offset)){
				$sql .= ' LIMIT '.$offset.",".$limit;
			}else{
				$sql .= ' LIMIT '.$limit;
			}
		}
		if($print_flag==1){
			echo($sql);
		}
		$result = $this->ExecuteQuery($sql); //Execute sql statement
		return $result;
	}

	function InsertData($tblName,$arrFieldNameValue,$replace_flag=0,$print_flag=0){
		if($replace_flag==0){
			$sqlFirst ="INSERT INTO " . $tblName . "(";
		}
		if($replace_flag==1){
			$sqlFirst ="INSERT IGNORE INTO " . $tblName . "(";
		}
		if($replace_flag==2){
			$sqlFirst ="REPLACE INTO " . $tblName . "(";
		}
		$sqlSecond =" VALUES(";
		while(list($key,$value) = each($arrFieldNameValue)){
			$sqlFirst  = $sqlFirst . $key . ",";
			$value     = "'".$this->Protect($value)."'";
			$sqlSecond = $sqlSecond . $value . ",";
		}
		$sqlFirst  = substr($sqlFirst,0,strlen($sqlFirst)-1) . ") ";
		$sqlSecond = substr($sqlSecond,0,strlen($sqlSecond)-1) .")";
		$sql       = $sqlFirst . $sqlSecond;

		if($print_flag==1)
		{
			echo($sql);
		}
		$result = $this->ExecuteQuery($sql); //Execute sql statement
		return $result;
	}

	function UpdateData($tblName,$arrFieldValue,$FieldName,$Fieldvalue,$print_flag=0){
		$sql = "UPDATE " . $tblName . " SET ";
		foreach ($arrFieldValue as $key => $value){
			$sql = $sql  . $key . "=" . "'" .$this->Protect($value) . "'"  . ", ";
		}
		$sql = substr($sql,0,strlen($sql)-2) . " WHERE " . $FieldName . "=" . "'" . $Fieldvalue. "'";
		if($print_flag==1){
			echo $sql;
		}
		$result = $this->ExecuteQuery($sql); //Execute sql statement		
		return $result;
	}
	
	function Update($tblName, $array, $conditions, $print_flag=0){
		$sql = "UPDATE " . $tblName . " SET ";
		
		while(list($key,$value) = each($array)){
			$sql = $sql  . $key . "=" . "'" .$value . "'"  . ", ";
		}
		
		if(is_array($conditions)){
			$conditions = implode(" AND ", $conditions);
		}
		
		$sql = substr($sql,0,strlen($sql)-2) . " WHERE ".$conditions;
		if($print_flag==1){
			echo $sql;
		}
		$result = $this->ExecuteQuery($sql); //Execute sql statement
		return $result;
	}
	
	function DeleteData($tblName,$FieldName,$value,$print_flag=0){
		$sql = "DELETE FROM " .$tblName . " WHERE " . $FieldName . "=" . "'".$value."'";
		if($print_flag==1){
			echo $sql;
		}
		$result = $this->ExecuteQuery($sql); //Execute sql statement
	}
	
	function randomPassword() {
		$alphabet    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass        = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n      = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	function checkModuleAuth($menu,$rights,$innerrights=NULL)
	{
		if(isset($_SESSION['admin_usertype']) && $_SESSION['admin_usertype']=='admin')
		{
			$adminid   = $_SESSION['ux-admin-id'];
			$fields    = array();
			$where     = array("id='".$adminid."'");
			$result    = $this->SelectData($fields, 'GAME_ADMINUSERS', $where, '', '', '', '', 0);
			$result    = $this->FetchObject($result);
			$val       = $result->admin_rights;
			$rightsVal = json_decode($val, true);

			if($rightsVal[$menu][$rights]=='yes')
			{
				return true;
			}
			else if($rightsVal[$menu][$rights][$innerrights]=='yes')
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		else
		{
			return true;
		}
		
	}
	
	function numhash($n) {
		return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
	}
}