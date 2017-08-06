<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\Session;
?>
<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/pass-change.css">
    <link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
<?php endblock() ?>
<?php startblock('content') ?>
<div class="panel panel-parla">
	<div class="panel-heading">
		<h1 class="panel-title">
		<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
		 Change password</h1>
	</div>
	<div class="panel-body frame">
		<form action="app.php?action=update_password&id=<?= Session::getSessionData('id') ?>" method="post">
			<div class="row row-sett">
					<div class="col-xs-6 panel-txt">
						Current password: 
					</div>
					<div class="col-xs-6">
						<input type="password" name="current" />
					</div>
			</div>
			<div class="row row-sett new-row">
					<div class="col-xs-6 panel-txt">
						New password:  
					</div>
					<div class="col-xs-6">
						<input type="password" name="new" />
					</div>
			</div>
			<div class="row row-sett">
					<div class="col-xs-6 panel-txt">
						Repeat new password:
					</div>
					<div class="col-xs-6">
						<input type="password" name="repeat" />
					</div>
			</div>
                                <span class="error"><?= Session::getSessionData('errors') ?></span>
			<div class="row row-sett new-row">
					<div class="col-xs-12">
						<input class="btn btn-success submit-btn" type="submit" value="SUBMIT"/>
					</div>
			</div>
			<div class="row row-sett new-row">
					<div class="col-xs-12">
						<input onclick="window.location.href='app.php'" class="btn btn-success submit-btn" type="button" value="CANCEL"/>
					</div>
			</div>
		</form>
	</div>
</div>
<?php endblock() ?>

