require_once("../dbinfo.php");
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
    $result = $mysqli->query("SELECT songnum,songname,page FROM songbooktext WHERE bookid=$bookid ORDER BY songnum");
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
