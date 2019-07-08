<?php
/*
 * This script gets the user balance from the database. A file to connect to the database is included.
 * $coins can be used to display the user's balance.
 * To get the new balance dynamically the new balance is only displayed, if it's a xmlhttprequest to
 * prevent that the balance is echoed on the site when it shouldn't.
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

// Prepare the statement to prevent SQL injection
if ($stmt = $connect->prepare('SELECT coins FROM User WHERE user_id = ?')) {

    // Replace the questionmark with the session user id
    $stmt->bind_param('i', $_SESSION['user_id']);

    // Execute the upper statement
    $stmt->execute();

    // Store the result of the query in the variable $coins
    $stmt->store_result();
    $stmt->bind_result($coins);
    $stmt->fetch();
} else{
    $connect->close();
    die('Couldn\'t get balance');  
}

// Get the array with all headers
$array_headers = getallheaders();

// Check if a xmlhttprequest was made
if (array_key_exists('HTTP_X_REQUESTED_WITH', $array_headers) && in_array('xmlhttprequest', $array_headers)){
    
    // Get the new balance dynamically
    echo $coins;
}
?>