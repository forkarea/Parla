<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

function __autoload($class_name) {
    include '../src/'.str_replace('\\', '/', $class_name) . '.php';
}
Mondo\SocialNetworkBundle\Controller\UserController::go();

