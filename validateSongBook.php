<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "authutil.php";
require_once "dbutil.php";

$astatus = Authenticate::validateAuthCookie();
    if ($astatus) {
        $userid = Authenticate::getUserId();
        if ($userid != 1001) {
            header("Location: https://kosolution.net/BibleApp/login.php?dpage=songmgmt");
        }
    } else {
        header("Location: https://kosolution.net/BibleApp/login.php?dpage=songmgmt");
    }

if ( isset($_POST['bookid'])) {
    $songbookid = $_POST['bookid'];
} else if ( isset($_GET['bookid'])) {
    $songbookid = $_GET['bookid'];
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$result = $mysqli->query("SELECT * from songbooktbl WHERE bookid=$songbookid ORDER BY songnum ASC");

/*$wellformed = true;
if ($result) {
    $i = 1;
    while (($row = $result->fetch_assoc())) {
        // $rows[] = $row;
        $snum = intval($row['songnum']);
        if ($snum != $i) {
            $sid = $row["sid"];
            $wellformed = false;   
            $mysqli->query("UPDATE songbooktbl SET songnum=$i WHERE sid=$sid");
        }
        $i++;
    }
    
}*/




?>
