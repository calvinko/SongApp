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

$list = getsongbookindex($songbookid);
$ret['status'] = '1';
$ret['data'] = $list;
echo json_encode($ret);
?>
