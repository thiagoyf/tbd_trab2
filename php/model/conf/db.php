<?php
    class DB_Config {

        public static $DB_CONF = Array(
            "host" => 'localhost', #endereço do banco
            "port" => "5432", #porta do banco
            "database" => "postgres", #nome do banco de dados
            "user" => 'postgres',#nome do usuario do banco
            "password" => 'postgres', #senha do banco
            "driver" => "pgsql" #sempre vai ser o postgresql =)
        );
     }
?>