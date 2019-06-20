<?php
/*
 * This script gets the message from shop.php and buys the right item for the user. It connects to the database, gets
 * the right user_id, checks the user's balance and stores the result in the Order table, where both the user_id and
 * the item_id as well as the timestamp is stored
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
$item_id = intval($_GET["q"]);
// Set the right timezone for Europe
date_default_timezone_set("Europe/Berlin");
// Get the current date and time
$time = '';
$time = $time .date("d.m.Y").'-'.date("H:i");

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
// Get the price of the item
if ($stmt = $connect->prepare('SELECT item_price FROM Item WHERE item_id = ?')) {
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    // Stores the result of the condition
    $stmt->store_result();
    $stmt->bind_result($price);
    $stmt->fetch();
} else{
  die('Couldn\'t get item price');  
}
$stmt->close();
// Variable that stores the difference between balance and price
$rest_balance = $balance - $price;

// "Buy the item"; insert the order in the Order table if the user has enough coins
if($rest_balance >= 0){
    if($stmt = $connect->prepare('INSERT INTO Orders (user_id, item_id, time) VALUES(?, ?, ?)')){
        $stmt->bind_param('iis', $_SESSION['user_id'], $item_id, $time);
        $stmt->execute();
    } else {
        die('An error occured with the buying process.');
    }
    $stmt->close();
    if($stmt = $connect->prepare("UPDATE User SET coins = ? WHERE user_id = ? ")){
        $stmt->bind_param('ii', $rest_balance, $_SESSION['user_id']);
        $stmt->execute();
    } else{
        die('An error occured when updating your balance.');
    }
    $stmt->close();
} else{
    die('Not enough coins to buy this item!');
}
$connect->close();
?>