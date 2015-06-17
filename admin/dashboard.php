<?php include('header.php');
$objF = new Fedena();
$objP = new Prerequistie();
$result = $objF->getSubjects();
?>
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
<div class="custtable_left fontstyles" style="margin-left:20px;width:80%;">
	<table id="datatables" class="display">
		<thead>
			<tr>
				<th >SUBJECT CODE</th>
				<th >SUBJECT NAME</th>   
				<th >BATCH NAME</th>
				<th >SUBJECT GROUP</th>  
				<th >SUBJECT PRE-REQUISITE</th>
				<th >STUDENTS SUBSCRIBED</th>				
			</tr>
		</thead>
		<tbody>
			<?php while ($data = $result->fetch_assoc()){	
			 $no_students = $objP->getPreSelectedSub($data['sub_grp_id']);
			 $req_sub_name = $objP->getAllPreRequistie($data['sub_id'],$data['batch_id'])
			 ?>
				<tr>
					<td class="align-center"><?php echo $data['code'];?></td>
					<td class="align-center"><?php echo $data['name'];?></td>
					<td class="align-center"><?php echo $data['batch_name'];?></td>
					<td class="align-center"><?php echo $data['subject_group_name'];?></td>   
					<td class="align-center"><?php echo $req_sub_name;?><!--<span class="subject-heading-1"><a href="#"> Edit</a></span>--></td>
					<td class="align-center"><?php echo $no_students;?><!--<span class="subject-heading-1"><a href="#"> See Group Distribution</a></span>--></td>					
				</tr>
			<?php } ?>								
		</tbody>
	</table>			 
</div>
<?php include('sidebar_right.php');?>
<?php include('../footer.php');?>


