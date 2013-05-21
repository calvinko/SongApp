<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * require "dbutil.php";
 *  */

require "dbutil.php";

if ( isset($_POST['bookname'])) {
    $songbook = $_POST['bookname'];
} else if ( isset($_GET['bookname'])) {
    $songbook = $_GET['bookname'];
}

if ( isset($_POST['songid'])) {
    $songid = $_POST['songid'];
} else if ( isset($_GET['songid'])) {
    $songid = $_GET['songid'];
}

if ($mysqli == null)
        initmysqli();
$result = $mysqli->query("SELECT * FROM songlyrics WHERE songid=$songid");
    
if ($result) {
    $ret = $result->fetch_assoc();
    $ret['status'] = '1';
    echo json_encode($ret);
} else {
    $ret['status'] = '0';
}
 
?>
