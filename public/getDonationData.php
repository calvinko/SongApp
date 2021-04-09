<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("sjdbinfo.php");
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

if ( isset($_POST['tranid'])) {
    $tranid = $_POST['tranid'];
} else if ( isset($_GET['tranid'])) {
    $tranid = $_GET['tranid'];
}

$result = $mysqli->query("SELECT * FROM ppbook where transaction_id='$tranid'");
if ($result) {
    $row = $result->fetch_assoc();
    if ($row != NULL) {
        $row['status'] = 1;
        $dstr = json_encode($row);
    } else {
        $row['status'] = -1;
        $dstr = json_encode($row);
    }
} else {
    $row['status'] = 0;
    $dstr = json_encode($row);
}
echo $dstr;