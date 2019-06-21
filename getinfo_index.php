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
// Get all orders from the user off the database
if($stmt = $connect->prepare("SELECT item_id FROM Orders WHERE user_id = ?")){
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $array_orders = [];
    // Stores the result of the condition
    foreach($stmt->get_result() as $row) {
        $array_orders[] = $row['item_id'];
    }
} else{
    die('An error occured when we tried to connect to the database.');
}
$stmt->close();
$connect->close();
?>