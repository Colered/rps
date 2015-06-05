<?php
class Prerequistie extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	public function savePreRequistie()
	{
		if(isset($_POST) && $_POST != "")
		{
		//	$sql = "INSERT INTO subjects_prerequistie(course_name,course_code,subject_name,subject_code,required_subject_name,required_subject_code,max_students,min_students,credits,cost) values()";
		}
	}
	public function getPreRequistie()
	{
		$sql = "select * from subjects_prerequistie";
		$q_res = mysqli_query($this->connrps, $sql);
		return $q_res;
	}
	function getrequistie($subCode)
	{
		$sql = "select required_subject_id,required_subject_code from subjects_prerequistie where batch_id='".$_SESSION['batch_id']."' and school_id='".$_SESSION['school_id']."' and status='1' and subject_code='".$subCode."'";
		$q_res = mysqli_query($this->connrps, $sql);
		if(mysqli_num_rows($q_res)>=0)
		{
			$row = mysqli_fetch_array($q_res);
			return $row['required_subject_code'];
		}
	}		
}
