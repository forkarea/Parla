<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

require_once '../../../../app/parameters.php';
header('Content-Type: text/plain');
?>
Thank you for your registration, to complete your registration process, please open the following link:
http://<?= \Parameters::DOMAIN_NAME ?>/public/<?= \Parameters::PATH ?>/web/app.php?action=verify&code=<?= $_GET['code'] ?>

This email has been generated automatically, please do not respond.
