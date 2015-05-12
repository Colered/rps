<?php include('header.php');?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Change Password</div>
            <form name="changePwdForm" id="changePwdForm" action="postdata.php" method="post">
				<input type="hidden" name="form_action" value="changePwd" />
				<div class="custtable_left">
					<div class="error">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="green">
							<?php if(isset($_SESSION['succ_msg']))
								echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Current Password:<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="password" name="currentPassword" id="currentPassword" class="inp_txt required"/>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>New Password:<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="password" name="newPassword" id="newPassword" class="inp_txt required"/>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Confirm Password:<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="inp_txt required"/>
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                     </div>
                    <div class="txtfield">
                        <input type="submit" name="forgotPwdBtn" class="buttonsub" value="Submit">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'dashboard.php';">
                    </div>
					<div class="clear"></div>
					<div class="custtd_left green">
						
					</div>
					<div class="clear"></div>
					
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
