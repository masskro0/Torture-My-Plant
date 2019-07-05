<?php
/*
 * This script connects to the phpmyadmin database. You need to close the connection by yourself at the end of your
 * script
 */

// Login info for the MySQL database
$host = 'localhost';
$user = 'user';
$pswd = 'password';
$db_name = 'website';

// Connect to the database
$connect = mysqli_connect($host, $user, $pswd, $db_name);

// Check if there is an error with the connection
if (mysqli_connect_errno()) {
    die('Connection to MySQL failed: ' .    mysql_connect_error());
}
?>