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
		case "add_subject_group":
			if((isset($_POST['career']) && $_POST['career']!="") && (isset($_POST['subject']) && $_POST['subject']!="") && (isset($_POST['max_students']) && $_POST['max_students']!="") && (isset($_POST['min_students']) && $_POST['min_students']!="") && (isset($_POST['credits']) && $_POST['credits']!="") && (isset($_POST['subject_cost']) && $_POST['subject_cost']!="")){
				$obj = new SubjectPreRequistie();
				$obj->savePreRequistie();				
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: index.php');
			}
			break;
		case "add_subject":
			if((isset($_POST['career']) && $_POST['career']!="") && (isset($_POST['batch']) && $_POST['batch']!="") && (isset($_POST['subject_grp']) && $_POST['subject_grp']!="") && (isset($_POST['subject']) && $_POST['subject']!="") && (isset($_POST['max_students']) && $_POST['max_students']!="") && (isset($_POST['min_students']) && $_POST['min_students']!="") && (isset($_POST['subject_cost']) && $_POST['subject_cost']!="")){
				$obj = new Prerequistie();
				$obj->savePreRequistie();
				 header('Location: admin/subjects_view.php');
			}else{
				$message="Please enter all required fields";
				$_SESSION['error_msg'] = $message;
				header('Location: admin/subjects.php');
			}
			break;
		
	}
}
?>