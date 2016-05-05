<?php
	include "include.php";
	$usertoleave = $_GET['user'];
	include "checkGroup.php";
	
	$blank = "";
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$playerid = "player".$usercolumn;
		if($numofmembers>1){
			// prepare sql and bind parameters
			if($isleader){
				echo "UPDATE groups SET ".$playerid."=:blank AND leader=:leader WHERE ".$playerid."=:userid";
				$stmt = $conn->prepare("UPDATE groups SET ".$playerid."=:blank, leader=:leader WHERE ".$playerid."=:userid");
				$stmt->bindParam(':userid', $usertoleave);
				$stmt->bindParam(':blank', $blank);
				$stmt->bindParam(':leader', $leaderreplacement);
			}
			else{
				$stmt = $conn->prepare("UPDATE groups SET ".$playerid."=:blank WHERE ".$playerid."=:userid");
				$stmt->bindParam(':userid', $usertoleave);
				$stmt->bindParam(':blank', $blank);
			}
		}
		else{
			$stmt = $conn->prepare("DELETE FROM groups WHERE ".$playerid."=:user");
			$stmt->bindParam(':user', $usertoleave);
		}
		
		
		
	 
		$stmt->execute();
		
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>