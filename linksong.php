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

function linkSongBook($bid) {
    global $mysqli;
    $result = $mysqli->query("SELECT songnum,pagenum,songname,rsong FROM songbooktext where bookid=$bid");
    if ($result) {
        while ( ($row = $result->fetch_assoc()) != NULL) {
            if ($row['rsong'] != "") {
                $r = explode(":", $row['rsong']);
                if (count($r) == 2) {
                    $snum = $row['songnum']; 
                    echo "<p>" . $row['songname'] . "---" . $r[0] . "::" . "$r[1]" . "</p> \n";
                    $rbid = $r[0];
                    $rnum = $r[1];
                    $q1 = "UPDATE songbooktext set rsong='$bid:$snum' where bookid=$rbid and songnum=$rnum";
                    echo "<p> $q1 </p>"; 
                    //$r1 = $mysqli->query($q1);
                    //echo "<p> $r1 </p>";
                } 
                
            }
            
        }
    }
}

echo "<html>";
linkSongBook(202);
echo "</html>";