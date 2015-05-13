<?php
abstract class Base
{
	public $conn;
	public function __construct(){
		global $db_FED;
		global $db_RPS;
		$this->connfed = $db_FED;
		$this->connrps = $db_RPS;
	}
}