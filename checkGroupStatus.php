<?php
	include "../include.php";
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
					array_push($members, $output['player1']);
					$numofmembers++;
				}
				if($output['player2'] != NULL){
					array_push($members, $output['player2']);
					$numofmembers++;
				}
				if($output['player3'] != NULL){
					array_push($members, $output['player3']);
					$numofmembers++;
				}
				if($output['player4'] != NULL){
					array_push($members, $output['player4']);
					$numofmembers++;
				}
				if($output['player5'] != NULL){
					array_push($members, $output['player5']);
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