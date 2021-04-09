<?php

require_once("sjdbinfo.php");
$mysqli = null;

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function initmysqli() {
    global $mysqli;
    if ($mysqli == null) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $mysqli->query("SET NAMES 'utf8'");
    }
}

if ($mysqli == null)
    initmysqli();


//$filename = "./activity.csv";
$filename = $_FILES['inputfile']['tmp_name'];
//echo "file is $filename";


$content = file_get_contents($filename, true);
$lines = explode("\n", $content);
$num = 0;
foreach ($lines as $line) {
    $elms = explode(",", $line);
    $payoutDate = str_replace('"', '', $elms[0]);
    if (validateDate($payoutDate)) {
        
        $donationDate = str_replace('"', '', $elms[1]);
        $currency = str_replace('"', '', $elms[7]);
        $amount = $elms[8];
        $tranid = str_replace('"', '', $elms[11]);
        //echo "$donationDate : ($currency) $amount -- $tranid \n";
        $sql = "INSERT into ppbook VALUES('$tranid', '$currency', $amount, '$donationDate', '$payoutDate', 0, 'paypal')";
        $result = $mysqli->query($sql);
        echo "<p>Res = $result</p>\n";
    }
    
}