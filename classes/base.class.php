<?php
abstract class Base
{
	public $conn;
	public function __construct(){
		global $db;
		$this->conn = $db;
	}

	//function to date format by datetime
	public function formatDate($date)
	{
		if(trim($date) != "") {
			$tempdate=explode(" ",$date);
			$date=$tempdate[0];
			if($date=="0000-00-00") {
				$date="";
			} else  {
				$dateArr = explode("-", $date);
				$year=$dateArr[0];
				$month=$dateArr[1];
				$day=$dateArr[2];
				$date_mktime = mktime(0, 0, 0, $month, $day, $year);
				$date = date("d-m-Y",$date_mktime);
			}
			return $date;
		}

	}
    //function to date format by date
	public function formatDateByDate($date)
	{
		if(trim($date) != "") {
			if($date=="0000-00-00") {
				$date="";
			} else  {
				$dateArr = explode("-", $date);
				$year=$dateArr[0];
				$month=$dateArr[1];
				$day=$dateArr[2];
				$date_mktime = mktime(0, 0, 0, $month, $day, $year);
				$date = date("d-m-Y",$date_mktime);
			}
			return $date;
		}

	}//end of formatDate function

	//function to clean input text
	public static function cleanText($txt){
		$str = strip_tags($txt);
		$str = str_replace("&nbsp;","",$str);
		return trim($str);
	}
	//function to fetch a
	public function getFielldVal($table,$field,$k,$v)
	{
       if($v){
            $field = trim($field);
			$sql = "SELECT $field FROM $table WHERE $k='".$v."' LIMIT 1";
			$result = $this->conn->query($sql);
			$row = $result->fetch_assoc();
			return $row[$field];
	   }else{
			return '';
	   }
	}

	//function to find all weeks in a date range
	public function getWeeksInDateRange($start,$end)
	{
       	$dateOne = $start; $dateTwo = $end;
		$dateStart = $dateOne; $dateEnd = $dateTwo;
		if(strtotime($dateOne)>strtotime($dateTwo)){
			$dateStart = $dateTwo;
			$dateEnd = $dateOne;
		}
		//calculate start week
		while (date('w', strtotime($dateStart)) != 1) {
		  $tmp = strtotime('-1 day', strtotime($dateStart));
		  $dateStart = date('Y-m-d', $tmp);
		}
		$weekStart = intval(date('W', strtotime($dateStart)));
		//calculate end week
		while (date('w', strtotime($dateEnd)) != 1) {
		  $tmp = strtotime('-1 day', strtotime($dateEnd));
		  $dateEnd = date('Y-m-d', $tmp);
		}
		$weekEnd = intval(date('W', strtotime($dateEnd)));
		//prepare array for all weeks coming in the date range
		$allWeeks = array();
		for($i=$weekStart; $i<=$weekEnd; $i++){
			$allWeeks[] = $i;
		}
		return $allWeeks;
	}

	//function to calculate timeslots from start time and duration
	public function getTimeslotsFromTimeDur($duartion,$start_time)
	{
		$noOfslots = $duartion / 15;
		$startTS = $start_time;
		$endTS = $startTS + $noOfslots;
		for ($i = $startTS; $i < $endTS; $i++) {
			$timeslotIdsArray[] = $i;
		}
		return $timeslotIdsArray;
	}

	//function to generate unique subject code
	public function subCodeGen($length = 8, $flag = 'ALPHANUMERIC',$area_code,$cycle_no,$pgm_name)
	{
		switch ($flag)
		{
			case 'NUMERIC':
				$str = '0123456789';
				break;
			case 'NO_NUMERIC':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			default:
				$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
		}

		for ($i = 0, $passwd = ''; $i < $length; $i++)
			$passwd .= substr($str, mt_rand(0, strlen($str) - 1), 1);

		$newpasswd = $area_code." C".$cycle_no." ".$pgm_name." ".$passwd;
		return $newpasswd;
	}
}