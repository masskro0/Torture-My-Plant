<?php
/*
 * This script updates the user's balance depending on how long he played and whether he bought the coin multiplier
 */

// Start the session
session_start();

// Connect to the database
include('db_connect.php');

// Get the message from the xmlhttprequest
$earned_coins = intval($_GET["q"]);

// Prepare the statement to prevent sql injection. Get the user's balance
if ($stmt = $connect->prepare('SELECT coins FROM User WHERE user_id = ?')) {
    
    // Replace the questionmark above with the user id (i := integer)
    $stmt->bind_param('i', $_SESSION['user_id']);
    
    // Execute the query above
    $stmt->execute();
    
    // Stores the result in the variable $balance
    $stmt->store_result();
    $stmt->bind_result($balance);
    $stmt->fetch();
} else{
  die('Couldn\'t get balance');  
}

// Close the statement
$stmt->close();

// Multiplier, initially 1
$multiplier = 1;

// Array to store all orders
$array_orders = [];

// Get all orders from a specific user
if($stmt = $connect->prepare('SELECT item_id FROM Orders WHERE user_id = ?')){
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    foreach($stmt->get_result() as $row) {
        $array_orders[] = $row['item_id'];
    }
} else{
    die('An error occured when we tried to connect to the database.');
}
$stmt->close();

// Check if the user bought the coin multiplier (id = 12 at the moment)
if(in_array(12, $array_orders)){
    $multiplier = 1.5;
}

// New balance, calculated from tortured seconds and user multiplayer
$new_balance = $balance + (($earned_coins) * $multiplier) * 20;
$stmt->close();

// Update coins of the user
if($stmt = $connect->prepare("UPDATE User SET coins = ? WHERE user_id = ? ")){
    $stmt->bind_param('ii', $new_balance, $_SESSION['user_id']);
    $stmt->execute();
} else{
    die('An error occured when updating your balance.');
}
$stmt->close();

// Close the connection to the database
$connect->close();
?>
