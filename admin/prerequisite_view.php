<?php
include('header.php');
$objP = new Prerequistie();
$result = $objP->getPreRequistie();
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
	<?php if($result->num_rows > 0){?>
	<div style="float:right;padding:5px 5px;"><input  type="button" class="buttonsub" value="Save & Finish" name="btnPrgmClone" id="btnPrgmClone" onclick="updatePrerequistie();"/>		</div>
	<?php } ?>
        <div class="full_w">
            <div class="h_title">Prerequisite Subject View</div>		
			 <table id="datatables" class="display">
                <thead>
                    <tr>
					    <th >Sr No</th>
						<th >Course</th>
                        <th >Course Code</th>
						<th >Batch </th>
                        <th >Subject</th>
                        <th width="350">Subject PRE-Requistie</th>
						<th >Maximum Students</th>
						<th >Minimum Students</th>
                        <th >Subject Cost</th>
						<th >Status</th>
					</tr>
                </thead>
                <tbody>
                    <?php $i=1;
					 while ($data = $result->fetch_assoc()){												
					 ?>
						<tr id="<?php echo $data['id']; ?>">
							<td class="align-center"><?php echo $i; ?></td>							
							<td class="align-center"><?php echo $data['course_name']; ?>
								<input type="hidden" name="course_id" value="<?php echo $data['course_id']; ?>"/>
								<input type="hidden" name="row_id[]" value="<?php echo $data['id']; ?>"/>
								<input type="hidden" id="total_rows" name="total_rows" value="<?php echo $result->num_rows; ?>"/>
							</td>
							<td class="align-center"><?php echo $data['course_code']; ?></td>
							<td class="align-center"><?php echo $data['batch_name']; ?>
								<input type="hidden" name="batch_id" value="<?php echo $data['batch_id']; ?>"/>
							</td>
							<td class="align-center"><?php echo $data['subject_name']; ?>
								<input type="hidden" name="subject_id" value="<?php echo $data['subject_id']; ?>"/>
							</td>
							<td class="align-center"><?php echo $data['required_subject_name']; ?>
								<input type="hidden" name="required_subject_id" value="<?php echo $data['required_subject_id']; ?>"/>
							</td>
							<td class="align-center"><input type="text" class="ipt" id="max_students<?php echo $i; ?>" name="max_students[]" value="<?php echo $data['max_students']; ?>" size="10px"/></td>
							<td class="align-center"><input type="text" class="ipt" id="min_students<?php echo $i; ?>" name="min_students[]" value="<?php echo $data['min_students']; ?>" size="10px"/></td>
							<td class="align-center"><?php echo $data['cost']; ?></td>
							<td>
							<?php if($data['status'] == 1) {?>
							<img id="status-user<?php echo $data['id'];?>" src="../images/status-active.png"  class="status-user-cls" onClick="setStatus(<?php echo $data['id']; ?>)" title="Disable" />
							<?php }else{ ?>
							<img id="status-user<?php echo $data['id'];?>" src="../images/status-deactive.png"  class="status-user-cls" onClick="setStatus(<?php echo $data['id']; ?>)" title="Enable" />
							<?php } ?>
							</td>
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
