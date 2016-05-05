<?php
	include "include.php";
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	
	$user = $_SESSION['user_id'];
	$image = $_GET['image'];
	
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//get new groupid to join
	$stmt = $conn->prepare("UPDATE users SET image=:image WHERE username=:user");
	$stmt->bindParam(':user', $user);
	$stmt->bindParam(':image', $image);
	$stmt->execute();
	$_SESSION['profileimage'] = $image;
?>