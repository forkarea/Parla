<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\Session;
?>
<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
<?php endblock() ?>
<?php startblock('content') ?>
Change password <br/>
<form action="app.php?action=update_password&id=<?= Session::getSessionData('id') ?>" method="post">
    Current password: <input type="password" name="current" /> <br/>
    New password: <input type="password" name="new" /> <br/>
    Repeat password: <input type="password" name="repeat" /> <br/>
    <input type="submit" value="OK"/>
</form>
<?= Session::getSessionData('errors'); ?>
<?php endblock() ?>

