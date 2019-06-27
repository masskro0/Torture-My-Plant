<?php
// Start the session
session_start();

// Unset all of the session variables.
$_SESSION = array();

// Destroy all cookies 
if (isset($_COOKIE['rememberme'])){
    setcookie('rememberme', "", time() - 3600);
}

// Destroy the session
session_destroy();
header('Location: index.php');
?>