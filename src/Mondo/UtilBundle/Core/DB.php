<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
namespace Mondo\UtilBundle\Core;

class DB {
    private static $lastQuery;

    public static function query($sql, $args = []) {
        $conn = new \mysqli(\Parameters::DB_HOST, \Parameters::DB_USER, \Parameters::DB_PASSWORD, \Parameters::DB_NAME);
        if ($conn->connect_error) {
            throw new \Exception("Connection failed: " . $conn->connect_error);
        }

        $ar = [];
        foreach($args as $a) $ar[] = $conn->real_escape_string($a);

        $lastQuery = vsprintf($sql,$ar);
        $result = $conn->query($lastQuery);
        self::$lastQuery = $lastQuery;
        file_put_contents('log.txt', "\n\nquery: ".$lastQuery, FILE_APPEND);
        $conn->close();
        return $result;
    }

    public static function queryRow($sql, $args) {
        return self::query($sql, $args)->fetch_assoc();
    }

    public static function queryCell($sql, $args, $index) {
        return self::queryRow($sql, $args)[$index];
    }

    public static function getLastQuery() {
        return self::$lastQuery;
    }
}
