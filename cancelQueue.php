<?php
	include "../include.php";
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	$userid = $_SESSION['user_id'];
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("DELETE FROM queue WHERE userid = :userid");
		$stmt->bindParam(':userid', $userid);
	 
		$stmt->execute();
		$_SESSION['inqueue'] = false;
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
		
	header("location:search");
?>