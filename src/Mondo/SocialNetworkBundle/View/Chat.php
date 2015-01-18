<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main2.css">
	<script src="../components/jquery/jquery-1.11.1.min.js"></script>
	<script src="../components/bootstrap/js/bootstrap.js"></script>

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

<script>
var $id = <?= $id ?>;
var image_src = '<?= \Parameters::UPLOADS_DIR.'/'.$key ?>';
</script>
<script src="../src/Mondo/SocialNetworkBundle/JS/ajax.js"></script>
</head>
<body>


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
		<div class="col-md-2">
			<a href="app.php?action=account_settings">Account settings</a>
			<a href="app.php?action=logout">log out</a>
		<div class="col-md-2 logout">
			<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span><a href="app.php?action=logout"> log out</a>
		</div>
	</div>
	<br><br><br>
	<div class="row">
		<!-- chat-->
		<div class="col-md-9">
			<div style="width:600px; height:400px; overflow:scroll" id='messages'></div>
			<input id='message'/>
			<button onclick='send()'>send</button>
		</div>
		<!--lista userów-->
		<div class="col-md-3">
			<div id='user_table'></div>
		</div>
	</div>
</div>
</body>
</html>


