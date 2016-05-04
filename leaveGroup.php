<?php
	include "../include.php";
	include "checkGroup.php";
	
	$user = $_SESSION['user_id'];
	$blank = "";
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$playerid = "player".$usercolumn;
		echo $leaderreplacement ."<br>". $isleader."<br>";
		if($numofmembers>1){
			// prepare sql and bind parameters
			if($isleader){
				echo "UPDATE groups SET ".$playerid."=:blank AND leader=:leader WHERE ".$playerid."=:userid";
				$stmt = $conn->prepare("UPDATE groups SET ".$playerid."=:blank, leader=:leader WHERE ".$playerid."=:userid");
				$stmt->bindParam(':userid', $user);
				$stmt->bindParam(':blank', $blank);
				$stmt->bindParam(':leader', $leaderreplacement);
			}
			else{
				$stmt = $conn->prepare("UPDATE groups SET ".$playerid."=:blank WHERE ".$playerid."=:userid");
				$stmt->bindParam(':userid', $user);
				$stmt->bindParam(':blank', $blank);
			}
		}
		else{
			$stmt = $conn->prepare("DELETE FROM groups WHERE ".$playerid."=:user");
			$stmt->bindParam(':user', $user);
		}
		
		
		
	 
		$stmt->execute();
		
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>