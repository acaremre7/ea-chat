<?php
include "CustomSessionHandler.php";
if(!isset($_SESSION['name'])) {
    header("Location: /");
}
$recipient = $_GET['recipient'];
if(!isset($recipient)){
    header("Location: /select_user.php");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Chat with <?php echo $recipient; ?></title>
    <link href='css/style.css' rel='stylesheet' type='text/css'/>
    <script src="js/main.js" type="text/javascript"></script>
</head>
<body onload="getMessages();setInterval(getMessages,5000)">
    <div id="message-container"></div>
    <div class="textarea-container">
            <input type="hidden" id="sender" value="<?php echo $_SESSION['name']; ?>"/>
            <input type="hidden" id="recipient" value="<?php echo $recipient; ?>"/>
            <textarea id="message-area" name="message" onkeydown="if(event.keyCode === 13){sendMessage();return false;}"></textarea>
            <button id="btn-send" onclick="sendMessage();">Send</button>
    </div>
</body>
</html>
