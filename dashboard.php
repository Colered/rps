<?php
include('header.php');
$obj_fedena=new Fedena();
$obj_ras=new RAS();
$stuendt_subjects=$obj_fedena->getCurrentStuSemSub();
$course_name = $obj_fedena->getStudentCourse();
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
			if(count($stuendt_subjects)>0){
				$i=1;
				foreach($stuendt_subjects as $key=>$val){ 
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
		<?php foreach($all_subjects as $subject)
		{
			$match = $obj_ras->matchSubject($subject);
			if($match)
			{?>
				<tr>
					<td class="align-center"><?php echo $subject;?></td>                        
					<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
					<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
				</tr>
			<?php } 
		}?>			
		</tbody>
	</table>			 
</div>


<?php include('sidebar_right.php');
	  include('footer.php');
?>

