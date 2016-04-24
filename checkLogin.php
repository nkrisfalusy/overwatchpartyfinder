<?php
	$sqlhost = "localhost";
	$sqluser = "root";
	$sqlpass = "";
	$sqldb = "wdw";
	$tablename = "users";
	$status = true;
	
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(strlen($username)==0 || strlen($password)==0)
	{
		$status=false;
	}
	
	
	if($status)
	{
		try {
		$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
		$stmt->bindParam(':username', $username);
	 
		$stmt->execute();
		$output =  $stmt->fetch(PDO::FETCH_ASSOC);
		if(password_verify($password, $output['password'])){
			echo "success";
		}
		else{
			$status=false;
		}
		
		}
	catch(PDOException $e)
		{
		echo "Error: " . $e->getMessage();
		}
	$conn = null;		
	}
	session_start();
	$_SESSION['loginstatus'] = $status;
	if($status)
	{
		$_SESSION['login_user'] = $username;
		$_SESSION['user_id'] = $output['id'];
		header("location:search");
	}
	else{
		header("location:login.php?faileduser=".$username);
	}
	
?>