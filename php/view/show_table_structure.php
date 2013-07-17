<?php
    var_dump($_GET);

    $arr = $querier->getStructureFromTableInSchema($_GET['table'], $_GET['schema']);
    PageHelper::Tabulator($arr);
