<?php
	include "../include.php";
	session_start();
	
	$userid = $_SESSION['user_id'];
	$offense = "0";
	$defense = "0";
	$tank = "0";
	$support = "0";
	$teamspeak = "0";
	$discord = "0";
	$skype = "0";
	$curse = "0";
	
	$group = $_GET['group'];
	$looking = $_GET['looking'];
	$region = $_GET['region'];
	$language = $_GET['language'];
	if(isset($_GET['offense'])){
		$offense = $_GET['offense'];
	}
	if(isset($_GET['defense'])){
		$defense = $_GET['defense'];
	}
	if(isset($_GET['tank'])){
		$tank = $_GET['tank'];
	}
	if(isset($_GET['support'])){
		$support = $_GET['support'];
	}
	if(isset($_GET['teamspeak'])){
		$teamspeak = $_GET['teamspeak'];
	}
	if(isset($_GET['discord'])){
		$discord = $_GET['discord'];
	}
	if(isset($_GET['skype'])){
		$skype = $_GET['skype'];
	}
	if(isset($_GET['curse'])){
		$curse = $_GET['curse'];
	}
	
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// prepare sql and bind parameters
	$stmt = $conn->prepare("INSERT INTO queue (userid, currentgroup, lookingfor, region, language, offense, defense, tank, support, teamspeak, discord, skype, curse) VALUES (:userid, :currentgroup, :lookingfor, :region, :language, :offense, :defense, :tank, :support, :teamspeak, :discord, :skype, :curse)");
	$stmt->bindParam(':userid', $userid);
	$stmt->bindParam(':currentgroup', $group);
	$stmt->bindParam(':lookingfor', $looking);
	$stmt->bindParam(':region', $region);
	$stmt->bindParam(':language', $language);
	$stmt->bindParam(':offense', $offense);
	$stmt->bindParam(':defense', $defense);
	$stmt->bindParam(':tank', $tank);
	$stmt->bindParam(':support', $support);
	$stmt->bindParam(':teamspeak', $teamspeak);
	$stmt->bindParam(':discord', $discord);
	$stmt->bindParam(':skype', $skype);
	$stmt->bindParam(':curse', $curse);
 
	$stmt->execute();
	$_SESSION['inqueue'] = true;
	/*
	echo $userid."<br>";
	echo $group."<br>";
	echo $looking."<br>";
	echo $region."<br>";
	echo $language."<br>";
	echo $offense."<br>";
	echo $defense."<br>";
	echo $tank."<br>";
	echo $support."<br>";
	echo $teamspeak."<br>";
	echo $discord."<br>";
	echo $skype."<br>";
	echo $curse."<br>";
	*/
	
	header("location:queue");
?>
               