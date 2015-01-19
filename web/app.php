<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
require_once '../app/parameters.php';

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
    },
    'notify' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::notify();
    },
    'logout' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::logout();
    },
    'account_settings' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/AccountSettings.php';
    },
    'profile_image' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::profileImage($_GET['user']);
    },
    'profile' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Profile.php';
    }
];


if(!isset($_GET['action'])) $action = 'home';
else $action = $_GET['action'];
$actions[$action]();
