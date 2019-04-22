<?php
include "CustomSessionHandler.php";
if(!isset($_SESSION['name'])) {
    header("Location: /");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Select User</title>
    <link href='css/style.css' rel='stylesheet' type='text/css'/>
    <script src="js/main.js" type="text/javascript"></script>
</head>
<body onload="getUsers();setInterval(getUsers,10000)">
<h2 class="title-welcome">Online Users</h2>
<div id="users-container">
</div>
</body>
</html>