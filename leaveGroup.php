<?php
	include "checkGroup.php";
	$sqlhost = "localhost";
	$sqluser = "root";
	$sqlpass = "";
	$sqldb = "wdw";
	$user = $_SESSION['user_id'];
	$blank = "";
	try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$playerid = "player".$usercolumn;
		
		if($numofmembers>1){
			// prepare sql and bind parameters
			$stmt = $conn->prepare("UPDATE groups SET ".$playerid."=:blank WHERE ".$playerid."=:userid");
			$stmt->bindParam(':userid', $user);
			$stmt->bindParam(':blank', $blank);
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