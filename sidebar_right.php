<?php
$objSps=new Spsconfig(); 
$div=$objSps->spsDayLeftCloseAndOpen();
?>
<div class="main-sidebar">
	<div class="side-div"><u>Download PENSUM PDF</u></div>
	<div class="side-div"><u><a href="<? echo SERVER_URL;?>web_calendar_rps/month.php" target="_blank">Calendar View</a></u></div>
	<?php echo $div; ?>
</div>