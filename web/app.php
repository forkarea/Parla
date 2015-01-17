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
        include '../src/Mondo/SocialNetworkBundle/View/Chat.php';
    },
    'go' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::go();
    },
    'send' => function() {
        Mondo\SocialNetworkBundle\Controller\ChatController::send();
    },
    'upload_photo' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::uploadPhoto();
    },
    'user_table' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/UserTable.php';
    },
    'messages' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Messages.php';
    }
];


if(!isset($_GET['action'])) $action = 'home';
else $action = $_GET['action'];
$actions[$action]();
