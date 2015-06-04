<?php
include_once("config.php");
$location = 'index.php';
if(isset($_SERVER['HTTP_REFERER'])){
	$reqflds = explode('/', $_SERVER['HTTP_REFERER']);
	if(in_array('admin', $reqflds )){
		$location = 'admin/index.php';
		unset($_SESSION['admin_id']);
	}else{
		unset($_SESSION['std_id']);
	}
}
header('Location: '.$location);
?>