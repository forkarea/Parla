<?php
namespace Mondo\SocialNetworkBundle\Controller;

use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

class ChatController {
    public static function send() {
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $text = $_POST['message'];
        DB::query("INSERT INTO messages (text, sender, receiver) VALUES ('%s', '%s', '%s')", [$text, $sender, $receiver]);
    }
}

