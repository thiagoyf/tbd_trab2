<?php
    $arr = $querier->getAllDataFromTableInSchema($_GET['table'], $_GET['schema']);
    PageHelper::printTable($arr);

