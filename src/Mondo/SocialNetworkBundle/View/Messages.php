<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
require_once '../app/parameters.php';
use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

$result = DB::query('SELECT text, sender, time FROM messages WHERE TIMESTAMPDIFF(HOUR, time, now()) < %s', [3]);
?>
<div width="300" height="500" style="overflow:scroll">
<?php 
    while($row = $result->fetch_assoc()) {
?>
    <div>
        <?php
            $user = DB::queryRow("SELECT name, mykey FROM users WHERE id='%s'", [$row['sender']]);
            $key = $user['mykey'];
        ?>
        <?php if(file_exists('../'.\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
            <img width="50px" height="50px" id="image" src="../<?= \Parameters::UPLOADS_DIR.'/'.$key ?>"/>
        <?php } ?>
        <span style="color:green; font-size:12px"><?= $row['time'] ?></span>
        <span style="color:blue; font-size:10px"><?= $key ?></span>
        <span style="color:orange; font-size:12px"><?= $user['name'] ?></span>
        <span style="font-size:24px"><?= $row['text'] ?></span>
    </div>

<?php
    }
?>
</div>

