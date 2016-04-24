<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	if(isset($_SESSION['user_id'])) :
		$cleanuser = str_replace("#", "", $_SESSION['user_id']); ?>
		<li><a href="#" data-toggle="dropdown" class="dropdown-toggle page-scroll"><?php echo $_SESSION['user_id']?></a>
			<ul class="dropdown-menu">
				<li><a href="profile?id=<?php echo $cleanuser;?>">Profile</a></li>
				<li><a href="logout">Logout</a></li>
			</ul>
		</li>
<?php else : ?>
	<li><a class="page-scroll" href="getBNet">Login</a></li>
	<li><a class="page-scroll" href="testLogin">Log in tester</a></li>
<?php endif; ?>
