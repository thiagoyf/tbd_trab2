<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daivid
 * Date: 16/07/13
 * Time: 13:08
 * To change this template use File | Settings | File Templates.
 */

namespace database;

class DBQuerier {
    protected $_conn;
    protected static $query_schemas = "SELECT schema_name FROM information_schema.schemata WHERE schema_name NOT LIKE 'pg_%' AND schema_name not in ('information_schema')";
    protected static $query_tables_from_schema = "SELECT table_name FROM information_schema.tables WHERE table_schema=?";
    protected static $query_schema_table_all = "SELECT * FROM ? || '.' ||?";
    protected static $query_schema_table_structure = "SELECT column_name, data_type, is_nullable, column_default, null is_pk FROM information_schema.columns WHERE table_schema || '.' || table_name = ? || '.' ||?";
    protected static $query_schema_table_structure_column_is_pk = "SELECT bool(count(*)>0) is_pk FROM information_schema.key_column_usage K NATURAL JOIN information_schema.table_constraints C WHERE C.table_schema || '.' || C.table_name = ? || '.' ||? AND C.constraint_type='PRIMARY KEY' and K.column_name=?";
    public function __construct(\PDO $conn) {
        $this->_conn = $conn;
    }

    public function getAllSchemas() {
        try {
            $st = $this->_conn->prepare(self::$query_schemas);
            $st->execute();
            return $st->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
        }
    }

    public function getAllTablesFromSchema($schema) {
        try {
            $st = $this->_conn->prepare(self::$query_tables_from_schema);
            $st->bindParam(1, $schema);
            $st->execute();

            return $st->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
        }
    }

    public function getAllDataFromTableInSchema($table, $schema) {
        try {
            $st = $this->_conn->prepare(self::$query_schema_table_all);
            $st->bindParam(1, $schema);
            $st->bindParam(2, $table);
            $st->execute();

            return $st->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
        }
    }

    public function isColumnFromTableInSchemaPK($column, $table, $schema) {
        $st = $this->_conn->prepare(self::$query_schema_table_structure_column_is_pk);
        $st->bindParam(1, $schema);
        $st->bindParam(2, $table);
        $st->bindParam(3, $column);
        $st->execute();

        $res = $st->fetch(\PDO::FETCH_ASSOC);
        return $res['is_pk'];
    }

    public function getStructureFromTableInSchema($table, $schema) {
        try {
            $st = $this->_conn->prepare(self::$query_schema_table_structure);
            $st->bindParam(1, $schema);
            $st->bindParam(2, $table);
            $st->execute();

            $res = $st->fetchAll(\PDO::FETCH_ASSOC);

            foreach($res as &$row) {
                $row['is_pk'] = self::isColumnFromTableInSchemaPK($row['column_name'], $table, $schema);
            }

            return $res;
        } catch (\PDOException $e) {
        }
    }

}