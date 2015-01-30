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
        if($from=='home' || $from=='forgot_password') {
            if(Session::getSessionData('key') != "") header('Location: app.php?action=chat');
        } else {
            if(Session::getSessionData('key') == "") header('Location: app.php');
        }
    }

    private static function univLogin($id, $name, $key, $password, $verified, $ok, $errMsg) {
        if($ok) {
            Session::toSession('id', $id);
            Session::toSession('name', $name);
            Session::toSession('key', $key);
            Session::toSession('password', $password);
            Session::toSession('verified', $verified);
            Session::toSession('errors', '');
            Session::toSession('errors_name', '');
            file_put_contents('log.txt', "\n\nSuccessful login, username: ".$name.', key: '.$key.
                ', time: '.(new \DateTime)->format('Y-m-d H:i:s'), FILE_APPEND);
        } else {
            foreach($errMsg as $errKey => $msg) {
                Session::toSession($errKey, $msg);
            }
            file_put_contents('log.txt', "\n\nUnsuccessful login, username: ".$name.
                ', time: '.(new \DateTime)->format('Y-m-d H:i:s'), FILE_APPEND);
        }
    }

    private static function login($key, $password) {
        $row = DB::queryRow(
            'SELECT id,name,mykey,verified FROM users WHERE (BINARY mykey="%1$s" OR BINARY mail="%1$s") AND PASSWORD("%2$s")=password LIMIT 1', [$key, $password]);
        self::univLogin($row['id'], $row ? $row['name'] : $key, $row['mykey'], $password, $row['verified']==1, $row ? true : false,
            ['errors' => 'Incorrect username or password']);
    }

    private static function loginById($id) {
        file_put_contents('/home/pierre/log.txt', "\n\nloginById id=".$id, FILE_APPEND);
        $row = DB::queryRow("SELECT * FROM users WHERE BINARY id=%s limit 1", [$id]);
        self::univLogin($row['id'], $row['name'], $row['mykey'], '', $row['verified']==1, $row ? true : false, ['errors' => 'Incorrect username or password']);
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

        self::univLogin($id, $name, $key, $password, false, self::validateName($name) ? true : false, ['errors_name' => 'Incorrect name']);
    }

    public static function go() {
        $key = $_POST['key'];
        $password = $_POST['password'];
        $row = DB::queryRow('SELECT * FROM users WHERE (BINARY mykey="%1$s" OR BINARY mail="%1$s") AND PASSWORD("%2$s")=password LIMIT 1', [$key, $password]);

        if($_POST['key']!=='' || $_POST['password']!=='') $loc = self::login($_POST['key'], $_POST['password']);
        else $loc = self::createUser($_POST['name']);

        if(isset($_POST['remember'])) {
            setcookie('key', Session::getSessionData('key'), time()+86400*30, '/');
            setcookie('password', Session::getSessionData('password'), time()+86400*30, '/');
        }

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
        $row = DB::queryRow('SELECT mail,verified FROM users WHERE id=%s', [$_GET['id']]);
        if($row['mail']!=$_POST['email']) {
            $count = DB::queryCell('SELECT COUNT(*) c FROM users WHERE mail="%s"', [$_POST['email']], 'c');
            if($count>0) {
                Session::toSession('errors_mail', 'another user has this email');
                header('Location: app.php?action=account_settings');
                return;
            }
        }
        if($row['mail']!=$_POST['email'] || !$row['verified']) if(!self::verify($_GET['id'], $_POST['email'])) {
            Session::toSession('errors_mail', 'incorrect email address');
            header('Location: app.php?action=account_settings');
            return;
        }
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
        $verified = $row['mail']==$_POST['email'] && $row['verified'] ? 1 : 0;
        DB::query("UPDATE users SET mail='%s', name='%s', city='%s', country='%s', birth='%s', gender='%s', orientation='%s', about='%s', verified=%s WHERE id=%s LIMIT 1",
            [
                $_POST['email'],
                $_POST['name'],
                $_POST['city'],
                $_POST['country'],
                $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'],
                $_POST['gender'],
                $_POST['orientation'],
                $_POST['about'],
                $verified,
                $_GET['id']
                ]);
        Session::toSession('name', $_POST['name']);
        header('Location: app.php');
    }

    private static function checkNewPassword() {
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
    }

    public static function updatePassword() {
        self::checkNewPassword();
        $isCorrect = DB::queryRow("SELECT password FROM users WHERE id=%s AND password=password('%s') LIMIT 1", [$_GET['id'], $_POST['current']], 'password');
        if(!$isCorrect) {
            Session::toSession('errors', 'incorrect password');
            header('Location: app.php?action=change_password');
            return;
        }
        DB::query("UPDATE users SET password=password('%s') WHERE id=%s LIMIT 1", [$_POST['new'], $_GET['id']]);
        Session::toSession('password', $_POST['new']);
        header('Location: app.php');
    }

    public static function resetAfter() {
        self::checkNewPassword();
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
        DB::query("UPDATE users SET password=password('%s'), verified=1 WHERE id=%s LIMIT 1", [$_POST['new'], $_GET['id']]);
        Session::toSession('password', $_POST['new']);
        header('Location: app.php');
    }


    private static function preMail($id, $email, $subject, $msgFunc) {
        $code = Text::randStrAlpha(24);
        DB::query('INSERT INTO verif_codes(user_id, code) VALUES("%s", password("%s"))', [$id, $code]);
        //header('Location: ../src/Mondo/SocialNetworkBundle/Controller/MailController.php?email='.urlencode($email).'&code='.$code);
        system(PHP_BINDIR.DIRECTORY_SEPARATOR.'php ..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Mondo'.DIRECTORY_SEPARATOR.
            'SocialNetworkBundle'.DIRECTORY_SEPARATOR.'Controller'.DIRECTORY_SEPARATOR.'MailController.php '.
            urlencode($email).' '.urlencode($subject).' '.urlencode(self::{$msgFunc}($code)));
        $is_correct = DB::queryCell('SELECT is_correct FROM emails WHERE email="%s"', [$email], 'is_correct');
        return $is_correct;
    }

    public static function verify($id, $email) {
        return self::preMail($id, $email, 'account verification', 'getVerifMessage');
    }

    public static function verifyById($id) {
        $email = DB::query('SELECT mail FROM users WHERE id=%s LIMIT 1', [$id]);
        return self::verify($id, $email);
    }

    public static function resetPassword($email) {
        $id = DB::queryCell("SELECT id FROM users WHERE mail='%s' LIMIT 1", [$email], 'id');
        self::preMail($id, $email, 'password reset', 'getResetMessage');
        file_put_contents('/home/pierre/log.txt', "\n\nemail=".$email, FILE_APPEND);
        header('Location: app.php');
    }

    private static function getResetMessage($code) {
        $domain_name = \Parameters::DOMAIN_NAME;
        $path = \Parameters::PATH;
        $project_name = \Parameters::PROJECT_NAME;
        return <<<DELIM
To reset your account, please open the following link:
http://$domain_name/public/{$path}{$project_name}/web/app.php?action=reset_view&code=$code

This email has been generated automatically, please do not respond.
DELIM;
    }

    private static function getVerifMessage($code) {
        $domain_name = \Parameters::DOMAIN_NAME;
        $path = \Parameters::PATH;
        $project_name = \Parameters::PROJECT_NAME;
        return <<<DELIM
Thank you for your registration, to complete your registration process, please open the following link:
http://$domain_name/public/{$path}{$project_name}/web/app.php?action=verify_after&code=$code

This email has been generated automatically, please do not respond.
DELIM;
    }

    public static function verifyAfter($code) {
        file_put_contents('/home/pierre/log.txt', "\n\nverAfter", FILE_APPEND);
        $id = DB::queryCell('SELECT user_id FROM verif_codes WHERE password("%s")=code', [$code], 'user_id');
        DB::query('UPDATE users SET verified=1 WHERE id=%s', [$id]);
        //DB::query('DELETE FROM verif_codes WHERE password("%s")=code', [$code]);
        echo 'xxx';
        self::loginById($id);
        header('Location: app.php');
    }
}
