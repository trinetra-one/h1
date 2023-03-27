<?php
require '../library/pageFunction.php';
require 'master.php';

?>
<head>
<link rel="stylesheet"  href="../css/dots.css">
<style>
.row h3{
	color:brown;
}
</style>
</head>

<div class="rightcolumn">
			<section id="reports" >
					<div class="card">
					<?php
					 $suser_id=$_SESSION['user_id'];
					
					if(isset($_POST['comment'])){
						$crimeid=$_POST['crimeid'];
						$content=$_POST['content'];
						writeComment($suser_id,$crimeid,$content);
					}
					if(isset($_POST['file_comp'])){
						$crimeid=$_POST['crimeid'];
						file_complaint($crimeid,);
					}
					
					if(isset($_POST['delete'])){
						$crimeid=$_POST['crimeid'];
						 deleteCrime($crimeid);
					}
					$sql_count="select count(crime_id) from crime where user_id=$suser_id and isdel=1";
							$result= $con->query($sql_count);
								if($result->num_rows>0)
								{
									$row=$result->fetch_assoc();
									$no_of_crime= $row['count(crime_id)'];
								}
								
	?>
						<p>Reported Crimes</p><?php echo "Records found:".$no_of_crime;?>
						</div>
						<div style="height:auto;border-top:3px solid grey;padding:5px;">
						 <?php						 
								$sql = "SELECT * from crime where user_id=$suser_id and isdel=1";
								$result= $con->query($sql);
								if($result->num_rows>0)
								{
									
								while($row=$result->fetch_assoc()){
										$crimeid=$row['crime_id'];
										$cmt="cmt".$row['crime_id'];
										$crime="crime".$row['crime_id'];
										$resp="resp".$row['crime_id'];
										$crime_location=$row['crime_location'];
										$sql_dept="select dept_id as did from dept where dname='$crime_location'";
										$result_dept= $con->query($sql_dept);
										if($result_dept->num_rows>0)
										{
											$row_dept=$result_dept->fetch_assoc();
											$dept_id=$row_dept['did'];
										}
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
													  <span><?php echo $suname?></span>
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
																	<p style="color:red;float:left">Complaint not filed!!</p>	<button name="file_comp"  style="padding:5px;width:70px"> File Now</button>	<?php
																	}
														?></h4>
														<h4 align="right"><?php if($row['crime_status']=="p"){?>
																		<div class="chip" style="background-color:white">
																		<img src="../images/icons/progress.png" alt="Person" onclick="document.getElementById('<?php echo $resp;?>').style.display='block';" style="cursor:pointer">
																		<span style="color:red">Processing..</span>
																		</div><?php
																	}
																	elseif ($row['crime_status']=="v"){?>
																		<div class="chip" style="background-color:white">
																		<img src="../images/icons/verified.png" alt="Person" onclick="document.getElementById('<?php echo $resp;?>').style.display='block';" style="cursor:pointer">
																		<span style="color:green">Verified</span>
																		</div><?php																	}
																	else{?>
																		<div class="chip" style="background-color:white">
																		<img src="../images/icons/failed.png" alt="Person" onclick="document.getElementById('<?php echo $resp;?>').style.display='block';" style="cursor:pointer">
																		<span style="color:red">Failed</span>
																		</div><?php	
																	}
														?></h4>	
													</div>
													<hr/>
													<input type="hidden" name="crimeid" value="<?php echo $crimeid;?>">
														<button name="delete"  style="padding:5px;width:70px"><img src="../images/icons/delete_icon.png" alt="Person" style="width:40px;height:40px;"> </button>	
														<div class="chip" style="width:20px">
														<img src="../images/icons/c.png" alt="Person" onclick="document.getElementById('<?php echo $cmt;?>').style.display='block';" style="cursor:pointer">
														</div>	
														<div class="chip" style="width:20px">
														<img src="../images/icons/response.png" alt="Person" onclick="document.getElementById('<?php echo $resp;?>').style.display='block';" style="cursor:pointer">
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
										<div id='<?php echo $resp ?>' class='modal'>
											  <form class='modal-content animate' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='post' style='margin:auto;height:350px;margin-top:10%;'>
												<div class='imgcontainer'>
												   <span onclick="document.getElementById('<?php echo $resp;?>').style.display='none';" class='rarr' >&larr;</span>
												</div>
												<h2 align='center'>Response</h2>
												<div class='container' style="height:250px;overflow-x:scroll; overflow-x: hidden;">
													<?php
													
													response($dept_id,$crimeid);
													?>		
													
												</div>
												
											  </form>
										</div>
										<?php
									}
								}
								else{
									$err= "now record found!!";
								}
								?>
						</div>
		</section>
</div>
<script>
</script>


