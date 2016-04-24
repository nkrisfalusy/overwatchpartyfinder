<!DOCTYPE html>
<?php
	session_start();
	include "checkQueue.php";
	if(!$queueresult){
		header("location:queue");
	}
	include "checkGroup.php";
?>
<html lang="en">

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
            <div class="header-content-inner" style="text-align: center">
                <h1 style="text-align: left">Search</h1>
			</div>
			<br><br><br><br><br>
			
				<?php if(isset($_SESSION['user_id']))	: ?>
				<div id="searchbox" style="text-align:left"><div id="leftcolumn" class="col-lg-2 col-lg-offset-3">
					<h4>Current Group:</h4>
					<select class="form-control formitem" id="groupselect" style="width: 120px;">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<br>
					<h4>Looking For:</h4>
					<select id="lookingselect" class="form-control formitem" style="width: 120px;">
						<option id="looking1" value="1">1</option>
						<option id="looking2" value="2">2</option>
						<option id="looking3" value="3">3</option>
						<option id="looking4" value="4">4</option>
						<option id="looking5" value="5">5</option>
					</select>
				</div>
				<div id="centercolumn" class="col-lg-2">
					<h4>Region:</h4>
					<select class="form-control formitem" id="regionselect" style="width: 120px;">
						<option value="Americas">Americas</option>
						<option value="Europe">Europe</option>
						<option value="Korea">Korea</option>
						<option value="Taiwan">Taiwan</option>
						<option value="China">China</option>
						<option value="SoutheastAsia">Southeast Asia</option>
					</select>
					<br>
					<h4>Preferred Language:</h4>
					<select class="form-control formitem" id="languageselect" style="width: 120px;">
						<option value="Engligh">Engligh</option>
						<option value="Spanish">Spanish</option>
						<option value="French">French</option>
						<option value="German">German</option>
						<option value="Italian">Italian</option>
					</select>
				</div>
				<div id="rightcolumn" class="col-lg-2">
				
					<h4>Role(s) Taken: <span id="roleHelp" class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></h4>
					<div class="formitem">
						<div class="checkbox">
						  <label><input type="checkbox" value="Offense" id="Offense">Offense</label>
						</div>
						<div class="checkbox">
						  <label><input type="checkbox" value="Defense" id="Defense">Defense</label>
						</div>
						<div class="checkbox">
						  <label><input type="checkbox" value="Tank" id="Tank">Tank</label>
						</div>
						<div class="checkbox">
						  <label><input type="checkbox" value="Support" id="Support">Support</label>
						</div>
					</div>
					<br>
					<h4>Preferred Communication Software:</h4>
					<div class="formitem">
						<div class="checkbox">
						  <label><input type="checkbox" value="TeamSpeak" id="TeamSpeak">TeamSpeak</label>
						</div>
						<div class="checkbox">
						  <label><input type="checkbox" value="Discord" id="Discord">Discord</label>
						</div>
						<div class="checkbox">
						  <label><input type="checkbox" value="Skype" id="Skype">Skype</label>
						</div>
						<div class="checkbox">
						  <label><input type="checkbox" value="Curse" id="Curse">Curse</label>
						</div>
					</div>
				</div>
				</div>
			<div id="submitcolumn" class="col-lg-12">
				<a onClick="searchSubmit();" class="btn btn-primary btn-xl page-scroll">Search</a>
			</div>
			<?php else : ?>
				<h2>Please <a class="page-scroll" href="getBNet">Login</a> to search for a group!
			<?php endif; ?>
        </div>
    </header>
	<?php include "footer.php"; ?>
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
	
    <script src="js/scripts.js"></script>

	<script>
		
	</script>
</body>

</html>
