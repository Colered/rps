<?php include('header.php');?>
<div id="content">
    <div id="main">
		<?php 
		if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
        <div class="full_w">
            <div class="h_title">Session Upload</div>
            <form name="session_upload" id="session_upload" action="../postdata_import.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="form_action" value="uploadSession" />
				<div class="custtable_left">
					<div class="custtd_left">
                        <h2>File Path<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
						 <input type="file" name="uploadSess" class="buttonsub" value="Upload"><input style="margin-left:20px;" type="submit" name="Upload" value="Upload" class="buttonsub" />
                    </div>
					<div class="clear"></div>
					<div style="float:left; margin-left:292px;">	
					Click <a href="../sample/upload.xlsx" target="_blank">here</a> to download a sample file.
					</div>
                    <div class="clear"></div>					                    
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
					
                </div>
            </form>
			<div class="clear"></div>
			<div class="red" style="text-align:left; margin-left:305px;">
					<?php
					if((isset($_SESSION['error_msgArr'])) && (count($_SESSION['error_msgArr'])>0)){
						foreach($_SESSION['error_msgArr'] as $errorData){
							echo $errorData.'</br>';
						}
						unset($_SESSION['error_msgArr']);
					}
					?>
			</div><br /><br />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php'); ?>

