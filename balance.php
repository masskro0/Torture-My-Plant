<?php
session_start();
if($_SESSION['loggedin']){
// Login info for the MySQL database
$host = 'localhost';
$user = 'user';
$pswd = 'password';
$db_name = 'website';
// Connect to the database
$connect = mysqli_connect($host, $user, $pswd, $db_name);
// Check if there is an error with the connection
if (mysqli_connect_errno()) {
    die('Connection to MySQL failed: ' .    mysql_connect_error());
}
$query = "SELECT coins FROM User WHERE user_id = " .$_SESSION['user_id'];
$result = $connect->query($query);
$row = $result->fetch_assoc();
$coins = $row['coins'];

$connect->close();
}

// Get the array with all headers
$array_headers = getallheaders();

// Check if a xmlhttprequest was made
if (array_key_exists('HTTP_X_REQUESTED_WITH', $array_headers) && in_array('xmlhttprequest', $array_headers)){
    // Get the new balance
    echo $coins;
}
?>