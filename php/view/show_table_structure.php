<?php
    $arr = $querier->getStructureFromTableInSchema($_GET['table'], $_GET['schema']);
    PageHelper::printTableStrucutre($arr);


