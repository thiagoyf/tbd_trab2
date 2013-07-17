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
                <div class="accordion" id="database">
                    <?php foreach ($querier->getAllSchemas() as $schema) { ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="database" href="#<?php echo $schema['schema_name']; ?>">
                                <?php echo $schema['schema_name']; ?>
                            </a>
                        </div>
                        <div id="<?php echo $schema['schema_name']; ?>" class="accordion-body collapse">
                            <div class="accordion-inner">
                                    asdasd
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
              </div>
        </div>

        <div class="span7 main">
            <div class="hero-unit">

            </div>
            <div class="row-fluid">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</body>
</html>