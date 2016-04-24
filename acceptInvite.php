<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	//returns groupresult FALSE if the session user_id is in a group
	$sqlhost = "localhost";
	$sqluser = "root";
	$sqlpass = "";
	$sqldb = "wdw";
	$groupresult = true;
	$groupid = "";
	$usercolumn = 0;
	$numofmembers = 0;
	$members = array();
	$invitee = $_GET['user'];
	$invited = $_SESSION['user_id'];
	$openspot = 0;
		try {
			$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			//get new groupid to join
			$stmt = $conn->prepare("SELECT * FROM groups WHERE player1=:userid OR player2=:userid OR player3=:userid OR player4=:userid OR player5=:userid");
			$stmt->bindParam(':userid', $invitee);
		 
			$stmt->execute();
			$size = $stmt->rowCount();
			$output =  $stmt->fetch(PDO::FETCH_ASSOC);
			
			$groupid = $output['id'];
			//get open playerspot
			if($output['player5'] == NULL){
				$openspot = 5;
			}
			if($output['player4'] == NULL){
				$openspot = 4;
			}
			if($output['player3'] == NULL){
				$openspot = 3;
			}
			if($output['player2'] == NULL){
				$openspot = 2;
			}
			if($output['player1'] == NULL){
				$openspot = 1;
			}
			//add user to new group in open playerspot
			$playerspot = "player".$openspot;
			$stmt = $conn->prepare("UPDATE groups SET ".$playerspot."=:invited WHERE id=:groupid");
			$stmt->bindParam(':invited', $invited);
			$stmt->bindParam(':groupid', $groupid);
			$stmt->execute();
			
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
?>