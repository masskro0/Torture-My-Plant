<?php
/*
 * Every time the torture screen is closed, this script is executed. It simply increases the number of plants tortured
 * by 1.
 */

// Start the session
session_start();

// Connect to the database
include('db_connect.php');

// Get the number of plants tortured. Prepare the statement to prevent sql injection
if ($stmt = $connect->prepare('SELECT plants_tortured FROM User WHERE user_id = ?')) {
    
    // Replace the questionmark with the user id (i := integer)
    $stmt->bind_param('i', $_SESSION['user_id']);
    
    // Execute the query above
    $stmt->execute();
    
    // Stores the result in the variable $plants_tortured
    $stmt->store_result();
    $stmt->bind_result($plants_tortured);
    $stmt->fetch();
    
    // Close the statement
    $stmt->close();
} else{
  die('Couldn\'t get the number of plants tortured.');  
}

// Increment the amount of plants tortured. To be sure convert the variable to an integer
$plants_tortured = intval($plants_tortured) + 1;

// Update the new number
if($stmt = $connect->prepare("UPDATE User SET plants_tortured = ? WHERE user_id = ? ")){
        $stmt->bind_param('ii', $plants_tortured, $_SESSION['user_id']);
        $stmt->execute();
} else{
    die('An error occured when updating the number of plants tortured.');
}
$stmt->close();

// Close the connection to the database
$connect->close();
?>