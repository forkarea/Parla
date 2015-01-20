<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

require_once '../../../../vendor/swiftmailer/swiftmailer/lib/swift_required.php';

class MailController {
    public static function verify($id) {
        $email = DB::queryCell('SELECT mail FROM users WHERE id=%s', $id, 'mail');
        self::sendMail($email, 'account verification', 'blabla');
    }

    private static function sendMail($email, $subject, $msg) {
        function __autoload($class_name) {
        }

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('parla.simple.mailer')
            ->setPassword('QMBfZjpRvPmjzQqIJkYD');

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance($subject)
            ->setFrom(array('ajax@chat.com' => 'chat'))
            ->setTo(array($email))
            ->setBody($msg);

        $result = $mailer->send($message);
        return $result;
    }
}



header('Location: ../../../../web/app.php?action=chat.php');
