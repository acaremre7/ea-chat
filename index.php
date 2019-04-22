<?php
include "CustomSessionHandler.php";
if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['Enter'])){
    $name = $_POST['tb-name'];
    if(empty($name)){
        echo "<center><span style='color:red'>Please enter a valid username.</span></center>";
    }else{
        $_SESSION['name'] = $name;
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title>Messaging Application</title>
        <link href='css/style.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
    <?php
        if(isset($_SESSION['name'])) {
            header("Location: /select_user.php");
        }else {
            ?>
                <h1 class="title-welcome">Welcome to the chat application.</h1>
                <h2 class="title-welcome">Please enter your name to start.</h2>

                <div class="name-container">
                    <form action="index.php" method="post">
                        <input id="tb-name" name="tb-name" type="text"/>
                        <input id="bt-name" type="submit" name="Enter" value="Enter"/>
                    </form>
                </div>
            <?php
        }
    ?>

    </body>
</html>
