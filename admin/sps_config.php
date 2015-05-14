<?php include('header.php');?>
<div class="custtable_left fontstyles" style="margin-left:20px;width:80%;">
	<h3>GENERAL CONFIGURATION FOR SUBJECT PRE-SELECTION PROCESS<h3>
	<form action="postdata.php" method="post" name="sps_config" id="sps_config">
		<input type="hidden" value="spsConfig" name="form_action">
			<div class="custtable_left">
				<div class="red" style="padding-bottom:10px;">
						<?php if(isset($_SESSION['error_msg']))
							echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
				</div>
				<div class="clear"></div>
				<div class="custtd_left">
					<h2><strong>Select start date for SPS</strong><span class="redstar">*</span></h2>
				</div>
				<div class="txtfield">
					<input type="text" required="true" id="fromSPS" name="fromSPS" size="13">					
				</div>
				<div class="clear"></div>
				<div class="custtd_left">
					<h2><strong>Select end date for SPS</strong><span class="redstar">*</span></h2>
				</div>
				<div class="txtfield">
					<input type="text" required="true" id="toSPS" name="toSPS" size="13">					
				</div>
				<div class="clear"></div>			
				<div class="txtfield" style="padding-left:41px; padding-top:10px;">
					<input type="button" name="btnSPSConfig" class="buttonsub btnSPSConfig" value="Save">
				</div>
				<div class="txtfield" style="padding-top:10px;">
					<input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = '';">
				</div>
            </div>	
    </form>
</div>
<?php include('../footer.php');?>


