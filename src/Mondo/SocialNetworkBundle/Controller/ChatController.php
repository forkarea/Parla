<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

namespace Mondo\SocialNetworkBundle\Controller;

use Mondo\UtilBundle\Core\DB;
use Mondo\UtilBundle\Core\Session;

class ChatController {
    public static function send() {
        $sender = $_POST['sender'];
        $text = $_POST['message'];
        file_put_contents('log.txt', "sender=$sender\n\n", FILE_APPEND);
        DB::query("INSERT INTO messages (text, sender) VALUES ('%s', '%s')", [$text, $sender]);
    }
}

