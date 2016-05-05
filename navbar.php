<?php
	include "../include.php";
	if(!isset($_SESSION)) 
	    { 
	        session_start(); 
	    } 
	if(isset($_SESSION['user_id'])) :
		include "onlineStatus.php";
		$cleanuser = str_replace("#", "", $_SESSION['user_id']); 
		if(!isset($_SESSION['region'])){
			$conn = new PDO("mysql:host=$sqlhost;dbname=$sqldb", $sqluser, $sqlpass);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT * FROM users WHERE username=:username");
			$stmt->bindParam(':username', $_SESSION['user_id']);
			
			$stmt->execute();
			$output =  $stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['region'] = $output['region'];
		}
		
		
		?>
		<li><a href="#" data-toggle="dropdown" class="dropdown-toggle page-scroll"><?php echo $_SESSION['user_id']?></a>
			<ul class="dropdown-menu">
				<li><a href="profile?id=<?php echo str_replace('#', '%23', $_SESSION['user_id']);?>">Profile</a></li>
				<li><a href="logout">Logout</a></li>
			</ul>
		</li>
		<li><a class="page-scroll inactiveLink">Region:</a></li>
		<li><a href="#" data-toggle="dropdown" class="dropdown-toggle page-scroll" id="selectedregion"><?php echo $_SESSION['region']?></a>
			<ul class="dropdown-menu">
				<li><a onclick="setSelectedRegion('NA', '<?php echo $_SESSION['user_id'];?>');">NA</a></li>
				<li><a onclick="setSelectedRegion('EU', '<?php echo $_SESSION['user_id'];?>');">EU</a></li>
				<li><a onclick="setSelectedRegion('Korea', '<?php echo $_SESSION['user_id'];?>');">Korea</a></li>
				<li><a onclick="setSelectedRegion('Taiwan', '<?php echo $_SESSION['user_id'];?>');">Taiwan</a></li>
				<li><a onclick="setSelectedRegion('China', '<?php echo $_SESSION['user_id'];?>');">China</a></li>
				<li><a onclick="setSelectedRegion('South East Asia', '<?php echo $_SESSION['user_id'];?>');">South East Asia</a></li>
			</ul>
		</li>
<?php else : ?>
	<li><a class="page-scroll" href="getBNet">Login with Battlenet</a></li>
	<li><a class="page-scroll" href="testLogin">Log in tester</a></li>
<?php endif; ?>