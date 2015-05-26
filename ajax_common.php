<?php
require_once('config.php');
function RexExpFormat($str)
{
	 $TempStr="";
	 $tempId=explode(",",$str);
	 for($i=0;$i<count($tempId);$i++)
	 {
		$TempStr=$TempStr."[[:<:]]".$tempId[$i]."[[:>:]]"."|";
	 }
	 if ($TempStr<>"")
	 {
		$TempStr=substr($TempStr,0,strlen($TempStr)-1);
	 }
	 return $TempStr;
}
$options = '';
$codeBlock = trim($_POST['codeBlock']);
switch ($codeBlock) {
		case "del_conf":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$query = "select id from sps_config where id = '".$id."'";
			$q_res = mysqli_query($db_RPS, $query);
			if(mysqli_affected_rows($db_RPS)>0){
				// then delete the config
				$del_buld_query="delete from sps_config where id='".$id."'";
				$qry = mysqli_query($db_RPS, $del_buld_query);
				echo 1;
			}else{
				echo 0;
			}
		}
		break;
}
?>