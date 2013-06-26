<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require "dbutil.php";

if ( isset($_POST['bookname'])) {
    $songbook = $_POST['bookname'];
} else if ( isset($_GET['bookname'])) {
    $songbook = $_GET['bookname'];
}

if ( isset($_POST['bookid'])) {
    $songbookid = $_POST['bookid'];
} else if ( isset($_GET['bookid'])) {
    $songbookid = $_GET['bookid'];
}


initmysqli();

$result = $mysqli->query("SELECT songnum,page,songname,songbook.songid,songtext FROM songbook join songlyrics on songbook.songid=songlyrics.songid WHERE bookid=$songbookid");
$rows = array();
if ($result) {
        while ( ($row = $result->fetch_assoc()) != NULL) {
            $rows[] = $row;
        }
}
$ret['status'] = '1';
$ret['error'] = "";
$ret['data'] = $rows;
echo json_encode($ret);    

?>
