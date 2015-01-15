<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

namespace Mondo\SocialNetworkBundle\Controller;

use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

class MyCookie {
    public static function read() {
        if(!isset($_COOKIE['key'])) return;
        if(!isset($_COOKIE['password'])) return;
        $key = $_COOKIE['key'];
        $password = $_COOKIE['password'];
        $row = DB::queryRow("SELECT * FROM users WHERE BINARY mykey='%s' and PASSWORD('%s')=password limit 1", [$key, $password]);
        if(!$row) return;
        Session::toSession('id', $row['id']);
        Session::toSession('name', $row['name']);
        Session::toSession('key', $key);
        Session::toSession('password', $password);
    }
}
