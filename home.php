<?php

require 'master.php';
 
?>
<?php
	
	
?>
<head>
<link rel="stylesheet"  href="../css/dots.css">
<link rel="stylesheet"  href="../css/slideshow.css">
<link rel="stylesheet"  href="../css/users.css">
</head>

<div class="rightcolumn">
			<section id="slideshow">
					<div class="slideshow-container">
					<div class="mySlides fade" >
					 
					  <img src="../images/img1.png" > 
					</div>
					<div class="mySlides fade">
					 
					  <img src="../images/crimescene.jpg" >
					</div>
					<div class="mySlides fade">
					
					  <img src="../images/crime_scene.jpg" >
					</div>
					</div>
					<h2>Hello, <?php echo $sfname."<span style='font-size:15px;'>($suname)</span>"; ?></h2>
					<div class="reportbtn" style="background-color:lightblue;width:200px">
							  <a onclick="document.getElementById('report').style.display='block'"  style="padding-left:5px;padding-top:5px;position:absolute" class="tooltip"><img src="../images/icons/report1.png" alt="Person" ></img>Report Crime</a>
						</div>
				
			</section>
				<section>
						
				<table  cellpadding=10 class='users'  >
				<tr onclick="forward_rep()">
				<td>reported Crimes</td>
				<td><?php counter("crime_id","crime","user_id",$suser_id)?></td>
				</tr>
				</table>
				<table cellpadding=10 class='users'>
				<tr onclick="forward_feedback()">
				<td>Feedbacks</td>
				<td><?php counter("feedback_id","feedback","user_id",$suser_id)?></td>
				</tr>
				</table>
		</section>
			
</div>
<script src="../javascript/slideshow.js"></script>
<script>
function forward_rep(){
		window.location='http://localhost/project/user/reports.php';
	}
function forward_feedback(){
		window.location='http://localhost/project/user/settings_feedback.php';
	}
</script>

