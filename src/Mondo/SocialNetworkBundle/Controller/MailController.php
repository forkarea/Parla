<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

require_once '../../../../vendor/swiftmailer/swiftmailer/lib/swift_required.php';
require_once '../../../../app/parameters.php';
require_once '../../UtilBundle/Core/DB.php';

use Mondo\UtilBundle\Core\DB;

class MailController {
    public static function verify($id) {
        $email = DB::queryCell('SELECT mail FROM users WHERE id=%s', [$id], 'mail');
        //$email = 'uomodislesia@gmail.com';

        $text = file_get_contents('http://'.\Parameters::DOMAIN_NAME.'/public/'.\Parameters::PATH.\Parameters::PROJECT_NAME.'/web/app.php?action=verif_text&id='.$id);
        echo 'text='.$text;
        //self::sendMail($email, 'account verification', $text);
    }

    private static function getMessage($user) {

    }

    private static function sendMail($email, $subject, $msg) {
        function __autoload($class_name) {
        }

        $transport = \Swift_SmtpTransport::newInstance(\Parameters::SMTP_SERVER, 465, "ssl")
            ->setUsername(\Parameters::SMTP_USER)
            ->setPassword(\Parameters::SMTP_PASSWORD);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance($subject)
            ->setFrom(array('ajax@chat.com' => 'chat'))
            ->setTo(array($email))
            ->setBody($msg);

        $result = $mailer->send($message);
        return $result;
    }
}


MailController::verify($_GET['id']);
//header('Location: ../../../../web/app.php');
