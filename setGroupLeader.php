<?php
	include "../include.php";
	include "checkGroup.php";
	
	$user = $_SESSION['user_id'];
	$newleader = $_GET['user'];
	$blank = "";
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$playerid = "player".$usercolumn;
		if($numofmembers>1){
			// prepare sql and bind parameters
				$stmt = $conn->prepare("UPDATE groups SET leader=:leader WHERE ".$playerid."=:userid");
				$stmt->bindParam(':userid', $user);
				$stmt->bindParam(':leader', $newleader);
		}
		$stmt->execute();
		
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>