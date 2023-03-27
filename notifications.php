<?php
require '../library/pageFunction.php';
require 'master.php';

?>
<div class="rightcolumn">
			<section id="reports">
					<div class="card">
						<h3>Notifications</h3>
						
						</div>
						 <?php
						 if(!isset($_COOKIE['area'])){
							 ?><h1 style="color:red">Area selection pending!!</h1>
							 <a href="settings_department.php">Select Now</a>
						 <?php }?>
						
		</section>
</div>

