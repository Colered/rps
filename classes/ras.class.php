<?php
class RAS extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	public function matchSubject($name)
	{
		$sql = "select * from timetable_detail td
				inner join subject s on td.subject_id = s.id
				where s.subject_name = '".$name."'";
		$qry_rslt= mysqli_query($this->connras,$sql);		
		if(mysqli_num_rows($qry_rslt)>0){
			return 1;
		}
	}
	public function getRulesofSubject($name,$course_name)
	{
		$sql = "select distinct srm.subject_rule_id, sr.rule_name from subject_rule_mapping srm inner join subject_session ss on ss.id = srm.session_id inner join subject s on ss.subject_id = s.id inner join subject_rule sr on sr.id = srm.subject_rule_id inner join program_years py on py.id = s.program_year_id inner join cycle c on c.program_year_id = py.id where s.subject_name = '".$name."' and py.name like '".trim($course_name)."%' and c.start_week='".$_SESSION['start_date']."' and c.end_week='".$_SESSION['end_date']."'";		
		$qry_rslt= mysqli_query($this->connras,$sql);
		return $qry_rslt;
	}
	public function checkTimetable($rule_id)
	{
		$sql = "select td.* from subject_rule_mapping srm 
				inner join timetable_detail td on td.session_id = srm.session_id where srm.subject_rule_id= '".$rule_id."'";
		$qry_rslt= mysqli_query($this->connras,$sql);
		if(mysqli_num_rows($qry_rslt)>0){
			return 1;
		}		
	}	
	//getting the detail of subject of a student
	public function subDetailFromRAS($sub_id)
	{
		$sql = "select td.id,DATE_FORMAT(td.date,'%Y%m%d'),td.timeslot,t.teacher_name,tt.teacher_type_name,py.name program_year_name,p.company,u.name as unit,t.payrate,s.session_name,a.area_name,su.subject_name,s.case_number,s.technical_notes,r.room_name,sr.rule_name,sr.start_date,sr.end_date from timetable_detail td 
		left join teacher t on t.id = td.teacher_id 
		left join subject su on su.id = td.subject_id 
		left join program_years py on py.id = td.program_year_id 
		left join program p on p.id = py.program_id 
		left join unit u on u.id = p.unit 
		left join subject_session s on s.id = td.session_id 
		left join subject_rule_mapping srm on srm.session_id = td.session_id
		left join subject_rule sr on sr.id = srm.subject_rule_id
		left join area a on a.id = su.area_id 
		left join room r on r.id = td.room_id 
		left join teacher_type tt on tt.id = t.teacher_type 
		where td.subject_id='".$sub_id."'";
		$data=array();
		$qry_rslt= mysqli_query($this->connras,$sql);		
		if(mysqli_num_rows($qry_rslt)>0){
			while($row=$qry_rslt->fetch_assoc()){
				$data[]=$row;
			}
		}
		return 	$data;
	}
	//getting the subject detail of a program 
	public function getProgramSub(){
	  $obj_fed=new Fedena();
	  $course_name=$obj_fed->getCourseName();
	  $sql = "select pg.id ,py.id as prgm_year_id from program pg inner join program_years py on py.program_id = pg.id where pg.program_name='".trim($course_name)."'";
	  $q_res = mysqli_query($this->connras, $sql);
	  if(mysqli_num_rows($q_res)>0){
		while($data=$q_res->fetch_assoc()){
			$prgm_year_ids[]=$data['prgm_year_id'];
		}
		$pgrm_year_id=implode(',',$prgm_year_ids);
		$sql_sub = "select id as ras_subject_id,program_year_id,subject_name,subject_code,cycle_no as cycle_id from subject where program_year_id IN ($pgrm_year_id)"; 
		$q_res1 = mysqli_query($this->connras, $sql_sub);
		while($data1=$q_res1->fetch_assoc()){
			$subject_name[]=$data1;
		}
		return $subject_name;
	  }else{
	  	return 0;
	  }
	 }
    //getting all subject of a rule to a student
	public function ruleAllSubject($subRuleId,$subject_name){
		$sql="SELECT session_id	 FROM  subject_rule_mapping where subject_rule_id='".$subRuleId."'";
		$q_res = mysqli_query($this->connras, $sql);	  
	    if(mysqli_num_rows($q_res)>0){
			while($data=$q_res->fetch_assoc()){
				$session_id[]=$data['session_id'];
			}
			$session_id=implode(',',$session_id);	
			$sql_sub = "select s.id as ras_sub_id ,s.subject_name  from subject s inner join subject_session ss   where ss.id IN ($session_id) and s.subject_name='".$subject_name."' group by  s.id" ;
			$q_res1 = mysqli_query($this->connras, $sql_sub);
			while($data1=$q_res1->fetch_assoc()){
				$subject_id_arr[]=$data1['ras_sub_id'];
			}
			return $subject_id_arr;   
	    }else{
			return 0;
		}
		
	 }
	 //getting all subject of a rule to a student
	public function reportStuSubject(){
	    //echo '<pre>';
		$sql="SELECT subject_group_id,associated_rules_ids FROM subjects_preselect where select_status='1'";
		$all_record=array();
		$q_res = mysqli_query($this->connrps, $sql);	
		if(mysqli_num_rows($q_res)>0){
			while($data=$q_res->fetch_assoc()){
			   $subject_record=$this->stuSubRasData($data['subject_group_id'],$data['associated_rules_ids'],'');
			   $all_record=array_merge($all_record,$subject_record);
			}
	    }
		return $all_record;
		
	 }
	 public function stuSubRasData($subGrpId,$subRuleId,$subject_filter_id){
	 	    $events=$sub_data=array();
			if($subRuleId !="" && $subGrpId!=''){
				$obj_fedena=new Fedena();
				$obj_ras=new RAS();
				$student_subjects=$obj_fedena->getCurrentStuSemSub();
				$course_name = $obj_fedena->getCourseName();
				$all_subjects = $obj_fedena->getAllSubjectsDetails();
				foreach($all_subjects as $subgrp_id=>$subgrp_detail ){
					if($subgrp_id==$subGrpId){
						$sub_cnt =  count($subgrp_detail['subjects']);
						if($sub_cnt>0){
							foreach($subgrp_detail['subjects'] as $sub_code=>$sub_detail){
								if(!$obj_fedena->search_array($sub_detail['name'],$student_subjects)){
									$sub_ids=$obj_ras->ruleAllSubject($subRuleId,$sub_detail['name']);
									$rowNewArr=array(array());$row=array();
									$row = $obj_ras->subDetailFromRAS($sub_ids[0]);
									  if(count($row)>0){
											for($i=0;$i<count($row);$i++){
												  $j=0;
												  foreach($row[$i] as $key=>$val){
												  $rowNewArr[$i][$j]=$val;
												  $j++;
												}
											}
										}
									$rows=$rowNewArr;
									$events=array_merge($events,$rows);
								}
							}
						}	
					}
				}
			}
			return $events;
	 }
	
}

	
