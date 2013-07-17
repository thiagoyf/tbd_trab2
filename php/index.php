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
        <div class="span4 hierarchy-tree">
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
                                    <?php foreach($querier->getAllTablesFromSchema($schema['schema_name']) as $table) {?>
                                <ul class="nav nav-list">

                                <li class="nav-header"><?php echo $table['table_name'];?></a></li>

                                    <a class="btn btn-small" href="#?">Visualizar Dados</a>
                                    <a class="btn btn-small" href="#?">Visualizar Estrutura</a>
                                </ul>
                                        <hr>
                                    <?php }?>

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
              </div>
        </div>

        <div class="span8 main">
            <div class="hero-unit">
				<form method="post" action="index.php">
					<textarea rows="10" class="span12"></textarea>
					<input type="submit" class="btn btn-primary" value="Executar"/>
				</form>
            </div>
            <div class="row-fluid">
				<table class="table table-striped">
					<?php
						echo "<tr>";
							echo "<th>";
							echo "title1";
							echo "</th>";
							echo "<th>";
							echo "title2";
							echo "</th>";
							echo "<th>";
							echo "title3";
							echo "</th>";
							echo "<th>";
							echo "title4";
							echo "</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<th>";
							echo "1,1";
							echo "</th>";
							echo "<th>";
							echo "1,2";
							echo "</th>";
							echo "<th>";
							echo "1,3";
							echo "</th>";
							echo "<th>";
							echo "1,4";
							echo "</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<th>";
							echo "2,1";
							echo "</th>";
							echo "<th>";
							echo "2,2";
							echo "</th>";
							echo "<th>";
							echo "2,3";
							echo "</th>";
							echo "<th>";
							echo "2,4";
							echo "</th>";
						echo "</tr>";
					?>
				</table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</body>
</html>