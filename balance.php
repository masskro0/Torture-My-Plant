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

?>