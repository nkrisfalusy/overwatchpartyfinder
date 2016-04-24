<div id="usersearchbox" style="display: none;">
		<input id="usersearchinput" type="text" name="searchtext" onkeyup="queryUsers()">
		<ul id="usersearchresults">
			
		</ul>
</div>
<div id="notificationbox" style="display: none;">
		<div id="notificationheader">
			Notifications
		</div>
		<ul id="notificationslist">
			
		</ul>
</div>
<footer class="footer">
<?php
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		$loggedin="";
		if(isset($_SESSION['user_id']) && $groupresult) : ?>
			<span id="groupinfo">
				<a onClick='startGroup("<?php echo $_SESSION['user_id'];?>")'; class="btn btn-primary btn-sm page-scroll">Start Group</a>
			</span>
			<a onClick='toggleNotifications()'; class="btn btn-primary btn-sm page-scroll"><span id="notification" class="glyphicon glyphicon-align-justify notificationbutton.no-notification" aria-hidden="true"></span></a>
		<?php elseif(!$groupresult) : ?>
			<span id="groupinfo">
				<?php
					$i=0;
					while($i<count($members)){ ?>
						<img src="../img/defaultprofile.jpg" class="profileimage" title="<?php echo $members[$i] ?>">
				<?php
					$i++;
					}
				?>
				&nbsp;&nbsp;<a onClick='toggleSearch()'; class="btn btn-primary btn-sm page-scroll">+</a>&nbsp;<a onClick='leaveGroup("<?php echo $_SESSION['user_id'];?>")'; class="btn btn-primary btn-sm page-scroll">X</a>
			</span>
			<a onClick='toggleNotifications()'; class="btn btn-primary btn-sm page-scroll"><span id="notification" class="glyphicon glyphicon-align-justify notificationbutton.no-notification" aria-hidden="true"></span></a>
		<?php endif; 
?>
</footer>