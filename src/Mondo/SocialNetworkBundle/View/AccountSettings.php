<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\Session;
?>
<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
<?php endblock() ?>
<?php startblock('content') ?>
Account settings <br/>
<a href="app.php?action=change_password">Change password</a> <br/>
<a href="app.php?action=verify&id=<?= Session::getSessionData('id') ?>">Verify e-mail address</a> <br/>
<form action="app.php?action=account_update&id=<?= Session::getSessionData('id') ?>" method="post">
    E-mail address: <input name="email" /> <br/>
    Name: <input name="name" /> <br/>
    City: <input name="city" /> <br/>
    Country: <input name="country" /> <br/>
    Birth: Year: <input name="year" /> <br/>
    Month: <input name="month" /> <br/>
    Day: <input name="day" /> <br/>
    Gender: <select name="gender">
        <option value="m">male</option>
        <option value="f">female</option>
        <option value="n">other</option>
    </select> <br/>
    Sexual orientation: <select name="orientation">
        <option value="hetero">heterosexual</option>
        <option value="homo">homosexual</option>
        <option value="bi">bisexual</option>
        <option value="a">asexual</option>
    </select> <br/>
    About you: <textarea name="about"></textarea> <br/>
    <input type="submit" value="OK"/>
</form>
<?php endblock() ?>
