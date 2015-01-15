<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

namespace Mondo\SocialNetworkBundle\Controller;

system('pwd');
use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;
use Mondo\UtilBundle\Core\Text;

class UserController {
    private static function login($key, $password) {
        $row = DB::queryRow("SELECT * FROM users WHERE BINARY mykey='%s' and PASSWORD('%s')=password limit 1", [$key, $password]);

        if($row) {
            Session::toSession('id', $row['id']);
            Session::toSession('name', $row['name']);
            Session::toSession('key', $key);
            Session::toSession('password', $password);
            Session::toSession('errors', '');
            return 'view2.php';
        } else {
            Session::toSession('errors', 'Not correct username or password');
            return 'Home.php';
        }
    }

    private static function createUser($name) {
        $key = Text::randStrAlpha(12);
        $password = Text::randStrAlpha(16);

        Session::toSession('name', $name);
        Session::toSession('key', $key);
        Session::toSession('password', $password);

        DB::query("INSERT INTO users (name, mykey, password) VALUES ('%s', '%s', PASSWORD('%s'))", [$name, $key, $password]);
        $id = DB::queryCell("SELECT id FROM users WHERE BINARY mykey='%s'", [$key], 'id');
        Session::toSession('id', $id);
        Session::toSession('errors', '');
        return 'Chat.php';
    }

    public static function go() {
        $key = $_POST['key'];
        $password = $_POST['password'];
        $row = DB::queryRow("SELECT * FROM users WHERE BINARY mykey='%s' and PASSWORD('%s')=password limit 1", [$key, $password]);

        if($_POST['key']!=='' || $_POST['password']!=='') $loc = self::login($_POST['key'], $_POST['password']);
        else $loc = self::createUser($_POST['name']);

        if(isset($_POST['remember'])) {
            setcookie('key', Session::getSessionData('key'), time()+86400*30, '/');
            setcookie('password', Session::getSessionData('password'), time()+86400*30, '/');
        }

        include '../src/Mondo/SocialNetworkBundle/View/'.$loc;
    }
}
