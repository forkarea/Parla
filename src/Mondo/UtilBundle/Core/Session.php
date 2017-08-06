<?php
namespace Mondo\UtilBundle\Core;

class Session {
    public static function session($index) {
        if(!isset($_SESSION)) session_start();
        return isset($_SESSION[$index]) ? $_SESSION[$index] : "";
    }

    public static function getSessionData($index) {
        if(!isset($_SESSION)) session_start();
        if(isset($_SESSION[$index])) return $_SESSION[$index];
        else {
            //self::clearSession();
            //if(basename($_SERVER['PHP_SELF']) != 'view1.php')
                //header('Location: view1.php');
        }
    }

    public static function toSession($index, $value) {
        if(!isset($_SESSION)) session_start();
        $_SESSION[$index] = $value;
    }

    public static function clearSession() {
        if(!isset($_SESSION)) session_start();
        $_SESSION = [];
    }

    public static function clearErrors() {
        if(!isset($_SESSION)) session_start();
        foreach($_SESSION as $i => $val) {
            if(preg_match('/errors.*/', $i)>0) $_SESSION[$i] = '';
        }
    }
}
