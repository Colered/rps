<?php
include('header.php');?>
<link type='text/css' href='css/demo.css' rel='stylesheet' media='screen' />
<link href="http://www.jqueryscript.net/css/top.css" rel="stylesheet" type="text/css">
<!-- Contact Form CSS files -->
<link rel="stylesheet" type="text/css" href="css/basic.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/demo.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<script type='text/javascript' src='js/jquery.simplemodal.js'></script> 
<script type='text/javascript' src='js/basic.js'></script>
<?php
$obj_fedena=new Fedena();
$stuendt_subjects=$obj_fedena->getCurrentStuSemSub();
/*echo '<pre>';
echo "yes";
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
				<th colspan="3" >Suggested Subject Groups to take next semester according to {Course Name} For {Student Name}</th>
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

