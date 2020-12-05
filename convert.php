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

//if ($mysqli == null)
    //initmysqli();

    echo "<html>\n";
    $sql = "";
    $bresult = $mysqli->query("SELECT bookid FROM booktbl");

    $books = array();

    while ($row = $bresult->fetch_assoc()) {
        //echo $row['bookid'] . "\n";
        $books[] = $row['bookid'];
    }

    $i = 22;
    while ($i < 184) {
        $r = $mysqli->query("SELECT title from songbooktext where bookid = 20 and songnum = $i");
        $row = $r->fetch
    }
    foreach ($books as $bookid) {
        echo "<p>Process $bookid </p>";

        $result = $mysqli->query("SELECT * FROM songbooktbl join songlyrics on songbooktbl.songid = songlyrics.songid where songbooktbl.bookid = $bookid order by songbooktbl.songnum");

        $n = 1;
        while ($row = $result->fetch_assoc()) {
            $songnum = $row['songnum'];
            $songid = $row['songid'];
            $page = $row['page'];
            $author = $row['author'];
            $text = $row['songtext'];
            $songname = $row['songname'];
            //if (strpos($text, "'")) {
            //    echo "<p> $bookid : $songid - $songnum - $n has quote </p>";
            //}
            $songname = addslashes($songname);
            if (strpos($text, '"')) {
                echo "<p> $bookid : $songid - $songnum - $n has double quote </p>";
                $text = addslashes($text);
            }
            $r1 = $mysqli->query("INSERT INTO songbooktext-2 VALUES ($bookid, $n, $page, '$songname', '$author', '', " . '"' . $text . '"' . ", 1, '')");
            if ($mysqli->errno != 0) {

                echo "<p> return {$mysqli->error} </p>";
            }

            $n = $n + 1;
        }
    }

    echo "</html>\n";

?>

