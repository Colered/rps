<?php
class Database{
	// specify your own database credentials
	private $host = DB_SERVER;
	private $db_RPS = DB_RPS;
	private $username = DB_USER;
	private $password = DB_PASS;
	private $db_fed = DB_FEDENA;
	public $conn;
	
	// get the fedena database connection
	public function getFedenaConnection(){
		$this->conn = null;
		$this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_fed);
				// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),E_USER_ERROR);
		}
		return $this->conn;
	}
	// get the RPS database connection
	public function getConnection(){
		$this->conn1 = null;
		$this->conn1 = new mysqli($this->host, $this->username, $this->password, $this->db_RPS);
				// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),E_USER_ERROR);
		}
		return $this->conn1;
	}	
}
