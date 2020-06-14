<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require "dbutil.php";

require_once("authutil.php");
    
    $userid = 0;
    
    $userprofile = array();
    $astatus = Authenticate::validateAuthCookie();
    if ($astatus) {
        $userid = Authenticate::getUserId();
       
    } 
    
function checkpermission($uid, $ownerid=-1, $groupid=100) {
    if ($uid == 1001) {
        return TRUE;
    } else if ($uid == $ownerid) {
        return TRUE;
    } else {
        return TRUE;
    }
}

if ( isset($_POST['bookid'])) {
    $bookid = $_POST['bookid'];
} else if ( isset($_GET['bookid'])) {
    $bookid = $_GET['bookid'];
}

if ( isset($_POST['songnum'])) {
    $songnum = $_POST['songnum'];
} else if ( isset($_GET['songnum'])) {
    $songnum = $_GET['songnum'];
}

if ( isset($_POST['songname'])) {
    $songname = $_POST['songname'];
} else if ( isset($_GET['songname'])) {
    $songname = $_GET['songname'];
}

if ( isset($_POST['songtext'])) {
    $songtext = $_POST['songtext'];
} else if ( isset($_GET['songtext'])) {
    $songtext = $_GET['songtext'];
}

if ($mysqli == null)
    initmysqli();

if (checkpermission($userid)) {
    $sql = "UPDATE songbooktext SET songname='$songname', songtext=" . '"' . $songtext . '"' . " WHERE bookid=$bookid and songnum=$songnum";
    $result = $mysqli->query($sql);

    if ($result) {
        //$ret = $result->fetch_assoc();
        $ret['status'] = '1';
        
    } else {
        $ret['status'] = '0';
        $ret['sql'] = $sql;
        $ret['errormsg'] = $mysqli->error;
    }
    echo json_encode($ret);
} else {
    $ret['status'] = '0';
    $ret['errormsg'] = 'Permission Denied';
    echo json_encode($ret);
}
?>
