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
    die('Connection to MySQL failed: ' . mysql_connect_error());
}
// Get the number of plants tortured
if ($stmt = $connect->prepare('SELECT plants_tortured FROM User WHERE user_id = ?')) {
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    // Stores the result of the condition
    $stmt->store_result();
    $stmt->bind_result($plants_tortured);
    $stmt->fetch();
} else{
  die('Couldn\'t get the number of plants tortured.');  
}
$stmt->close();
$plants_tortured = intval($plants_tortured) + 1;

// Update the new number
if($stmt = $connect->prepare("UPDATE User SET plants_tortured = ? WHERE user_id = ? ")){
        $stmt->bind_param('ii', $plants_tortured, $_SESSION['user_id']);
        $stmt->execute();
} else{
    die('An error occured when updating the number of plants tortured.');
}
$stmt->close();
$connect->close();
?>