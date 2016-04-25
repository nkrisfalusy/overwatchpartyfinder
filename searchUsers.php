<?php
	include "include.php";
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	$output = array();
	$value = "%".$_GET['value']."%";
	$region = $_SESSION['region'];
	
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT * FROM users WHERE region=:region AND username LIKE :username LIMIT 10");
		$stmt->bindParam(':username', $value);
		$stmt->bindParam(':region', $region);
	 
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