<?php
session_start();

$_SESSION = array();


session_destroy();

header("Location: login.php");
exit(); //This ensures that no further PHP code is executed after the header function, preventing any unexpected behavior.
?>