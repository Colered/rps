<?php include('header.php');
$obj_fedena=new Fedena();
$all_courses = $obj_fedena->getAllCourses();
?>
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
					  <h2>Choose Career Program<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
						<select id="career" name="career" class="select1 required">
							<option value="">--Select--</option>					
							<?php while ($courses = $all_courses->fetch_assoc()){ ?>	
								<option value="<?php echo $courses['code']."#".$courses['course_name']; ?>"><?php echo $courses['course_name']; ?></option>
							<?php } ?>
						</select>
					</div>
                    <div class="clear"></div>
					<div class="custtd_left">
					  <h2>Choose Subject<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
					<select id="subject" name="subject" class="select1 required">
						<option value="">--Select--</option>
					</select>
					</div>
                    <div class="clear"></div>
					<div class="custtd_left">
					  <h2>Select Subject PRE-REQUISITE</h2>
					</div>
					<div class="txtfield">
					<select id="subject_requistie" name="subject_requistie" class="select1">
						<option value="">--Select--</option>
					</select>
					</div>
                    <div class="clear"></div>
                    <div class="custtd_left">
                        <h2>Maximum number of students<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="max_students" maxlength="50" name="max_students" value="">
                    </div>
                    <div class="clear"></div>					
					<div class="custtd_left">
                        <h2>Minimum number of students<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="min_students" maxlength="50" name="min_students" value="">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Enter number of credits<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="credits" maxlength="50" name="credits" value="">
                    </div>
                    <div class="clear"></div>
					<div class="custtd_left">
                        <h2>Enter subject cost/fee($)<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
                        <input type="text" class="inp_txt required" id="subject_cost" maxlength="50" name="subject_cost" value="">
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


