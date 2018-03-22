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

$booklist = array(
                array(id => 31, name => 'Oakland 詩歌 1'),
                array(id => 32, name => 'Oakland 詩歌 2'),
                array(id => 33, name => 'Oakland 詩歌 3'),
                array(id => 34, name=> 'Other 詩歌 4'),
                array(id => 120, name=> 'English Song 1'),
                array(id => 105, name=> 'Butterfly Hymns'),
                array(id => 11, name => '神家詩歌 1'),
                array(id => 12, name => '神家詩歌 2'),
                array(id => 13, name => '神家詩歌 3'),
                array(id => 14, name => '神家詩歌 4'),
                array(id => 15, name => '神家詩歌 5'),
                array(id => 16, name => '神家詩歌 6'),
                array(id => 17, name => '神家詩歌 7'),
                array(id => 18, name => '神家詩歌 8'),
                array(id => 19, name => '神家詩歌 9'),
                array(id => 20, name => '神家詩歌 10'),
                array(id => 21, name => '神家詩歌 11'),
                array(id => 22, name => '神家詩歌 12'),
                array(id => 23, name => '神家詩歌 13'),
                array(id => 25, name => '神家詩歌 14'),
                array(id => 24, name => '愛的迴響')
            );
              
$blist = getsongbooklist();
echo json_encode($blist);
//echo json_encode($booklist);
                                   
                                                              

?>
