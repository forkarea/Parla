<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

$result = DB::query('SELECT text, sender, time FROM messages WHERE TIMESTAMPDIFF(HOUR, time, now()) < %s', [3]);
?>

<div width="300" height="500" style="background:#EDFFDC;">
<?php 
    while($row = $result->fetch_assoc()) {
?>
    <div class="container" style="background: white; margin-bottom:5px; width:800px">
		<div class="row message">
			<!-- wyswietlenie avataru-->
			<div class="col-md-1">
				<?php
					$user = DB::queryRow("SELECT name, mykey FROM users WHERE id='%s'", [$row['sender']]);
					$key = $user['mykey'];
				?>
				<?php if(file_exists('../'.\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
					<img class="imgCol" width="50px" height="50px" id="image" src="app.php?action=profile_image&user=<?= $user['mykey'] ?>"/>
				<?php } ?>
			</div>
			<!-- info o dacie i nadacy-->
			<div class="col-md-2 messageInfo">
				<div class="row">
					<span class="dateTime"><?= $row['time'] ?></span>
				</div>
				<div class="row">
					<span class="name"><?= $user['name'] ?></span>
					</div>
				<div class="row">
					<span style="color:#52CC7A; font-size:10px">(<?= $key ?>)</span>
				</div>
			</div>
			<!--treść wiadomości-->
			<div class="col-md-9 txtMsg">
				<span><?= $row['text'] ?></span>
			</div>
		</div>
    </div>
<?php
    }
?>
</div>

