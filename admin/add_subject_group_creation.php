<?php include('header.php');?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">SUBJECT GROUPS CREATION FOR PRE-SELECTION</div>
            <form name="frmSubjectGroup" id="frmSubjectGroup" action="postdata.php" method="post">
              <input type="hidden" name="form_action" value="add_subject_group" />
              <div class="custtable_left" >
                    <div class="custtd_left red">
						<?php if(isset($_SESSION['error_msg'])) echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
					  <h2>Choose Career Program</h2>
					</div>
					<div class="txtfield">
					<select id="career" name="career" class="select1">
					<option value="">--Select--</option>
					<option value="1">MBA</option>
					<option value="2">MCA</option>
					<option value="3">MEDICINA</option>					
					</select>
					</div>
                    <div class="clear"></div>
					<div class="custtd_left">
					  <h2>Choose Subject</h2>
					</div>
					<div class="txtfield">
					<select id="career" name="career" class="select1">
					<option value="">--Select--</option>
					<option value="1">English</option>
					<option value="2">Hindi</option>
					<option value="3">Maths</option>					
					</select>
					</div>
                    <div class="clear"></div>
					<div class="custtd_left">
					  <h2>Select Subject PRE-REQUISITE</h2>
					</div>
					<div class="txtfield">
					<select id="career" name="career" class="select1">
					<option value="">--Select--</option>
					<option value="1">English</option>
					<option value="2">Hindi</option>
					<option value="3">Maths</option>					
					</select>
					</div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Maximum number of students</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtPname" maxlength="50" name="txtPname" value="">
                    </div>
                    <div class="clear"></div>					
					<div class="custtd_left">
                        <h2>Minimum number of students</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtteacher_code" maxlength="50" name="txtteacher_code" value="">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Enter number of credits</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtteacher_code" maxlength="50" name="txtteacher_code" value="">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Enter subject cost/fee($)</h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="txtteacher_code" maxlength="50" name="txtteacher_code" value="">
                    </div>
                    <div class="clear"></div>                    
                    <div class="txtfield">
                        <input type="submit" name="btnAdd" id="btnAdd" class="buttonsub btnSave" value="Save">
                        <input type="button" name="btnCancel" class="buttonsub" value="Cancel" onclick="location.href = ''">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php');?>


