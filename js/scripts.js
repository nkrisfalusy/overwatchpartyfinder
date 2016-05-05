var numofnotifications = 0;
var audio = new Audio('../sound/pop.mp3');
var lastcheckedgroupsize = 0;
var lastcheckedgroup = "";

function startGroup(user) {
			var response = "";
			userclean = user.replace("#", "%23");
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  response = xhttp.responseText;
				}
			  };
			  xhttp.open("GET", "createGroup.php?user="+userclean, false);
			  xhttp.send();
			
			checkGroupStatus();
}
function leaveGroup(user) {
	var response = "";
	userclean = user.replace("#", "%23");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	  xhttp.open("GET", "leaveGroup.php?user="+userclean, false);
	  xhttp.send();
	  
	  checkGroupStatus();
}
function toggleSearch(){
	$('#usersearchbox').toggle();
	$('#notificationbox').hide();
}
function toggleNotifications(){
	$('#usersearchbox').hide();
	$('#notificationbox').toggle();
}
function queryUsers(){
	var value = document.getElementById("usersearchinput").value;
	var div = document.getElementById("usersearchresults");
	if(value.length>0)
	{
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  response = xhttp.responseText;
			}
		  };
		  xhttp.open("GET", "searchUsers.php?value="+value, false);
		  xhttp.send();
		  
		
		var inner = "";
		var holder = response.split("~");
		var i = 0;
		while(i<holder.length-1){
			inner += "<li><a onClick='inviteUser(\""+ holder[i] +"\")';>"+ holder[i] +"</a></li>";
			i++;
		}
		div.innerHTML = inner;
	}
	else{
		div.innerHTML = "";
	}
}
function inviteUser(user) {
	userclean = user.replace("#", "%23");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	  xhttp.open("GET", "createPendingInvite.php?user="+userclean, false);
	  xhttp.send();
}

$(document).ready(function(){
			$('.glyphicon-info-sign').popover({content: "Unselected roles are assumed open.", trigger: "click", placement: "top"}); 
		});
	

function searchSubmit(){
	var urlextension = "searchSubmit?";
	
	var e = document.getElementById("groupselect");
	var currentgroup = e.options[e.selectedIndex].value;
	
	urlextension += "group="+currentgroup;
	
	e = document.getElementById("lookingselect");
	var lookinggroup = e.options[e.selectedIndex].value;
	
	urlextension += "&looking="+lookinggroup;
	
	e = document.getElementById("regionselect");
	var region = e.options[e.selectedIndex].value;
	
	urlextension += "&region="+region;
	
	e = document.getElementById("languageselect");
	var language = e.options[e.selectedIndex].value;
	
	urlextension += "&language="+language;
	
	e = document.getElementById("Offense");
	var offense = e.checked;
	
	if(offense){
		urlextension += "&offense=1";
	}
	
	e = document.getElementById("Defense");
	var defense = e.checked;
	
	if(defense){
		urlextension += "&defense=1";
	}
	
	e = document.getElementById("Tank");
	var Tank = e.checked;
	
	if(Tank){
		urlextension += "&tank=1";
	}
	
	e = document.getElementById("Support");
	var Support = e.checked;
	
	if(Support){
		urlextension += "&support=1";
	}
	
	e = document.getElementById("TeamSpeak");
	var TeamSpeak = e.checked;
	
	if(TeamSpeak){
		urlextension += "&teamspeak=1";
	}
	
	e = document.getElementById("Discord");
	var Discord = e.checked;
	
	if(Discord){
		urlextension += "&discord=1";
	}
	
	e = document.getElementById("Skype");
	var Skype = e.checked;
	
	if(Skype){
		urlextension += "&skype=1";
	}
	
	e = document.getElementById("Curse");
	var Curse = e.checked;
	
	if(Curse){
		urlextension += "&curse=1";
	}
	window.location=urlextension;
}

window.onload = checkForInvites();
window.onload = checkGroupStatus();
setInterval(function(){ 
	checkForInvites();
}, 1000);

setInterval(function(){ 
	checkGroupStatus();
}, 1000);

