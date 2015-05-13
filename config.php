<?php
//die("here");
session_start();
define('DB_SERVER', "localhost");
define('DB_DATABASE', "fedena");
define('DB_USER', "root");
define('DB_PASS', "");
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
$db = $database->getConnection();
//date_default_timezone_set("America/New_York");
?>