<?php
/*
 *This script gets every information from the Item table and all user's orders from the Orders table. 
 */

// Start the session
session_start();

// Get all orders from a user
include('getinfo_index.php');

// Connect to the database
include('db_connect.php');

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