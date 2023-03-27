<?php
	require '../database/database.php';
	require '../library/lib.php';
	if(isset($_SESSION['uname'])){
		header("Location: http://192.168.29.62/project/user/home.php");
	}
?>
<html>
<head>
<title>Trinetra User-login</title>
<link rel = "icon" href="./images/logo_final.png" type = "image/x-icon" style="border-radius:10px">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"  href="../css/index.css">
<style>
button{
	
	color:black;
}
</style>
</head>
<body>
<?php
if(isset($_POST['btnsignup'])){
	$uname=test_input($_POST['uname']);
	$password=test_input($_POST['password']);
	$fname=test_input($_POST["fullname"]);
	$moe=test_input($_POST['mobile_no/email']);
		if(empty($uname) || empty($password)  || empty($fname) || empty($moe)){
				$msg="all fields must be filled!!";
				signupDiv($uname,$moe,$fname,$password,$msg);
		}
		else{
				$sql = "SELECT uname from user where uname='$uname'";
				$result= $con->query($sql);
				if($result->num_rows>0)
				{
						
							$msg="Username already exists. please try another one!!";
							signupDiv($uname,$moe,$fname,$password,$msg);
							
				}
				else{

						if(int_val($uname)==false){
								if(int_val($moe)===true){
									$mo=$moe;
									$email="";
									if(strlen((string)$mo)==10){
										signup($fname,$uname,$password,$mo,$email);
									}
									else{
										$msg="Mobile number is invalid!";
										signupDiv($uname,$moe,$fname,$password,$msg);
									}
								}
								else if(email_val($moe)===true){
									$email=$moe;
									signup($fname,$uname,$password,$mo,$email);
								}
								else {
									$msg="Please enter valid mobile number or email address!";
									signupDiv($uname,$moe,$fname,$password,$msg);
								}
						}
						else{
							$msg="Username cannot be only numbers!!";
							signupDiv($uname,$moe,$fname,$password,$msg);
						}
				}					
			}			
				
				
	}

if (isset($_POST['btnlogin'])) {
			
			$uname=test_input($_POST['uname']);
			$password=test_input($_POST['password']);
			$sql = "SELECT user_id,uname,password,fname from user where uname='$uname' and password='$password' and isdel=1";
			$result= $con->query($sql);
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
				if($row['uname']=== $uname && $row['password']=== $password){	
					
					$_SESSION['uname']=$uname;
					$_SESSION['user_id']=$row['user_id'];
					$_SESSION['fname']=$row['fname'];
					header("Location: home.php");
				}
				else{
					loginDiv($uname,$password);
				}
			}
		}
		else{
				loginDiv($uname,$password);
			}
				$con->close();
}
if(isset($_POST['btnfrgpsw'])){
			$uname=test_input($_POST['uname']);
			$moe=test_input($_POST['mobile_no/email']);
			$sql = "SELECT uname,mobile_no,email from user where uname='$uname'";
			$result= $con->query($sql);
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc()){
				if($row['uname']=== $uname){					
					if($row['mobile_no']===$moe){
						$msg="Vefication successful.";
						forgotPswConf($uname,$moe,$msg);				
					}
					else if($row['email']===$moe){
						$msg="Vefication successful.";
						forgotPswConf($uname,$moe,$msg);
					}
					else{
						  $msg= "mobile number or email dosen't match"; 
						   forgotPsw($uname,$moe,$msg);
					}
				}
				else{
					 $msg= "Invalid username.please try again";
					forgotPsw($uname,$moe,$msg);					 
				}
			}
		}
		else{
				 $msg= "Invalid username.please try again";
					forgotPsw($uname,$moe,$msg);
			}
				$con->close();
}
if(isset($_POST['btnfrgpswConf'])){
			$uname=test_input($_POST['uname']);
			$password=test_input($_POST['password']);
			$moe=test_input($_POST['mobile_no/email']);
			$sql = "update user set password='$password' where uname='$uname'";
		if ($con->query($sql)==true) 
		{
			echo "<script>alert('Password was updated successfully');</script>";
			
		}
		else{
				 $msg= "Error updating password";
				forgotPswConf($uname,$moe,$msg);
			}
		$con->close();
}
?>
<div class="show"> 
<h2>Welcome</h2>
<button onclick="document.getElementById('login').style.display='block'" style="width:auto;font-size:20px;color:black;">Get started</button>
</div>

<!--login form-->
<div id="login" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>
      <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
    </div>
	<h2 align="center">login</h2>
    <div class="container"> 
	  <input type="text" placeholder="Enter Username" name="uname" id="uname"  required autocomplete="off" >
	  <input type="password" placeholder="Enter Password" name="password" id="password" required >
      <button name="btnlogin">Login</button>
	 <label>
		<input type='checkbox' id='show' onclick="showPassword()">Show password
	</label>
    </div>
    <div class="container" style="background-color:#f1f1f1">
    <!--  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>-->
    <span class="psw"> <a onclick="document.getElementById('frgtpsw').style.display='block'" style="width:auto;">Forgot password?</a></span>
    <span class="sgn">Don't have an account? <a onclick="document.getElementById('signup').style.display='block'" style="width:auto;">Signup</a></span>
	</div>
  </form>
</div>

<!-- Signup form-->
<div id="signup" class="modal" name="signup">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" style="margin:auto">
    <div class="imgcontainer">
       <span onclick="document.getElementById('signup').style.display='none'" class="rarr" >&larr;</span>
       <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
    </div>
	<h2 align="center">Signup</h2>
    <div class="container">
      <input type="text" name="mobile_no/email" placeholder="Mobile number or Email" autocomplete='off' required><br>
	  <input type="text" name="fullname" id="fullname" placeholder="Full Name" autocomplete='off' required>
	  <input type="text" name="uname" id="uname" placeholder="Username" autocomplete='off' required>
      <input type="password" name="password" id="password" placeholder="password" autocomplete='off' required>
      <button name="btnsignup">signup</button>
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('signup').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<!--forgot password form-->
<div id="frgtpsw" class="modal">
  <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="imgcontainer">
	  <span onclick="document.getElementById('frgtpsw').style.display='none'" class="rarr" >&larr;</span>
	  <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
    </div>
	<h2 align="center"> Forgot password</h2>
    <div class="container">
      <input type="text" placeholder="Enter username" name="uname" autocomplete='off' required> 
	   <input type="text" placeholder="Enter Mobile no/Email" name="mobile_no/email" autocomplete='off' required>
      <button name="btnfrgpsw">Verify</button>
    </div>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('frgtpsw').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>
<script src="modalcl.js"></script>
</body>
</html>
<script>

function showPassword() {
	
	var check=document.getElementById('show');
			  if (check.checked) {
					document.getElementById('password').type="text";
			  } else {
					document.getElementById('password').type="password";
			  }
			}
</script>