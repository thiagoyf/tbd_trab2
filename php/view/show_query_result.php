<?php
	$sql = $_POST['sql'];

    PageHelper::printResultsQueriesTables($querier->getConsultString($sql));