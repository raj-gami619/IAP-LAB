<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
?>
<html>
    <head>
        <title>Internet programming private page</title>
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
    </head>
    <body>
        <p>This page is private</p>
        <p>We must protect it</p>
        <p><a href="logout.php">Logout</a></p>
    </body>
</html>