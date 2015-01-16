<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

function __autoload($class_name) {
    include '../src/'.str_replace('\\', '/', $class_name) . '.php';
}

$actions = [
    'home' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Home.php';
    },
    'chat' => function() {
        '../src/Mondo/SocialNetworkBundle/View/Chat.php';
    },
    'go' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::go();
    }
];


if(!isset($_GET['action'])) $action = 'home';
else $action = $_GET['action'];
$actions[$action]();
