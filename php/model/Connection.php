<?php
namespace database;
require 'conf/db.php';

class Connection {
    private static $conn;
    private function __construct() {}

    public static function getConnection() {
        try {
            if (self::$conn == null) {
                self::$conn = new \PDO(
                    \DB_Config::$DB_CONF['driver'] . ":dbname=" . \DB_Config::$DB_CONF['database'] . ";" .
                    "host=" . \DB_Config::$DB_CONF['host'] . ";port=" . \DB_Config::$DB_CONF['port'],
                    \DB_Config::$DB_CONF['user'], \DB_Config::$DB_CONF['password']);
            }
            return self::$conn;

        } catch (\PDOException $e) {
            throw $e;
        }
    }

}