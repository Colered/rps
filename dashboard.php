<?php
include('header.php');

$obj_fedena=new Fedena();
$stuendt_subjects=$obj_fedena->getCurrentStuSemSub();
/*echo '<pre>';
print_r($stuendt_subjects);
die;*/
?>
<div class="custtable_left fontstyles" style="margin-left:20px;width:80%;">
	<table id="datatables-left" class="display">
		<thead>
			<tr>
				<th >Subjects Currently Taking</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($stuendt_subjects as $key=>$val){ ?>
			<tr>
				<td class="align-left"><?php echo $key;//echo '<pre>'; print_r($val); ?> <span class="subject-heading-1"><a href="#">See Details</a></span></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	
	<table id="datatables-right" class="display">
		<thead>
			<tr>
				<th colspan="3" >Suggested Subject Groups to take next semester according to {Course Name} For {Student Name}
</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="align-center">SUBJECT1</td>                        
				<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
				<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
			</tr>
			<tr>
				<td class="align-center">SUBJECT1</td>                        
				<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
				<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
			</tr>
			<tr>
				<td class="align-center">SUBJECT1</td>                        
				<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
				<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
			</tr>
			<tr>
				<td class="align-center">SUBJECT1</td>                        
				<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
				<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
			</tr>
			<tr>
				<td class="align-center">SUBJECT1</td>                        
				<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
				<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
			</tr>
			<tr>
				<td class="align-center">SUBJECT1</td>                        
				<td class="align-center"><span class="subject-heading-1"><a href="#">Confirm SG:</a></span> L-M-V-8:00-10:00 - A4 103 - Prof. Jose Disla </td>
				<td class="align-center"><span class="subject-heading-1"><a href="#">See other availaible SG</a></span></td>	
			</tr>
		</tbody>
	</table>			 
</div>
<?php include('sidebar_right.php');
	  include('footer.php');
?>

