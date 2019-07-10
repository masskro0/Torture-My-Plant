<?php
/*
 * This script connects to the Python socket server as a client. This happens when a user clicks on a tool on the
 * torture screen. It gets the message that is sent by a xmlhttprequest and sends this message to the socket
 * server. It uses the localhost since the server runs on the same machine as the python tool script.
 * Port was randomly chosen because you can use any port in the range of 1024-49151
 */

// Check if the user is logged in, if not redirect him to the startpage
session_start();

if(!$_SESSION['loggedin']){
    header('Location: index.php');
    die();
}

// Port
$service_port = 9997;

// Localhost
$address = '127.0.0.1';

// Create a TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Connect to the socket server
$result = socket_connect($socket, $address, $service_port);

// Get the message
$str = $_REQUEST["q"];

// Send a message
$length = strlen($str);
socket_write($socket, $str, $length);

// Close the socket
socket_close($socket);
?>
