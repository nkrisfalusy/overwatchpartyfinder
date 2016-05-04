<?php
	include "../include.php";
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	
	$user = $_SESSION['user_id'];
	$region = $_GET['region'];
	
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//get new groupid to join
	$stmt = $conn->prepare("UPDATE users SET region=:region WHERE username=:user");
	$stmt->bindParam(':user', $user);
	$stmt->bindParam(':region', $region);
	$stmt->execute();
	$_SESSION['region'] = $region;
?>