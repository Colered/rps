<?php
include('header.php');
$obj_fedena=new Fedena();
$obj_ras=new RAS();
$objP = new Prerequistie();
$student_subjects=$obj_fedena->getCurrentStuSemSub();
$course_name = $obj_fedena->getCourseName();
$all_subjects = $obj_fedena->getAllSubjects();
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
		$subject_rule = array();
		foreach($all_subjects as $subject_id => $subject_details)
		{
			$sub_cnt =  count($subject_details['subjects']);
			$cnt = 0;			
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
						$i=0;
						while($data = $result_rules->fetch_assoc())
						 {	
							 if($obj_ras->checkTimetable($data['subject_rule_id']))
							 {
								 $subject_rule[$subject_id][$i]['id'] = $data['subject_rule_id'];
								 $subject_rule[$subject_id][$i]['name'] = $data['rule_name'];
							 }else{
								 $cnt++;
							 }
						$i++;
						}
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
				<td class="align-center"><?php echo $subject_details['name'];?> <span class="subject-heading-1"><a href="#">See Details</a></span></td>
			</tr>
			<?php }
		}?>
			
		</tbody>
	</table>	
	<table id="datatables-right" class="display">
		<thead>
			<tr>
				<th >Groups for {Sem Name} for <br /> <?php echo $course_name;?> For <?php echo ucfirst($user_name['first_name'])." ".ucfirst($user_name['last_name']);?></th>
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
				<td class="align-center"><span class="subject-heading-1"><a href="#" onclick="saveSubGrp('<?php echo $_GET['id'];?>','<?php echo $value['id'];?>');"><?php echo $statusTxt;?></a></span></td>				
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

