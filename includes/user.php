<?php
/**
* Description:	This is a class for member.
* Author:		Joken Villanueva
* Date Created:	Nov. 2, 2013
* Revised By:		
*/

require_once('database.php');
class User{
	
	protected static $tbl_name = "tbluseraccount";
	function db_fields(){
		global $mydb;
		return $mydb->getFieldsOnOneTable(self::$tbl_name);
	}
	function listOfmembers(){
		global $mydb;
		$mydb->setQuery("Select * from ".self::$tbl_name);
		$cur = $mydb->loadResultList();
		return $cur;
	
	}
	function single_user($id=0){
			global $mydb;
			$mydb->setQuery("SELECT * FROM ".self::$tbl_name." Where `USERID`= {$id} LIMIT 1");
			$cur = $mydb->loadSingleResult();
			return $cur;
	}
	function find_all_user($name=""){
			global $mydb;
			$mydb->setQuery("SELECT * 
							FROM  ".self::$tbl_name." 
							WHERE  `UNAME` ='{$name}'");
			$cur = $mydb->executeQuery();
			$row_count = $mydb->num_rows($cur);//get the number of count
			return $row_count;
	}
	static function AuthenticateUser ($email = "", $upass = "") {
		global $mydb;
	
		// Prepare the SQL statement to prevent SQL injection
		$mydb->setQuery("SELECT * FROM `tbluseraccount` WHERE `USER_NAME` = ? LIMIT 1");
		$stmt = $mydb->prepare($mydb->getQuery());
		$stmt->bind_param("s", $email); // Bind the email parameter
		$stmt->execute();
		$cur = $stmt->get_result();
	
		if ($cur && $mydb->num_rows($cur) == 1) {
			$found_user = $cur->fetch_object(); // Use fetch_object() to get the user data
	
			// First, check against the SHA1 hash
			if (sha1($upass) === $found_user->UPASS) {
				// If the SHA1 matches, re-hash with bcrypt
				$new_hashed_password = password_hash($upass, PASSWORD_BCRYPT);
				// Update the database with the new hashed password
				$mydb->setQuery("UPDATE `tbluseraccount` SET `UPASS` = ? WHERE `USER_NAME` = ?");
				$update_stmt = $mydb->prepare($mydb->getQuery());
				$update_stmt->bind_param("ss", $new_hashed_password, $email);
				$update_stmt->execute();
	
				// Set session variables
				$_SESSION['ADMIN_ID'] = $found_user->USERID;
				$_SESSION['ADMIN_UNAME'] = $found_user->UNAME;
				$_SESSION['ADMIN_USERNAME'] = $found_user->USER_NAME;
				$_SESSION['ADMIN_UROLE'] = $found_user->ROLE;
				return true; // Authentication successful
			}
	
			// If the password does not match SHA1, check bcrypt
			if (password_verify($upass, $found_user->UPASS)) {
				// Set session variables
				$_SESSION['ADMIN_ID'] = $found_user->USERID;
				$_SESSION['ADMIN_UNAME'] = $found_user->UNAME;
				$_SESSION['ADMIN_USERNAME'] = $found_user->USER_NAME;
				$_SESSION['ADMIN_UROLE'] = $found_user->ROLE;
				return true; // Authentication successful
			}
		}
	
		return false; // Return false if authentication fails
	}
/* 	static function AuthenticateMember($email="", $h_upass=""){
		global $mydb;
		$res=$mydb->setQuery("SELECT * FROM `user_info` WHERE `email`='" . $email . "' and `pword`='" . $h_upass ."' LIMIT 1");
		 $found_user = $mydb->loadSingleResult();
		   $_SESSION['member_id'] = $found_user['member_id'];
            $_SESSION['fName']     = $found_user['fName'];
            $_SESSION['lName']     = $found_user['lName'];
            $_SESSION['email']     = $found_user['email'];
            $_SESSION['pword']     = $found_user['pword'];
            $_SESSION['mm']        = $found_user['mm'];
            $_SESSION['dd']        = $found_user['dd'];
            $_SESSION['yy']        = $found_user['yy'];
            $_SESSION['gender']    = $found_user['gender'];
		return $found_user;	
	} */	
	
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
		$sql .= " WHERE USERID=". $id;
	  $mydb->setQuery($sql);
	 	if(!$mydb->executeQuery()) return false; 	
		
	}

	public function delete($id=0) {
		global $mydb;
		  $sql = "DELETE FROM ".self::$tbl_name;
		  $sql .= " WHERE USERID=". $id;
		  $sql .= " LIMIT 1 ";
		  $mydb->setQuery($sql);
		  
			if(!$mydb->executeQuery()) return false; 	
	
	}
		
}
?>