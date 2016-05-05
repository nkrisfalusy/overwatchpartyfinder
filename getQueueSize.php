<?php
	include "../include.php";
	
	
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT * FROM queue");
	 
		$stmt->execute();
		
		$size = $stmt->rowCount();
		echo $size;
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>