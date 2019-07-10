<?php
/*
 *This script gets every information from the Item table and all user's orders from the Orders table. 
 */

// Start the session
session_start();

// Connect to the database
include('db_connect.php');

// Prepare statement to prevent sql injection. Get all orders from the user of the database
if($stmt = $connect->prepare("SELECT item_id FROM Orders WHERE user_id = ?")){
    
    // Replace the questionmark with the user id (i := integer)
    $stmt->bind_param('i', $_SESSION['user_id']);
    
    // Execute the query above
    $stmt->execute();
    
    // Empty array to store the orders
    $array_orders = [];
    
    // Stores the result of the condition
    foreach($stmt->get_result() as $row) {
        $array_orders[] = $row['item_id'];
    }
} else{
    die('An error occured when we tried to connect to the database.');
}

// Close the statement
$stmt->close();

// Get all the information from the item table
if($stmt = $connect->prepare("SELECT * FROM Item")){
    $stmt->execute();
    
    // Arrays for each information (item id, name, price, description, picture path)
    $array_id = [];
    $array_name = [];
    $array_price = [];
    $array_description = [];
    $array_picture = [];
    
    // Store everything in separate arrays
    foreach ($stmt->get_result() as $row) {
        $array_id[] = $row['item_id'];
        $array_name[] = $row['item_name'];
        $array_price[] = $row['item_price'];
        $array_description[] = $row['item_description'];
        $array_picture[] = $row['picture'];
    }
}
$stmt->close();

// Close the connection
$connect->close();
?>