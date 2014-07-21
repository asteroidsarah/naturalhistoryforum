<?php
//define constants
define("DB_SERVER", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "forum");

class Connection {

	//attributes
	private $mysqli;


	public function __construct() {
		$this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

	}

	//Close connection
	public function close_connection() {
		$this->mysqli->close();
	}

	//execute the passed in query and return result
	public function query($sql) {

		//execute query
		$result = $this->mysqli->query($sql);
		return $result;
	}


	// fetch a row from result_set as an associative array
	public function fetch_array($result_set) {
		return $result_set->fetch_assoc();
	}

	//call this function to get the last auto generated id
	public function get_insert_id(){
		return $this->mysqli->insert_id;
	}

	//method for filtering input and output
	public function escape_value( $value ) {

		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysqli_real_escape_string" ); // i.e. PHP >= v4.3.0

			if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
				$value = $this->mysqli->real_escape_string( $value );
			} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
			}
			return $value;
			}


}