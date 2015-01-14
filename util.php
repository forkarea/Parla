<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

require_once 'parameters.php';

class Util {

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

    public static function query($sql, $args = []) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $ar = [];
        foreach($args as $a) $ar[] = $conn->real_escape_string($a);

        $result = $conn->query(vsprintf($sql,$ar));
        $conn->close();
        return $result;
    }

    public static function queryRow($sql, $args) {
        return self::query($sql, $args)->fetch_assoc();
    }

    public static function queryCell($sql, $args, $index) {
        return self::queryRow($sql, $args)[$index];
    }

    public static function randStr($str, $n) {
        $ret = '';
        for($i=0; $i<$n; $i++) $ret .= $str[rand(0,strlen($str)-1)];
        return $ret;
    }

    public static function randStrAlpha($n) {
        return self::randStr('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $n);
    }
}
