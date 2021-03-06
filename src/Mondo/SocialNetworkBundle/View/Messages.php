<?php
use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

header('Content-type: application/json');


$sender = $_GET['sender'];
$receiver = $_GET['receiver'];
$lastId = 0;
if(is_numeric($_GET['last_id'])) $lastId = $_GET['last_id'];
$result = DB::query(
    'SELECT id, text, sender, time FROM messages WHERE TIMESTAMPDIFF(%5$s, time, now()) < %1$s AND (sender=%2$s AND receiver=%3$s OR sender=%3$s AND receiver=%2$s) AND id>%4$s',
    [$_GET['time_val'], $sender, $receiver, $lastId, $_GET['time_unit']]);
DB::query(
    'UPDATE messages SET just_read=1 WHERE TIMESTAMPDIFF(%5$s, time, now()) < %1$s AND sender=%3$s AND receiver=%2$s AND id>%4$s',
    [$_GET['time_val'], $sender, $receiver, $lastId, $_GET['time_unit']]);

ob_start();
?>

<div width="300" height="500" style="background:#EDFFDC;">
<?php 
    while($row = $result->fetch_assoc()) {
?>
    <div class="container" style="background: white; margin-bottom:5px; width:800px">
                <?php
                        $lastId = $row['id'];
                        $user = DB::queryRow("SELECT name, mykey FROM users WHERE id='%s'", [$row['sender']]);
                        $key = $user['mykey'];
                ?>
		<div class="row message <?= $row['sender']==$sender ? 'myMessage' : 'notMyMessage' ?>">
			<!-- wyswietlenie avataru-->
			<div class="col-md-1">
					<img class="imgCol" width="50px" height="50px" id="image" src="app.php?action=profile_image&user=<?= $user['mykey'] ?>"/>
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
                                        <span class="user_key">
                                            <a href="app.php?action=profile&user=<?= $key ?>">
                                                (<?= $key ?>)
                                            </a>
                                        </span>
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
<?php
$out = ob_get_clean();
echo json_encode(['html' => $out, 'lastId' => $lastId]);
?>