function checkGroupStatus(){
	var el = document.getElementById("groupinfo");
	var inner = "";
	var response = "";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "checkGroupStatus.php", false);
	xhttp.send();
	if(response != lastcheckedgroup){
		var groupsize = response.split("~")[0];
		var user =  response.split("~")[1];
		var members = response.split("~")[2].split(",");
		var leader = response.split("~")[3];
		if(groupsize > 0){
			if(user == leader){
				var i = 0;
				while(i<groupsize){
					var member = members[i].split("@")[0];
					var image = members[i].split("@")[1];
					console.log("member: " + member + ". image: " + image);
					if(member==leader){
						inner += "<span=\"btn-group\"><span id=\"toggledropup"+i+"\" class=\"leaderimage dropdown-toggle\" data-toggle=\"dropdown\"><img src=\"../img/profileimgs/"+image+".png\" class=\"profileimage\" id=\"profileimage"+i+"\" title=\""+member+"\"></span><ul class=\"dropdown-menu drop-up\" id=\"dropup"+i+"\"><lh>"+member+"</lh><hr><li><a onclick=\"viewProfile('"+member+"');\">Profile</a></li></ul></span>&nbsp;";
					}else{
						inner += "<span=\"btn-group\"><span id=\"toggledropup"+i+"\" class =\"memberimage dropdown-toggle\"  data-toggle=\"dropdown\"><img src=\"../img/profileimgs/"+image+".png\" class=\"profileimage\" id=\"profileimage"+i+"\" title=\""+member+"\"></span><ul class=\"dropdown-menu drop-up\" id=\"dropup"+i+"\"><lh>"+member+"</lh><hr><li><a onclick=\"viewProfile('"+member+"');\">Profile</a></li><li><a onclick=\"promoteToLeader('"+member+"');\">Promote to Leader</a></li><li><a onclick=\"kickFromGroup('"+member+"');\">Kick</a></li></ul></span>&nbsp;";
					}
				i++;
				}
				inner += "&nbsp;&nbsp;<a onClick=\'toggleSearch()\'; class=\"btn btn-primary btn-sm page-scroll\">+</a>&nbsp;<a onClick=\'leaveGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">X</a>";
				el.innerHTML = inner;
			}
			else{
				var i = 0;
				while(i<groupsize){
					if(members[i]==leader){
						inner += "<span=\"btn-group\"><span id=\"toggledropup"+i+"\" class=\"leaderimage dropdown-toggle\" data-toggle=\"dropdown\"><img src=\"../img/profileimgs/"+image+".png\" class=\"profileimage\" id=\"profileimage"+i+"\" title=\""+member+"\"></span><ul class=\"dropdown-menu drop-up\" id=\"dropup"+i+"\"><lh>"+member+"</lh><hr><li><a onclick=\"viewProfile('"+member+"');\">Profile</a></li></ul></span>&nbsp;";
					}else{
						inner += "<span=\"btn-group\"><span id=\"toggledropup"+i+"\" class =\"memberimage dropdown-toggle\"  data-toggle=\"dropdown\"><img src=\"../img/profileimgs/"+image+".png\" class=\"profileimage\" id=\"profileimage"+i+"\" title=\""+member+"\"></span><ul class=\"dropdown-menu drop-up\" id=\"dropup"+i+"\"><lh>"+member+"</lh><hr><li><a onclick=\"viewProfile('"+member+"');\">Profile</a></li></ul></span>&nbsp;";
					}
				i++;
				}
				inner += "&nbsp;&nbsp;<a onClick=\'toggleSearch()\'; class=\"btn btn-primary btn-sm page-scroll\">+</a>&nbsp;<a onClick=\'leaveGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">X</a>";
				el.innerHTML = inner;
			}
			$('#toggledropup0').on('click', function(e){
				setposition(e, 0);
			});
			$('#toggledropup1').on('click', function(e){
				setposition(e, 1);
			});
			$('#toggledropup2').on('click', function(e){
				setposition(e, 2);
			});
			$('#toggledropup3').on('click', function(e){
				setposition(e, 3);
			});
			$('#toggledropup4').on('click', function(e){
				setposition(e, 4);
			});
		}else{
			el.innerHTML = "<a onClick=\'startGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">Start Group</a>";
		}
		lastcheckedgroup = response;
	}else{
	}
}

function viewProfile(user){
	var url = "/profile?id="+user;
	var win = window.open(url, '_blank');
	win.focus();	
}

function promoteToLeader(user){
	var response = "";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "setGroupLeader.php?user="+user.replace("#", "%23"), false);
	xhttp.send();
	checkGroupStatus();
}

function kickFromGroup(user){
	var response = "";
	userclean = user.replace("#", "%23");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	  xhttp.open("GET", "leaveGroup.php?user="+userclean, false);
	  xhttp.send();
	checkGroupStatus();
}

