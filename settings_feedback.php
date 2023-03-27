<?php
require '../library/pageFunction.php';
require 'settings.php';

?>
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
							<tr class="slab"style="background-color:rgba(0, 185, 255, 0.1)" onclick="forward_feedback()">
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
<div class="rightcolumn_set">
			<?php
						if(isset($_POST['submit'])){
							$fdetails=$_POST['fdetails'];
							writefeedBack($_SESSION['user_id'],$fdetails);
						}
						if(isset($_POST['delete'])){
							$feedback_id=$_POST['feedback_id'];
							$sql1 = "delete from feedback where feedback_id=$feedback_id";
							if ($con->query($sql1)==true) {	
								echo "<script>FeedBack deleted successfully</script>";
							}
							else{
								echo $con->error;
							}
						}
					?>
				<h2 align="center">Feedback History</h2>
				<?php
					$sql1 = "SELECT * from feedBack where user_id=$suser_id";
					$result1= $con->query($sql1);
					if($result1->num_rows>0){	?>
						<table cellpadding=10 align="center" style="background-color:linen;border-radius:25px;padding:10px;">
						<th>Details</th>
						<th>Date/Time</th>
						<?php
						while($row=$result1->fetch_assoc()){
								$odate= $row["feedback_date"];
								$feedback_date = date("d-m-Y:h:i:sa", strtotime($odate));
								?>	
											<tr style="text-align:center">
												<td><?php echo $row['feedback_details']?></td>
												<td><?php echo $row['feedback_date']?></td>
												<td ><form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
													<input type="hidden" name="feedback_id" value="<?php echo $row['feedback_id'];?>">
													<button name="delete"  style="padding:5px;width:70px"><img src="../images/icons/delete_icon.png" alt="Person" style="width:40px;height:40px;"> </button>
													</form>
												</td>
											</tr>
									
								<?php
						}
						?></table>
						<?php
					}
				?>
				<button onclick="document.getElementById('feedback').style.display='block'">Write New feedback</button>
				<div id="feedback" class="modal">
				<form class='modal-content animate' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post' style='height:auto;'>
					<div class='imgcontainer'>
						 <span onclick="document.getElementById('feedback').style.display='none';" class='rarr' >&larr;</span>
					</div>
					<div class="container">
						  <h2 align="center">Help us to improve... </h2>
						  <h4 align="center">Submit your feedback</h4>	
						 
							<div class="row">
							  <div class="col-25">
								<label for="subject">Subject</label>
							  </div>
							  <div class="col-75">
								<textarea id="subject" name="fdetails" placeholder="Write something.." style="height:200px"></textarea>
							  </div>
							</div>
							<div>
							  <button name="submit" value="submit">Submit</button>
							</div>
						  </form>
					</div>
		
		
</div>


