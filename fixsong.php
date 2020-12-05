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

$result = $mysqli->query("SELECT songnum,pagenum,songname FROM songbooktext where bookid=21");
if ($result) {
    while ( ($row = $result->fetch_assoc()) != NULL) {
        $sname = str_replace("10", "11", $row["songname"]);
        $snum = $row['songnum'];
        $q1 = "UPDATE songbooktext set songname='$sname' where bookid=21 and songnum='$snum'";
        $mysqli->query($q1);
        echo "$q1";
    }
}    

