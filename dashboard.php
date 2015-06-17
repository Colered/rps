<?php
include('header.php');
$obj_fedena=new Fedena();
$obj_ras=new RAS();
$objP = new Prerequistie();
$student_subjects=$obj_fedena->getCurrentStuSemSub();
$course_name = $obj_fedena->getCourseName();
$all_subjects = $obj_fedena->getAllSubjects();
$date='';
$objs=new Spsconfig();
$sps_result=$objs->getAllConfig();
if($sps_result->num_rows >0){
	while ($data=$sps_result->fetch_assoc()){
		$sps_st_date=$data['sps_start_date'];
		$sps_en_date=$data['sps_end_date'];
	}
	$now = date("Y-m-d");
	$date=$objs->checkInRange($sps_st_date,$sps_en_date,$now);
}

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
						<p>Group Detail</p>
					</div>
					<div class="SubSessHeading">
						<div class="SubSessCell">
							<p>Group</p>
						</div>
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
			$cnt = 0;$k=0;
			$subject_rule = array();
			foreach($subject_details['subjects'] as $key=>$value)
			{
				$sub_code = $objP->getrequistie($key);
				if($obj_fedena->search_array($value,$student_subjects))
				{
					$cnt++;									
				}else if(($sub_code!="" && $obj_fedena->search_array($sub_code,$student_subjects)) || $sub_code == "")
				{				
					$result_rules = $obj_ras->getRulesofSubject($value,$course_name);
					
					if($result_rules->num_rows>0)
					{
						$i=0;$rule_cnt=0;
						while($data = $result_rules->fetch_assoc())
						 {	
							 if($obj_ras->checkTimetable($data['subject_rule_id']))
							 {
								 $subject_rule[$subject_id][$k][$i]['id'] = $data['subject_rule_id'];
								 $subject_rule[$subject_id][$k][$i]['name'] = $data['rule_name'];
								 $rule_cnt++;$i++;
							 }						
						}$k++;
						if($rule_cnt == 0)
							$cnt++;
					}else{
						$cnt++;
					}
				}
			}
			//print"<pre>";print_r($subject_rule);die;
			if($cnt != $sub_cnt)
			{
				$status = $objP->getSubGrpStatus($subject_id,$subject_rule[$subject_id]['0']['0']['id']);				
			?>		
				<tr>
					<td class="align-center"><?php echo $subject_details['name'];?></td> 
					<?php if(isset($subject_rule[$subject_id])){?>
					<td class="align-center"><span class="subject-heading-1">
					<?php if($date){ ?>
							<a href="#" onclick="saveSubGrp('<?php echo $subject_id;?>','<?php echo $subject_rule[$subject_id]['0']['0']['id'];?>');"><?php if($status == 1) { echo "<span style='color:red'>Unconfirm SG: </span>";}else{ echo "Confirm SG:";}?></a>
					<?php }else{?>
							<?php if($status == 1) { echo "<span style='color:red'>Unconfirm SG: </span>";}else{ echo "Confirm SG:";}?>
					<?php } ?>
					</span><?php echo $subject_rule[$subject_id]['0']['0']['name'];?>
					<a href="<?php echo SERVER_URL ?>web_calendar_rps/month.php?subGrpId=<?php echo $subject_id;?>&subRuleId=<?php echo $subject_rule[$subject_id]['0']['0']['id'];?>" class="see_cal">see cal</a>
					</td>
					<?php }else{ ?>
					<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span><?php echo "None";?></td>
					<?php } ?>
					<td class="align-center"><span class="subject-heading-1">
						<?php if($date){ ?>
							<a href="subject_pre_selection.php?id=<?php echo $subject_id;?>">See other availaible SG</a></span>
						<?php }else{ ?>
						<?php echo "See other availaible SG";}?>
					</td>
					
					</tr>				
		<?php }
		}?>					
		</tbody>
	</table>			 
</div>
<?php include('sidebar_right.php');
	  include('footer.php');
?>

