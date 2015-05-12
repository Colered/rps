<?php
class Database{
	// specify your own database credentials
	private $host = DB_SERVER;
	private $db_name = DB_DATABASE;
	private $username = DB_USER;
	private $password = DB_PASS;
	public $conn;

	// get the database connection
	public function getConnection(){
		$this->conn = null;
		$this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
				// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),E_USER_ERROR);
		}
		return $this->conn;
	}
}
