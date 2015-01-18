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
use Mondo\SocialNetworkBundle\Controller\MyCookie;

MyCookie::read();
//if(Session::getSessionData('key') == "") header('Location: view1.php');
$id = Session::getSessionData('id');
$name = Session::getSessionData('name');
$key = Session::getSessionData('key');
?>


<script>
var $id = <?= $id ?>;
var image_src = '<?= \Parameters::UPLOADS_DIR.'/'.$key ?>';
setInterval( function() {
    $.get('app.php?action=user_table', function(data) {
        $('#user_table').html(data);
    });
}, 2000);

setInterval( function() {
    $.get('app.php?action=messages', function(data) {
        $('#messages').html(data);
    });
}, 2000);

setInterval( function() {
    $.post('app.php?action=notify', {sender: $id});
}, 2000);


function send() {
    $.post('app.php?action=send', {sender: $id, message: $('#message').val()});
    $('#message').val('');
}

function refresh_image() {
    $('#image').attr(image_src+'?'+Math.random());
}

function togglePassword() {
    $('#password').toggle();
    $('#passwordButton').html($('#passwordButton').html()[0]=='S' ? 'Hide password' : 'Show password');
}

$(document).ready( function() {
    $('#message').keypress(function(e) {
        if(e.which == 13) send();
    });
});
</script>
</head>
<body>




<div class="container">
	<h1>Multiuser chat</h1>
	<div class="row">
		<!-- wyświetlenie zdjecia-->
		<div class="col-md-2">
			<?php if(file_exists('../'.\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
				<img width="150px" height="150px" id="image" src="../<?= \Parameters::UPLOADS_DIR.'/'.$key ?>"/>
			<?php } ?>
		</div>
		<!-- upload zdjecia-->
		<div class="col-md-4">
			<form action="app.php?action=upload_photo" method="post" enctype="multipart/form-data" onsubmit="refresh_image()">
				Select image to upload:
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="upload your photo" name="submit">
			</form>
			<?= Session::session('info')  ?>
		</div>
		<!-- user info-->
		<div class="col-md-4">
			Your name: <?= Session::getSessionData('name') ?> <br/>
			Your key: <?= Session::getSessionData('key') ?> <br/>
			<button id="passwordButton" onclick="togglePassword()">Show password</button>
			<p id="password" style="display:none">Your password: <?= Session::getSessionData('password') ?> </p><br/>

			<?php
				echo Session::getSessionData('errors'); 
			?>
		</div>
		<!-- logout-->
		<div class="col-md-2">
			<a href="logout.php">log out</a>
		</div>
	</div>
	<br><br><br>
	<div class="row">
		<!-- chat-->
		<div class="col-md-9">
			<div width="300px" height="400px" style="overflow:scroll" id='messages'></div>
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


