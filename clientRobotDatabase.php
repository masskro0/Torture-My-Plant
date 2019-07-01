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

$current_user = 0;
// Get current_player off the database
if($stmt = $connect->prepare("SELECT user_id FROM Game WHERE user_id = ?")){
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    // Stores the result of the condition
    $stmt->store_result();
    $stmt->bind_result($current_user);
    $stmt->fetch();
    //foreach($stmt->get_result() as $row) {
    //	$current_user = $row['user_id'];
    //}
    //$array_orders = [];
    // Stores the result of the condition
    //foreach($stmt->get_result() as $row) {
    //    $array_orders[] = $row['item_id'];
    //}
} else{
    die('An error occured when we tried to connect to the database.');
}

$stmt->close();
$connect->close();

error_reporting(E_ALL);

// Port
$service_port = 23;

// Localhost
$address = '10.90.1.170';

// Create a TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Connect to the socket server
$result = socket_connect($socket, $address, $service_port);

// Get the message
$plant = $_GET["a"];
$userid = $_GET["b"];
$current_time = time();

if ($userid == $current_player || $current_player == 0){
	// Send a message
	$length = strlen($plant);
	socket_write($socket, $plant, $length);
} else {
    echo("Error: some other user is playing");
}

// Close the socket
socket_close($socket);
?>
