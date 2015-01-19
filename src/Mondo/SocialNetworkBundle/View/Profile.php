<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\DB;
use Mondo\SocialNetworkBundle\Entity\User;

$key = $_GET['user'];
$user = DB::queryRow("SELECT * FROM users WHERE mykey='%s'", [$key]);
$entity = new User($user);
?>

<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/profile.css">
<?php endblock() ?>
<?php startblock('content') ?>
<div class="panel panel-settings">
	<div class="panel-heading">
		<h1 class="panel-title">
		<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
		 Profile details</h1>
	</div>
	<div class="panel-body">
		<div class="container-non-responsive">
			<div class="row">
				<div class="border">
					<div class="col-xs-4">
						<img class="img" width="80px" height="80px" id="image" src="app.php?action=profile_image&user=<?= $user['mykey'] ?>"/>
					</div>
					<div class="col-xs-8 name-txt">
						<div class="row">
							<span class="name">
								<?= $user['name'] ?> 
							</span>
						</div>
						<div class="row">
							<span class="user_key">
								(<?= $user['mykey'] ?>)
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-sett">
					<div class="col-xs-4 info-txt">
						City: 
					</div>
					<div class="col-xs-8">
						<?= $user['city'] ?>
					</div>
			</div>
			<div class="row row-sett">
					<div class="col-xs-4 info-txt">
						Country: 
					</div>
					<div class="col-xs-8">
						<?= $user['country'] ?>
					</div>
			</div>
			<div class="row row-sett">
					<div class="col-xs-4 info-txt">
						Gender: 
					</div>
					<div class="col-xs-8">
						<?= $user['gender'] ?>
					</div>
			</div><div class="row row-sett">
					<div class="col-xs-4 info-txt">
						Age: 
					</div>
					<div class="col-xs-8">
						<?= $entity->get('age') ?>
					</div>
			</div><div class="row row-sett">
					<div class="col-xs-4 info-txt">
						Orientation: 
					</div>
					<div class="col-xs-8">
						<?= $user['orientation'] ?>
					</div>
			</div>
		</div>
	</div>
</div>
<?php endblock() ?>
