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
		<div class="row singleUser" style="background: white; margin-bottom:5px">
			<?php if(!$me) { ?>
				<div class="col-md-3 userAv">
					<?php if(file_exists('../'.\Parameters::UPLOADS_DIR.'/'.$key)) { ?>
						<img width="50px" height="50px" id="image" src="../<?= \Parameters::UPLOADS_DIR.'/'.$key ?>"/>
					<?php } ?>
				</div>
				<div class="col-md-8 onlineUserInfo">
					<div class="row">
						<span class="name"><?= $row['name'] ?></span>
					</div>
					<div class="row">
						<span style="color:#52CC7A; font-size:10px">(<?= $row['mykey'] ?>)</span>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
			}
		?>
	</div>
</div>




