<?php

require "dbutil.php";

if ( isset($_GET['bookname'])) {
    $bookid = $_GET['bookid'];
}
if ( isset($_GET['bookname'])) {
    $songnum = $_GET['songnum'];
}

if ($mysqli == null)
    initmysqli();

$ret = array();
$ret['status'] = '0';

$result = $mysqli->query("SELECT * FROM songbooktext WHERE bookid=$bookid and songnum=$songnum");
if ($result) {
    $ret['data'] = $result->fetch_assoc();
    $ret['status'] = '1';
}

echo json_encode($ret);