<?php
include "include.php";
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
require('OAuth2/client.php');
require('OAuth2/GrantType/IGrantType.php');
require('OAuth2/GrantType/AuthorizationCode.php');

$status=true;
$statuscode=0;

$client_id = 'aptj73rpvkyx33qgj3zkswjrypcqubp7';
$client_secret = 'HQGhc4cbeuQdtFEPyWEkrV7ZC8b46kNp';

$redirect_uri = 'https://mywebsite.dev/getBNet';
$authorize_uri = 'https://us.battle.net/oauth/authorize';
$token_uri = 'https://us.battle.net/oauth/token';

$client = new OAuth2\Client($client_id, $client_secret);

if (!isset($_GET['code'])) {

 $auth_url = $authorize_uri.'?client_id='.$client_id.'&scope='.$scope.'&state='.$state.'&redirect_uri='.$redirect_uri.'&response_type=code';
 header('Location: ' . $auth_url);

 die('Redirect');
}
else {
	$params = array('code' => $_GET['code'], 'redirect_uri' => $redirect_uri);
	$response = $client->getAccessToken($token_uri, 'authorization_code', $params);
	$info = $response['result'];
	$client->setAccessToken($info['access_token']);
	$response = $client->fetch('https://us.api.battle.net/account/user');
	$battletag = $response['result']['battletag'];
	var_dump($battletag);
	
	$_SESSION['user_id'] = $battletag;
	$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// prepare sql and bind parameters
	$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
	$stmt->bindParam(':username', $username);
 
	$stmt->execute();
	$output =  $stmt->fetch(PDO::FETCH_ASSOC);
	//status is set to false if the user already exists in the users database
	if($output != NULL)
	{
		$status=false;
	}
	
	if($status)
	{
		try {
			$password = password_hash($password, PASSWORD_BCRYPT);

			$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// prepare sql and bind parameters
			$stmt = $conn->prepare("INSERT INTO users (username) VALUES (:username)");
			$stmt->bindParam(':username', $battletag);
		 
			$stmt->execute();
			
			header("location:index.php");
			}
		catch(PDOException $e)
			{
			echo "Error: " . $e->getMessage();
			}
		$conn = null;
	}
	
	
	header("location:index");
}

?>