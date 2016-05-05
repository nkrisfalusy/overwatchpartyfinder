<?php
	include "include.php";
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
			$_SESSION['profileimage'] = $output['image'];
		}
		
		
		?>
		<li><a href="#" data-toggle="dropdown" class="dropdown-toggle page-scroll" id="profileimageselect"><img src="../img/profileimgs/<?php echo $_SESSION['profileimage'];?>.png" class="profileimage"/></a>
			<ul class="dropdown-menu" id="profimageselector">
				<li><a onclick="changeProfileImage('1');"><img src="../img/profileimgs/1.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('2');"><img src="../img/profileimgs/2.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('3');"><img src="../img/profileimgs/3.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('4');"><img src="../img/profileimgs/4.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('5');"><img src="../img/profileimgs/5.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('6');"><img src="../img/profileimgs/6.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('7');"><img src="../img/profileimgs/7.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('8');"><img src="../img/profileimgs/8.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('9');"><img src="../img/profileimgs/9.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('10');"><img src="../img/profileimgs/10.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('11');"><img src="../img/profileimgs/11.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('12');"><img src="../img/profileimgs/12.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('13');"><img src="../img/profileimgs/13.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('14');"><img src="../img/profileimgs/14.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('15');"><img src="../img/profileimgs/15.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('16');"><img src="../img/profileimgs/16.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('17');"><img src="../img/profileimgs/17.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('18');"><img src="../img/profileimgs/18.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('19');"><img src="../img/profileimgs/19.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('20');"><img src="../img/profileimgs/20.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('21');"><img src="../img/profileimgs/21.png" class="profileimage"/></a></li>
				<li><a onclick="changeProfileImage('22');"><img src="../img/profileimgs/22.png" class="profileimage"/></a></li>
				
			</ul>
		</li>
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