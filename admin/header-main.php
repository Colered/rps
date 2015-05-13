<?php
require_once('../config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	 <title>REGISTRATION PRE-SELECTION SOLUTION</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/navi.css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="js/jquery-ui.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/common.js"></script>
	<script type="text/javascript">
		$(function() {
			$(".box .h_title").not(this).next("ul").hide("normal");
			$(".box .h_title").not(this).next("#home").show("normal");
			$(".box").children(".h_title").click(function() {
				$(this).next("ul").slideToggle();
			});
		});
	</script>
  </head>
<body>
	<div class="wrap">
		<div id="header">
			<div id="top">
				<div class="left" style="width:506px;">
                        <a href="index.php"><img src="../images/logo.png"  border="0" class="logo-img"/></a>
						<span style="float: right; margin-top: -55px; color: #ffffff; font-size:20px;">REGISTRATION PRE-SELECTION SOLUTION</span>
                    </div>
				<div class="right">
					<div class="align-right">
					</div>
				</div>
			</div>
			<div id="nav"></div>		
		</div>
