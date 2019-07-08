<?php
/*
 * This script is activated when a user clicks on the "Torture Me" button on the index.php page.
 * It connects to the database and writes the user id in the Game table so only one user can play at a time.
 * It also checks if there is already a user in the Game table and echos a message to activate the notify popup on 
 * the index page. After that he connects to the arduino via websocket (same as client.php with the torture tools) and
 * sends him the message of the plant
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

// Bool variable. 1 := open torture screen on index.php, 0 := open notify popup window on index.php because someone is playing
$is_ok = '0';

// Check if someone is playing. Prepare statement to prevent sql injection
if($stmt = $connect->prepare("SELECT * FROM Game")){
    
    // Execute the query above
    $stmt->execute();
    
    // Stores the result of the condition
    $stmt->store_result();
    
    // If noone is playing, insert user id in the Game table
    if ($stmt->num_rows == 0) {
        $stmt_user = $connect->prepare("INSERT INTO Game (user_id) VALUES(?)");
        $stmt_user->bind_param(i, $_SESSION['user_id']);
        $stmt_user->execute();
        $stmt_user->close();
        
        // Port
        $service_port = 23;
        
        // Ip adress of the arduino
        //$address = '10.90.1.170';
        $address = '127.0.0.1';
        
        // Create a TCP/IP socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        // Connect to the socket server
        $result = socket_connect($socket, $address, $service_port);
        
        // Get the sent message (Plant)
        $plant = $_REQUEST["q"];
        
        // Get the length of the message
        $length = strlen($plant);
        
        // Send message
        socket_write($socket, $plant, $length);
        
        // Close the socket
        socket_close($socket);
        $is_ok = '1';
    }
    
    // Close statement
    $stmt->close();
} else{
    die('Could not fetch the information from the database.');
}

// Echo the result as a responsetext back to the responsible xmlhttprequest
echo $is_ok;

// Close the connection to the database
$connect->close();
?>
