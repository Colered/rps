<?php
$objSps=new Spsconfig(); 
$div=$objSps->spsDayLeftCloseAndOpen();
?>
<div class="main-sidebar">
	<div class="side-div"><u>General SPS CONFIG</u></div>
	<div class="side-div"><u>See other Reports</u></div>
	<?php echo $div; ?>
</div>