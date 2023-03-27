<?php
require '../library/pageFunction.php';
require 'master.php';

?>
<link rel="stylesheet" href="../css/reportbtn.css">
<link rel="stylesheet" href="../css/dots.css">
<style>
.row h3{
	color:brown;
}
</style>
<div class="rightcolumn">
<section id="reports">
<?php
if(!isset($_COOKIE['area'])){
							 ?><h1 style="color:red">Area selection pending!!</h1>
							 <a href="settings_department.php">Select Now</a><?php
					}
					else{?>

			
					<div class="card">	
					<?php
					$area=$_COOKIE['area'];
						if(isset($_POST['comment'])){
							$crimeid=$_POST['crimeid'];
							$content=$_POST['content'];
							writeComment($suser_id,$crimeid,$content);
					}
					?>
						<h3>latest crime reports in your area:<?php echo $area;?></h3>
						</div>
						 <?php
						  $suser_id=$_SESSION['user_id'];
								$sql = "SELECT * from crime where crime_location='$area' and isdel=1 and crime_status='v' and complaint_status=0";
								$result= $con->query($sql);
								if($result->num_rows>0)
								{
									
								while($row=$result->fetch_assoc()){
										$user_id=$row['user_id'];
										$sql1="select uname from user where user_id=$user_id";
										$result1=$con->query($sql1);
										if($result1->num_rows>0)
										{
											$row1=$result1->fetch_assoc();
											$uname=$row1['uname'];
										}
										$crimeid=$row['crime_id'];
										$cmt="cmt".$row['crime_id'];
										$crime="crime".$row['crime_id'];
										$resp="resp".$row['crime_id'];
										?><table class='report' onclick="document.getElementById('<?php echo $crime;?>').style.display='block';">
										<tr>
										<td style='width:40%'><?php echo $row['crime_title']; ?></td>
										<td style='margin-top:10px;float:right'>
										<div class="chip" style="width:35px;height:45px;background-color:transparent">
											<a onclick="document.getElementById('<?php echo $crime;?>').style.display='block';" ><img src="../images/icons/expand.png" alt="Person" style="width:35px;height:35px;margin-top:3px;"></a>
										</div>
										
										</td>
										</tr>
										</table>
										<?php
										$odate= $row["crime_date"];
										$newDate = date("d-m-Y", strtotime($odate));
										?>
										<div id='<?php echo $crime ?>' class='modal'> 
											<form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="post"  enctype="multipart/form-data" style="margin:auto;height:auto;width:70%">
												
												   <span onclick="document.getElementById('<?php echo $crime ?>').style.display='none'" class="rarr" style="position:relative;">&larr;</span>
												
												<div style="padding:10px;">
													<fieldset>
													<legend><h2 align="center"><?php echo $row['crime_title']?></h2></legend>
													<div class="container">
													<div class="row">
													<div style="width:49%;float:left;">
													
													  <h3>User name</h3>
													  <span><?php echo $uname?></span>
													  <h3>Crime Details</h3>
														<span><?php echo $row['crime_details']?></span>
														<h3>Crime Location</h3>
														<p><?php echo $row['crime_location']?></p>
													</div>												
													<div style="width:49%;float:left;margin-left:2%;">
														<h3 >Crime Date</h3>
														<p><?php echo $newDate?></p>
														<h3 >Reporing Date</h3>
														<p><?php echo $row['posting_date']?></p>
														
														<h4><?php if($row['complaint_status']==0){?>
																	<p style="color:green;">Complaint Filed</p><?php
																	}
																	else{?>
																	<p style="color:red;">Complaint not filed!!</p><?php
																	}
														?></h4>
														
													</div>
													<hr/>
													
													<div class="chip" style="width:20px">
														<img src="../images/icons/c.png" alt="Person" onclick="document.getElementById('<?php echo $cmt;?>').style.display='block';" style="cursor:pointer">
														</div>	
														
													</div>
													<br>
													</div>  
													</fieldset>	
												</div>												
										  </form>
										</div>
										
										<div id='<?php echo $cmt ?>' class='modal'>
											  <form class='modal-content animate' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post' style='margin:auto;height:350px;margin-top:10%;'>
												<div class='imgcontainer'>
												   <span onclick="document.getElementById('<?php echo $cmt;?>').style.display='none';" class='rarr' >&larr;</span>
												</div>
												<h2 align='center'>Comment</h2>
												<div class='container' style="height:150px;overflow-x:scroll; overflow-x: hidden;background-color:grey;">
													<?php
													comments($row['user_id'],$crimeid,$suser_id);
													?>		
													
												</div>
												<input type="text" name="content" placeholder="Write comment" >
													<button  name="comment">post</button>
													<input type='hidden' name='crimeid' value="<?php echo $crimeid?>" hidden >
											  </form>
										</div>
										
										<?php
									}
								
								}
								else{
									$err= "now record found!!";
								}
								?>
				
		

<?php
}
?>
</section>					
</div>
