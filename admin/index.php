<?php
include('header-main.php');
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){
	header('Location: dashboard.php');
}
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Administrator Login</div>
            <form action="../postdata.php" method="post" autocomplete="off" id="adminLogin" class="login">
				<input type="hidden" name="form_action" value="adminLogin" />
                <div class="custtable_left">
                    <img src="../images/lock.jpg" id="lock-img" class="lock-img" />
                </div>
                <div class="custtable_left " style="padding-left:14px;">
					<div class="custtd_left error">
							<?php if(isset($_SESSION['error_msg']))
								echo $_SESSION['error_msg']; $_SESSION['error_msg']=""; ?>
					</div>
					<div class="green">
							<?php if(isset($_SESSION['succ_msg']))
								echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);?>
					</div>
					<div class="clear"></div>
                    <div class="custtd_left" style="padding-left:14px;">
                        <h2 class=""><strong>User Name</strong><span class="redstar">*</span></h2>
                    </div>
                    <div class="clear"></div>
                    <div class="txtfield1" style="border-left:none;">
                        <input type="text" class="inp_txt" id="txtUName" maxlength="50" name="txtUName" autocomplete="off" >
                    </div>
                    <div class="clear"></div>
                    <div class="custtd_left" style="padding-left:14px;">
                        <h2 class=""><strong>Password</strong><span class="redstar">*</span></h2>
                    </div>
                    <div class="clear"></div>
                    <div class="txtfield1" style="border-left:none;">
                        <input type="password" class="inp_txt" id="txtPwd" maxlength="50" name="txtPwd" autocomplete="off" >
                    </div>
                    <div class="clear"></div>
					 <div class="txtfield1" style="border-left:none;">
                       <a href="forgot.php">Forgot Password</a>
                    </div>
                    <div class="clear"></div>
                    <div class="txtfield1" style="border-left:none;">
                        <input type="submit" name="login" class="buttonsub" value="Login">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php'); ?>

