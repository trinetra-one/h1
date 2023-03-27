<?php
	require '../database/database.php';
	require '../library/lib.php';
	if(!isset($_SESSION['uname'])){
		header("Location: http://192.168.29.62/project/user/index.php");
	}
	$suser_id=$_SESSION['user_id'];
	$suname=$_SESSION['uname'];
	$sfname=$_SESSION['fname'];
?>
<html>
	<head>
		<title>Trinetra User</title>
		<link rel = "icon" href="./images/logo_final.png" type = "image/x-icon" style="border-radius:10px">
		<link rel="stylesheet"  href="../css/home.css">
		<link rel="stylesheet" href="../css/index.css">
		<link rel="stylesheet"  href="../css/uploadchip.css">
		<link rel="stylesheet"  href="../css/tooltip.css">
		<link rel = "icon" href="../images/header.png"type = "image/x-icon">
	</head>
	<body style=" background:#cccccc">
	<?php
	
	if(isset($_POST['report'])){

		$ctitle=test_input($_POST['crime_title']);
		$cdetails=$_POST['crime_details'];
		$cdate=test_input($_POST['crime_date']);
		$ccity=test_input($_POST['city']);
		$complaint_status=$_POST['complaint_status'];
		$user_id=$_SESSION['user_id'];
		
		if(empty($ctitle) || empty($cdetails)  || empty($cdate) || empty($ccity) ){
				$msg="all fields must be filled!!";
				signupDiv($uname,$moe,$fname,$password,$msg);
		}
		else{	
				echo "$ctitle,$cdetails,$cdate,$ccity,$user_id,$complaint_status";
				reportCrime($ctitle,$cdetails,$cdate,$ccity,$user_id,$complaint_status);
				//upload files 
				$add = $_SESSION['crime_id'];
				$add1="CR".$add;
				$path="../upload/exp/".$add1;
				$flag=0;
				mkdir($path);
				echo "<script type = 'text/javascript'>alert('Crime was reported successfully');</script>";
				foreach($_FILES['upload']['name'] as $key=>$val){
					$flag++;
					$temp = explode(".",$_FILES["upload"]["name"][$key]);
					$name = 'media'.$flag . '.' . end($temp);
					move_uploaded_file($_FILES['upload']['tmp_name'][$key],$path.'/'.$name);
					//auto increment code
					$sql = "SELECT max(media_id) from media";
					$result= $con->query($sql);
					if($result->num_rows>0)
						{
							while($row=$result->fetch_assoc()){
							$counter=$row['max(media_id)'] ;
						}
						$counter++;	
					}
					else{
						$counter=1;
					}
					$type=$_FILES['upload']['type'][$key];
					$sql="insert into media values($counter,$add,'$type','$name')";
					$con->query($sql);
				}
				
				
		}
		/*
		echo "<script>submitForm()	</script>";
		$selectedfilelist = $_POST['selectedfilelist'];
		$selectedfiles = explode("," , $selectedfilelist);
		print_r($selectedfiles);*/		
	}
	
	?>
	<img src="../images/logo_final.png" class="logo_final" ></img>	
		<div class="header">
		
			<div class="menu-bar menu">
						<div class="col-md-4" style="width:20%;float:left;padding-top:5px;padding-left:50px">
							<a href="home.php"><img src="../images/text.png" style="width:150px;margin-left:120px"></img></a>
							
						</div>
						<div class="col-md-8" style="width:80%;float:right">
							
							  <div class="chip" style="margin:0;width:auto;padding:0">
							  <a onclick="document.getElementById('lines').style.display='block'"><img src="../images/icons/nav_lines.png" alt="Person" style="margin-left:10px;padding:10px"><img src="../images/icons/user_light.png" alt="Person" style="padding:10px"></a>
							  </div>
							
	
						</div>
				</div>
			</div>	
	<div class="row">
	<div class="leftcolumn">
				<div class="header" style="width:5%;height:85%;" id="leftpanel">
						<div class="reportbtn" style="background-color:lightblue">
							  <a onclick="document.getElementById('report').style.display='block'"  style="padding-left:5px;padding-top:5px;position:absolute" class="tooltip"><img src="../images/icons/report1.png" alt="Person" ></img></a>
						</div>
						<div class="chipsl" >
							  <a href="home.php" style="padding-left:5px;padding-top:5px;position:absolute" class="tooltip"><img src="../images/icons/home.png" alt="Person"></img></a>
						</div>
						<div class="chipsl" >
							  <a href="reports.php" style="padding-left:5px;padding-top:5px;position:absolute" class="tooltip"><img src="../images/icons/report_icn.png" alt="Person"></img></a>
						</div>
						<div class="chipsl" >
							  <a href="notifications.php" style="padding-left:5px;padding-top:5px;position:absolute" class="tooltip"><img id="bell" src="../images/icons/bell_light.png" alt="Person"></img></a>
						</div>
						<div class="chipsl" >
							  <a href="latest.php" style="padding-left:5px;padding-top:5px;position:absolute" class="tooltip"><img id="bell" src="../images/icons/latest_updates.png" alt="Person" ></img></a>
						</div>
						<div class="chipsl" style="margin-top:170px;">
							  <a href="settings_user.php" style="padding-left:5px;padding-top:5px;position:absolute"class="tooltip"><img src="../images/icons/settings_light.png" alt="Person"></img></a>
						</div>
				</div>
	  </div>
	<div class="rightcolumn">	
		
	</div>
	</div>
	<!--settings-->
		
		<!-- report-->
	<div id="report" class="modal">
	  <form id="reportForm" class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="post"  enctype="multipart/form-data" style="margin:auto;width:80%">
		<div class="imgcontainer">
		   <span onclick="document.getElementById('report').style.display='none'" class="rarr" >&larr;</span>
		</div>
		<h2 align="center">Report Crime</h2>
		<div class="container">
		<div class="row">
		<div style="width:49%;float:left;">
		  <input type="text" name="crime_title" placeholder="Crime Title"  maxlength="12" required>
		  <textarea name="crime_details" class="multitext" placeholder="Crime_Details" required></textarea>
				<input type="checkbox"  id="checkbox" name="remember" onchange="javascript:check(this)"> File complaint<br>
				<p style="color:brown">Note: Filing complaint is necessary to receive response from department</p>
				<input type="hidden" name="complaint_status" value="1" id="c_status">
			  <input type="file" name="upload[]" id="file" multiple hidden onchange="javascript:updateList()"/><br>	  
		</div>
		<div style="width:49%;float:left;margin-left:2%;">
			<input type="date" name="crime_date" id="crime_date" value="MM/DD/YYYY" required>
			<select class="dropdown" name="city">
				<option>Ahmedabad</option>
				<option>Surat</option>	
				<option>Vadodara</option>	
				<option>Rajkot</option>
				<option>Bhavnagar</option>	
				<option>Jamnagar</option>	
				<option>Gandhinagar</option>
				<option>Junagadh</option>	
				<option>Gandhidham</option>
				<option>Anand</option>	
				<option>Navsari</option>	
				<option>Morbi</option>	
				<option>Nadiad</option>	
				<option>Surendranagar</option>		
				<option>Bharuch</option>	
				<option>Mehsana</option>	
				<option>Bhuj</option>
				<option>Porbandar</option>	
				<option>Palanpur</option>
				<option>Valsad</option>		
				<option>Vapi</option>	
				<option>Gondal</option>		
				<option>Veraval</option>	
				<option>Godhra</option>		
				<option>Patan</option>	
				<option>Kalol</option>	
				<option>Dahod</option>	
				<option>Botad</option>	
				<option>Amreli</option>	
				<option>Deesa</option>		
				<option>Jetpur</option>	
			 </select>
		  
			<div id="fileList" class="list" style="padding:10px;">	
				<label for="file" ><img src="../images/icons/upload.png" alt="Person"  style="height:40px;width:40px;margin-top:5%;margin-left:45%;cursor:pointer"></label> 
			</div>
			
				<img src="../images/icons/reset.png" alt="Person" style="margin:0;height:40px;width:40px;padding:5px;cursor:pointer" onclick="reset()">
				
			<input id="selectedfilelist" name="selectedfilelist" type="hidden" value ="">	
			
		</div>
		</div><br>
		  <button name="report" >Submit</button>
		  <p id="output"></p>
		</div>
	   
	  </form>
	</div>
	<div id="lines" class="modal" style="background-color:transparent;">	
		<div class="container" style="width:15%;float:right;margin-top:50px;margin-right:30px;background-color:white;border-radius:25px">
			<table cellpadding=7>
							<tr class="slab" onclick="forward_Info()">
								<td>
								<div class="chipsl">
								<a href="settings_user.php" style="padding-left:5px;padding-top:5px;position:absolute"><img src="../images/icons/user_light.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								Profile
								</td>
							</tr>
							<tr class="slab" onclick="forward_logout()">
								<td>
								<div class="chipsl">
								<a href="logout.php" style="padding-left:5px;padding-top:5px;position:absolute;text-decoration: none;"><img src="../images/icons/logout.png" alt="Person"></a>
								</div>
								</td>
								<td style="padding-bottom:15px">
								logout
								</td>
							</tr>
				</table>
	</div>
</div>
	</body>

	<script src="../javascript/upload.js"></script>
	
	<script>
		
		var report = document.getElementById('report');
		var lines=document.getElementById('lines');
		window.onclick = function(event) {
		   
			 if(event.target== report){
				report.style.display="none";
				}
		}
		window.onclick = function(event) {
		   
			 if(event.target== lines){
				lines.style.display="none";
				}
		}
		function check(checkboxElem) {
			  if (checkboxElem.checked) {
				document.getElementById('c_status').value = 0;	
			  } else {
				document.getElementById('c_status').value = 1;
			  }
			}
		function reset(){
			document.getElementById('file').value="";
			document.getElementById('fileList').style.backgroundColor="lightgrey";
			document.getElementById('fileList').innerHTML='<label for="file" ><img src="../images/icons/upload.png" alt="Person"  style="height:40px;width:40px;margin-top:5%;margin-left:45%;cursor:pointer"></label> ';
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
                window.location='http://localhost/project/user/logout.php';
            } else {
              
            }
           
        
	}
	function forward_home(){
		window.location='http://localhost/project/user/home.php';
	}
	</script>
	
</html>
