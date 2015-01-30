<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

require_once '../vendor/swiftmailer/swiftmailer/lib/swift_required.php';
require_once '../app/parameters.php';
require_once '../src/Mondo/UtilBundle/Core/DB.php';

use Mondo\UtilBundle\Core\DB;

class MailController {
    public static function verify($email, $subject, $msg) {
        try {
            self::sendMail($email, $subject, $msg);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    private static function sendMail($email, $subject, $msg) {
        try {
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
        } catch(\Exception $e) {
            throw $e;
        }
    }
}


try {
    MailController::verify(urldecode($argv[1]), urldecode($argv[2]), urldecode($argv[3]));
    DB::query('INSERT INTO emails VALUES ("%s", 1) ON DUPLICATE KEY UPDATE is_correct=1', [urldecode($argv[1])]);
} catch(\Exception $e) {
    DB::query('INSERT INTO emails VALUES ("%s", 0) ON DUPLICATE KEY UPDATE is_correct=0', [urldecode($argv[1])]);
}
