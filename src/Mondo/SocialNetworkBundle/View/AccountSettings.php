<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\Session;
use Mondo\UtilBundle\Core\DB;

$user = DB::queryRow('SELECT * FROM users WHERE id=%s LIMIT 1', [Session::getSessionData('id')]);
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
				<a href="app.php?action=verify&id=<?= $user['id'] ?>">Verify e-mail address</a> <br/>
			</div>
		</div>
	</div>
		<div class="row dataSett">
			<form action="app.php?action=account_update&id=<?= $user['id'] ?>" method="post">
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
                                            <input name="email" value="<?= $user['mail'] ?>" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Name: 
                                                <?= Session::getSessionData('errors_name') ?>
					</div>
					<div class="col-md-8">
						<input name="name" value="<?= $user['name'] ?>" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						City: 
					</div>
					<div class="col-md-8">
						<input name="city" value="<?= $user['city'] ?>" />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Country: 
					</div>
					<div class="col-md-8">
						<input name="country" value="<?= $user['country'] ?>" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row row-sett">
					<div class="col-md-4">
						Date of birth: 
                                                <?= Session::getSessionData('errors_birth') ?>
					</div>
					<div class="col-md-8">
                                        <?php $birth = new \DateTime($user['birth']) ?>
                                        <input placeholder="dd" class="dateInput" name="day" value="<?= $birth->format('d') ?>" />
						<input placeholder="mm" class="dateInput" name="month" value="<?= $birth->format('m') ?>"  />
						<input placeholder="yyyy" class="yearInput" name="year" value="<?= $birth->format('Y') ?>"  />
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Gender: 
					</div>
					<div class="col-md-8">
						<select class="selects" name="gender">
                                                        <option value="m" <?php if($user['gender']=='m') echo 'selected' ?> >male</option>
							<option value="f" <?php if($user['gender']=='f') echo 'selected' ?> >female</option>
							<option value="n" <?php if($user['gender']=='n') echo 'selected' ?> >other</option>
						</select>
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						Sexual orientation:
					</div>
					<div class="col-md-8">
						<select class="selects" name="orientation">
							<option value="hetero" <?php if($user['orientation']=='hetero') echo 'selected' ?> >heterosexual</option>
							<option value="homo" <?php if($user['orientation']=='homo') echo 'selected' ?> >homosexual</option>
							<option value="bi" <?php if($user['orientation']=='bi') echo 'selected' ?> >bisexual</option>
							<option value="a" <?php if($user['orientation']=='a') echo 'selected' ?> >asexual</option>
						</select>
					</div>
				</div>
				<div class="row row-sett">
					<div class="col-md-4">
						About you: 
					</div>
					<div class="col-md-8">
						<textarea name="about"><?= $user['about'] ?></textarea>
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
