<?php
	include "include.php";
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	//returns false if the session user_id is in the queue, returns true if not in the queue
	
	$queueresult = "true";
	if(isset($_SESSION['user_id'])){
		$userid = $_SESSION['user_id'];
		try {
			$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// prepare sql and bind parameters
			$stmt = $conn->prepare("SELECT * FROM queue WHERE userid=:userid");
			$stmt->bindParam(':userid', $userid);
		 
			$stmt->execute();
			$size = $stmt->rowCount();
			if($size>0){
				$queueresult = false;
			}
			else{
				$queueresult = true;
			}
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
	}
	
	
	
?>