function setposition(e, pos) {
    var bodyOffsets = document.body.getBoundingClientRect();
    tempX = e.pageX - bodyOffsets.left;
    tempY = e.pageY;
	var zeropoint = $(window).width() - $("#rightfoot").width();
	var moveit = tempX - zeropoint;
	switch(pos){
		case 0:
			$("#dropup0").css({'left': moveit });
		break;
		case 1:
			$("#dropup1").css({'left': moveit });
		break;
		case 2:
			$("#dropup2").css({'left': moveit });
		break;
		case 3:
			$("#dropup3").css({'left': moveit });
		break;
		case 4:
			$("#dropup4").css({'left': moveit });
		break;
	}
	
    
}



function searchGroupSize(){
	var response = "";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "checkGroupStatus.php", false);
	xhttp.send();
	var groupsize = response.split("~")[0];
	var groupcount = parseInt(groupsize);
	if(groupcount != lastcheckedgroupsize){
		document.getElementById("lookingselect").selectedIndex = 0;
		lastcheckedgroupsize = groupcount;
		switch(groupcount) {
		case 1:
			$("#looking5").attr('disabled',false);
			$("#looking4").attr('disabled',false);
			$("#looking3").attr('disabled',false);
			$("#looking2").attr('disabled',false);
			$("#looking1").attr('disabled',false);
			break;
		case 2:
			$("#looking5").attr('disabled',true);
			$("#looking4").attr('disabled',false);
			$("#looking3").attr('disabled',false);
			$("#looking2").attr('disabled',false);
			$("#looking1").attr('disabled',false);
			break;
		case 3:
			$("#looking5").attr('disabled',true);
			$("#looking4").attr('disabled',true);
			$("#looking3").attr('disabled',false);
			$("#looking2").attr('disabled',false);
			$("#looking1").attr('disabled',false);
			break;
		case 4:
			$("#looking5").attr('disabled',true);
			$("#looking4").attr('disabled',true);
			$("#looking3").attr('disabled',true);
			$("#looking2").attr('disabled',false);
			$("#looking1").attr('disabled',false);
			break;
		default:
			$("#looking5").attr('disabled',true);
			$("#looking4").attr('disabled',true);
			$("#looking3").attr('disabled',true);
			$("#looking2").attr('disabled',true);
			$("#looking1").attr('disabled',false);
			break;
	}
	}
	
}

function checkForInvites(){
	var el = document.getElementById("notificationslist");
	var inner = "";
	var response = "";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "checkPendingInvites.php", false);
	xhttp.send();
	if(response.length > 0){
		document.getElementById("notifybutton").className = "btn btn-primary btn-sm page-scroll notificationbutton";
		var holder = response.split("~");
		if(holder.length-1 > numofnotifications){
			audio.play();
		}
		numofnotifications = holder.length-1;
		
		var i = 0;
		var i = 0;
		while(i<holder.length-1){
			inner += "<li class=\"notificationitem\">"+holder[i]+"<span class=\"pendingicons\"><a onClick='acceptInvite(\""+ holder[i] +"\")';><span class=\"glyphicon glyphicon-ok acceptinvite\" aria-hidden=\"true\"></span></a><a onClick='declineInvite(\""+ holder[i] +"\")';><span class=\"glyphicon glyphicon-remove declineinvite\" aria-hidden=\"true\"></span></a></span></li>";
			i++;
		}
		el.innerHTML = inner;
	}else{
		document.getElementById("notifybutton").className = "btn btn-primary btn-sm page-scroll notificationbutton no-notification";
		el.innerHTML = "";
		numofnotifications=0;
	}
}

function acceptInvite(user){
	//leave current group
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	  xhttp.open("GET", "leaveGroup.php", true);
	  xhttp.send();
	
	//accept group invite
	userclean = user.replace("#", "%23");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "acceptInvite.php?user="+userclean, true);
	xhttp.send();
	
	//delete invite from pending list
	declineInvite(user);
}

function declineInvite(user){
	userclean = user.replace("#", "%23");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "declineInvite.php?user="+userclean, true);
	xhttp.send();
	checkForInvites();
}

function setSelectedRegion(region, user){
	document.getElementById("selectedregion").innerHTML = region;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "setUserRegion.php?region="+region, true);
	xhttp.send();
	
	leaveGroup(user);
	clearAllNotifications();
	$('#usersearchbox').hide();
	$('#notificationbox').hide();
}

function changeProfileImage(imgnum){
	document.getElementById("profileimageselect").innerHTML = "<img src=\"../img/profileimgs/"+imgnum+".png\" class=\"profileimage\"/>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "setProfileImage.php?image="+imgnum, true);
	xhttp.send();
}

function clearAllNotifications(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  response = xhttp.responseText;
		}
	  };
	xhttp.open("GET", "declineAllInvites.php", true);
	xhttp.send();
}