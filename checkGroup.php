<?php
<<<<<<< HEAD
<<<<<<< HEAD
	include "include.php";
	$userid = "";
=======
	include "../include.php";
>>>>>>> origin/master
=======
	include "../include.php";
>>>>>>> origin/master
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	
	if(isset($_SESSION['user_id']))
	{
		$userid = $_SESSION['user_id'];
	}
	
	if(isset($usertoleave))
	{
		$userid = $usertoleave;
	}

	//returns groupresult FALSE if the session user_id is in a group

	$groupresult = true;
	$groupid = "";
	$usercolumn = 0;
	$numofmembers = 0;
	$isleader = false;
	$leaderreplacement = "";
	$members = array();
	if(isset($_SESSION['user_id'])){
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
				$groupresult = false;
				$groupid = $output['id'];
				if($output['player1'] != NULL){
					if($output['player1']==$userid){$usercolumn=1;}
					else{$leaderreplacement = $output['player1'];}
					array_push($members, $output['player1']);
					$numofmembers++;
				}
				if($output['player2'] != NULL){
					if($output['player2']==$userid){$usercolumn=2;}
					else{$leaderreplacement = $output['player2'];}
					array_push($members, $output['player2']);
					$numofmembers++;
				}
				if($output['player3'] != NULL){
					if($output['player3']==$userid){$usercolumn=3;}
					else{$leaderreplacement = $output['player3'];}
					array_push($members, $output['player3']);
					$numofmembers++;
				}
				if($output['player4'] != NULL){
					if($output['player4']==$userid){$usercolumn=4;}
					else{$leaderreplacement = $output['player4'];}
					array_push($members, $output['player4']);
					$numofmembers++;
				}
				if($output['player5'] != NULL){
					if($output['player5']==$userid){$usercolumn=5;}
					else{$leaderreplacement = $output['player5'];}
					array_push($members, $output['player5']);
					$numofmembers++;
				}
				if($output['leader'] == $userid){
					$isleader = true;
				}
			}
			else{
				$groupresult = true;
			}
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
	}
?>