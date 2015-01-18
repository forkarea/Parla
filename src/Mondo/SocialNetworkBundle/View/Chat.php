<?php include 'Base.php' ?>
<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
require_once '../app/parameters.php';

use Mondo\UtilBundle\Core\Session;
use Mondo\SocialNetworkBundle\Controller\UserController;

UserController::autoGo('chat');

$id = Session::getSessionData('id');
$name = Session::getSessionData('name');
$key = Session::getSessionData('key');
?>


<?php startblock('styles') ?>
    <link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main2.css">
<?php endblock() ?>
<?php startblock('javascripts') ?>
    <script src="../components/jquery/jquery-1.11.1.min.js"></script>
    <script src="../components/bootstrap/js/bootstrap.js"></script>
    <script>
        var $id = <?= $id ?>;
        var image_src = '<?= \Parameters::UPLOADS_DIR.'/'.$key ?>';
    </script>
    <script src="../src/Mondo/SocialNetworkBundle/JS/ajax.js"></script>
<?php endblock() ?>


<?php startblock('content') ?>


<div class="container chatPanel">
	<div class="row userRow">
		<!-- wyświetlenie zdjecia-->
		<div class="col-md-2 avatar">
			<?php if(file_exists('../'.\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
				<img width="150px" height="150px" id="image" src="../<?= \Parameters::UPLOADS_DIR.'/'.$key ?>"/>
			<?php } ?>
		</div>
		<!-- upload zdjecia-->
		<div class="col-md-4 avatarUpload">
			<form action="app.php?action=upload_photo" method="post" enctype="multipart/form-data" onsubmit="refresh_image()">
				<span class="glyphicon glyphicon-picture" aria-hidden="true"></span><span class="uploadTxt"> Select image to upload:</span>
				<input class="chooseAvatar" type="file" name="fileToUpload" id="fileToUpload">
				<input class="btn btn-success uploadBtn" type="submit" value="upload your photo" name="submit">
			</form>
			<span class="uploadInfo"><?= Session::session('info')  ?></span>
		</div>
		<!-- user info-->
		<div class="col-md-3 userInfo">
			<span class="glyphicon glyphicon-user infoTxt" aria-hidden="true"></span><span class="infoTxt"> Your name:</span> <?= Session::getSessionData('name') ?> <br/>
			<span class="glyphicon glyphicon-wrench infoTxt" aria-hidden="true"></span><span class="infoTxt"> Your key:</span> <?= Session::getSessionData('key') ?> <br/>
			<br><button class="btn btn-success passBtn" id="passwordButton" onclick="togglePassword()">Show password</button>
			<div class="pass"><p id="password" style="display:none"> <?= Session::getSessionData('password') ?> </p></div>
			<?php
				echo Session::getSessionData('errors'); 
			?>
		</div>
		<!-- logout-->
		<div class="col-md-2 logout">
			<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span><a href="app.php?action=logout"> log out</a>
			<br><a href="app.php?action=account_settings">Account settings</a>
		</div>
	</div>
	<div class="row chatRow">
		<!-- chat-->
		<div class="col-md-9">
			<div class="chatHistory" id='messages'></div>
			<input class="chat" id='message'/>
			<button class="btn btn-success sendBtn" onclick='send()'>send</button>
		</div>
		<!--lista userów-->
		<div class="col-md-3">
			<div id='user_table'></div>
		</div>
	</div>
</div>
<?php endblock() ?>
