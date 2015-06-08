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
}

	
