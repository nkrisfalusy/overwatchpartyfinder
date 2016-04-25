<?php
	include "include.php";
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	$user = $_SESSION['user_id'];
	
	//check if invite already exists
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// prepare sql and bind parameters
	$stmt = $conn->prepare("SELECT * FROM pendinginvites WHERE invited=:user");
	$stmt->bindParam(':user', $user);
 
	$stmt->execute();
	$output =  $stmt->fetchAll();
	$i=0;
	while($i < count($output)){
		echo $output[$i]['invitee']."~";
		$i++;
	}
	
	$conn = null;
?>