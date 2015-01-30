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
		Forgot password</h1>
	</div>
	<div class="panel-body">
		<form action="app.php?action=reset_password" method="post">
			<div class="frame">
				</br>
				<input placeholder="Enter your e-mail address" name="key"/>
				<br/>
				<span class="error"><?= Session::getSessionData('errors') ?></span>
			</div>
			<div class="go">
				<button class="btn btn-success btn-log">RESET</button>
			</div>
		</form>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../components/bootstrap/js/bootstrap.js"></script>
<?php endblock() ?>

