<?php
class Prerequistie extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	public function savePreRequistie()
	{
		if(isset($_POST) && $_POST != "")
		{
			//print"<pre>";print_r($_POST);die;
			$career = explode("-",$_POST['career']);
			$batch = explode("-",$_POST['batch']);
			$subject_grp = explode("-",$_POST['subject_grp']);
			$subject = explode("-",$_POST['subject']);
			$sql = "INSERT INTO subjects(subject_id,name,course_id,course_name,batch_id,batch_name,subject_group_id,subject_group_name,max_students,min_students,subject_cost) values('".$subject[0]."','".$subject[1]."','".$career[0]."','".$career[1]."','".$batch[0]."','".$batch[1]."','".$subject_grp[0]."','".$subject_grp[1]."','".$_POST['max_students']."','".$_POST['min_students']."','".$_POST['subject_cost']."')";
			if($q_res = mysqli_query($this->connrps, $sql))
				return 1;
		}
	}
	public function getPreRequistie()
	{
		$sql = "select * from subjects_prerequistie";
		$q_res = mysqli_query($this->connrps, $sql);
		return $q_res;
	}
	public function getAllPreRequistie($sub_id,$batch_id)
	{
		$sql = "select required_subject_id,required_subject_name from subjects_prerequistie where batch_id='".$batch_id."' and school_id='".$_SESSION['school_id']."' and status='1' and subject_id='".$sub_id."'";
		$q_res = mysqli_query($this->connrps, $sql);
		if(mysqli_num_rows($q_res)>=0)
		{
			$row = mysqli_fetch_array($q_res);
			return $row['required_subject_name'];
		}
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
	public function getSubGrpStatus($subject_id,$rule_id)
	{
		$sql = "select select_status from subjects_preselect where subject_group_id = '".$subject_id."' and associated_rules_ids='".$rule_id."'";
		$q_res = mysqli_query($this->connrps, $sql);
		if(mysqli_num_rows($q_res)>=0)
		{
			$row = mysqli_fetch_array($q_res);
			return $row['select_status'];
		}
	}
	public function getSubGrp($subject_id)
	{
		$sql = "select * from subjects_preselect where select_status='1'";
		$q_res = mysqli_query($this->connrps, $sql);
		return $q_res;
	}
	public function getPreSelectedSub($sub_grp_id)
	{
		$sql = "select count( distinct std_id) as total from subjects_preselect where subject_group_id='".$sub_grp_id."' and select_status = '1'";
		$q_res = mysqli_query($this->connrps, $sql);
		$row = mysqli_fetch_assoc($q_res);
		return $row['total'];
	}
	public function getSeats($sub_id,$batch_id)
	{
		$sql = "select max_students,cost from subjects_prerequistie where batch_id='".$batch_id."' and subject_id='".$sub_id."' and status = '1' and school_id='".$_SESSION['school_id']."'";
		$q_res = mysqli_query($this->connrps, $sql);
		return $q_res;
	}
	public function getSubjects()
	{
		$sql = "select * from subjects";
		$q_res = mysqli_query($this->connrps, $sql);
		return $q_res;
	}
}
