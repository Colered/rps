<?php
class Fedena extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	//getting the student subject of a current semester
	function getCurrentStuSemSub(){
		$uesr_id=$_SESSION['user_id'];
		$sub_name_arr=$stu_sub_arr=array();
		$sql="select id,admission_no,batch_id,school_id from  students where user_id='".$uesr_id."' and school_id='".$_SESSION['school_id']."' and is_active='1' ";
		$qry_rslt= mysqli_query($this->connfed,$sql);
		$std_array=array();
		if(mysqli_num_rows($qry_rslt)>0){
			while($row=mysqli_fetch_array($qry_rslt)){
			 	$std_array['stu_id']=$row['id'];
				$std_array['stu_admission_no']=$row['admission_no'];
				$std_array['stu_batch_id']=$row['batch_id'];
				$std_array['stu_school_id']=$row['school_id'];
			}
		 $sql_stu_sub="select id as student_subject_id,subject_id from  students_subjects where student_id ='".$std_array['stu_id']."' and batch_id='".$std_array['stu_batch_id']."' and school_id='".$std_array['stu_school_id']."'";
		 //$sql_stu_sub="select id as student_subject_id,subject_id from  students_subjects where student_id ='28840' and batch_id='4872' and school_id='184'";
		 $stu_sub_rslt= mysqli_query($this->connfed,$sql_stu_sub);	
		 if(mysqli_num_rows($stu_sub_rslt)> 0){
		 	while($data=mysqli_fetch_array($stu_sub_rslt)){
				$stu_sub_arr[]= $data['subject_id'];
			}
		  if(count($stu_sub_arr)>0){
		  	$subject_id_str=implode(',',$stu_sub_arr);
		  	$sql_sub_query="SELECT su.name,su.code,eg.name as elective_grp ,su.max_weekly_classes,su.credit_hours,su.amount,su.no_exams  FROM subjects su LEFT JOIN  elective_groups eg ON su.elective_group_id = eg.id WHERE su.id IN($subject_id_str)";
			$sql_sub_rslt= mysqli_query($this->connfed,$sql_sub_query);
			while($sub_data=mysqli_fetch_assoc($sql_sub_rslt)){
				$sub_name_arr[$sub_data['elective_grp']][]= $sub_data;
			}
		  }	
			return $sub_name_arr;
		 }
		}else{
		  $message= "No student found with user credential";
		  $_SESSION['error_msg'] = $message;
		}
	}
	function getStudentCourse()
	{
		$sql="select course_name 
			  from courses c inner join batches b on b.course_id = c.id
			  inner join students s on s.batch_id = b.id where s.user_id='".$_SESSION['user_id']."' and s.school_id='".$_SESSION['school_id']."' and s.is_active='1' and b.is_active='1' and b.is_deleted='0' and c.is_deleted='0' and s.is_deleted='0'";
		$qry_rslt= mysqli_query($this->connfed,$sql);		
		if(mysqli_num_rows($qry_rslt)>0){
			$row = mysqli_fetch_array($qry_rslt);
			return $row['course_name'];
		}
	}
	function getAllSubjects()
	{
		$sql="select distinct eg.name from subjects s
			  inner join elective_groups eg on eg.id = s.elective_group_id
			  where s.batch_id = '".$_SESSION['batch_id']."' and s.school_id='".$_SESSION['school_id']."' and s.is_deleted='0' ";
		$qry_rslt= mysqli_query($this->connfed,$sql);		
		if(mysqli_num_rows($qry_rslt)>0){
			$subjects = array();
			while($row = mysqli_fetch_array($qry_rslt))
			{
				$subjects[] = trim($row['name']);

			}
			return $subjects;
		}
	}
}
