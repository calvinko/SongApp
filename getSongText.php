<?php

require "dbutil.php";

if ( isset($_GET['bookname'])) {
    $bookid = $_GET['bookid'];
}
if ( isset($_GET['bookname'])) {
    $songnum = $_GET['songnum'];
}

$songid = 0;
if ( isset($_POST['songid'])) {
    $songid = $_POST['songid'];
} else if ( isset($_GET['songid'])) {
    $songid = $_GET['songid'];
}

if ($mysqli == null)
    initmysqli();

$ret = array();
$ret['status'] = '0';

if ($songid == 0) {
    $result = $mysqli->query("SELECT * FROM songbooktext WHERE bookid=$bookid and songnum=$songnum");
    if ($result) {
        $ret = $result->fetch_assoc();
        $ret['status'] = '1';
    }
} else {
    $result = $mysqli->query("SELECT * FROM songlyrics WHERE songid=$songid");
    if ($result) {
        $ret = $result->fetch_assoc();
        $ret['status'] = '1';
    }
}
echo json_encode($ret);
 
?>
