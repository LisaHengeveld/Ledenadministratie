<?php
// Vernietig sessie en al zijn data
session_start();
$_SESSION = array();
$_SERVER['PHP_AUTH_USER']="";
$_SERVER['PHP_AUTH_PW']="";
setcookie(session_name(), '', time() - 2592000, '/');
session_destroy();

// Stuur terug naar de inlogpagina
header('location:index.php');
?>