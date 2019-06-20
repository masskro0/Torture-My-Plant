<?php
/*
 *This script gets every information from the Item table from the Website database. 
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
// Get all orders from the user off the database
if($stmt = $connect->prepare("SELECT item_id FROM Orders WHERE user_id = ?")){
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $array_orders = [];
    // Stores the result of the condition
    $stmt->store_result();
    $stmt->bind_result($array_orders[]);
    $stmt->fetch();
} else{
    die('An error occured when we tried to connect to the database.');
}
// Get all the information from the database
$stmt = $connect->prepare("SELECT * FROM Item");
$stmt->execute();
$array_id = [];
$array_name = [];
$array_price = [];
$array_description = [];
$array_picture = [];
// Store everything in separate arrays
foreach ($stmt->get_result() as $row) {
    $array_id[] = $row['item_id'];
    $array_name[] = $row['item_name'];
    $array_price[] = $row['item_price'];
    $array_description[] = $row['item_description'];
    $array_picture[] = $row['picture'];
}
$connect->close();
?>