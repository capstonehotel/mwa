<?php
date_default_timezone_set('America/New_York');
?>
<?php
/**
* Description:	The main class for Database.
* Author:		Joken Villanueva
* Date Created:	october27, 2013
* Revised By:		
*/

require_once('config.php');
class Database {
	var $sql_string = '';
	var $error_no = 0;
	var $error_msg = '';
	private $conn;
	public $last_query;
	// private $magic_quotes_active;
	private $real_escape_string_exists;
	
	function __construct() {
		$this->open_connection();
		// $this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
	}
	
	public function open_connection() {
		$this->conn = mysqli_connect('127.0.0.1', 'u510162695_hmsystemdb', '1Hmsystemdb','u510162695_hmsystemdb', '3306');
		if(!$this->conn){
			echo "Problem in database connection! Contact administrator!";
			exit();
		} 
	}
	// private $stmt; // To hold prepared statements

    // // Add this method for prepared statements
    // public function prepare($sql) {
    //     $this->stmt = mysqli_prepare($this->conn, $sql);
    //     return $this->stmt;
    // }

    // public function bind_param($types, ...$params) {
    //     // Bind parameters to the prepared statement
    //     mysqli_stmt_bind_param($this->stmt, $types, ...$params);
    // }

    // public function execute() {
    //     // Execute the prepared statement
    //     return mysqli_stmt_execute($this->stmt);
    // }

    // public function get_result() {
    //     // Get the result set from the prepared statement
    //     return mysqli_stmt_get_result($this->stmt);
    // }
	
	function setQuery($sql='') {
		$this->sql_string=$sql;
	}
	
	function executeQuery() {
		$result = mysqli_query($this->conn, $this->sql_string);
		$this->confirm_query($result);
		return $result;
	}	
	
	private function confirm_query($result) {
		if(!$result){
			$this->error_no = mysqli_errno( $this->conn );
			$this->error_msg = mysqli_error( $this->conn );
			return false;				
		}
		return $result;
	} 
	
	function loadResultList( $key='' ) {
		$cur = $this->executeQuery();
		
		$array = array();
		while ($row = mysqli_fetch_object( $cur )) {
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysqli_free_result( $cur );
		return $array;
	}
	
	function loadSingleResult() {
		$cur = $this->executeQuery();
			
		while ($row = mysqli_fetch_object( $cur )) {
		return $data = $row;
		}
		mysqli_free_result( $cur );
		//return $data;
	}
	
	function getFieldsOnOneTable( $tbl_name ) {
	
		$this->setQuery("DESC ".$tbl_name);
		$rows = $this->loadResultList();
		
		$f = array();
		for ( $x=0; $x<count( $rows ); $x++ ) {
			$f[] = $rows[$x]->Field;
		}
		
		return $f;
	}	

	public function fetch_array($result) {
		return mysqli_fetch_array($result);
	}
	//gets the number or rows	
	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}
  
	public function insert_id() {
    // get the last id inserted over the current db connection
		return mysqli_insert_id($this->conn);
	}
  
	public function affected_rows() {
		return mysqli_affected_rows($this->conn);
	}
	
	 public function escape_value( $value ) {
		// if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
		// 	// undo any magic quote effects so mysqli_real_escape_string can do the work
		// 	if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
		// 	$value = mysqli_real_escape_string( $value );
		// } else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			// if( !$this->magic_quotes_active ) { 
				$value = addslashes( $value );
			// }
			// if magic quotes are active, then the slashes already exist
		// }
		return $value;
   	}
	
	public function close_connection() {
		if(isset($this->conn)) {
			mysqli_close($this->conn);
			unset($this->conn);
		}
	}
	
} 
$mydb = new Database();


?>
