<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require "dbutil.php";
    
$userid = 10;
$mysqli = null;

//$astatus = Authenticate::validateAuthCookie();
//if ($astatus) {
//    $userid = Authenticate::getUserId();
//} 

if ( isset($_POST['bookid'])) {
    $songbookid = $_POST['bookid'];
} else if ( isset($_GET['bookid'])) {
    $songbookid = $_GET['bookid'];
}

$tag = '';

if (True) {
    if ($mysqli == null)  initmysqli();
    $newsongid = 0;
    if ($songbookid == '34') {
        // find the biggest songid, the new songid is that plus one
        $result = $mysqli->query("SELECT MAX(songid) FROM songlyrics WHERE songid >= 3400 and songid < 3600");
        if ($result) {
            
            $row = $result->fetch_row();
            if (isset($row[0])) {
                $newsongid = $row[0] + 1;
                
            } else {
                $newsongid = 3401;
            }
        }
    } elseif ($songbookid == '120') {
        $tag = "English";
        $result = $mysqli->query("SELECT MAX(songid) FROM songlyrics WHERE songid >= 12000 and songid < 13000");
        if ($result) {
            $row = $result->fetch_row();
            if (isset($row[0])) {
                $newsongid = $row[0] + 1;
                
            } else {
                $newsongid = 12001;
            }
        }
    } elseif ($songbookid == '40') {
        $result = $mysqli->query("SELECT MAX(songid) FROM songlyrics WHERE songid >= 4000 and songid < 5000");
        if ($result) {   
            $row = $result->fetch_row();
            if (isset($row[0])) {
                $newsongid = $row[0] + 1;
            } else {
                $newsongid = 4001;
            }
        }
    } else {
        $result = $mysqli->query("SELECT MAX(songid) FROM songlyrics WHERE songid >= 20000");
        if ($result) {   
            $row = $result->fetch_row();
            if (isset($row[0])) {
                $newsongid = $row[0] + 1;
            } else {
                $newsongid = 20001;
            }
        }
    }
    
    $result1 = $mysqli->query("SELECT MAX(songnum) FROM songbook WHERE bookid = $songbookid");
    if ($result1) {
        $row = $result1->fetch_row();
        if (isset($row[0])) {
            $songnum = $row[0] + 1;
        } else {
            $songnum = 1;
        }
    } else {
        $songnum = 1;
    }
    
    $newsongname = "New Song $newsongid";
    if (($result2 = $mysqli->query("INSERT into songlyrics (songid,owner,tag,songname) VALUES($newsongid,$userid,'$tag','$newsongname')")) != null) {
        $result3 = $mysqli->query("INSERT into songbooktbl (bookid,songnum,songid) VALUES($songbookid,$songnum,$newsongid)");
        if ($result3) {
            $ret['status'] = '1';
            $ret['error'] = '';
            $ret['songid'] = $newsongid;
            $ret['songnum'] = $songnum;
        } else {
            $ret['status'] = '0';
            $ret['error'] = $mysqli->error;
        }
    } else {
        $ret['status'] = '0';
        $ret['error'] = $mysqli->error;
    }
    
    echo json_encode($ret);
} else {
    $ret['status'] = '0';
    $ret['error'] = 'Permission Denial';
    echo json_encode($ret);
}


?>
