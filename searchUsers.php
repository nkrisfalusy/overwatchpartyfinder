<?php
	include "include.php";
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	$output = array();
	$value = "%".$_GET['value']."%";
	$region = $_SESSION['region'];
	date_default_timezone_set("America/New_York");
    	$stampstring= date("Y-m-d H:i:s");
    	$stamp = new DateTime($stampstring);
	
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
			$lastaction = $output[$i]['timesincelastaction'];
			$lastaction = new DateTime($lastaction );
			$since_start = $lastaction->diff($stamp);
			$minutes = $since_start->days * 24 * 60;
			$minutes += $since_start->h * 60;
			$minutes += $since_start->i;
			if($minutes < 60){
				echo $output[$i]['username']."~";
			}
			$i++;
		}
	
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
	$conn = null;		
?>