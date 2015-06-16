<?php include('header.php');
$obj_fedena=new Fedena();
$all_courses = $obj_fedena->getAllCourses();?>
<div id="content">
    <div id="main">
		<?php 
		if(isset($_SESSION['succ_msg'])){ echo '<div class="green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);}
		if(isset($_SESSION['error_msg'])){ echo '<div class="red center">'.$_SESSION['error_msg'].'</div>'; unset($_SESSION['error_msg']);}
		?>
        <div class="full_w">
            <div class="h_title">Manage Subjects</div>
            <form name="frmSubjectGroup" id="frmSubjectGroup" action="../postdata.php" method="post">
              <input type="hidden" name="form_action" value="add_subject" />
				<div class="custtable_left">
					<div class="custtd_left">
					  <h2>Choose Career Program<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
						<select id="career" name="career" class="select1 required">
							<option value="">--Select--</option>					
							<?php while ($courses = $all_courses->fetch_assoc()){ ?>	
								<option value="<?php echo $courses['id']."-".$courses['course_name']." ".$courses['section_name'];?>"><?php echo $courses['course_name']." ".$courses['section_name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
                        <h2>Batch<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					<select id="batch" name="batch" class="select1 required">
						<option value="">--Select--</option>
					</select>
					</div>
					<div class="clear"></div>
					<div class="custtd_left">
					  <h2>Choose Subject Group<span class="redstar">*</span></h2>
					</div>
					<div class="txtfield">
					<select id="subject_grp" name="subject_grp" class="select1 required">
						<option value="">--Select--</option>
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
					<div class="clear"></div>
                    <div class="custtd_left">
                        <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
					
                </div>
            </form>
			<div class="clear"></div>			
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php'); ?>

