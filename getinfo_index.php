<?php
/*
 * This script is just for the index.php page. It stores all orders of a user in a variable to check if the user bought
 * something or not
 */

// Start the session
session_start();

// Connect to the database
include('db_connect.php');

// Get all orders from the user off the database. Prepare the statement to prevent sql injection
if($stmt = $connect->prepare("SELECT item_id FROM Orders WHERE user_id = ?")){
    
    // Replace the questionmark with the user id (i := integer)
    $stmt->bind_param('i', $_SESSION['user_id']);
    
    // Execute the string above
    $stmt->execute();
    
    // Array which contains all orders
    $array_orders = [];
    
    // Stores the result of the condition
    foreach($stmt->get_result() as $row) {
        $array_orders[] = $row['item_id'];
    }
} else{
    die('An error occured when we tried to connect to the database.');
}

// Close the statement and the connection
$stmt->close();
$connect->close();
?>