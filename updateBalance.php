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
// Get the message from the xmlhttprequest
$earned_coins = intval($_GET["q"]);

// Check the user's balance
if ($stmt = $connect->prepare('SELECT coins FROM User WHERE user_id = ?')) {
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    // Stores the result of the condition
    $stmt->store_result();
    $stmt->bind_result($balance);
    $stmt->fetch();
} else{
  die('Couldn\'t get balance');  
}
$stmt->close();

//need to fetch multiplier
$multiplier = 1;
// new balance, calculated from tortured seconds and user multiplayer
$new_balance = $balance + (($earned_coins)*$multiplier)*10;

// Update coins of the user
$stmt->close();
if($stmt = $connect->prepare("UPDATE User SET coins = ? WHERE user_id = ? ")){
    $stmt->bind_param('ii', $new_balance, $_SESSION['user_id']);
    $stmt->execute();
} else{
    die('An error occured when updating your balance.');
}
$stmt->close();

$connect->close();
?>
