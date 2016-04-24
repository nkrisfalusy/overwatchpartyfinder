var numofnotifications = 0;
var audio = new Audio('../sound/pop.mp3');

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
			  
			  document.getElementById("groupinfo").innerHTML = "<img src=\"../img/defaultprofile.jpg\" class=\"profileimage\">&nbsp;&nbsp;<a onClick=\'toggleSearch()\'; class=\"btn btn-primary btn-sm page-scroll\">+</a>&nbsp;<a onClick=\'leaveGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">X</a>";
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
	  xhttp.open("GET", "leaveGroup.php", false);
	  xhttp.send();
	  
	  document.getElementById("groupinfo").innerHTML = "<a onClick=\'startGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">Start Group</a>";
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
	  console.log("createPendingInvite.php?user="+userclean);
	  xhttp.open("GET", "createPendingInvite.php?user="+userclean, false);
	  xhttp.send();
}

$(document).ready(function(){
			$('.glyphicon-info-sign').popover({content: "Unselected roles are assumed open.", trigger: "click", placement: "top"}); 
		});
	
$("#groupselect").on('change', function(){
  document.getElementById("lookingselect").selectedIndex = 0;
  switch(parseInt($("#groupselect option:selected").val())) {
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
	
	console.log(urlextension);
	
	window.location=urlextension;
}

window.onload = checkForInvites();
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
	var groupsize = response.split("~")[0];
	var user =  response.split("~")[1];
	var members = response.split("~")[2].split(",");
	console.log("group size: " + groupsize);
	if(groupsize > 0){
		var i = 0;
		while(i<groupsize){
			inner += "<img src=\"../img/defaultprofile.jpg\" class=\"profileimage\" title=\""+members[i]+"\">&nbsp;";
			i++;
		}
		inner += "&nbsp;&nbsp;<a onClick=\'toggleSearch()\'; class=\"btn btn-primary btn-sm page-scroll\">+</a>&nbsp;<a onClick=\'leaveGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">X</a>";
		el.innerHTML = inner;
	}else{
		el.innerHTML = "<a onClick=\'startGroup(\""+user+"\")\'; class=\"btn btn-primary btn-sm page-scroll\">Start Group</a>";
	}
}

function checkForInvites(){
	console.log("Checking for invites. number of notifications: " + numofnotifications);
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
		
		document.getElementById("notification").className = "glyphicon glyphicon-align-justify notificationbutton";
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
		document.getElementById("notification").className = "glyphicon glyphicon-align-justify notificationbutton no-notification";
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