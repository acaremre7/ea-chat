<?php
include "connect_db.php";

$p1 = $_GET['p1'];
$p2 = $_GET['p2'];
$query = "SELECT sender, recipient, message FROM messages WHERE (sender = '$p1' AND recipient = '$p2') OR 
                                                                (sender = '$p2' AND recipient = '$p1')
                                                                ORDER BY timestamp ASC";

$result = $db->query($query);
$resultArray = array();

while($record = $result->fetchArray(SQLITE3_ASSOC)) {
    array_push($resultArray,$record);
}

echo json_encode($resultArray);

