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
		<script src="js/jquery-1.10.2.js"></script>
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
                        <a href="index.php"><img src="images/logo.png"  border="0" class="logo-img"/></a>
						<div class="header-title">REGISTRATION PRE-SELECTION SOLUTION</div>
                    </div>
                    <div class="right">
                        <div class="align-right" style="color: #ffffff;">
						Welcome <B> <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){ 
											$objU = new Users();
											$user_name = $objU->getStuUname($_SESSION['user_id']);
											echo ucfirst($user_name['username']);
										} ?>
									  </B>
						
                        </div>
                    </div>
                </div>
			 </div>
                <div id="nav">
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){ $urlData = explode("/",$_SERVER['PHP_SELF']); ?>
					<ul>
						<li class="upp <?php if(isset($urlData[2]) && $urlData[2]=='dashboard.php'){ echo "selected"; } ?>"><a href="dashboard.php">Dashboard</a></li>
						<li class="upp <?php if(isset($urlData[2]) && $urlData[2]=='subject-pre-selection.php'){ echo "selected"; } ?>"><a href="subject-pre-selection.php">Subject PRE-SELECTION</a></li>
						<li class="upp <?php if(isset($urlData[2]) && $urlData[2]=='reports.php'){ echo "selected"; } ?>"><a href="reports.php">Reports</a></li>					
						<li class="upp right"  style="float:right"><a href="logout.php">Logout</a></li>						
						<li class="upp right <?php if(isset($urlData[2]) && $urlData[2]=='change_password.php'){ echo "selected"; } ?>"  style="float:right"><a href="change_password.php">Change Password</a></li>		
                    </ul>
					<?php } ?>
					</div>
           

