<?php
require 'model/conf/db.php';
    try {
        $pdo = new \PDO(
            \DB_Config::$DB_CONF['driver'] . ":dbname=" . \DB_Config::$DB_CONF['database'] . ";host=" .
            \DB_Config::$DB_CONF['host'] . ";port=" . \DB_Config::$DB_CONF['port'],
            \DB_Config::$DB_CONF['user'], \DB_Config::$DB_CONF['password']);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
?>