<?php
	include "include.php";
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	$invited = $_GET['user'];
	$invitee = $_SESSION['user_id'];
	
	//check if invite already exists
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// prepare sql and bind parameters
	$stmt = $conn->prepare("SELECT * FROM pendinginvites WHERE invited=:invited AND invitee=:invitee");
	$stmt->bindParam(':invited', $invited);
	$stmt->bindParam(':invitee', $invitee);
 
	$stmt->execute();
	$output =  $stmt->fetch(PDO::FETCH_ASSOC);
	if($output == NULL)
	{
		$status=true;
	}
	//if not, create new one
	if($status){

		// prepare sql and bind parameters
		$stmt = $conn->prepare("INSERT INTO pendinginvites (invited, invitee) VALUES (:invited, :invitee)");
		$stmt->bindParam(':invited', $invited);
		$stmt->bindParam(':invitee', $invitee);
	 
		$stmt->execute();
	}
	$conn = null;
?>