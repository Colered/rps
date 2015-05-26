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
}
