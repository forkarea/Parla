<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\DB;
use Mondo\SocialNetworkBundle\Entity\User;

$key = $_GET['user'];
$user = DB::queryRow("SELECT * FROM users WHERE mykey='%s'", [$key]);
$entity = new User($user);
?>

<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
<?php endblock() ?>
<?php startblock('content') ?>

<img class="" width="50px" id="image" src="app.php?action=profile_image&user=<?= $user['mykey'] ?>"/>
key: <?= $user['mykey'] ?> <br/>
name: <?= $user['name'] ?> <br/>
city: <?= $user['city'] ?> <br/>
country: <?= $user['country'] ?> <br/>
gender: <?= $user['gender'] ?> <br/>
age: <?= $entity->get('age') ?> <br/>
orientation: <?= $user['orientation'] ?> <br/>

<?php endblock() ?>
