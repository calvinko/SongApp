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

function getbookabbv($bid) {
    if ($bid == 10) {
        return "EL";
    } elseif ($bid == 211) {
        return "SOL1";
    } elseif ($bid == 212) {
        return "SOL2";
    } else if ($bid == 201) {
        return "GFH1";
    } else if ($bid == 202) {
        return "GFH2";
    } else {
        $i = $bid - 10;
        return "H$i";
    }
}

function genmapping($bid) {
    global $mysqli;
    $result = $mysqli->query("SELECT songnum,pagenum,rsong FROM songbooktext where bookid=$bid");
    $map1 = array();
    if ($result) {
        while ( ($row = $result->fetch_assoc()) != NULL) {
            $rsong = $row['rsong'];
            if ($rsong != "") {
                $r = explode(":", $rsong);
                if (count($r) == 2) {
                    $pnum = $row['pagenum'];
                    $lbid = $r[0];
                    $lsnum = $r[1];
                    $res1 = $mysqli->query("SELECT songnum,pagenum FROM songbooktext where bookid=$lbid and songnum=$lsnum");
                    if ($res1) {
                        if (($nrow = $res1->fetch_assoc()) != NULL) {
                            $pn = $nrow['pagenum'];
                            $element['englishKey'] = getbookabbv($bid) . "_$pnum";
                            $element['chineseKey'] = getbookabbv($lbid) . "_$pn";  
                            $map1[] = $element; 
                        };

                    }
                } 
            }
        }
    }
    return $map1;
}    

echo "<html><pre>";
$m = genmapping(202);
$m1 = genmapping(212);

echo json_encode(array_merge($m, $m1));
echo "</html></pre>";