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

if ( isset($_POST['songid'])) {
    $songid = $_POST['songid'];
} else if ( isset($_GET['songid'])) {
    $songid = $_GET['songid'];
}

if ( isset($_POST['rsid'])) {
    $rsid = $_POST['rsid'];
} else if ( isset($_GET['rsid'])) {
    $rsid = $_GET['rsid'];
}
if ( isset($_POST['pagenum'])) {
    $pagenum = $_POST['pagenum'];
} else if ( isset($_GET['pagenum'])) {
    $pagenum = $_GET['pagenum'];
}

if ($mysqli == null)
        initmysqli();

if (checkpermission($userid)) {
    $sql = "UPDATE songlyrics SET relsongid=$rsid WHERE songid=$songid";
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
