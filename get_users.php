<?php
include "connect_db.php";
include "CustomSessionHandler.php";

$query = "SELECT data FROM sessions";

$result = $db->query($query);
$resultArray = array();
while($record = $result->fetchArray(SQLITE3_ASSOC)["data"]) {
    $pattern = '#([^\|]+)\|([a-z]+:\d+:)"(.*?)"#s';
    preg_match_all($pattern, $record, $match);
    $name="";
    foreach ($match[1] as $index=>$name){
        $value = $match[3][$index];
        $$name = $value;
    }
    if($_SESSION['name'] != $name) {
        array_push($resultArray, $name);
    }
}
echo json_encode($resultArray);