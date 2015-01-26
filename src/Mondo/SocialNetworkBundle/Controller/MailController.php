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
    public static function verify($email, $code) {
        try {
            $text = self::getMessage($code);
            self::sendMail($email, 'account verification', $text);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    private static function getMessage($code) {
        $domain_name = \Parameters::DOMAIN_NAME;
        $path = \Parameters::PATH;
        $project_name = \Parameters::PROJECT_NAME;
        return <<<DELIM
Thank you for your registration, to complete your registration process, please open the following link:
http://$domain_name/public/{$path}{$project_name}/web/app.php?action=verify_after&code=$code

This email has been generated automatically, please do not respond.
DELIM;
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
    MailController::verify(urldecode($argv[1]), $argv[2]);
    DB::query('INSERT INTO emails VALUES ("%s", 1) ON DUPLICATE KEY UPDATE is_correct=1', [urldecode($argv[1])]);
} catch(\Exception $e) {
    DB::query('INSERT INTO emails VALUES ("%s", 0) ON DUPLICATE KEY UPDATE is_correct=0', [urldecode($argv[1])]);
}
