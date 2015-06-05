<?php
include('header.php');
$obj_fedena=new Fedena();
$obj_ras=new RAS();
$objP = new Prerequistie();
$student_subjects=$obj_fedena->getCurrentStuSemSub();
$course_name = $obj_fedena->getCourseName();
$all_subjects = $obj_fedena->getAllSubjects();
//print"<pre>";print_r($all_subjects);die;
?>
<div class="custtable_left fontstyles" style="margin-left:20px;width:80%;">
	<table id="datatables-left" class="display">
		<thead>
			<tr>
				<th >Subjects Currently Taking</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if(count($student_subjects)>0){
				$i=1;
				foreach($student_subjects as $key=>$val){ 
			?>
			<tr>
				<td class="align-left"><div style="float:left"><span><?php echo $key; ?></span></div> <div id='<?php echo "sub_detail_".$i;?>' style="float:right"><span class="subject-heading-1"><a href='#' class='basic'  id="<?php echo $i;?>">See detail</a> </span></div></td>
			</tr>
				<div id='<?php echo "sub_sees_detail_".$i;?>'  class="SubSessTbl" style="display:none;" >
				<?php
				 $j=1;
				 foreach($val as $k=>$v){
				 	if($j==1){?>
					<div class="SubSessTitle">
						<p>Subject's Session detail</p>
					</div>
					<div class="SubSessHeading">
						<div class="SubSessCell">
							<p>Subject</p>
						</div>
						<div class="SubSessCell">
							<p>Session</p>
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
					<?php }?>
					<div class="SubSessRow">
						<div class="SubSessCell">
							<p><?php echo $v['elective_grp']?></p>
						</div>
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
				<?php $j++;}?>
				</div>
			<?php $i++;}
			   }else{ ?>
			<tr>
				<td class="align-center"><?php echo "Not Found "; ?></td>
			</tr>  
			<?php }	
			?>
		</tbody>
	</table>
	<table id="datatables-right" class="display">
		<thead>
			<tr>
				<th colspan="3" >Suggested Subject Groups to take next semester according to <?php echo $course_name;?> For 
				<?php echo ucfirst($user_name['first_name'])." ".ucfirst($user_name['last_name']);?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($all_subjects as $subject_id => $subject_details)
		{
			$sub_cnt =  count($subject_details['subjects']);
			$cnt = 0;
			$subject_rule = array();
			foreach($subject_details['subjects'] as $key=>$value)
			{
				$sub_code = $objP->getrequistie($key);
				if($obj_fedena->search_array($value,$student_subjects))
				{
					$cnt++;									
				}else if($sub_code!="" && $obj_fedena->search_array($sub_code,$student_subjects))
				{				
					$result_rules = $obj_ras->getRulesofSubject($value,$course_name);
					$i=0;
					while($data = $result_rules->fetch_assoc())
					 {	
						 if($obj_ras->checkTimetable($data['subject_rule_id']));
						 {
							 $subject_rule[$subject_id][$i]['id'] = $data['subject_rule_id'];
							 $subject_rule[$subject_id][$i]['name'] = $data['rule_name'];
						 }
					$i++;
					}
				}else{
					$cnt++;
				}
			}
			if($cnt != $sub_cnt)
			{
			?>		
				<tr>
					<td class="align-center"><?php echo $subject_details['name'];?></td>                       
					<td class="align-center"><span class="subject-heading-1"><a href="#" onclick="saveSubGrp();">Confirm SG:</a></span><?php if(isset($subject_rule[$subject_id])) {echo $subject_rule[$subject_id]['0']['name'];} else echo 'No Rule';?></td>
					<td class="align-center"><span class="subject-heading-1"><a href='#' class='basic-sub-grp'  id="<?php echo $i;?>">See other availaible SG</a></span></td>	
				</tr>				
		<?php }
		}?>					
		</tbody>
	</table>			 
</div>
<?php include('sidebar_right.php');
	  include('footer.php');
?>

