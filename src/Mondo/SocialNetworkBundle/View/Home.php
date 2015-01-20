<?php include 'Base.php' ?>
<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
use Mondo\UtilBundle\Core\Session;
use Mondo\SocialNetworkBundle\Controller\UserController;

UserController::autoGo('home');
?>
<?php require_once '../components/arshaw/phpti/src/ti.php' ?>

<?php startblock('styles') ?>
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
<?php endblock() ?>


<?php startblock('content') ?>
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
				<span class="error"><?= Session::getSessionData('errors_name') ?></span>
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
<?php endblock() ?>
