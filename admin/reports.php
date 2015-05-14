<?php include('header.php');?>
<div class="report-name">
<h3>CAREER SUBJECT GROUP REPORT</h3>
</div>
<div class = "activity-color-filteration"> 
	<form id="career_filter" name="career_filter" method="post" action="" novalidate="novalidate">	
		<strong>SELECT CAREER: </strong>
		<select id="career" name="career" class="select-filter" onchange="" style="width:110px;"> 
			<option value="" selected="selected">--Select--</option>
			<option value="1">MBA</option>
			<option value="2">MCA</option>
			<option value="3">MEDICINA</option>
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
			<tr>
				<td class="align-center">SUBJECT7</td>
				<td class="align-center">SBJCT07-T-002</td>                        
				<td class="align-center">12</td>
				<td class="align-center">23</td>
				<td class="align-center">$12,000.00</td>
				<td class="align-center">Prof. Jose Disla</td>
			</tr>
			<tr>
				<td class="align-center">SUBJECT7</td>
				<td class="align-center">SBJCT07-T-002</td>                        
				<td class="align-center">12</td>
				<td class="align-center">23</td>
				<td class="align-center">$12,000.00</td>
				<td class="align-center">Prof. Jose Disla</td>
			</tr>
			<tr>
				<td class="align-center">SUBJECT7</td>
				<td class="align-center">SBJCT07-T-002</td>                        
				<td class="align-center">12</td>
				<td class="align-center">23</td>
				<td class="align-center">$12,000.00</td>
				<td class="align-center">Prof. Jose Disla</td>
			</tr>
			<tr>
				<td class="align-center">SUBJECT7</td>
				<td class="align-center">SBJCT07-T-002</td>                        
				<td class="align-center">12</td>
				<td class="align-center">23</td>
				<td class="align-center">$12,000.00</td>
				<td class="align-center">Prof. Jose Disla</td>
			</tr>
			<tr>
				<td class="align-center">SUBJECT7</td>
				<td class="align-center">SBJCT07-T-002</td>                        
				<td class="align-center">12</td>
				<td class="align-center">23</td>
				<td class="align-center">$12,000.00</td>
				<td class="align-center">Prof. Jose Disla</td>
			</tr>
			<tr>
				<td class="align-center">SUBJECT7</td>
				<td class="align-center">SBJCT07-T-002</td>                        
				<td class="align-center">12</td>
				<td class="align-center">23</td>
				<td class="align-center">$12,000.00</td>
				<td class="align-center">Prof. Jose Disla</td>
			</tr>
		</tbody>
	</table>			 
</div>
<?php include('../footer.php');?>


