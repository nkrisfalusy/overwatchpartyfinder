<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	$sqlhost = "localhost";
	$sqluser = "root";
	$sqlpass = "";
	$sqldb = "wdw";
	$invitee = $_GET['user'];
	$invited = $_SESSION['user_id'];
	$blank = "";
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $conn->prepare("DELETE FROM pendinginvites WHERE invited=:invited AND invitee=:invitee");
		$stmt->bindParam(':invited', $invited);
		$stmt->bindParam(':invitee', $invitee);
		
		$stmt->execute();
		
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>