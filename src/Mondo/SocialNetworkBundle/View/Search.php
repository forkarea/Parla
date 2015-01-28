<?php
/****************************************
 *
 * Author: Piotr Sroczkowski, Paulina Ryfka
 *
 ****************************************/
?>
<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\DB;
use Mondo\SocialNetworkBundle\Entity\User;

$minAge = 18;
$maxAge = 70;
?>

<?php startblock('styles') ?>
    <link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
<?php endblock() ?>
<?php startblock('javascripts') ?>
<script>
    var minAge = <?= $minAge ?>;
    var maxAge = <?= $maxAge ?>;
</script>
    <script src="../components/jquery/jquery-1.11.1.min.js"></script>
    <script src="../components/bootstrap/js/bootstrap.js"></script>
    <script src="../src/Mondo/SocialNetworkBundle/JS/search.js"></script>
<?php endblock() ?>
<?php startblock('content') ?>

City: <input name="city" id="city" />
Country: <input name="country" id="country" />
Age:
From:
<select class="selects" name="age_from" id="age_from">
    <option value="under">Under <?= $minAge ?></option>
    <?php
    for($i=$minAge; $i<=$maxAge; $i++) {
    ?>
        <option value="<?= $i ?>"><?= $i ?></option>
    <?php
    }
    ?>
    <option value="over">Over <?= $maxAge ?></option>
</select>
To:
<select class="selects" name="age_to" id="age_to">
    <option value="under">Under <?= $minAge ?></option>
    <?php
    for($i=$minAge; $i<=$maxAge; $i++) {
    ?>
        <option value="<?= $i ?>"><?= $i ?></option>
    <?php
    }
    ?>
    <option value="over">Over <?= $maxAge ?></option>
</select>
Gender:
<select class="selects" name="gender" id="gender">
    <option value=""></option>
    <option value="m">male</option>
    <option value="f">female</option>
    <option value="n">other</option>
</select>
Orientation:

<select class="selects" name="orientation" id="orientation">
    <option value=""></option>
    <option value="hetero">heterosexual</option>
    <option value="homo">homosexual</option>
    <option value="bi">bisexual</option>
    <option value="a">asexual</option>
</select>
<input onclick="search()" class="btn btn-success submit-btn" type="button" value="OK"/>
<input onclick="window.location.href='app.php'" class="btn btn-success submit-btn" type="button" value="BACK"/>
<div id="results">

</div>
<?php endblock() ?>
