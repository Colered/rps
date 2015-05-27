<?php 
$numberDays=$numberDaysCurrent='';
$obj=new Spsconfig();
$sps_result=$obj->getAllConfig();
if($sps_result->num_rows >0){
	while ($data=$sps_result->fetch_assoc()){
		$sps_st_date=$data['sps_start_date'];
		$sps_en_date=$data['sps_end_date'];
	}
	$st_date=strtotime($sps_st_date);
	$en_date=strtotime($sps_en_date);
	$timeDiff= abs($en_date-$st_date);
	$numberDays = $timeDiff/86400; 
	$now = strtotime(date("Y-m-d"));
	if($now>=$st_date && $now <=$en_date){
		$timeDiffCurrent= abs($now-$st_date);
		$numberDaysCurrent = $timeDiffCurrent/86400; 
		$numberDaysFromNow=$numberDays-$numberDaysCurrent;
		$div='<div class="side-div align-center"><b>'.$numberDaysFromNow.'</b><br>Days left to close SPG</div>';
	}elseif($now<$st_date){
		$timeDiffCurrent= abs($st_date-$now);
		$numberDaysFromNow = $timeDiffCurrent/86400; 
		$div='<div class="side-div align-center"><b>'.$numberDaysFromNow.'</b><br>Days left to open SPG</div>';
	}else{
		$numberDaysFromNow='0';
		$div='<div class="side-div align-center"><b>'.$numberDaysFromNow.'</b><br>Days left to close SPG</div>';
	}
}else{
	$div='<div class="side-div align-center"><b>SPG config does not exist</b></div>';
}
?>
<div class="main-sidebar">
	<div class="side-div"><u>General SPS CONFIG</u></div>
	<div class="side-div"><u>See other Reports</u></div>
	<?php echo $div; ?>
</div>