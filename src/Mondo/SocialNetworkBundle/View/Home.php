<?php
/****************************************
 *
 * Author: Piotr Sroczkowski, Paulina Ryfka
 *
 ****************************************/
?>

<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\Session;
?>
<?php require_once '../components/arshaw/phpti/src/ti.php' ?>

<?php startblock('styles') ?>
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/home.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
<?php endblock() ?>


<?php startblock('content') ?>
<div class="panel panel-parla">
	<div class="panel-heading">
		<h1 class="panel-title">
		<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
		 Log in</h1>
	</div>
	<div class="panel-body">
		<form action="app.php?action=go" method="post">
			take advantage of the quick registration:
			<div class="frame">
				<input placeholder="Name" name="name"/>
				<span class="error"><?= Session::getSessionData('errors_name') ?></span>
			</div>
			<div class="frame">
				or log in if you already have account:
				</br>
				<input placeholder="Enter your key or e-mail address" name="key"/>
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
