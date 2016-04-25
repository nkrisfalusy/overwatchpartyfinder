<?php
	include "include.php";
	
	$status=true;
	$statuscode=0;

	$username=$_GET['user'];

	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("INSERT INTO groups (player1) VALUES (:username)");
		$stmt->bindParam(':username', $username);
	 
		$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
	$conn = null;

?>