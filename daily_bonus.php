<?php
session_start();
include('getinfo_index.php');
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
if($stmt = $connect->prepare("SELECT coins FROM User WHERE user_id = ? ")){
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($coins);
    $stmt->fetch();
    $stmt->close();
} else{
    die('An error occured when we tried to get your balance.');
}
if (in_array(12, $array_orders)){
    $coins = $coins + 750;
} else {
    $coins = $coins + 500;
}
date_default_timezone_set("Europe/Berlin");
$current_date = date('Y-m-d');
// Update the user's balance when he claims his daily bonus by 500 coins; also update the current date
if($stmt = $connect->prepare("UPDATE User SET coins = ? , last_login = ? WHERE user_id = ? ")){
        $stmt->bind_param('isi', $coins, $current_date, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
} else{
    die('An error occured when updating your balance.');
}

$connect->close();
?>