<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\DB;
use Mondo\SocialNetworkBundle\Entity\User;

$minAge = 18;
$maxAge = 70;
?>
<?php startblock('styles') ?>
    <link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/search.css">
	<link rel="stylesheet" type="text/css" href="../src/Mondo/SocialNetworkBundle/CSS/main.css">
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

<div class="panel panel-parla">
        <div class="panel-heading">
                <h1 class="panel-title">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                 Search user</h1>
        </div>
        <div class="panel-body search">
		<div class="row row-sett">
            <div class="col-xs-3">
                City: 
            </div>
            <div class="col-xs-9">
                <input name="city" id="city" />
           </div>
        </div>	
		<div class="row row-sett">
            <div class="col-xs-3">
                Country: 
            </div>
            <div class="col-xs-9">
                <input name="country" id="country" />
           </div>
        </div>	
		<div class="row row-sett">
			<div class="col-xs-3"> 
				Age:
			</div>
			<div class="col-xs-9 age"> 
				<span class="txt">From:</span>
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
				<span class="txt">To:</span>
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
			</div>
		</div>
		<div class="row row-sett">
            <div class="col-xs-3">
                Gender: 
            </div>
            <div class="col-xs-9">
                <select class="selects" name="gender" id="gender">
					<option value=""></option>
					<option value="m">male</option>
					<option value="f">female</option>
					<option value="n">other</option>
				</select>
           </div>
        </div>	
		<div class="row row-sett">
            <div class="col-xs-3">
                Orientation: 
            </div>
            <div class="col-xs-9">
                <select class="selects" name="orientation" id="orientation">
					<option value=""></option>
					<option value="hetero">heterosexual</option>
					<option value="homo">homosexual</option>
					<option value="bi">bisexual</option>
					<option value="a">asexual</option>
				</select>
           </div>
        </div>
		<input onclick="window.location.href='app.php'" class="btn btn-success search-btn" type="button" value="BACK"/>
		<input onclick="search()" class="btn btn-success search-btn" type="button" value="SEARCH"/>
		<div id="results">

		</div>
                <div style="text-align:center">
                    <button onclick="prev()" style="width:20%">Previous</button>
                    <input id="paginator" style="width:20%" placeholder="page nr"/>
                    <span id="totalPages" style="width:20%"></span>
                    <button onclick="next()" style="width:20%">Next</button>
                    <select id="onOnePage" style="width:20%">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
	</div>
</div>
<?php endblock() ?>
