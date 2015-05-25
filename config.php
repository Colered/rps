<?php
//die("here");
session_start();
define('DB_SERVER', "localhost");
define('DB_USER', "root");
define('DB_PASS', "");
define('DB_FEDENA', "fedena_new");
define('DB_RPS', "rps");
// include database and object files
if(!function_exists('classAutoLoader')){
	function classAutoLoader($class){
		$class=strtolower($class);
		$classFile='classes/'.$class.'.class.php';
		if(!class_exists($class)) include $classFile;
	}
}
spl_autoload_register('classAutoLoader');
// instantiate database object
$database = new Database();
$db_FED = $database->getFedenaConnection();
$db_RPS = $database->getConnection();
//date_default_timezone_set("America/New_York");
?>