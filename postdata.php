<?php
require_once('config.php');
if (isset($_POST['form_action']) && $_POST['form_action']!=""){
	$formPost = $_POST['form_action'];
	switch ($formPost) {
		case 'adminLogin':
			//conditions for user login
			if($_POST['txtUName']!="" && $_POST['txtPwd']!="" ){
				$obj = new Users();
				$resp = $obj->userLogin();
				$location = ($resp == 1) ? "admin/dashboard.php" : "admin/index.php";
				header('Location: '.$location);
			}else{
				$message="Please enter username and password";
				$_SESSION['error_msg'] = $message;
				header('Location: admin/index.php');
			}
		break;	
		case "adminChangePwd":
		 if(isset($_POST['currentPassword']) && $_POST['currentPassword']!=""){
			 $obj = new Users();
			 $resp = $obj->changePwd();
			 if($resp){
			 	session_destroy();
				session_start();
				$message= "New password has been updated successfully";
				$_SESSION['succ_msg'] = $message;
			 	header('Location: admin/index.php');
			 }else{
			 	header('Location: admin/change_password.php');
			 }
		}
		break;
		case "forgotPwd":
		 if(isset($_POST['email']) && $_POST['email']!=""){
			 $obj = new Users();
			 $resp = $obj->forgotPwd();
			 header('Location: admin/forgot.php');
		}else{
				$message="Please enter email";
				$_SESSION['error_msg'] = $message;
				header('Location: admin/forgot.php');
		}
		break;
		case 'StuLogin':
			//conditions for student login
			if($_POST['txtUName']!="" && $_POST['txtPwd']!="" ){
				$obj = new Users();
				$resp = $obj->stuUserLogin();
				$location = ($resp == 1) ? "dashboard.php" : "index.php";
				header('Location: '.$location);
			}else{
				$message="Please enter username and password";
				$_SESSION['error_msg'] = $message;
				header('Location: index.php');
			}
		break;	
		case "changeStuPwd":
		 if(isset($_POST['currentPassword']) && $_POST['currentPassword']!=""){
			 $obj = new Users();
			 $resp = $obj->changeStuPwd();
			 if($resp){
			 	session_destroy();
				session_start();
				$message= "New password has been updated successfully";
				$_SESSION['succ_msg'] = $message;
			 	header('Location: index.php');
			 }else{
			 	header('Location: change_password.php');
			 }
		}
		break;
		case "spsConfig":
		 if((isset($_POST['fromSPS']) && $_POST['fromSPS']!="") && (isset($_POST['toSPS']) && $_POST['toSPS']!="")){
			 $obj = new Spsconfig();
			 if(isset($_POST['spsConfigId']) && $_POST['spsConfigId']!=''){
					//update new building
					$resp = $obj->adminUpdateSpsConfig();
					$message= "configuration has been updated successfully";
				}else{
					//add new building
					$resp = $obj->adminAddSpsConfig();
					$message= "configuration has been saved successfully";
			}
			 if($resp==0){
					//return back data to the form
					echo "<html><head></head><body>";
					echo "<form name='sps_config' method='post' action='sps_config.php'>";
					reset($_POST);
					while(list($iname,$ival) = each($_POST)) {
						echo "<input type='hidden' name='$iname' value='$ival'>";
					}
					echo "</form>";
					echo "</body></html>";
					echo"<script language='JavaScript'>function submit_back(){ window.document.sps_config.submit();}submit_back();</script>";
					
					$message="Please enter email";
					$_SESSION['error_msg'] = $message;
					exit();
					//end return back
			}else{
				$_SESSION['succ_msg'] = $message;
			 	header('Location: admin/sps_config_view.php');
				exit();
			}
		}
		break;
	}
}
?>