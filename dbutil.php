<?php
/* 
 * dbutil:  sql database utility functions
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
 
function getsongbookindex($bookid) {
    global $mysqli;
    if ($mysqli == null)
        initmysqli();
    $result = $mysqli->query("SELECT songnum,songname,page,songbooktbl.songid FROM songbooktbl join songlyrics on songbooktbl.songid=songlyrics.songid WHERE bookid=$bookid ORDER BY songnum,page");
    $rows = array();
    if ($result) {
        while ( ($row = $result->fetch_assoc()) != NULL) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function getsongbooklist() {
    global $mysqli;
    if ($mysqli == null)
        initmysqli();
    $result = $mysqli->query("SELECT bookid,name,attribute FROM booktbl");
    $rows = array();
    if ($result) {
        while ( ($row = $result->fetch_assoc()) != NULL) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function generateCookie( $id, $expiration ) {

	$key = hash_hmac( 'md5', $id . $expiration, SECRET_KEY );
	$hash = hash_hmac( 'md5', $id . $expiration, $key );
        //$hash = hash_hmac( 'md5', $id . $expiration, SECRET_KEY );

	$cookie = $id . '|' . $expiration . '|' . $hash;

	return $cookie;

}

function verifyCookie() {

	if ( empty($_COOKIE[COOKIE_AUTH]) )
		return false;

	list( $id, $expiration, $hmac ) = explode( '|', $_COOKIE[COOKIE_AUTH] );

	$expired = $expiration;

	if ( $expired < time() )
		return false;

	$key = hash_hmac( 'md5', $id . $expiration, SECRET_KEY );
	$hash = hash_hmac( 'md5', $id . $expiration, $key );

	if ( $hmac != $hash )
		return false;

	return true;

}

function getWebParam($pname, $defaultvalue) {
    global $_GET, $_POST;
    
    if ( isset($_POST[$pname])) {
        return $_POST[$pname];
    } else if (isset($_GET[$pname])) {
        return $_GET[$pname];
    } else 
        return $defaultvalue;
};

// return an array of assoc rows retrieved
function retrieveRows($dbtable, $cond="1") {
    $sql = "SELECT * FROM $dbtable WHERE $cond";
    $result = mysql_query($sql);
    $ret = array();
    if ($result) {
        while ($row = mysql_fetch_assoc($result)) {
            $ret[] = $row;
        }
        return $ret;
    } else {
        return $ret;
    }
}


?>