<?php
	include "include.php";
	
	$status=true;
	$statuscode=0;
	
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(strlen($username)==0 || strlen($password)==0)
	{
		$status=false;
		$statuscode=1;
	}
	
	if($status)
	{
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
		$stmt->bindParam(':username', $username);
	 
		$stmt->execute();
		$output =  $stmt->fetch(PDO::FETCH_ASSOC);
		if($output != NULL)
		{
			$status=false;
			$statuscode=2;
		}
		
		$conn = null;
	}
	
	
	if($status)
	{
		try {
			$password = password_hash($password, PASSWORD_BCRYPT);

			$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// prepare sql and bind parameters
			$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);
		 
			$stmt->execute();
			
			header("location:index.php");
			}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$conn = null;
	}
	
	if(!$status)
	{
		header("location:register.php?failed=".$statuscode."&un=".$username);
	}

?>