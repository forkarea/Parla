<?php
/****************************************
 *
 * Author: Piotr Sroczkowski, Paulina Ryfka
 *
 ****************************************/
?>

<?php include 'Base.php' ?>
<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
use Mondo\UtilBundle\Core\Session;

$id = Session::getSessionData('id');
$name = Session::getSessionData('name');
$key = Session::getSessionData('key');
?>

<?php startblock('styles') ?>
    <link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/chat.css">
    <link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/user_table.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
<?php endblock() ?>
<?php startblock('javascripts') ?>
    <script src="../components/jquery/jquery-1.11.1.min.js"></script>
    <script src="../components/bootstrap/js/bootstrap.js"></script>
    <script>
        var $id = <?= $id ?>;
        var image_src = '<?= \Parameters::UPLOADS_DIR.'/'.$key ?>';
        var receiver = null;
    </script>
    <script src="../src/Mondo/SocialNetworkBundle/JS/ajax.js"></script>
<?php endblock() ?>

<?php startblock('content') ?>
<div class="panel panel-parla">
	<div class="panel-heading">
		<h1 class="panel-title">
		<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
		 Main page</h1>
	</div>
	<div class="panel-body chat-pnl">
	<div class="row userRow">
                <?php /* displaying profile image */ ?>
		<div class="col-xs-2 avatar">
            <img width="150px" height="150px" id="image" src="app.php?action=profile_image&user=<?= Session::getSessionData('key') ?>"/>
		</div>
                <?php /* photo upload */ ?>
		<div class="col-xs-3 avatarUpload">
			<form action="app.php?action=upload_photo" method="post" enctype="multipart/form-data" onsubmit="refresh_image()">
				<span class="glyphicon glyphicon-picture" aria-hidden="true"></span><span class="uploadTxt"> Select image to upload:</span>
				<input class="chooseAvatar" type="file" name="fileToUpload" id="fileToUpload">
				<input class="btn btn-success uploadBtn" type="submit" value="upload your photo" name="submit">
			</form>
			<span class="uploadInfo"><?= Session::session('info')  ?></span>
		</div>
                <?php /* user info */ ?>
		<div class="col-xs-4 userInfo">
			<div class="row">
					<div class="col-xs-4">
						<span class="glyphicon glyphicon-user infoTxt info-pad" aria-hidden="true"></span><span class="infoTxt"> Your name:</span>
					</div>
					<div class="col-xs-8">
						<span class="name-info"><?= Session::getSessionData('name') ?></span>
					</div>
			</div>
			<div class="row">
					<div class="col-xs-4">
						<span class="glyphicon glyphicon-hand-right infoTxt" aria-hidden="true"></span><span class="infoTxt"> Your key:</span>
					</div>
					<div class="col-xs-8">
						<span class="key-info"><?= Session::getSessionData('key') ?></span>
					</div>
			</div>
			</br>
			<div class="row">
					<div class="col-xs-4">
						<button class="btn btn-success passBtn" id="passwordButton" onclick="togglePassword()">Show password/email</button>
					</div>
					<div class="col-xs-8">
						<div class="pass"><p id="password" style="display:none"> <?= Session::getSessionData('password') ?> </p></div>
					</div>
			</div>
			<?php
				echo Session::getSessionData('errors'); 
			?>
		</div>
                <?php /* logout */ ?>
		<div class="col-xs-3 logout">
			<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span><a href="app.php?action=logout"> log out</a> <br/>
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span><a href="app.php?action=account_settings">account settings</a> <br/>
                        <a href="app.php?action=search">Search</a> <br/>
		</div>
	</div>
	<div class="row chatRow">
                <?php /* chat */ ?>
		<div class="col-xs-9">
			<div class="chat-box">
				<div class="chatTitle">
					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
					<span style="font-weight:bold">CHAT: </span><span id="chat_partner">(select chat partner)</span>
				</div>
				<div class="chatHistory" id='messages'></div>
				<input class="chat" id='message'/>
				<button class="btn btn-success sendBtn" onclick='send()'>send</button>
			</div>
		</div>
                <?php /* user list */ ?>
		<div class="col-xs-3">
			<div id='user_table'></div>
		</div>
                <div class="col-xs-5" id="writing_info"></div>
	</div>
</div>

</div>
<?php endblock() ?>
