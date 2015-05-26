<?php include('header.php');
$sps_start_date = ""; $sps_end_date="";$confId="";
$obj = new Spsconfig();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$confId = base64_decode($_GET['edit']);
	$result = $obj->getDataByConfID($confId);
	$row = $result->fetch_assoc();
}else{
	//check if some data already exists
	$allData = $obj->getAllConfig();
	$allDataRows = $allData->fetch_assoc();
	if(isset($allDataRows['id']) && $allDataRows['id'] !="" )
	{
		header('Location: sps_config.php?edit='.base64_encode($allDataRows['id']).'');
	}
}

$sps_start_date = isset($_GET['edit']) ? $row['sps_start_date'] : (isset($_POST['fromSPS'])? $obj->cleanText($_POST['fromSPS']):'');
$sps_end_date = isset($_GET['edit']) ? $row['sps_end_date'] : (isset($_POST['toSPS'])? $obj->cleanText($_POST['toSPS']):'');
?>
<div class="custtable_left fontstyles" style="margin-left:20px;width:80%;">
	<h3>GENERAL CONFIGURATION FOR SUBJECT PRE-SELECTION PROCESS<h3>
	<form action="../postdata.php" method="post" name="sps_config" id="sps_config">
		<input type="hidden" value="spsConfig" name="form_action">
		<input type="hidden" name="spsConfigId" value="<?php echo $confId; ?>" />
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
					<input type="text" required="true" id="fromSPS" name="fromSPS" size="13" value="<?php echo $sps_start_date; ?>">					
				</div>
				<div class="clear"></div>
				<div class="custtd_left">
					<h2><strong>Select end date for SPS</strong><span class="redstar">*</span></h2>
				</div>
				<div class="txtfield">
					<input type="text" required="true" id="toSPS" name="toSPS" value="<?php echo $sps_end_date ; ?>" size="13">					
				</div>
				<div class="clear"></div>			
				<div class="txtfield" style="padding-left:41px; padding-top:10px;">
					<input type="submit" name="btnSPSConfig" class="buttonsub btnSPSConfig" value="<?php echo $buttonName = ($sps_start_date!="") ? "Update":"Save" ?>">				
					<input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'sps_config_view.php';">
				</div>
            </div>	
    </form>
</div>
<?php include('../footer.php');?>


