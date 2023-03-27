<?php
	if(isset($_POST['area'])){
							$area_name=$_POST['city'];
							setcookie ("area",$area_name);
							
							?><meta http-equiv="refresh" content="0; url= http://localhost/project/user/settings_department.php"><?php
	}
	if(isset($_POST['delete_area'])){
							
							setcookie ("area","");
							?><meta http-equiv="refresh" content="0; url= http://localhost/project/user/settings_department.php"><?php
	}
?>

<?php

require 'settings.php';

?>

<style>
.row h3{
	color:brown;
}
</style>
<div class="leftcolumn_set">
				<h2 align="center">Settings</h2>
						<div class="header" style="width:16%;height:85%;margin-top:5px" id="leftpanel">
						<table cellpadding=7>
							<tr class="slab" onclick="forward_Info()">
								<td>
								<div class="chipsl">
								<a href="settings_user.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/user_settings.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Personal Info
								</td>
							</tr>
							<tr class="slab" style="background-color:rgba(0, 185, 255, 0.1)" onclick="forward_dept()">
								<td>
								<div class="chipsl" >
									<a href="settings_department.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/dept.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Department
								</td>
							</tr>
							<tr class="slab"  onclick="forward_feedback()">
								<td>
								<div class="chipsl">
									<a href="settings_feedback.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/feedback.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								FeedBack
								</td>
							</tr>
							<tr class="slab" onclick=" forward_logout()"> 
								<td>
								<div class="chipsl">
									<a href="logout.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/logout.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Logout
								</td>
							</tr>
							<tr class="slab" onclick="forward_home()"> 
								<td>
								<div class="chipsl">
									<a href="home.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/Home.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Home
								</td>
							</tr>
							
						</table>
						
						</div>
			  </div>
<div class="rightcolumn_set">
			
					<div class="card">
						<h2>Department(police station) of your area</>
					</div>
						<?php
						if(!isset($_COOKIE['area'])){
							 ?>
								<h3 style="color:red">Selection pending!!</h3>
							 <p><b font color="red">Note:<b>This selection is only for knowing latest crime reports in your area</p>
							 <button onclick="document.getElementById('area').style.display='block'">Select Now</button>
						 <div id="area" class="modal" >
							<form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" style="height:300px">
							<h2 align="center">Select your City</h2>
							<div class="container"> 
							<?php
								$sql="select dname,dept_id from dept";
								$result=$con->query($sql);
								if($result->num_rows>0)
									{?>
										<select class="dropdown" name="city" ><?php
											while($row=$result->fetch_assoc()){
												?>
												<option><?php echo $row['dname']?></option>	
											<?php
										}
									?></select><?php
									}
							?>
							 
							  <button name="area">Submit</button>
							</div>
							<div class="container" style="background-color:#f1f1f1">
								<button type="button" onclick="document.getElementById('area').style.display='none'" class="cancelbtn">Cancel</button>
							</form>
							</div>
						</div>
							 <?php
							 
					}
					else{
						$area=$_COOKIE['area'];
						?>
						<div class="container">
							<div class="row">
						<?php
									$sql="select * from dept where dname='$area' ";
									$result=$con->query($sql);
									if($result->num_rows>0)
									{
										$row=$result->fetch_assoc();
										$dname=$row['dname'];
										$daddress=$row['daddress'];
										$email=$row['email'];
										$ds_date=$row['ds_date'];
									}
						
								?>
							<div style="width:49%;float:left;">
							<form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
							  <h3>Department Name: </h3><?php echo $dname;?><br>
							  <h3>Address: </h3><?php echo $daddress;?><br>
							  <h3>Email:</h3><?php echo $email;?><br>
							</div>
							<div style="width:49%;float:left;margin-left:2%;">
								 <h3>Joining Date:</h3> <?php echo $ds_date;?>
							</div>
							</div><br>
							<button name="delete_area">Remove department</button>
							</form>  
		</div><?php
	   
					}
						
								?>					
						
						
		


