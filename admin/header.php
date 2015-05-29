<?php
require_once('../config.php');
if($_SERVER['REQUEST_URI']=='/rps/admin/forgot.php' || $_SERVER['REQUEST_URI']=='/admin/forgot.php'){
		//Do Nothing
}elseif(!isset($_SESSION['user_id'])){
		header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>Admin - REGISTRATION PRE-SELECTION SOLUTION (RPS)</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/navi.css" media="screen" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="../js/jquery-ui.css">
		<script src="../js/jquery-1.10.2.js"></script>
		<script src="../js/jquery-ui.js"></script>
		<script src="../js/jquery.validate.js"></script>
		<script src="../js/common.js"></script>
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
						<div class="header-title">ADMINISTRATION PANEL RPS</div>
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
					<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){ $urlData = explode("admin/",$_SERVER['PHP_SELF']);?>
					<ul>
						<li class="upp <?php if(isset($urlData[1]) && $urlData[1]=='dashboard.php'){ echo "selected"; } ?>"><a href="dashboard.php">Dashboard</a></li>
						<!--<li class="upp <?php if(isset($urlData[1]) && $urlData[1]=='subject_group_creation.php'){ echo "selected"; } ?>"><a href="subject_group_creation.php">Subject Groups Creation</a></li>
						<li class="upp <?php if(isset($urlData[1]) && $urlData[1]=='add_subject_group_creation.php'){ echo "selected"; } ?>"><a href="add_subject_group_creation.php">Subject Groups Creation1</a></li>-->
						<li class="upp"><a href="#">Subject Prerequisite</a>
							<ul>
								<li <?php if(isset($urlData[1]) && $urlData[1]=='prerequisite_view.php'){ echo "selected"; } ?>"><a href="prerequisite_view.php">View Subject Prerequisite</a></li>
								<li <?php if(isset($urlData[1]) && $urlData[1]=='prerequistie_upload.php'){ echo "selected"; } ?>"><a href="prerequistie_upload.php">Import Subject Prerequisite</a></li>								
							</ul>
						</li>						
						<?php 
							$obj = new Spsconfig();
							$allData = $obj->getAllConfig();
							$allDataRows = $allData->fetch_assoc();
							if(isset($allDataRows['id']) && $allDataRows['id'] !="" )
							{
								$link = "sps_config_view.php";
							}else{
								$link = "sps_config.php";
							}
						?>
						<li class="upp <?php if(isset($urlData[1]) && ($urlData[1]=='sps_config_view.php' || $urlData[1]=='sps_config.php')){ echo "selected"; } ?>"><a href="<?php echo $link ?>">Manage SPS Config</a></li>
						<li class="upp <?php if(isset($urlData[1]) && $urlData[1]=='reports.php'){ echo "selected"; } ?>"><a href="reports.php">Reports</a></li>					
						<li class="upp right"  style="float:right"><a href="../logout.php">Logout</a></li>						
						<li class="upp right <?php if(isset($urlData[1]) && $urlData[1]=='change_password.php'){ echo "selected"; } ?>"  style="float:right"><a href="change_password.php">Change Password</a></li>		
                    </ul>
					<?php } ?>
					</div>
           

