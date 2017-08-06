<?php
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

    public static function queryMulti($list) {
        $conn = new \mysqli(\Parameters::DB_HOST, \Parameters::DB_USER, \Parameters::DB_PASSWORD, \Parameters::DB_NAME);
        if ($conn->connect_error) {
            throw new \Exception("Connection failed: " . $conn->connect_error);
        }

        $query = '';
        foreach($list as $elem) {
            $queryLine = $elem[0];
            if(isset($elem[1])) $args = $elem[1];
            else $args = [];
            $ar = [];
            foreach($args as $a) $ar[] = $conn->real_escape_string($a);
            $query .= vsprintf($queryLine, $ar).';';
        }

        $result = $conn->multi_query($query);
        self::$lastQuery = $query;
        file_put_contents('log.txt', "\n\nquery: ".$query, FILE_APPEND);
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

    public static function ajaxQuery($query, $args) {
        foreach($args as $argskey => $argsval) $query = preg_replace('/:'.$argskey.'/', $argsval, $query);
        $result = self::query($query);
        header('Content-type: application/json');
        if(!is_object($result)) return;
        $output = [];
        while($row = $result->fetch_assoc()) $output[] = $row;
        echo json_encode($output);
    }
}
