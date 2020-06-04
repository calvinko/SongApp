<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

require "dbutil.php";

if ( isset($_POST['church'])) {
    $church = $_POST['church'];
} else if ( isset($_GET['church'])) {
    $church = $_GET['church'];
}
              
$blist = getsongbooklist();
echo json_encode($blist);
//echo json_encode($booklist);
                                   
                                                              

?>
