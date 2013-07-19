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
    protected static $query_schema_table_all = "SELECT * FROM %s.%s";
    protected static $query_schema_table_structure = "SELECT column_name, data_type, is_nullable, column_default, null is_pk FROM information_schema.columns WHERE table_schema || '.' || table_name = ? || '.' ||?";
    protected static $query_schema_table_structure_column_is_pk = "SELECT bool(count(*)>0) is_pk FROM information_schema.key_column_usage K NATURAL JOIN information_schema.table_constraints C WHERE C.table_schema || '.' || C.table_name = ? || '.' ||? AND C.constraint_type='PRIMARY KEY' and K.column_name=?";
    protected static $query_database_info = "SELECT current_database as db, inet_server_addr as server, inet_server_port as port, version from current_database(), inet_server_addr(), inet_server_port(), version()";
	protected static $client_encoding = "SHOW client_encoding";
	protected static $size_database = "SELECT * FROM pg_size_pretty(pg_database_size(?)) as size";
	
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
            $st = $this->_conn->prepare(sprintf(self::$query_schema_table_all, $schema, $table));
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
        return $res['is_pk'] ? "sim":"não";
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

	/* Pega a string de queries */
	public function getConsultString($queries_string) {
		try {
			$queries_string = explode(";", $queries_string);
			$tables = array();
			
			foreach ($queries_string as $value) {
				$table = self::executeQuery(trim($value));
				if($table != null) {
					$tables[] = $table;
				} 
			}
			
			if(empty($tables))
				return null;
			
			return $tables;
		}
		catch (\PDOException $e) {
        }
	}
	
	/* Executa a query */
	private function executeQuery($query) {
		$st = $this->_conn->prepare($query);
        $st->execute();
		
		$mensage = array();
		if($st->errorInfo()[0] == '00000'){
			$mensage['type'] = "success";
			$mensage['string'] .= "<div>";
			$mensage['string'] .= "<pre class='alert alert-success'><b>SUCESS!</b><br>" .  $query . "</pre><br>";
			$mensage['string'] .= "</div>";
		}
		else {
			$mensage['type'] = "error";
			$mensage['string'] .= "<div>";
			$mensage['string'] .= "<pre class='alert alert-error'><b>ERROR!</b><br>" .  $st->errorInfo()[2] . "</pre><br>";
			$mensage['string'] .= "</div>";
		}
		
		$res = $st->fetchAll(\PDO::FETCH_ASSOC);
		$res['mensage'] = $mensage;

		if(empty($res) || $query == '')
			return null;
			
		return $res;
	} 
	
    public function getConnectionInfo() {
        $st = $this->_conn->prepare(self::$query_database_info);
        $st->execute();
		
        return $st->fetch(\PDO::FETCH_ASSOC);
    }
	
	public function getClientEncoding() {
		$st = $this->_conn->prepare(self::$client_encoding);
        $st->execute();
		
        return $st->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function getSizeDataBase($database) {
		$st = $this->_conn->prepare(self::$size_database);
		$st->bindParam(1, $database);
        $st->execute();
		
		return $st->fetch(\PDO::FETCH_ASSOC);
	}
	
	public function getDatabaseInfo() {
        $connection_info = self::getConnectionInfo();
		$client_encoding = self::getClientEncoding();
		$size_database = self::getSizeDataBase($connection_info['db']);
		
		$database_info = array_merge($connection_info, $client_encoding, $size_database);
		
		return $database_info;
    }
}