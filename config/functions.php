<?php
define("ENCRYPTION_KEY", "Abcd1234");

class Functions extends database
{
	function __construct()
	{
		$database   = new database();
		$this->conn = $database->connection();
	}

	function EscapeString($string)
	{
		return $this->conn->real_escape_string($string);
	}

	function InsertID()
	{
		return $this->conn->insert_id;
	}

	function ExecuteQuery($sql)
	{
		$result = $this->conn->query($sql) or die($this->conn->error . "(" . $sql . ")");
		return $result;
	}

	function MySqliError()
	{
		return $this->conn->error;
	}

	function Protect($val)
	{
		$value = "'" . addslashes($val) . "'";
		return $value;
	}

	function FetchData($object)
	{
		if($object->num_rows > 0)
		{
			$data = $object->fetch_assoc() or die($this->conn->error);
			return $data;
		}
		else
		{
			return false;
		}
	}

	function FetchObject($object)
	{
		if($object->num_rows > 0)
		{
			$data = $object->fetch_object() or die($this->conn->error);
			return $data;
		}
		else
		{
			return false;
		}
	}

	function FetchCount($object)
	{
		$count = $object->num_rows or die($this->conn->error);
		return $count;
	}

	function AffectedRows()
	{
		return $this->conn->affected_rows;
	}

	function SelectData($fields, $tables, $where, $order = array(), $group = array(), $limit = '', $offset = '', $print_flag = 0)
	{
		if(!empty($fields))
		{
			$fields = implode(",", $fields);
		}

		if(!empty($where))
		{
			$where = implode(" AND ", $where);
		}

		if(is_array($order))
		{
			$order = implode(",", $order);
		}

		if(!empty($fields))
		{
			$sql = "SELECT $fields FROM $tables ";
		}
		else
		{
			$sql = "SELECT * FROM $tables ";
		}

		if(!empty($where))
		{
			$sql .= ' WHERE ' . $where;
		}

		if(!empty($group))
		{
			$group = implode(",", $group);
		}

		if(!empty($group))
		{
			$sql .= ' GROUP BY ' . $group;
		}

		if(!empty($order))
		{
			$sql .= ' ORDER BY ' . $order;
		}

		if(!empty($limit))
		{
			if(!empty($offset))
			{
				$sql .= ' LIMIT ' . $offset . "," . $limit;
			}
			else
			{
				$sql .= ' LIMIT ' . $limit;
			}
		}

		if($print_flag == 1)
		{
			echo ($sql);
		}

    //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
		return $result;
	}

	function InsertData($tblName, $array, $replace_flag = 0, $print_flag = 0)
	{
		if($replace_flag == 0)
		{
			$sqlFirst = "INSERT INTO " . $tblName . "(";
		}
		if($replace_flag == 1)
		{
			$sqlFirst = "INSERT IGNORE INTO " . $tblName . "(";
		}
		if($replace_flag == 2)
		{
			$sqlFirst = "REPLACE INTO " . $tblName . "(";
		}
		$sqlSecond = " VALUES(";
		while(list($key, $value) = each($array))
		{
			$sqlFirst  = $sqlFirst . $key . ",";
			$value     = $this->Protect($value);
			$sqlSecond = $sqlSecond . $value . ",";
		}
		$sqlFirst  = substr($sqlFirst, 0, strlen($sqlFirst) - 1) . ") ";
		$sqlSecond = substr($sqlSecond, 0, strlen($sqlSecond) - 1) . ")";
		$sql       = $sqlFirst . $sqlSecond;

		if($print_flag == 1)
		{
			echo ($sql);
		}
		// die($sql);
    //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
		return $result;
	}

  // adding this new function for bulk insert/update
	function BulkInsertUpdateData($tblName, $FieldName, $Fieldvalue, $status, $print_flag = 0)
	{
		$updateQueryField = array();
    // to avoid the updation of primary key value
		$flag             = true; 
		foreach($FieldName as $row)
		{
			$updateQueryField[] = $row . '=' . 'VALUES(' . $row . ')';
		}
    // removing first element of an array, as it would be ID(Primary Key) for updation
		if($status == 'update')
		{
			array_shift($updateQueryField);
		}

		$sql = " INSERT INTO " . $tblName . "(" . implode(',', $FieldName) . ") VALUES " . $Fieldvalue . " ON DUPLICATE KEY UPDATE " . implode(',', $updateQueryField);
		
		//Execute sql statement die($sql);
		$result = $this->ExecuteQuery($sql); 
		return $result;
	}

	function UpdateData($tblName, $array, $FieldName, $Fieldvalue, $print_flag = 0)
	{
		$sql = "UPDATE " . $tblName . " SET ";
		while(list($key, $value) = each($array))
		{
			$sql = $sql . $key . "=" . "'" . $value . "'" . ", ";
		}
		$sql = substr($sql, 0, strlen($sql) - 2) . " WHERE " . $FieldName . "=" . "'" . $Fieldvalue . "'";
		if($print_flag == 1)
		{
			echo $sql;
		}
   //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
		return $result;
	}

