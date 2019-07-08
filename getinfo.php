<?php 
/*
 * This script stores the username, e-mail-adress, amount of plants tortured, profile picture path and timestamp of the
 * last login of a specific user_id in variables. You can echo the variables in the html document to display the info
 */

// Start the session
session_start();

// Connect to the database
include('db_connect.php');

// Get all the information from a specific user_id in the database. Prepare the statement to prevent sql injection
if ($stmt = $connect->prepare('SELECT username, email, plants_tortured, profile_picture, last_login FROM User WHERE user_id = ?')) {
    
    // Replace the questionmark with the user id
    $stmt->bind_param('i', $_SESSION['user_id']);

    // Execute the statement above
    $stmt->execute();
    
    // Store the result of the query in the array $row
    $stmt->store_result();
    $stmt->bind_result($row['username'], $row['email'], $row['plants_tortured'], $row['profile_picture'], $row['last_login']);
    $stmt->data_seek(0);
    $stmt->fetch();
    
    // Close the statement
    $stmt->close();
}

// Initialize the path with NULL
$path = NULL;

// If the user has a profile picture, link it to it
if($row['profile_picture'] !== NULL){
    $path = substr($row['profile_picture'], 14);
}

// Variables to display information on the html documents
$uname = $row['username'];
$email = $row['email'];
$last_login = $row['last_login'];

// Close the connection
$connect->close();
?>