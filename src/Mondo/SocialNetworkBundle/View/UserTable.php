<?php
/****************************************
 *
 * Author: Piotr Sroczkowski, Paulina Ryfka
 *
 ****************************************/
?>
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

<div class="container userTable">
	<div class="row">
		<div class="tableTitle">
			<span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
			users online:
		</div>
	</div>
	<div class="row users" >
		<?php  if($result) if($result->num_rows > 0)
			while($row = $result->fetch_assoc()) {
			$me = $row['mykey']==$key;
		?>
                    <?php if(!$me) { ?>
                    <div 
                        id="user-<?= $row['mykey'] ?>" onclick="userClick(<?php echo $row['id'].', \''.$row['mykey'].'\', \''.$row['name'].'\'' ?>)"
                        class="row singleUser" style="background: white; margin-bottom:5px"
                    >
				<div class="col-md-3 userAv">
						<img width="50px" height="50px" id="image" src="app.php?action=profile_image&user=<?= $row['mykey'] ?>"/>
				</div>
				<div class="col-md-8 onlineUserInfo">
					<div class="row">
						<span class="name"><?= $row['name'] ?></span>
					</div>
					<div class="row">
                                                <span class="user_key">
                                                    <a href="app.php?action=profile&user=<?= $row['mykey'] ?>">
                                                        (<?= $row['mykey'] ?>)
                                                    </a>
                                                </span>
					</div>
				</div>
                    </div>
                <?php } ?>
		<?php
			}
		?>
	</div>
</div>




