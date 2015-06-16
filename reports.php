<?php
include('header.php');
?>
<script src="js/jquery.dataTables.js" type="text/javascript"></script>
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
	@import "css/demo_table_jui.css";
	@import "css/jquery-ui-1.8.4.custom.css";
</style>
<div id="content" style="margin-left:20px;width:80%;">
    <div id="main">
<div class="custtable_left fontstyles full_w" >
	<div class="h_title">Prerequisite Subject Report</div>
	<input type="hidden" name="stu_report" id="stu_report" value="stu_report"  />
	<?php 
	   $objR=new RAS();
	   $report='report';
	   $confirmSubData=$objR->reportStuSubject($report);?>
    <table id="datatables" class="display">
		<thead>
			<tr>
				<th >Status</th>
				<th >Subject Group</th> 
				<th >Subject Name</th>                        
				<th >Subject Session</th>
				<th >Subject Schedule</th>
				<th >Subject Room</th>
				<th >Date</th>
				<th>Teachers </th>		
			</tr>
		</thead>
		<tbody>
		<?php 
		if(count($confirmSubData)>0){
			foreach ($confirmSubData as $key=>$value){	
				if(!empty($value)){?>	
				 <tr>
					<td class="align-center"><strong>Pre-selected</strong></td>
					<td class="align-center"><?php echo $value['0']; ?></td>
					<td class="align-center"><?php echo $value['12']; ?></td>                        
					<td class="align-center"><?php echo $value['10']; ?></td>
					<td class="align-center"><?php echo $value['3']; ?></td>
					<td class="align-center"><?php echo $value['15']; ?></td>	
					<td class="align-center"><?php echo date('Y-m-d',strtotime($value['2'])); ?></td>
					<td class="align-center"><?php echo $value['4']; ?> </td>
				</tr> 
			<?php }	
			 }
		 }?>
		</tbody>
	</table>			 
</div>
</div>
</div>
<?php include('sidebar_right.php');
	  include('footer.php');
?>