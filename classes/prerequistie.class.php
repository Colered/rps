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
		
}
