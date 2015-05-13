<?php include('../header.php');?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Forgot Password</div>
            <form name="forgotPwdForm" id="forgotPwdForm" action="../postdata.php" method="post">
				<input type="hidden" name="form_action" value="forgotPwd" />
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
                        <h2>Enter your email address:<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="email" maxlength="50" name="email" >
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                     </div>
                    <div class="txtfield">
                        <input type="submit" name="forgotPwdBtn" class="buttonsub" value="submit">
                    </div>
                    <div class="txtfield">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = 'index.php';">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php'); ?>
