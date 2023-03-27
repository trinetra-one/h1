<?php
	include 'settings.php';
?>
<div class="leftcolumn_set">
				<h2 align="center">Settings</h2>
						<div class="header" style="width:16%;height:85%;margin-top:5px" id="leftpanel">
						<table cellpadding=7>
							<tr class="slab" style="background-color:rgba(0, 185, 255, 0.1)" onclick="forward_Info()">
								<td>
								<div class="chipsl">
								<a href="settings_user.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/user_settings.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Personal Info
								</td>
							</tr>
							<tr class="slab" onclick="forward_dept()">
								<td>
								<div class="chipsl" >
									<a href="settings_department.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/dept.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Department
								</td>
							</tr>
							<tr class="slab" onclick="forward_feedback()">
								<td>
								<div class="chipsl">
									<a href="settings_feedback.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/feedback.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								FeedBack
								</td>
							</tr>
							<tr class="slab" onclick="forward_logout()"> 
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
									<a href="home.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/home.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Home
								</td>
							</tr>
							
						</table>
						
						</div>
			  </div>
<div class="rightcolumn_set" >	
		
		<h2 align="center">Personal information</h2>
		<div class="card">
		<div class="container">
		<div class="row">
		<?php
									$sql="select * from user where isdel=1 and user_id=$suser_id;";
									$result=$con->query($sql);
									if($result->num_rows>0)
									{
										$row=$result->fetch_assoc();
										
										$uname=$row['uname'];
										$fname=$row['fname'];
										$password=$row['password'];
										$mobile_no=$row['mobile_no'];
										$email=$row['email'];
										$rdate= $row["sdate"];
										$sdate = date("d-m-Y:h:i:sa", strtotime($rdate));
									}
						if(isset($_POST['update'])){
							
							$fname=$_POST['fname'];
							$password=$_POST['password'];
							$mo=$_POST['mobile_no'];
							$email=$_POST['email'];
									if($mo!=""){	
										if(int_val($mo)==true){
													if(strlen((string)$mo)==10){
														update($fname,$password,$mo,$email);
													}
													else{
														echo "<script>alert('Mobile number is invalid!');</script>";	
														?><meta http-equiv="refresh" content="0; url= http://localhost/project/user/settings_department.php"><?php
													}
												}
											else{
												echo "<script>alert('Mobile number is invalid!');</script>";
												?><meta http-equiv="refresh" content="0; url= http://localhost/project/user/settings_department.php"><?php
											}
									}
									else{
										
										update($fname,$password,NULL,$email);
									}
									if($email!=""){
											if(email_val($email)===true){
												
												update($fname,$password,$mo,$email);
											}
											else {
												
												echo "<script>alert('Email is invalid!');</script>";
											}
									}
									else{
										$email="";
										update($fname,$password,$mo,$email);
									}
							}
						
						function update($fname,$password,$mo,$email){
								require '../database/dblib.php';
								$suser_id=$_SESSION['user_id'];
								$sql="update user set fname='$fname',password='$password',mobile_no=$mo,email='$email' where user_id=$suser_id";
								echo $sql;
								if ($con->query($sql)==true) 
								{
									?><meta http-equiv="refresh" content="0; url= http://localhost/project/user/settings_department.php"><?php
									
								}
								else{
										echo "<script>alert('Error updating details');</script>";	
									}
							}
								?>
		<div style="width:49%;float:left;">
		<form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		  User Name: <input type="text" name="uname" id="uname" value="<?php echo $uname;?>" disabled spellcheck="false" required>
		  Full Name: <input type="text" name="fname" id="fname" value="<?php echo $fname;?>"  spellcheck="false" required>
		  password: <input type="password" name="password" id="password" value="<?php echo $password;?>"   spellcheck="false" required>
		  <label>
			<input type='checkbox' id='show' onclick="showPassword()">Show password
		  </label>
		</div>
		<div style="width:49%;float:left;margin-left:2%;">
			  Mobile No: <input type="text" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no;?>"  spellcheck="false" >
			  Email: <input type="text" name="email" id="email" value="<?php echo $email;?>"   spellcheck="false" >
			 Joining Date: <?php echo $sdate;?>
		</div>
		</div><br>
		  <button name="update" >Update</button>
		</form>  
		</div>	
		</div>	
	</div>
	<script>
	function myFunction(var1) {
		document.getElementById(var1).readonly = false;
		document.getElementById(var1).focus();
	}
	function myFunctionlost(var1){
		document.getElementById(var1).disabled = true;
	}
	function convertVal(var1,var2){
		var form = document.getElementById( 'form1' );
		var allFormControls = form.elements;
		allFormControls.forEach(myFunction(var1));
	}
	function showPassword() {
	
	var check=document.getElementById('show');
			  if (check.checked) {
					document.getElementById('password').type="text";
			  } else {
					document.getElementById('password').type="password";
			  }
			}

	</script>