   // adding this new function to update the game values in bulk for csv
	function UpdateGame($tblName, $array, $fieldName, $fieldvalue, $print_flag = 0)
	{
    // if status is zero then remove all except the value getting from csv file
		$new_value = $array['User_games'];
                // converting to array
		$old_value = explode(',', $new_value); 
		$old_value = array_splice($old_value, 0, -2);
                // converting to string
		$old_value = implode(',', $old_value); 
		$csv_value = explode(',', $array['User_games']);
		$csv_value = $csv_value[count($csv_value) - 2];

		$sql    = " UPDATE
		" . $tblName . " 
		SET
		User_status = '" . $array['User_status'] . "', User_games = ( 
		CASE
		User_status 
		WHEN
		1 
		THEN
		IF(!FIND_IN_SET(" . $csv_value . ",User_games),'" . $new_value . "',CONCAT('" . $old_value . "',','))
		WHEN
		0 
		THEN
		IF(FIND_IN_SET(" . $csv_value . ",User_games),REPLACE(User_games,CONCAT('" . $csv_value . "',','),''),CONCAT('" . $old_value . "',',')) 
		END
		) 
		WHERE
		" . $fieldName . '=' . $fieldvalue;
    //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
		return $result;
	}

	function Update($tblName, $array, $conditions, $print_flag = 0)
	{
		$sql = " UPDATE " . $tblName . " SET ";

		while(list($key, $value) = each($array))
		{
			$sql = $sql . $key . "=" . "'" . $value . "'" . ", ";
		}

		if(is_array($conditions))
		{
			$conditions = implode(" AND ", $conditions);
		}

		$sql = substr($sql, 0, strlen($sql) - 2) . " WHERE " . $conditions;
		if($print_flag == 1)
		{
			echo $sql;
		}
    //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
		return $result;
	}


	function DeleteDataCron($tblName, $FieldName, $value, $print_flag = 0)
	{
		$sql = " DELETE FROM " . $tblName . " WHERE " . $FieldName . "=" . "'" . $value . "'";
		if($print_flag == 1)
		{
			echo $sql;
		}
    //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
	}

	function DeleteData($tblName, $array, $condition = '', $print_flag = 0)
	{
		$sql = " DELETE FROM " . $tblName;

		if(!empty($condition))
		{
			$condition = " " . $condition . " ";
		}

		if(!empty($array))
		{
			$value = implode($condition, $array);
			$sql  .= " WHERE " . $value;
		}

		if($print_flag == 1)
		{
			echo $sql;
		}
    //Execute sql statement
		$result = $this->ExecuteQuery($sql); 
	}

	function randomPassword()
	{
		$alphabet    = 'abcdefghijklmnopqrstuvwxyz1234567890';
		//remember to declare $pass as an array
		$pass        = array(); 
		//put the length -1 in cache
		$alphaLength = strlen($alphabet) - 1; 
		for($i = 0; $i < 8; $i++)
		{
			$n      = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		//turn the array into a string
		return implode($pass); 
	}

	function generateOrderId()
	{
		$object  = $this->SelectData(array(
			"(MAX(order_id) + 1) as order_id"
		), orders, array(), '', '', '', '', 0);
		$details = $this->FetchObject($object);

		if($details->order_id != NULL)
		{
			$order_id = $details->order_id;
		}
		else
		{
			$order_id = 1;
		}
		return $order_id;
	}

	function getPizzaOptionDetails($item_id)
	{
		$object = $this->SelectData(array(), food_optional_details, array(
			"item_id=" . $item_id
		), '', '', '', '', 0);
		$array  = array();
		while($row = $object->fetch_object())
		{
			$obj      = $this->SelectData(array(), categories, array(
				"category_id=" . $row->category_type
			), '', '', '', '', 0);
			$cat_name = $this->FetchObject($obj);

			/* $array[$cat_name->category_id][$cat_name->category_name] = array(); */
			$array[$cat_name->category_id]["name"]           = $cat_name->category_name;
			$array[$cat_name->category_id]["items"]          = array();
			$array[$cat_name->category_id]['selection_type'] = $cat_name->selection_type;

			$obj = $this->SelectData(array(), subcategories, array(
				"scat_id in (" . $row->optional_items . ")"
			), '', '', '', '', 0);
			while($items = $obj->fetch_object())
			{
				array_push($array[$cat_name->category_id]["items"], array(
					$items->scat_id,
					$items->scat_name,
					$items->price
				));
			}
		}
		return $array;
	}

	function encrypt($pure_string)
	{
		$encryption_key   = ENCRYPTION_KEY;
		$iv_size          = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv               = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
		return $encrypted_string;
	}

	function decrypt($encrypted_string)
	{
		$encryption_key   = ENCRYPTION_KEY;
		$iv_size          = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv               = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
		return $decrypted_string;
	}
}