<?php
	require '../database/database.php';
	require '../library/lib.php';
	if(!isset($_SESSION['uname'])){
		header("Location: http://localhost/project/user/index.php");
	}
	$suser_id=$_SESSION['user_id'];
	$suname=$_SESSION['uname'];
	$sfname=$_SESSION['fname'];
?><html>
	<head>
		<title>Trinetra</title>
		<link rel = "icon" href="./images/logo.png" type = "image/x-icon" style="border-radius:10px">
		<link rel="stylesheet"  href="../css/home.css">
		<link rel="stylesheet" href="../css/index.css">
		<link rel="stylesheet" href="../css/settings.css">
		
		<link rel="stylesheet"  href="../css/uploadchip.css">
		<link rel = "icon" href="../images/header.png"type = "image/x-icon">
	</head>
<body>
	
	
		
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
							
							
						</table>
						
						</div>
			  </div>
			  
				<div class="rightcolumn_set">	
					
				</div>
			  
			</body>
<script>
	function Previous() {
            window.history.back()
        }
	function forward_Info(){
		window.location='http://localhost/project/user/settings_user.php';
	}
	function forward_feedback(){
		window.location='http://localhost/project/user/settings_feedback.php';
	}
	function forward_dept(){
		window.location='http://localhost/project/user/settings_department.php';
	}
	function forward_logout(){
            var doc;
            var result = confirm("Do you really want to logout!");
            if (result == true) {
                window.location=' http://192.168.29.62/project/user/logout.php';
            } else {
              
            }
           
        
	}
	function forward_home(){
		window.location='http://localhost/project/user/home.php';
	}
			</script>
	</html>