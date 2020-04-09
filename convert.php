<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("dbinfo.php");
$mysqli = null;

function initmysqli() {
    global $mysqli;
    if ($mysqli == null) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $mysqli->query("SET NAMES 'utf8'");
    }
}

if ($mysqli == null)
    initmysqli();

    $sql = "";
    $bresult = $mysqli->query("SELECT bookid FROM booktbl");

    while ($row = $bresult->fetch_assoc()) {
        echo $row['bookid'] . "\n";
    }

?>
