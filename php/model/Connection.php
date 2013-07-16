<?php
namespace database;
require 'conf/db.php';

class Connection {
    private $conn;

    private function __construct()
    {
        if ($this->conn == null) {
            $pdo = new \PDO(
                \DB_Config::$DB_CONF['driver'] . ":dbname=" . \DB_Config::$DB_CONF['database'] . ";" .
                \DB_Config::$DB_CONF['host'] . ":" . \DB_Config::$DB_CONF['port'],
                \DB_Config::$DB_CONF['user'], \DB_Config::$DB_CONF['password']);

        }
    }


}