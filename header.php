<?php
//echo "'http://".$_SERVER['SERVER_NAME']."/rps/config.php'";
$calender = strpos($_SERVER['SCRIPT_NAME'], 'web_calendar_rps');
if ($calender == true) {	
	require_once('../config.php');
}else{
	require_once('config.php');
}
if($_SERVER['REQUEST_URI']==SERVER_URL.'admin/forgot.php' || $_SERVER['REQUEST_URI']==SERVER_URL.'admin/forgot.php'){
		//Do Nothing
}elseif(!isset($_SESSION['std_id'])){
		unset($_SESSION['std_id']);
		header('Location: index.php');
		
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>SUBJECT PRE-SELECTION MODULE</title>
		<?php if ($calender == true) {	?>
        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_URL; ?>css/style-cal.css" media="screen" />
		<?php }else{ ?>
        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_URL; ?>css/style.css" media="screen" />
		<?php }?>
		
        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_URL; ?>css/navi.css" media="screen" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="<?php echo SERVER_URL; ?>image/x-icon">
		<link rel="stylesheet" href="<?php echo SERVER_URL; ?>js/jquery-ui.css">
		<script src="<?php echo SERVER_URL; ?>js/jquery-1.10.2.js"></script>
		<script src="<?php echo SERVER_URL; ?>js/jquery-ui.js"></script>
		<script src="<?php echo SERVER_URL; ?>js/jquery.validate.js"></script>
		<script src="<?php echo SERVER_URL; ?>js/common.js"></script>
		<?php $pos = strpos($_SERVER['SCRIPT_NAME'], 'dashboard');
		 if ($pos == true) {?>	
			<script type='text/javascript' src='<?php echo SERVER_URL; ?>js/jquery.simplemodal.js'></script> 
		<?php }?>
		<?php $pos = strpos($_SERVER['SCRIPT_NAME'], 'subject_pre_selection');
		 if ($pos == true) {?>	
			<script type='text/javascript' src='js/jquery.simplemodal.js'></script> 
		<?php }?>
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
                        <a href="<?php echo SERVER_URL; ?>index.php"><img src="<?php echo SERVER_URL; ?>images/logo.png"  border="0" class="logo-img"/></a>
						<div class="header-title">REGISTRATION PRE-SELECTION SOLUTION</div>
                    </div>
                    <div class="right">
                        <div class="align-right" style="color: #ffffff;">
						Welcome <B> <?php if(isset($_SESSION['std_id']) && $_SESSION['std_id']!=""){ 
											$objU = new Users();
											$user_name = $objU->getStuUname($_SESSION['std_id']);
											echo ucfirst($user_name['first_name'])." ".ucfirst($user_name['last_name']);
										} ?>
									  </B>
						
                        </div>
                    </div>
                </div>
			 </div>
                <div id="nav">
                    <?php if(isset($_SESSION['std_id']) && $_SESSION['std_id']!=""){ $urlData = explode("/",$_SERVER['PHP_SELF']); ?>
					<ul>
						<li class="upp <?php if(isset($urlData[2]) && $urlData[2]=='dashboard.php'){ echo "selected"; } ?>"><a href="<?php echo SERVER_URL; ?>dashboard.php">Dashboard</a></li>
						<li class="upp <?php if(isset($urlData[2]) && $urlData[2]=='reports.php'){ echo "selected"; } ?>"><a href="<?php echo SERVER_URL; ?>reports.php">Reports</a></li>					
						<li class="upp right"  style="float:right"><a href="<?php echo SERVER_URL; ?>logout.php">Logout</a></li>						
						<li class="upp right <?php if(isset($urlData[2]) && $urlData[2]=='change_password.php'){ echo "selected"; } ?>"  style="float:right"><a href="<?php echo SERVER_URL; ?>change_password.php">Change Password</a></li>		
                    </ul>
					<?php } ?>
					</div>
           

