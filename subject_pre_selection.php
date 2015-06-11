<?php
include('header.php');
$obj_fedena=new Fedena();
$obj_ras=new RAS();
$objP = new Prerequistie();
$student_subjects=$obj_fedena->getCurrentStuSemSub();
$course_name = $obj_fedena->getCourseName();
$all_subjects = $obj_fedena->getAllSubjectsDetails();
?>
<div class="custtable_left fontstyles" style="margin-left:20px;width:80%;">
	<table id="datatables-left" class="display">
		<thead>
			<tr>
				<th >Suggested Subjects for Next Semester </th>
			</tr>
		</thead>
		<tbody>
		<?php
		$subject_rule = array();$subjects = array();$k=1;
		foreach($all_subjects as $subject_id => $subject_details)
		{
			$sub_cnt =  count($subject_details['subjects']);
			$cnt = 0;			
			foreach($subject_details['subjects'] as $key=>$value)
			{
				$sub_code = $objP->getrequistie($key);
				if($obj_fedena->search_array($value['name'],$student_subjects))
				{
					$cnt++;									
				}else if(($sub_code!="" && $obj_fedena->search_array($sub_code,$student_subjects)) || $sub_code == "")
				{				
					$result_rules = $obj_ras->getRulesofSubject($value['name'],$course_name);
					if($result_rules->num_rows>0)
					{
						$i=0;$rule_cnt=0;
						while($data = $result_rules->fetch_assoc())
						 {	
							 if($obj_ras->checkTimetable($data['subject_rule_id']))
							 {
								 $subject_rule[$subject_id][$i]['id'] = $data['subject_rule_id'];
								 $subject_rule[$subject_id][$i]['name'] = $data['rule_name'];
								 $subjects[$subject_id]['name'] = $value['name'];
								 $subjects[$subject_id]['code'] = $key;
								 $subjects[$subject_id]['max_weekly_classes'] = $value['max_weekly_classes'];
								 $subjects[$subject_id]['credit_hours'] = $value['credit_hours'];
								 $subjects[$subject_id]['amount'] = $value['amount'];
								 $subjects[$subject_id]['no_exams'] = $value['no_exams'];
								 $rule_cnt++;$i++;
							 }						
						}
						if($rule_cnt == 0)
							$cnt++;
					}else{
						$cnt++;
					}
				}
			}
			if($cnt != $sub_cnt)
			{
				if($subject_id==$_GET['id'])
				{
					$style='style="background-color:#29bc69"';
				}else{
					$style='';
				}
				?>
			<tr <?php echo $style;?>>
				<td class="align-center"><?php echo $subject_details['name'];?> <span class="subject-heading-1"><a href="#" class="basic-sub-grp" id="<?php echo $k;?>">See Details</a></span></td>
			</tr>
			<div id="<?php echo 'sub_grp_detail_'.$k;?>"  class="SubSessTbl" style="display:none;">				 
				<div class="SubSessTitle">
					<p>Subject's Session detail</p>
				</div>
				<div class="SubSessHeading">
					<div class="SubSessCell">
						<p>Subject</p>
					</div>
					<div class="SubSessCell">
						<p>Code</p>
					</div>
					<div class="SubSessCell">
						<p>Max Weekly Class</p>
					</div>
					<div class="SubSessCell">
						<p>Credit Hours</p>
					</div>
					<div class="SubSessCell">
						<p>Amount</p>
					</div>
					<div class="SubSessCell">
						<p>No Exam</p>
					</div>
				</div>
					<?php foreach($subjects as $k=>$v){
					if($k == $subject_id){?>
					<div class="SubSessRow">
						<div class="SubSessCell">
							<p><?php echo $v['name']?></p>
						</div>
						<div class="SubSessCell">
							<p><?php echo $v['code']?></p>
						</div>
						<div class="SubSessCell">
							<p><?php echo $v['max_weekly_classes']?></p>
						</div>
						<div class="SubSessCell">
							<p><?php echo $v['credit_hours']?></p>
						</div>
						<div class="SubSessCell">
							<p><?php echo $v['amount']?></p>
						</div>
						<div class="SubSessCell">
							<p><?php echo $v['no_exams']?></p>
						</div>
					</div>
				<?php } }?>
				</div>
			<?php } $k++;
		}?>
		<input type="hidden" id="page" name="page" value="<?php echo $_GET['id'];?>"/>
		</tbody>
	</table>	
	<table id="datatables-right" class="display">
		<thead>
			<tr>
				<th >Groups for <br /> <?php echo $course_name;?> For <?php echo ucfirst($user_name['first_name'])." ".ucfirst($user_name['last_name']);?></th>
				<th >Credits</th>                        
				<th >Seats</th>
				<th >Action</th>							
			</tr>
		</thead>
		<tbody>
		<?php foreach($subject_rule[$_GET['id']] as $id=>$value){?>
			<tr>
				<td class="align-center"><?php echo $value['name'];?></td>
				<td class="align-center">3</td>                        
				<td class="align-center">30</td>
				<?php $status = $objP->getSubGrpStatus($_GET['id']);
				$statusTxt = ($status==1?"Unselect":"Select");?>
				<td class="align-center"><span class="subject-heading-1"><a href="#" onclick="saveSubGrp('<?php echo $_GET['id'];?>','<?php echo $value['id'];?>','subject_pre_selection');"><?php echo $statusTxt;?></a></span></td>				
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<table id="datatables-right" class="display">
		<thead>
			<tr>
				<th >Selected Subject Groups </th>
			</tr>
		</thead>
		<tbody>
		<?php $selectedGrps = $objP->getSubGrp($_GET['id']);
		if($selectedGrps->num_rows>0){
			while($data = $selectedGrps->fetch_assoc()){?>
			<tr>
				<td class="align-center"><?php echo $data['subject_group_name']." - ".$data['associated_rules_names'];?></td>
			</tr>
			<?php } }else{?>
				<tr class="align-center"><td>No result Found</td></tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php include('sidebar_right.php');
	  include('footer.php');
?>

