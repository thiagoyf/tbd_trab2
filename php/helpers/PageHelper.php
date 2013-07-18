<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daivid
 * Date: 17/07/13
 * Time: 17:49
 * To change this template use File | Settings | File Templates.
 */

class PageHelper {
    public static function printTableStrucutre($array) {
    echo
    '<table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Nulidade</th>
                <th>Valor Default</th>
                <th>É Chave Primária</th>
            </tr>
        </thead>
        <tbody>';
    foreach ($array as $row) {
        echo "<tr>";
        foreach ($row as $col) {
            echo "<td>$col</td>";
        }
        echo "</tr>";
    }
    echo '</tbody></table>';
    }

    /* Imprime uma tabela com o resultado de uma query */
    public static function printTable($table){
        if (!empty($table)) {
            echo "<table class='table table-striped table-hover table-bordered'>";
            echo "<thead><tr>";
            $titles = array_keys($table[0]);
            foreach($titles as $title) {
                echo "<th>$title</th>";
            }
            echo "</tr></thead>";

            echo "<tbody>";
            foreach($table as $line) {
                echo "<tr>";
                foreach($line as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
    }

    /* Imprime as tabelas com o resultado das queries */
    public static function printResultsQueriesTables($tables){
        if(empty($tables) == false){
            foreach($tables as $table) {
                self::printTable($table);
            }
        }
    }
}
