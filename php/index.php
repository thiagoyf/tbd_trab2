<?php
    require_once 'model/Connection.php';
    require_once 'model/DBQuerier.php';

    $pdo = \database\Connection::getConnection();
    $querier = new \database\DBQuerier($pdo);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>PostgreSQL + PHP</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
  <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css"/>
</head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3 hierarchy-tree">
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                        <?php
                            foreach($querier->getAllSchemas() as $schema) {
                                echo "<li><ul>" . $schema['schema_name'];

                                foreach ($querier->getAllTablesFromSchema($schema['schema_name']) as $table) {
                                    echo "<li>" . $table['table_name'] . "</li>";
                                }

                                echo "</ul></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="span9 main">
                <div class="hero-unit">

                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-2.0.3.js"/>
    <script src="bootstrap/js/bootstrap.min.js"/>
</body>
</html>
