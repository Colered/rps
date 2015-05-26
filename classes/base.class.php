<?php
abstract class Base
{
	public $conn;
	public function __construct(){
		global $db_FED;
		global $db_RPS;
		global $db_RAS;
		$this->connfed = $db_FED;
		$this->connrps = $db_RPS;
		$this->connras = $db_RAS;
	}
	//function to clean input text
	public static function cleanText($txt){
		$str = strip_tags($txt);
		$str = str_replace("&nbsp;","",$str);
		return trim($str);
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
	//function to generate unique subject code
	public function subCodeGen($length = 8, $flag = 'ALPHANUMERIC')
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
		return $passwd;
	}
}