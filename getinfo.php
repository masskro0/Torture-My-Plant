<?php 
session_start();

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
$query = "SELECT username, email, plants_tortured, profile_picture, last_login FROM User WHERE user_id = " .$_SESSION['user_id'];
$result = $connect->query($query);
$row = $result->fetch_assoc();
$path = NULL;
if($row['profile_picture'] !== NULL){
    $path = substr($row['profile_picture'], 14);
}
$uname = $row['username'];
$email = $row['email'];
$last_login = $row['last_login'];
$connect->close();
?>