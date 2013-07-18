<?php
	$table = $_GET['table'];
	$schema = $_GET['schema'];

    $arr = $querier->getAllDataFromTableInSchema($table, $schema);
    PageHelper::printTableData($table, $arr);

