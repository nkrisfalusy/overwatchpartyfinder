<?php
	include "include.php";
	if(!isset($_SESSION)) 
	    { 
	        session_start(); 
	    } 
	date_default_timezone_set("America/New_York");
	$stampstring= date("Y-m-d H:i:s");
	$stamp = new DateTime($stampstring);
	$user = $_SESSION['user_id'];
	
	
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// prepare sql and bind parameters
	$stmt = $conn->prepare("SELECT * FROM users WHERE username=:user");
 	$stmt->bindParam(':user', $user);
	$stmt->execute();
	$output =  $stmt->fetch(PDO::FETCH_ASSOC);
	//check if timestamp is older than an hour ago
	$timesincelastaction = $output['timesincelastaction'];
	$timesincelastaction = new DateTime($timesincelastaction);
	$since_start = $timesincelastaction->diff($stamp);
	$minutes = $since_start->days * 24 * 60;
	$minutes += $since_start->h * 60;
	$minutes += $since_start->i;
	
	if($minutes > 30){
		$stmt = $conn->prepare("UPDATE users SET timesincelastaction=:time WHERE username=:user");
	 	$stmt->bindParam(':user', $user);
	 	$stmt->bindParam(':time', $stampstring);
		$stmt->execute();
	}
		
?>