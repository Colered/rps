<?php include('header.php');
$objF = new Fedena();
$objP = new Prerequistie();
$courses = $objF->getAllCourses();
if(isset($_POST['career']) && $_POST['career'] != '')
{
	$result = $objF->getSubjects($_POST['career']);
}else{
	$result = $objF->getSubjects();
}
?>
<script>
function careerFilter()
{
	$('#career_filter').submit();
}
</script>
<script src="../js/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#datatables').dataTable({
		"sPaginationType":"full_numbers",
		"aaSorting":[[0, "asc"]],
		"bJQueryUI":true
	});
})
</script>
<style type="text/css">
	@import "../css/demo_table_jui.css";
	@import "../css/jquery-ui-1.8.4.custom.css";
</style>
<div class="report-name">
<h3>CAREER SUBJECT GROUP REPORT</h3>
</div>
<div class = "activity-color-filteration"> 
	<form id="career_filter" name="career_filter" method="post" action="reports.php" novalidate="novalidate">	
		<strong>SELECT CAREER: </strong>
		<select id="career" name="career" class="select-filter" onchange="careerFilter();" style="width:110px;">
		<option value="" selected="selected">--Select--</option>
		<?php foreach($courses as $course)
		{
			if($_POST['career']==$course['id'])
			{
				$selected='selected="selected"';
			}else{
				$selected = '';
			}
		?>
		<option <?php echo $selected;?> value="<?php echo $course['id'];?>"><?php echo $course['course_name'];?></option>
		<?php } ?>			
		</select>
	</form>
</div>
<div class="custtable_left fontstyles" style="width:100%;">
	<table id="datatables" class="display">
		<thead>
			<tr>
				<th >SUBJECT NAME</th>
				<th >SUBJECT GROUP ID</th>                        
				<th >NUMBER OF STUDENTS SUBSCRIBED</th>
				<th >NUMBER OF SUBSCRIPTIONS AVAILABLE</th>
				<th >ESTIMATED FEE COLLECTION BY GROUP</th>
				<th >TEACHER</th>
			</tr>
		</thead>
		<tbody>
		 <?php while ($data = $result->fetch_assoc()){	
		 $max_students=0;
		 $no_students = $objP->getPreSelectedSub($data['sub_grp_id']);
		 $total_std = $objP->getSeats($data['sub_id'],$data['batch_id']);		 
		 if($total_std)
		 {
			 $details = mysqli_fetch_assoc($total_std);
			 $max_students = $details['max_students'];
			 $cost = $details['cost'];
		 }
		 ?>
			<tr>
				<td class="align-center"><?php echo $data['name'];?></td>
				<td class="align-center"><?php echo $data['subject_group_name'];?></td>                        
				<td class="align-center"><?php echo $no_students;?></td>
				<td class="align-center"><?php echo $max_students;?></td>
				<td class="align-center">$<?php echo $cost*$no_students;?></td>
				<td class="align-center"></td>
			</tr>
		<?php } ?>			
		</tbody>
	</table>			 
</div>
<?php include('../footer.php');?>


