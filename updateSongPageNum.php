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

if ( isset($_POST['bookname'])) {
    $songbook = $_POST['bookname'];
} else if ( isset($_GET['bookname'])) {
    $songbook = $_GET['bookname'];
}

if ( isset($_POST['sid'])) {
    $songid = $_POST['sid'];
} else if ( isset($_GET['sid'])) {
    $songid = $_GET['sid'];
}

if ( isset($_POST['songname'])) {
    $songname = $_POST['songname'];
} else if ( isset($_GET['songname'])) {
    $songname = $_GET['songname'];
}

if ( isset($_POST['songnum'])) {
    $songname = $_POST['songnum'];
} else if ( isset($_GET['songnum'])) {
    $songname = $_GET['songnum'];
}

if ( isset($_POST['songtext'])) {
    $songtext = $_POST['songtext'];
} else if ( isset($_GET['songtext'])) {
    $songtext = $_GET['songtext'];
}

if ( isset($_POST['pagenum'])) {
    $pagenum = $_POST['pagenum'];
} else if ( isset($_GET['pagenum'])) {
    $pagenum = $_GET['pagenum'];
}

if ($mysqli == null)
        initmysqli();

if (checkpermission($userid)) {
    $sql = "UPDATE songbooktbl SET songnum=$songnum WHERE sid=$sid";
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
    $ret['error'] = 'Permission Denial';
    echo json_encode($ret);
}
?>
