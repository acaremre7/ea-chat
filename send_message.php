<?php
include "connect_db.php";

$data = json_decode(file_get_contents('php://input'), true);
$sender = $data['sender'];
$receiver = $data['recipient'];
$message = $data['body'];
$query = "INSERT INTO messages (sender, recipient, message) VALUES ('$sender', '$receiver', '$message')";
if(!$db->exec($query) ){
    http_response_code(500);
}
