<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\Session;
?>
<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/accSettings.css">
<?php endblock() ?>
<?php startblock('content') ?>

<div class="panel panel-settings">
	<div class="panel-heading">
		<h1 class="panel-title">
		<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
		 Account settings</h1>
	</div>
	<div class="panel-body accountSettings">
	<div class="col-md-12">
		<div class="row linksSett">
			<div class="col-md-12">
				<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
				<a href="app.php?action=change_password">Change password</a> <br/>
			</div>
			<div class="col-md-12">
			<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
				<a href="app.php?action=verify&id=<?= Session::getSessionData('id') ?>">Verify e-mail address</a> <br/>
			</div>
		</div>
	</div>
		<div class="row dataSett">
			<form action="app.php?action=account_update&id=<?= Session::getSessionData('id') ?>" method="post">
			<div class="col-md-6">
				<div class="row row-sett">
				<div class="border">
					<div class="col-md-4 img">
						<img width="85px" height="85px" id="image" src="app.php?action=profile_image&user=<?= Session::getSessionData('key') ?>"/>
					</div>
					<div class="col-md-6 info-txt">
					</div>
				</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						E-mail address: 
					</div>
					<div class="col-md-8">
						<input name="email" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Name: 
					</div>
					<div class="col-md-8">
						<input name="name" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						City: 
					</div>
					<div class="col-md-8">
						<input name="city" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Country: 
					</div>
					<div class="col-md-8">
						<input name="country" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row row-sett">
					<div class="col-md-4">
						Date of birth: 
					</div>
					<div class="col-md-8">
						<input placeholder="dd" class="dateInput" name="day" />
						<input placeholder="mm" class="dateInput" name="month" />
						<input placeholder="yyyy" class="yearInput" name="year" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Gender: 
					</div>
					<div class="col-md-8">
						<select class="selects" name="gender">
							<option value="m">male</option>
							<option value="f">female</option>
							<option value="n">other</option>
						</select>
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Sexual orientation:
					</div>
					<div class="col-md-8">
						<select class="selects" name="orientation">
							<option value="hetero">heterosexual</option>
							<option value="homo">homosexual</option>
							<option value="bi">bisexual</option>
							<option value="a">asexual</option>
						</select>
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						About you: 
					</div>
					<div class="col-md-8">
						<textarea name="about"></textarea>
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-12">
						<input class="btn btn-success submit-btn" type="submit" value="SUBMIT"/>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<?php endblock() ?>
