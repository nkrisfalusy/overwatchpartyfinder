<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	include "checkQueue.php";
	if($queueresult){
		header("location:search");
	}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OLFG</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index">Overwatch LFG</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
					<?php
						include 'navbar.php';
					?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
	
    <header>
        <div class="header-content-left">
			<?php if(isset($_SESSION['user_id'])) : ?>
				<div class="header-content-inner" style="text-align: center">
					<h1 style="text-align: left">In Queue</h1>
				</div>
				<br><br><br>
				<img src="img/loading.gif" style="width: 257px; height: 257px;"></img>
				<br>
				<h2>PEOPLE IN QUEUE: <span id="queuecount"></span></h2>
				<br>
				<a href="cancelQueue" class="btn btn-primary btn-xl page-scroll">Cancel</a>
			<?php else : ?>
				<h2>Please <a class="page-scroll" href="getBNet">Login</a> to search for a group!
			<?php endif; ?>
        </div>
    </header>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.js"></script>
    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jquery.fittext.js"></script>
    <script src="js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/creative.js"></script>

	<script>
		window.onload = getQueueSize;
		setInterval(function(){ 
			getQueueSize();
		}, 3000);
		
		function getQueueSize(){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  document.getElementById("queuecount").innerHTML = xhttp.responseText;
				}
			  };
			  xhttp.open("GET", "getQueueSize.php", true);
			  xhttp.send();
		}
		
		
		
		window.onbeforeunload = function (e) {
		  var message = "You will be removed from the queue if you leave this page.",
		  e = e || window.event;
		  // For IE and Firefox
		  if (e) {
			e.returnValue = message;
		  }

		  // For Safari
		  return message;
		};
		
		window.onunload = function() { 
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  document.getElementById("queuecount").innerHTML = xhttp.responseText;
				}
			  };
			  xhttp.open("GET", "leaveQueue.php", false);
			  xhttp.send();
		}
	</script>
</body>

</html>
