<?php
session_start();
//Get rid of session variables
$_SESSION = array();
//destroy session
session_destroy();
// go to login page
header("location: login.php");
exit;
?>