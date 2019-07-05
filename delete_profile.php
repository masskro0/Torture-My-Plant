<?php
/*
 * After clicking on the delete button, this script handles the deletion of all files and the folder of a user and
 * deletes him of the database
 */

// Start the session
session_start();
$user_id = $_SESSION['user_id'];

// Unset all of the session variables.
$_SESSION = array();

// Destroy all cookies 
if (isset($_COOKIE['rememberme'])){
    setcookie('rememberme', "", time() - 3600);
}

// Destroy the session
session_destroy();

// Connect to the database
include('db_connect.php');

// Get the folder. Prepare statement to prevent sql injection
if ($stmt = $connect->prepare("SELECT profile_picture FROM User WHERE user_id = ?")){
    // i := integer, s := string
    $stmt->bind_param('s', $user_id);
    
    // Execute the query above
    $stmt->execute();
    // Store the result of the query in the variable $coins
    $stmt->store_result();
    $stmt->bind_result($full_path);
    $stmt->fetch();
    
    // Close statement
    $stmt->close();
} else{
    die('An error occured when trying to fetch folder destination.');
}

// Get only the foldername on the server with the user_id
$path = substr($full_path, 0, 20);
$path = $path .'/'. $user_id;
 
// Get a list of all of the file names in the folder.
$files = glob($path . '/*');

// Loop through the file list.
foreach($files as $file){
    
    // Make sure that this is a file and not a directory.
    if(is_file($file)){
        
        // Unlink function to delete the file.
        unlink($file);
    }
}

// Delete user folder
rmdir($path);

// Delete user from Orders and User table
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

// Close connection to the database
$connect->close();

// Redirect user to the index page
header('Location: index.php');
?>