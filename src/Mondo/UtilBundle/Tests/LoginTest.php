<?php
namespace Mondo\UtilBundle\Tests;

require_once '../app/parameters.php';
require_once '../src/Mondo/UtilBundle/Core/DB.php';

use Mondo\UtilBundle\Core\DB;

class DBTest extends \PHPUnit_Framework_TestCase {
    public function testUsers() {
        DB::query('INSERT INTO users(name, mykey, password) VALUES("%s", "%s", PASSWORD("%s"))', ['alan', 'qw123', 'zaqwsx']);
        $key = DB::queryCell('SELECT name, mykey FROM users WHERE name="%s"', ['alan'], 'mykey');
        $this->assertEquals($key, 'qw123');
        $row = DB::queryRow('SELECT mykey, password FROM users WHERE mykey="%s" AND password=PASSWORD("%s")', ['qw123', 'zaqwsx']);
        $this->assertNotNull($row);
    }

    public function testMessages() {
        DB::query('INSERT INTO messages(text, sender, receiver) VALUES("%s", %s, %s)', ['blabla test', 1, 3]);
        $hour = DB::queryCell('SELECT hour(time) h FROM messages WHERE text="%s" AND sender=%s AND receiver=%s', ['blabla test', 1, 3], 'h');
        $this->assertEquals($hour, idate('H'));
    }
}
