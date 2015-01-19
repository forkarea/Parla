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
            return 'Chat.php';
        } else {
            Session::toSession('errors', 'Not correct username or password');
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

    public static function verifMail() {

    }

    private static function sendMail($email, $subject, $msg) {
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('parla.simple.mailer')
            ->setPassword('QMBfZjpRvPmjzQqIJkYD');

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance($subject)
            ->setFrom(array('ajax@chat.com' => 'chat'))
            ->setTo(array($email))
            ->setBody($msg);

        $result = $mailer->send($message);
        return $result;
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
}
