<?php
error_reporting(E_ALL);

// Port
$service_port = 9990;

// Localhost
$address = '192.168.0.11';

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
