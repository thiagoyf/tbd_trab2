<?php
	$table = $_GET['table'];
	$schema = $_GET['schema'];

    $arr = $querier->getStructureFromTableInSchema($table, $schema);
    PageHelper::printTableStrucutre($table, $arr);


