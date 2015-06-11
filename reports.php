<?php
include('header.php');?>
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
	<table id="datatables" class="display">
		<thead>
			<tr>
				<th >Status</th>
				<th >Subject Group / Class</th>                        
				<th >Subject Name</th>
				<th >Subject Schedule</th>
				<th >Subject Room</th>
				<th >Credits</th>
				<th>Teachers </th>		
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="align-center"><strong>Pre-selected</strong></td>
				<td class="align-center">SBJCT011 - T- 001</td>                        
				<td class="align-center">SUBJECT 11</td>
				<td class="align-center">S-8:00-12:00</td>
				<td class="align-center">A3- 310</td>	
				<td class="align-center">4</td>
				<td class="align-center">Prof. Julia Smith </td>
			</tr>
			<tr>
				<td class="align-center"><strong>Pre-selected</strong></td>
				<td class="align-center">SBJCT011 - T- 001</td>                        
				<td class="align-center">SUBJECT 11</td>
				<td class="align-center">S-8:00-12:00</td>
				<td class="align-center">A3- 310</td>	
				<td class="align-center">4</td>
				<td class="align-center">Rohit </td>
			</tr>
			<tr>
				<td class="align-center"><strong>Pre-selected</strong></td>
				<td class="align-center">SBJCT011 - T- 001</td>                        
				<td class="align-center">SUBJECT 11</td>
				<td class="align-center">S-8:00-12:00</td>
				<td class="align-center">A3- 310</td>	
				<td class="align-center">4</td>
				<td class="align-center">Prof. Julia Smith </td>
			</tr>
			<tr>
				<td class="align-center"><strong>Pre-selected</strong></td>
				<td class="align-center">SBJCT011 - T- 001</td>                        
				<td class="align-center">SUBJECT 11</td>
				<td class="align-center">S-8:00-12:00</td>
				<td class="align-center">A3- 310</td>	
				<td class="align-center">4</td>
				<td class="align-center">Prof. Julia Smith </td>
			</tr>
			<tr>
				<td class="align-center"><strong>Pre-selected</strong></td>
				<td class="align-center">SBJCT011 - T- 001</td>                        
				<td class="align-center">SUBJECT 11</td>
				<td class="align-center">S-8:00-12:00</td>
				<td class="align-center">A3- 310</td>	
				<td class="align-center">4</td>
				<td class="align-center">Prof. Julia Smith </td>
			</tr>
			<tr>
				<td class="align-center"><strong>Pre-selected</strong></td>
				<td class="align-center">SBJCT011 - T- 001</td>                        
				<td class="align-center">SUBJECT 11</td>
				<td class="align-center">S-8:00-12:00</td>
				<td class="align-center">A3- 310</td>	
				<td class="align-center">4</td>
				<td class="align-center">Prof. Julia Smith </td>
			</tr>
		</tbody>
	</table>			 
</div>
</div>
</div>
<?php include('sidebar_right.php');
	  include('footer.php');
?>

