<?php
	include "../include.php";
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	$invited = $_SESSION['user_id'];
	$blank = "";
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $conn->prepare("DELETE FROM pendinginvites WHERE invited=:invited OR invitee=:invited");
		$stmt->bindParam(':invited', $invited);
		
		$stmt->execute();
		
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>