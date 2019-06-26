<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
 * After clicking on the delete button, this script handles the deletion of all files and the folder of a user and deletes him of the database
 */

// Start the session
session_start();
$user_id = $_SESSION['user_id'];
// Unset all of the session variables.
$_SESSION = array();

// Destroy all cookies 
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

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


// Get the folder
$query = "SELECT profile_picture FROM User WHERE user_id = " .$user_id;
$result = $connect->query($query);
$row = $result->fetch_assoc();
$path = substr($row['profile_picture'], 0, 20);
$path = $path .'/'. $user_id;
 
// Get a list of all of the file names in the folder.
$files = glob($path . '/*');
// Loop through the file list.
foreach($files as $file){
    // Make sure that this is a file and not a directory.
    if(is_file($file)){
        // Use the unlink function to delete the file.
        unlink($file);
    }
}
// Delete the folder
rmdir($path);
// Delete the row
if ($stmt = $connect->prepare('DELETE FROM Orders WHERE user_id = ?')) {
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
}
$stmt->close();
if ($stmt = $connect->prepare('DELETE FROM User WHERE user_id = ?')) {
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
}
$stmt->close();
$connect->close();
header('Location: index.php');
?>