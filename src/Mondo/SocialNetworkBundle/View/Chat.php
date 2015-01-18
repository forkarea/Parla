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



<h1>Multiuser chat</h1>

Your name: <?= Session::getSessionData('name') ?> <br/>
Your key: <?= Session::getSessionData('key') ?> <br/>
<button id="passwordButton" onclick="togglePassword()">Show password</button>
<p id="password" style="display:none">Your password: <?= Session::getSessionData('password') ?> </p><br/>

<?php
echo Session::getSessionData('errors'); 
?>


<a href="app.php?action=logout">log out</a>
<br/>

<?= Session::session('info')  ?>
<form action="app.php?action=upload_photo" method="post" enctype="multipart/form-data" onsubmit="refresh_image()">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="upload your photo" name="submit">
</form>

<br/>

<?php if(file_exists('../'.\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
<img width="250px" height="250px" id="image" src="../<?= \Parameters::UPLOADS_DIR.'/'.$key ?>"/>
<?php } ?>

<br/>
<div id='user_table'></div>
<div width="300px" height="400px" style="overflow:scroll" id='messages'></div>



<input id='message'/>
<button onclick='send()'>send</button>


</body>
</html>


