<?php
/*
 * This script add the users earned coins to the balance
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Login info for the MySQL database
$host = 'localhost';
$user = 'user';
$pswd = 'password';
$db_name = 'website';
// Connect to the database
$connect = mysqli_connect($host, $user, $pswd, $db_name);
// Check if there is an error with the connection
if (mysqli_connect_errno()) {
    die('Connection to MySQL failed: ' . mysql_connect_error());
}

// Update the current user
if ($stmt = $connect->prepare('DELETE FROM Game WHERE user_id = ?')) {
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
} else {
    die('An error occured when updating your balance.');
}
$stmt->close();

$connect->close();
?>
