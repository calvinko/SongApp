<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require "dbutil.php";

if ( isset($_GET['bookid'])) {
    $songbookid = $_GET['bookid'];
}


initmysqli();

$result = $mysqli->query("SELECT * FROM songbooktext WHERE bookid=$bookid");
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
