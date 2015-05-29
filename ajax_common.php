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
				if(mysqli_affected_rows($db_RPS)>0){file:///C:/Users/deepali.kakkar.IBTS/Downloads/subjects_prerequistie.sql
					// then delete the config
					$del_buld_query="delete from sps_config where id='".$id."'";
					$qry = mysqli_query($db_RPS, $del_buld_query);
					echo 1;
				}else{
					echo 0;
				}
			}
		break;
		case "getSubjects":
			if(isset($_POST['course'])){
				$eg_arr = array();
				$course_data = explode("#",$_POST['course']);
				$course_code = $course_data['0'];
				$sql = "select DISTINCT eg.* from elective_groups eg inner join batches b on b.id = eg.batch_id inner join courses c on c.id = b.course_id where c.code='".$course_code."'";
				if($_POST['id'] != "")
				{
					$sql .= "and eg.id != '".$_POST['id']."'"; 
				}
				$q_res = mysqli_query($db_FED, $sql);				
				if(mysqli_affected_rows($db_FED)>0){
					$options .='<option value="">--Select--</option>';
					while($subject_data= mysqli_fetch_array($q_res)){
						$options .='<option value="'.$subject_data['id'].'">'.$subject_data['name'].'</option>';
					}					
				}			
			}
			echo $options;
			break;
		case "updatePrerequistie":
			if(isset($_POST['Id']) && isset($_POST['maxStudents']) && isset($_POST['minStudents']))
			{
				$make_arr = array();
				$rowId_arr = (isset($_POST['Id'])) ? $_POST['Id'] : '';
				$maxStudents_arr = (isset($_POST['maxStudents'])) ? $_POST['maxStudents'] : '';
				$minStudents_arr = (isset($_POST['minStudents'])) ? $_POST['minStudents'] : '';
				for($i=0;$i<count($rowId_arr);$i++){
					    $make_arr[$i]['row_id']=$rowId_arr[$i];
						$make_arr[$i]['max_students']=$maxStudents_arr[$i];
						$make_arr[$i]['min_students']=$minStudents_arr[$i];						
					}
				for($i=0;$i<count($make_arr);$i++){
					$sql = "update subjects_prerequistie set max_students = '".$make_arr[$i]['max_students']."' ,
															 min_students = '".$make_arr[$i]['min_students']."'
														 where id = '".$make_arr[$i]['row_id']."'";
					$q_res = mysqli_query($db_RPS, $sql);
				}
				echo 1;
			}else
			{
				echo 0;
			}
		break;
		case "set_requistie_status":
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$sql_slct="select status from  subjects_prerequistie where id='".$id ."'";
			$qry = mysqli_query($db_RPS, $sql_slct);
			$data = mysqli_fetch_assoc($qry);
			$status='';
			if(count($data)>0){
				if($data['status']==1){
					$status="0";
				}else{
					$status="1";
				}
				$update="Update subjects_prerequistie Set status = '".$status."' where id='".$id."'";
				$qry_update = mysqli_query($db_RPS, $update);
			}
			echo $status;
		}
	break;
}
?>