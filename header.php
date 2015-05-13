<?php
require_once('config.php');
if($_SERVER['REQUEST_URI']=='/rps/admin/forgot.php' || $_SERVER['REQUEST_URI']=='/admin/forgot.php'){
		//Do Nothing
}elseif(!isset($_SESSION['user_id'])){
		header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>SUBJECT PRE-SELECTION MODULE</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/navi.css" media="screen" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="js/jquery-ui.css">
        <script src="js/jquery-1.10.2.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/jquery.validate.js"></script>
		<?php $pos = strpos($_SERVER['SCRIPT_NAME'], 'programs_clone-1');
		if ($pos === false) {?>		
		<script src="js/common.js"></script>
		<?php } else{?>
		<script src="js/common_new.js"></script>
		<?php } ?>
		<script type="text/javascript" src="js/jquery.tablednd.0.7.min.js"></script>
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
                        <a href="index.php"><img src="images/logo.png"  border="0" class="logo-img"/></a>
						<span style="float: right; margin-top: -55px; color: #ffffff; font-size:20px;">REGISTRATION PRE-SELECTION SOLUTION</span>
                    </div>
                    <div class="right">
                        <div class="align-right" style="color: #ffffff;">
						Welcome <B> <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){ 
											$objU = new Users();
											$user_name = $objU->getUserName($_SESSION['user_id']);
											echo ucfirst($user_name['username']);
										} ?>
									  </B>
						
                        </div>
                    </div>
                </div>
			 </div>
                <div id="nav">
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){ ?>
					<ul>
						<li class="upp"><a href="dashboard.php">Dashboard</a></li>
						<li class="upp"><a href="#">Subject PRE-SELECTION</a></li>
						<li class="upp"><a href="#">Reports</a></li>					
						<li class="upp right"  style="float:right"><a href="logout.php">Logout</a></li>						
						<li class="upp right"  style="float:right"><a href="change_password.php">Change Password</a></li>		
                    </ul>
					<?php } ?>
					</div>
           

