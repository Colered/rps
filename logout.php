<?php
include_once("config.php");
if($_SESSION['role'] == 1)
	$location = 'admin/index.php';
else
	$location = 'index.php';
session_destroy();
header('Location: '.$location);
?>