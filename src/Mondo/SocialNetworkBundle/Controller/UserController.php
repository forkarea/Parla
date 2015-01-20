<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

namespace Mondo\SocialNetworkBundle\Controller;


use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;
use Mondo\UtilBundle\Core\Text;
use Mondo\SocialNetworkBundle\Controller\MyCookie;

class UserController {
    public static function autoGo($from) {
        MyCookie::read();
        if($from!='home') if(Session::getSessionData('key') == "") header('Location: app.php');
        if($from=='home') if(Session::getSessionData('key') != "") header('Location: app.php?action=chat');
    }

    private static function login($key, $password) {
        $row = DB::queryRow("SELECT * FROM users WHERE BINARY mykey='%s' and PASSWORD('%s')=password limit 1", [$key, $password]);

        if($row) {
            Session::toSession('id', $row['id']);
            Session::toSession('name', $row['name']);
            Session::toSession('key', $key);
            Session::toSession('password', $password);
            Session::toSession('errors', '');
            Session::toSession('errors_name', '');
            return 'Chat.php';
        } else {
            Session::toSession('errors', 'Incorrect username or password');
            return 'Home.php';
        }
    }

    public static function logout() {
        Session::clearSession();
        setcookie('key', '', time()-86400*30, '/');
        setcookie('password', '', time()-86400*30, '/');
        header("Location: app.php");
    }

    private static function createUser($name) {
        $key = Text::randStrAlpha(12);
        $password = Text::randStrAlpha(16);

        DB::query("INSERT INTO users (name, mykey, password) VALUES ('%s', '%s', PASSWORD('%s'))", [$name, $key, $password]);
        $id = DB::queryCell("SELECT id FROM users WHERE BINARY mykey='%s'", [$key], 'id');

        if(!self::validateName($name)) {
            Session::clearSession();
            Session::toSession('errors_name', 'Incorrect name');
            return 'Home.php';
        }
        Session::toSession('id', $id);
        Session::toSession('errors', '');
        Session::toSession('name', $name);
        Session::toSession('key', $key);
        Session::toSession('password', $password);
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

        //include '../src/Mondo/SocialNetworkBundle/View/'.$loc;
        header('Location: app.php');
    }

    private static function upload($fileName, $new) {
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
        $target_dir = "./uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $new;
        $imageFileType = pathinfo($fileName,PATHINFO_EXTENSION);
        if ($_FILES["fileToUpload"]["size"] > 500000) return "Sorry, your file is too large.";
        if(!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'bmp', 'gif'])) return "Sorry, only image files are allowed.";
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            return "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        else
            return "Sorry, there was an error uploading your file.";
    }

    public static function uploadPhoto() {
        $file = basename($_FILES["fileToUpload"]["name"]);
        $key = Session::getSessionData('key');
        Session::toSession('info', self::upload($file, $key));
        header('Location: app.php?action=chat');
    }

    public static function notify() {
        $id = $_POST['sender'];
        DB::query("UPDATE users SET last_notified=NOW() WHERE ID=%s", [$id]);
    }


    public static function profileImage($key) {
        header('Content-Type: image/png');

        $path = '../'.\Parameters::UPLOADS_DIR.'/'.$key;
        if(file_exists($path)) readfile($path);
        else {
            $gender = DB::queryCell("SELECT gender FROM users WHERE mykey='%s'", [$key], 'gender');
            $images = [
                'n' => 'both.png',
                'm' => 'man.png',
                'f' => 'woman.png'
                ];
            readfile('../src/Mondo/SocialNetworkBundle/Images/'.$images[$gender]);
        }
    }

    private static function validateName($name) {
        if(is_string($name)) if(strlen($name)>0 && strlen($name)<16) return true;
        return false;
    }

    private static function validateBirth($birth) {
        set_error_handler(function() {
            throw new \Exception('incorrect or missing parameters');
        });
        try {
            new \DateTime($birth);
        } catch(\Exception $e) {
            return false;
        }
        return true;
    }

    public static function accountUpdate() {
        if(!self::validateBirth($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'])) {
            Session::toSession('errors_birth', 'incorrect date of birth');
            header('Location: app.php?action=account_settings');
            return;
        }
        if(!self::validateName($_POST['name'])) {
            Session::toSession('errors_name', 'incorrect name');
            header('Location: app.php?action=account_settings');
            return;
        }
        DB::query("UPDATE users SET mail='%s', name='%s', city='%s', country='%s', birth='%s', gender='%s', orientation='%s', about='%s' WHERE id=%s LIMIT 1",
            [
                $_POST['email'],
                $_POST['name'],
                $_POST['city'],
                $_POST['country'],
                $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'],
                $_POST['gender'],
                $_POST['orientation'],
                $_POST['about'],
                $_GET['id']
                ]);
        Session::toSession('name', $_POST['name']);
        header('Location: app.php?action=chat');
    }

    public static function updatePassword() {
        if($_POST['new'] == '') {
            Session::toSession('errors', 'the password cannot be empty');
            header('Location: app.php?action=change_password');
            return;
        }
        if($_POST['new'] != $_POST['repeat']) {
            Session::toSession('errors', 'the passwords are not the same');
            header('Location: app.php?action=change_password');
            return;
        }
        $isCorrect = DB::queryRow("SELECT password FROM users WHERE id=%s AND password=password('%s') LIMIT 1", [$_GET['id'], $_POST['current']], 'password');
        var_dump($isCorrect);
        if(!$isCorrect) {
            Session::toSession('errors', 'incorrect password');
            header('Location: app.php?action=change_password');
            return;
        }
        DB::query("UPDATE users SET password=password('%s') WHERE id=%s LIMIT 1", [$_POST['new'], $_GET['id']]);
        Session::toSession('password', $_POST['new']);
        header('Location: app.php?action=chat');
    }
}
