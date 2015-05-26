<?php
class Spsconfig extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	//save sps config set by admin
	function adminAddSpsConfig(){
		$startDate = date("Y-m-d" ,strtotime($_POST['fromSPS']));
		$endDate = date("Y-m-d" ,strtotime($_POST['toSPS']));
		$currentDateTime = date("Y-m-d H:i:s");
				if ($result = mysqli_query($this->connrps, "INSERT INTO sps_config(sps_start_date, sps_end_date, date_add, date_update) VALUES ('".Base::cleanText($startDate)."', '".Base::cleanText($endDate)."', '".$currentDateTime."', '".$currentDateTime."');")) {
   					$message="Configuration has been saved successfully";
					$_SESSION['succ_msg'] = $message;
					return 1;
				}else{
					$message="Cannot save the configuration";
					$_SESSION['error_msg'] = $message;
					return 0;
				}
	}
	//update sps config set by admin
	function adminUpdateSpsConfig(){
		$startDate = date("Y-m-d" ,strtotime($_POST['fromSPS']));
		$endDate = date("Y-m-d" ,strtotime($_POST['toSPS']));
		$currentDateTime = date("Y-m-d H:i:s");
			if ($result = mysqli_query($this->connrps, "Update sps_config set sps_start_date = '".Base::cleanText($_POST['fromSPS'])."',sps_end_date = '".Base::cleanText($_POST['toSPS'])."', date_update = '".date("Y-m-d H:i:s")."' where id='".$_POST['spsConfigId']."'")) {
				$message="Configuration has been updated successfully";
				$_SESSION['succ_msg'] = $message;
				return 1;
			}else{
				$message="Cannot update the configuration";
				$_SESSION['error_msg'] = $message;
				header('Location: sps_config.php?edit='.base64_encode($_POST['spsConfigId']));
				return 0;
			}
	}
	/*function for listing configurations*/
	public function getAllConfig() {
			$conf_query="select * from sps_config order by id ASC";
			$q_res = mysqli_query($this->connrps, $conf_query);
			return $q_res;
	}
	public function getDataByConfID($id) {
			$conf_query_get="select * from sps_config where id= $id";
			$q_res = mysqli_query($this->connrps, $conf_query_get);
			return $q_res;
	}
	
}
