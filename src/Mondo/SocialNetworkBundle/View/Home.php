<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
use Mondo\UtilBundle\Core\Session;
use Mondo\SocialNetworkBundle\Controller\MyCookie;

new Session();
//MyCookie::read();
//if(Session::getSessionData('key') != "") header('Location: view2.php');
?>

<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
</head>
<body>


<div class="panel panel-login">
	<div class="panel-heading">
		<h1 class="panel-title">
		<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
		 Log in</h1>
	</div>
	<div class="panel-body">
		<form action="app.php?action=go" method="post">
			<div class="frame">
				<input placeholder="Name" name="name"/>
			</div>
			<div style="float:left">
				Or
			</div>
			</br>
			<div class="frame">
				<input placeholder="Enter your username" name="key"/>
				<br/>
				<input placeholder="Enter your password" type="password" name="password"/>
				<br/>
				<span class="error"><?= Session::getSessionData('errors') ?></span>
			</div>
			<div class="go">
				<input class="checkB" type="checkbox" name="remember" value="yes" /><span class="sign">Keep me signed in</span>
				<button class="btn btn-success btn-log">LOGIN</button>
			</div>
		</form>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../components/bootstrap/js/bootstrap.js"></script>
</body>
</html>

