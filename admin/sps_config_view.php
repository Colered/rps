<?php include('header.php');?>
<?php
$obj = new Spsconfig();
$result = $obj->getAllConfig();
?>
<div id="content">
    <div id="main">
		<div class="full_w green center">
		<?php if(isset($_SESSION['succ_msg'])){ echo $_SESSION['succ_msg']; unset($_SESSION['succ_msg']);} ?>
		</div>
        <div class="full_w">
            <div class="h_title">SPS configuration View
			</div>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th >ID</th>
                        <th >Start Date</th>
						<th >End Date</th>                        
                        <th >Added On</th>
						<th >Last Updated On</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>

					<?php while ($data = $result->fetch_assoc()){ ?>
					<tr>
                        <td class="align-center"><?php echo $data['id'] ?></td>
                        <td><?php echo $data['sps_start_date'] ?></td>
						<td><?php echo $data['sps_end_date'] ?></td>                        
                        <td><?php echo $data['date_add'] ?></td>
						<td><?php echo $data['date_update'] ?></td>
							<td class="align-center" id="<?php echo $data['id'] ?>">
									 <a href="sps_config.php?edit=<?php echo base64_encode($data['id']) ?>" class="table-icon edit" title="Edit"></a>
									 <a href="#" class="table-icon delete" onClick="deleteConf(<?php echo $data['id'] ?>)"></a>
							</td>
                        </td>
                    </tr>
					<?php }?>
                </tbody>
            </table>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('../footer.php');?>


