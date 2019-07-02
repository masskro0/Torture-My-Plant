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
$is_ok = '0';

// Get current_player off the database
if($stmt = $connect->prepare("SELECT * FROM Game")){
    //$stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    // Stores the result of the condition
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        $stmt_user = $connect->prepare("INSERT INTO Game (user_id) VALUES(?)");
        $stmt_user->bind_param(i, $_SESSION['user_id']);
        $stmt_user->execute();
        $stmt_user->close();
        
        // Port
        $service_port = 23;
        // Localhost
        $address = '10.90.1.170';
        //$address = '127.0.0.1';
        // Create a TCP/IP socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        // Connect to the socket server
        $result = socket_connect($socket, $address, $service_port);
        $plant = $_REQUEST["q"];
        $length = strlen($plant);
        socket_write($socket, $plant, $length);
        
        // Close the socket
        socket_close($socket);
        
        $is_ok = '1';
        
    }
    
    

    
} else{
    echo 'Someone is already playing';
}

echo $is_ok;

$stmt->close();
$connect->close();

error_reporting(E_ALL);





?>
