<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

function __autoload($class_name) {
    include '../src/'.str_replace('\\', '/', $class_name) . '.php';
}

include '../src/Mondo/SocialNetworkBundle/View/Home.php';
