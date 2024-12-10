<?php
/**
* Description:	This is a class for member.
* Author:		Joken Villanueva
* Date Created:	Nov. 2, 2013
* Revised By:		
*/
require_once('database.php');
class Guest{
	
	protected static $tbl_name = "tblguest";
	function db_fields(){
		global $mydb;
		return $mydb->getFieldsOnOneTable(self::$tbl_name);
	}
	function listOfguest(){
		global $mydb;
		$mydb->setQuery("Select * from ".self::$tbl_name);
		$cur = $mydb->loadResultList();
		return $cur;
	
	}
	function single_guest($id=0){
			global $mydb;
			$mydb->setQuery("SELECT * FROM ".self::$tbl_name." Where `GUESTID`= {$id} LIMIT 1");
			$cur = $mydb->loadSingleResult();
			return $cur;
	}
	function find_all_guest($phone="", $email=""){
			global $mydb;
			$mydb->setQuery("SELECT * 
							FROM  ".self::$tbl_name." 
							WHERE  `phone` ='{$phone}' OR email='{email}'");
	
			$cur = $mydb->executeQuery();
			$row_count = $mydb->num_rows($cur);//get the number of count
			return $row_count;
	}
	static function guest_login($email = "", $pass = "") {
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tbl_name . " WHERE `G_UNAME` ='" . $email . "'");
		$cur = $mydb->executeQuery();
		
		if ($cur == false) {
			die(mysql_error());
		}
		
		$row_count = $mydb->num_rows($cur); // get the number of count
		if ($row_count == 1) {
			$found_user = $mydb->loadSingleResult();
			
			// Check if password matches using password_verify
			if (password_verify($pass, $found_user->G_PASS)) {
				$_SESSION['GUESTID'] = $found_user->GUESTID;
				$_SESSION['name'] = $found_user->G_FNAME;
				$_SESSION['last'] = $found_user->G_LNAME;
				$_SESSION['gender'] = $found_user->G_GENDER;
				$_SESSION['address'] = $found_user->G_ADDRESS;
				$_SESSION['phone'] = $found_user->G_PHONE;
				$_SESSION['username'] = $found_user->G_UNAME;
	 // Generate and store session token
	 $session_token = bin2hex(random_bytes(32));
	 $mydb->setQuery("UPDATE " . self::$tbl_name . " SET session_token = ?, last_activity = NOW() WHERE GUESTID = ?");
	 $mydb->bind_param("si", $session_token, $found_user->GUESTID);
	 $mydb->executeQuery();

	 $_SESSION['session_token'] = $session_token;
				return true; // Successful login
			} else {
				return false; // Invalid password
			}
		} else {
			return false; // Invalid email
		}
	}
	
    static function check_session_expiration() {
        global $mydb;
        $timeout_duration = 1800; // 30 minutes

        if (isset($_SESSION['GUESTID'])) {
            $user_id = $_SESSION['GUESTID'];
            $mydb->setQuery("SELECT last_activity FROM " . self::$tbl_name . " WHERE GUESTID = ?");
            $mydb->bind_param("i", $user_id);
            $mydb->executeQuery();
            $result = $mydb->loadSingleResult();

            if ($result) {
                $last_activity = strtotime($result->last_activity);
                if (time() - $last_activity > $timeout_duration) {
                    // Session has expired, log the user out
                    self::logout();
                } else {
                    // Update last activity timestamp
                    $mydb->setQuery("UPDATE " . self::$tbl_name . " SET last_activity = NOW() WHERE GUESTID = ?");
                    $mydb->bind_param("i", $user_id);
                    $mydb->executeQuery();
                }
            }
        }
    }

    static function logout() {
        global $mydb;

        if (isset($_SESSION['GUESTID'])) {
            $user_id = $_SESSION['GUESTID'];
            // Clear the session token in the database
            $mydb->setQuery("UPDATE " . self::$tbl_name . " SET session_token = NULL WHERE GUESTID = ?");
            $mydb->bind_param("i", $user_id);
            $mydb->executeQuery();

            // Unset session variables and destroy the session
            session_unset();
            session_destroy();
            header("Location: https://mcchmhotelreservation.com/index.php?logout=1");
            exit();
        }
    }

	/*---Instantiation of Object dynamically---*/
	static function instantiate($record) {
		$object = new self;

		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		} 
		return $object;
	}
	
	
	/*--Cleaning the raw data before submitting to Database--*/
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  global $mydb;
	  $attributes = array();
	  foreach($this->db_fields() as $field) {
	    if(property_exists($this, $field)) {
			$attributes[$field] = $this->$field;
		}
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $mydb;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $mydb->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	
	/*--Create,Update and Delete methods--*/
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $mydb;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".self::$tbl_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	echo $mydb->setQuery($sql);
	
	 if($mydb->executeQuery()) {
	    $this->id = $mydb->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update($id=0) {
	  global $mydb;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$tbl_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE GUESTID=". $id;
	  $mydb->setQuery($sql);
	 	if(!$mydb->executeQuery()) return false; 	
		
	}

	public function delete($id=0) {
		global $mydb;
		  $sql = "DELETE FROM ".self::$tbl_name;
		  $sql .= " WHERE GUESTID=". $id;
		  $sql .= " LIMIT 1 ";
		  $mydb->setQuery($sql);
		  
			if(!$mydb->executeQuery()) return false; 	
	
	}
		
}
?>