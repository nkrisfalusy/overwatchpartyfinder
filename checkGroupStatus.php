<?php
	include "include.php";
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 

	//returns groupresult FALSE if the session user_id is in a group
	
	$groupresult = true;
	$groupid = "";
	$usercolumn = 0;
	$numofmembers = 0;
	$members = array();
	$leader = "";
	if(isset($_SESSION['user_id'])){
		$userid = $_SESSION['user_id'];
		try {
			$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// prepare sql and bind parameters
			$stmt = $conn->prepare("SELECT * FROM groups WHERE player1=:userid OR player2=:userid OR player3=:userid OR player4=:userid OR player5=:userid");
			$stmt->bindParam(':userid', $userid);
		 
			$stmt->execute();
			$size = $stmt->rowCount();
			$output =  $stmt->fetch(PDO::FETCH_ASSOC);
			if($size>0){
				if($output['player1'] != NULL){
					$player1 = $output['player1'];
					$stmt = $conn->prepare("SELECT * FROM users WHERE username=:user");
					$stmt->bindParam(':user', $player1);
					$stmt->execute();
					$outputnew =  $stmt->fetch(PDO::FETCH_ASSOC);
					array_push($members, $player1."@".$outputnew['image']);
					$numofmembers++;
				}
				if($output['player2'] != NULL){
					$player2 = $output['player2'];
					$stmt = $conn->prepare("SELECT * FROM users WHERE username=:user");
					$stmt->bindParam(':user', $player2);
					$stmt->execute();
					$outputnew =  $stmt->fetch(PDO::FETCH_ASSOC);
					array_push($members, $player2."@".$outputnew['image']);
					$numofmembers++;
				}
				if($output['player3'] != NULL){
					$player3 = $output['player3'];
					$stmt = $conn->prepare("SELECT * FROM users WHERE username=:user");
					$stmt->bindParam(':user', $player3);
					$stmt->execute();
					$outputnew =  $stmt->fetch(PDO::FETCH_ASSOC);
					array_push($members, $player3."@".$outputnew['image']);
					$numofmembers++;
				}
				if($output['player4'] != NULL){
					$player4 = $output['player4'];
					$stmt = $conn->prepare("SELECT * FROM users WHERE username=:user");
					$stmt->bindParam(':user', $player4);
					$stmt->execute();
					$outputnew =  $stmt->fetch(PDO::FETCH_ASSOC);
					array_push($members, $player4."@".$outputnew['image']);
					$numofmembers++;
				}
				if($output['player5'] != NULL){
					$player5 = $output['player5'];
					$stmt = $conn->prepare("SELECT * FROM users WHERE username=:user");
					$stmt->bindParam(':user', $player5);
					$stmt->execute();
					$outputnew =  $stmt->fetch(PDO::FETCH_ASSOC);
					array_push($members, $player5."@".$outputnew['image']);
					$numofmembers++;
				}
				$leader = $output['leader'];
			}
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
	}
	echo $numofmembers."~".$userid."~".join(',', $members)."~".$leader;
?>