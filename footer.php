<div id="footer">
    <div class="center" style="text-align:center; font-weight:normal">
	<p>&copy; 2014 COLERED. All rights reserved &nbsp;
	<?php if(isset($_SESSION['role']) && $_SESSION['role'] != 1)
	{?>   | &nbsp;<a style="font-weight:normal" href="about_us.php" target="_self"> About Us</a>&nbsp; 	
		  | &nbsp;<a style="font-weight:normal" href="help.php" target="_self">Help</a>	
	<?php } ?>
	</p>
    </div>
</div>
</div>
</body>
</html>
