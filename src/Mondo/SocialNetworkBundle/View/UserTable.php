<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

if(Session::getSessionData('key') == "") header('Location: view1.php');
$name = Session::getSessionData('name');
$key = Session::getSessionData('key');
$result = DB::query("SELECT id, name, mykey, last_notified FROM users WHERE TIMESTAMPDIFF(SECOND, last_notified, now()) < %s ORDER BY name", [9]);
?>

<table border="2">
<thead>
    <tr>
        <td colspan="2">Users online</td> 
    </tr>
    <tr>
        <td>Key</td>
        <td>Name</td>
    </tr>
</thead>
<?php  if($result) if($result->num_rows > 0)
    while($row = $result->fetch_assoc()) {
        $me = $row['mykey']==$key;
?>
    <tr>
        <?php if(!$me) { ?>
            <td><?= $row['mykey'] ?></td>
            <td><?= $row['name'] ?></td>
        <?php } ?>
    </tr> 
<?php
    }
?>
</table>


