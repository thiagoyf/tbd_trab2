<?php
    require_once 'helpers/PageHelper.php';
    require_once 'model/Connection.php';
    require_once 'model/DBQuerier.php';

    $pdo = \database\Connection::getConnection();
    $querier = new \database\DBQuerier($pdo);

    if (isset($_GET['act'])) {
        switch ($_GET['act']) {
            case 've':
                $page = 'show_table_structure';
                break;
            case 'vd':
                $page = 'show_table_data';
                break;
            default:
                $page = null;
        }
    }
    if (isset($_POST['sql'])) {
        $page = "show_query_result";
    }
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
            <div class="row-fluid page-header">
                <div class="well">
                    <p>
                        <?php
							$database_info = $querier->getDatabaseInfo();
							
                            echo "<b>Banco:</b> " . $database_info['db'] . "<br>";
                            echo "<b>Endereço:</b> " . $database_info['server'] . "<br>";
                            echo "<b>Porta:</b> " . $database_info['port'] . "<br>";
                            echo "<b>Versão:</b> " . $database_info['version'] . "<br>";
							echo "<b>Codificação:</b> " . $database_info['client_encoding'] . "<br>";
							echo "<b>Tamanho:</b> " . $database_info['size'] . "<br>";
                        ?>
                    </p>
                </div>
            </div>
            <div class="well sidebar-nav page-header">
                <h1 class="">Schemas</h1>
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
                                    <?php
                                        echo "<a class='btn btn-small' href='index.php?act=vd&schema=" . $schema['schema_name'] . "&table=" . $table['table_name'] . "'>Visualizar Dados</a>";
                                        echo "<a class='btn btn-small' href='index.php?act=ve&schema=" . $schema['schema_name'] . "&table=" . $table['table_name'] . "'>Visualizar Estrutura</a>";
                                    ?>
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
            <div class="row-fluid page-header">
                <div class="well">
				<h3>SQL</h3>
				<form method="post" action="index.php">
					<textarea name="sql" rows="5" class="span12"></textarea>
					    <input type="submit" class="btn btn-primary btn-large btn-block" value="Executar"/>
                </form>
                </div>
            </div>

                <?php
                    if (isset($page)) {
                        echo '<div class="row-fluid"><div class="well">';
                            include_once('view/' . $page . ".php");
                        echo '</div></div>';
                    }
                ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</body>
</html>