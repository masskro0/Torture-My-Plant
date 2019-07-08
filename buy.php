<?php
/*
 * This script gets the precise item from shop.php and buys the right item for the user. It connects to the database,
 * checks the user's balance, gets the item price, calculates the difference between the users balance and the item
 * price and stores both the user_id, the item_id and timestamp in the Orders. After that is updates the user's balance
 */

// Start the session
session_start();

// Check if the user is logged in, if not redirect him to the startpage
if(!$_SESSION['loggedin']){
    header('Location: index.php');
    die();
}

// Connect to the database
include('db_connect.php');

// Get the message from the xmlhttprequest
$item_id = intval($_GET["q"]);

// Set the right timezone for Europe
date_default_timezone_set("Europe/Berlin");

// Get the current date and time
$time = '';
$time = $time .date("d.m.Y").'-'.date("H:i");

// Check the user's balance
include('balance.php');

// Get the price of the item
if ($stmt = $connect->prepare('SELECT item_price FROM Item WHERE item_id = ?')) {
    
    // Replace the questionmark with the item id
    $stmt->bind_param('i', $item_id);
    
    // Execute the statement above
    $stmt->execute();
    
    // Store the result of the query in the variable $price
    $stmt->store_result();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();
} else{
    $connect->close();
    die('Couldn\'t get item price');  
}

// Calculate the difference between the user's balance and the item price
$rest_balance = $coins - $price;

// "Buy the item"; insert the order in the Order table if the user has enough coins
if($rest_balance >= 0){
    if($stmt = $connect->prepare('INSERT INTO Orders (user_id, item_id, time) VALUES(?, ?, ?)')){
        $stmt->bind_param('iis', $_SESSION['user_id'], $item_id, $time);
        $stmt->execute();
        $stmt->close();
    } else {
        $connect->close();
        die('An error occured with the buying process.');
    }
    
    // Update the user's balance
    if($stmt = $connect->prepare("UPDATE User SET coins = ? WHERE user_id = ? ")){
        $stmt->bind_param('ii', $rest_balance, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
    } else{
        $connect->close();
        die('An error occured when updating your balance.');
    }
} else{
    $connect->close();
    die('Not enough coins to buy this item!');
}
$connect->close();
?>