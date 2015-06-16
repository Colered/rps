<?php
include('header.php');
$objP = new Prerequistie();
$result = $objP->getSubjects();
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
<div id="content">
    <div id="main">
	<?php if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
	<?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 1){ echo '<div class="green center" id="succ_msg">Data has been saved successfully</div>';}?>
	     <div class="full_w">
            <div class="h_title">Subject View</div>		
			 <table id="datatables" class="display">
                <thead>
                    <tr>
					    <th >Sr No</th>
						<th >Subject Name</th>
						<th >Subject Group</th>
                        <th >Course Code</th>
						<th >Batch </th>                        
                        <th >Maximum Students</th>
						<th >Minimum Students</th>
                        <th >Subject Cost</th>						
					</tr>
                </thead>
                <tbody>
                    <?php $i=1;
					 while ($data = $result->fetch_assoc()){												
					 ?>
						<tr id="<?php echo $data['id']; ?>">
							<td class="align-center"><?php echo $i; ?></td>							
							<td class="align-center"><?php echo $data['name']; ?></td>							
							<td class="align-center"><?php echo $data['subject_group_name']; ?></td>
							<td class="align-center"><?php echo $data['course_name']; ?></td>								
							<td class="align-center"><?php echo $data['batch_name']; ?></td>
							<td class="align-center"><?php echo $data['max_students']; ?></td>
							<td class="align-center"><?php echo $data['min_students']; ?></td>
							<td class="align-center">$<?php echo $data['subject_cost']; ?></td></td>					
					   </tr>
					<?php $i++;}?>				
                </tbody>
            </table>
		  </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php'); ?>
