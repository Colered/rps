<?php
class Fedena extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	//getting the student subject of a current semester
	function getCurrentStuSemSub(){
		$uesr_id=$_SESSION['std_id'];
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
	function getAllSubjects()
	{
		$sql="select distinct eg.name as grp_name,eg.id from subjects s
			  inner join elective_groups eg on eg.id = s.elective_group_id
			  where s.batch_id = '".$_SESSION['batch_id']."' and s.school_id='".$_SESSION['school_id']."' and s.is_deleted='0' ";
		$qry_rslt= mysqli_query($this->connfed,$sql);
		$subjects = array();
		if(mysqli_num_rows($qry_rslt)>0){			
			while($row = mysqli_fetch_array($qry_rslt))
			{
				 $sql_sub = "select s.id,s.name as sub_name,s.code from subjects s where elective_group_id = '".$row['id']."' and s.school_id='".$_SESSION['school_id']."' and s.is_deleted='0' and s.batch_id = '".$_SESSION['batch_id']."'";
				 $qry_rslt_sub= mysqli_query($this->connfed,$sql_sub);
				 if(mysqli_num_rows($qry_rslt_sub)>0)
				 {
					 while($row_sub = mysqli_fetch_array($qry_rslt_sub))
					 {
						 $subjects[$row['id']]['name'] = trim($row['grp_name']); 
						 $subjects[$row['id']]['subjects'][$row_sub['code']] = trim($row_sub['sub_name']);
					 }
				 }
			}
			return $subjects;
		}
	}
	function getAllCourses()
	{
		$sql="select id,course_name,code,section_name from courses where school_id='".$_SESSION['school_id']."' and is_deleted='0' ";
		$q_res = mysqli_query($this->connfed, $sql);
		return $q_res;
	}
	function getAllBatches($course_id)
	{
		$sql="select id,name from batches where course_id = '".$course_id."' and school_id='".$_SESSION['school_id']."' and is_deleted='0' and is_active='1' ";
		$q_res = mysqli_query($this->connfed, $sql);
		return $q_res;
	}
	function getSubjectList($batch_id)
	{
		$sql = "select id,name from elective_groups where batch_id='".$batch_id."' and school_id='".$_SESSION['school_id']."' and is_deleted='0'";
		$q_res = mysqli_query($this->connfed, $sql);
		return $q_res;
	}
	function getCourseName()
	{
		$sql = "select course_name from courses where id='".$_SESSION['course_id']."'";
		$q_res = mysqli_query($this->connfed, $sql);
		$row = mysqli_fetch_array($q_res);
		return $row['course_name'];
	}
	function getAllSubjectsDetails()
	{
		$sql="select distinct eg.name as grp_name,eg.id from subjects s
			  inner join elective_groups eg on eg.id = s.elective_group_id
			  where s.batch_id = '".$_SESSION['batch_id']."' and s.school_id='".$_SESSION['school_id']."' and s.is_deleted='0' ";
		$qry_rslt= mysqli_query($this->connfed,$sql);
		$subjects = array();
		if(mysqli_num_rows($qry_rslt)>0){			
			while($row = mysqli_fetch_array($qry_rslt))
			{
				 $sql_sub = "select s.id,s.name as sub_name,s.code,s.max_weekly_classes,s.credit_hours,s.amount,s.no_exams from subjects s where elective_group_id = '".$row['id']."' and s.school_id='".$_SESSION['school_id']."' and s.is_deleted='0' and s.batch_id = '".$_SESSION['batch_id']."'";
				 $qry_rslt_sub= mysqli_query($this->connfed,$sql_sub);
				 if(mysqli_num_rows($qry_rslt_sub)>0)
				 {
					 while($row_sub = mysqli_fetch_array($qry_rslt_sub))
					 {
						 $subjects[$row['id']]['name'] = trim($row['grp_name']); 
						 $subjects[$row['id']]['subjects'][$row_sub['code']]['name'] = trim($row_sub['sub_name']);
						 $subjects[$row['id']]['subjects'][$row_sub['code']]['max_weekly_classes'] = trim($row_sub['max_weekly_classes']);
						 $subjects[$row['id']]['subjects'][$row_sub['code']]['credit_hours'] = trim($row_sub['credit_hours']);
						 $subjects[$row['id']]['subjects'][$row_sub['code']]['amount'] = trim($row_sub['amount']);
						 $subjects[$row['id']]['subjects'][$row_sub['code']]['no_exams'] = trim($row_sub['no_exams']);
					 }
				 }
			}
			return $subjects;
		}
	}
	function getSubjects($course_id='')
	{
		$sql="select s.id as sub_id,s.name,s.code,s.batch_id,eg.name as subject_group_name,eg.id as sub_grp_id,b.name as batch_name from subjects s left join elective_groups eg on eg.id = s.elective_group_id left join batches b on b.id=s.batch_id where s.school_id='".$_SESSION['school_id']."' and s.is_deleted='0' and s.elective_group_id!=''";
		if($course_id!='')
		{
			$sql .= "and b.course_id='".$course_id."'";
		}
		$sql .= "order by s.name";
		//echo $sql;die;
		$q_res = mysqli_query($this->connfed, $sql);
		return $q_res;
	}
	
}
