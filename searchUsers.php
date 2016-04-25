<?php
	include "include.php";
	
	$output = array();
	$value = "%".$_GET['value']."%";

	
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE :username LIMIT 10");
		$stmt->bindParam(':username', $value);
	 
		$stmt->execute();
		$output =  $stmt->fetchAll();
		$i=0;
		while($i < count($output)){
			echo $output[$i]['username']."~";
			$i++;
		}
	
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
	$conn = null;		
?>