<?php
	session_start();
	$_SESSION['user_id'] = "testeruser#1234";
	header("location:index");
?>