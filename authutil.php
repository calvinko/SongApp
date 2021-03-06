<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$cookiedomain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; 

define( 'COOKIE_DOMAIN', $cookiedomain ); 
define( 'COOKIE_PATH', '/' ); 
define( 'COOKIE_AUTH', 'auth_bibleapp' ); 

define( 'SECRET_KEY', 'dk;l1894!851éds-fghjg4lui:è3afàzgq_f4fá.' ); 


function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}

function generateblowfishsalt() {
        $salt = '$2x$14$' . rand_string(22);
        return $salt;     
}

function generatemd5salt() {
        $salt = "\$1\$" . rand_string(9);
        return $salt;
}
    
function checkpassword($password, $hashpw) {
        $r = crypt($password, $hashpw);
        return $r == $hashpw;
}
    
function changepassword($userid, $oldpassword, $hashpw, $newpassword) {
        if (checkpassword($oldpassword, $hashpw)) {
            
            return true;
        } else {
            return false;
        }
}

 // initial password setting
function setpassword($userid, $password) {
    $hashedpassword = crypt($password, generatemd5salt());
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = $mysqli->query("UPDATE usertbl SET passwd='$hashedpassword' WHERE userid = $userid");
    if ($result) {

        // $hashedpassword = crypt($password);
        return $hashedpassword;
    } else {
        return 0;
    }
        
}

class Authenticate { 

    public function __construct( $username, $password, $remember ) { 
     
        $this->authenticate( $username, $password, $remember ); 
         
    } 
     
    private function checkpassword($passwd, $hashpasswd) {
        $r = crypt($passwd, $hashpasswd);
        return $r == $hashpasswd;
    }
    
    public function authenticate( $email, $password, $remember ) {

        $sql = "SELECT `userid`, `passwd` FROM `usertbl` WHERE `username` = '$email'"; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = $mysqli->query($sql);
        
        if ($result) {
            $row = $result->fetch_row();
            if ($row) {
                $userid = $row[0];
                
                if (crypt($password, $row[1]) == $row[1]) {
                    $this->setCookie( $userid, $remember );
                    return 1;
                } else {
                    throw new AuthException( "Username and Password not Match.", 4 );
                    return 0;
                };
                                
            } else {
                throw new AuthException( "Username and password not match.", 5); 
            }
        }
        
        throw new Exception("Database Error", 3);
        return;

    } 
     
    private function setCookie( $id, $remember = false ) { 

        if ( $remember ) { 
            $expiration = time() + 1209600; // 14 dagen 
        } else { 
            $expiration = time() + 172800; // 48 uur 
        } 
        $cookie = $this->generateCookie( $id, $expiration ); 
        
        if ( !setcookie( COOKIE_AUTH, $cookie, $expiration, COOKIE_PATH, COOKIE_DOMAIN, false, true ) ) { 
            throw new AuthException( "Could not set cookie." ); 
        } 
    } 
     
    private function generateCookie( $id, $expiration ) { 

        $key = hash_hmac( 'md5', $id . $expiration, SECRET_KEY ); 
        $hash = hash_hmac( 'md5', $id . $expiration, $key ); 

        $cookie = $id . '|' . $expiration . '|' . $hash; 
        return $cookie; 
    } 

    public static function logOut( ) { 

        setcookie( COOKIE_AUTH, "", time() - 1209600, COOKIE_PATH, COOKIE_DOMAIN, false, true ); 

    } 

    public static function validateAuthCookie() { 

        if ( empty($_COOKIE[COOKIE_AUTH]) ) 
            return false; 

        list( $id, $expiration, $hmac ) = explode( '|', $_COOKIE[COOKIE_AUTH] ); 

        if ( $expiration < time() ) 
            return false; 

        $key = hash_hmac( 'md5', $id . $expiration, SECRET_KEY ); 
        $hash = hash_hmac( 'md5', $id . $expiration, $key ); 
        
        ///echo "Hash is ", $hash;
        //echo "-- hmac is ", $hmac;

        if ( $hmac != $hash ) 
            return false; 

        return true; 
    } 

    public static function getUserId() { 

        list( $id, $expiration, $hmac ) = explode( '|', $_COOKIE[COOKIE_AUTH] ); 

        return $id; 

    } 

} 

class AuthException extends Exception {} 



?>
