<html>
<head>
<link rel="stylesheet" type="text/css" href="1.css">
<script src="../components/jquery/jquery-1.11.1.min.js"></script>

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
    $.get('user_table.php', function(data) {
        $('#user_table').html(data);
    });
}, 2000);

setInterval( function() {
    $.get('messages.php', function(data) {
        $('#messages').html(data);
    });
}, 2000);

setInterval( function() {
    $.post('notify.php', {sender: $id});
}, 2000);


function send() {
    $.post('send.php', {sender: $id, message: $('#message').val()});
    $('#message').val('');
}

function refresh_image() {
    console.log('aaa');
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



<h1>Multiuser chat</h1>

Your name: <?= Session::getSessionData('name') ?> <br/>
Your key: <?= Session::getSessionData('key') ?> <br/>
<button id="passwordButton" onclick="togglePassword()">Show password</button>
<p id="password" style="display:none">Your password: <?= Session::getSessionData('password') ?> </p><br/>

<?php
echo Session::getSessionData('errors'); 
?>


<a href="logout.php">log out</a>
<br/>

<?= Session::session('info')  ?>
<form action="upload_photo.php" method="post" enctype="multipart/form-data" onsubmit="refresh_image()">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="upload your photo" name="submit">
</form>

<br/>

<?php if(file_exists(\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
<img width="250px" height="250px" id="image" src="<?= \Parameters::UPLOADS_DIR.'/'.$key ?>"/>
<?php } ?>

<br/>
<div id='user_table'></div>
<div width="300px" height="400px" style="overflow:scroll" id='messages'></div>



<input id='message'/>
<button onclick='send()'>send</button>


</body>
</html>


