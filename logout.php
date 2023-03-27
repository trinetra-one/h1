<?php
	session_start();
	unset($_SESSION['uname']);
	if(!isset($_SESSION['uname'])){
		header("location:index.php");
	}
?>