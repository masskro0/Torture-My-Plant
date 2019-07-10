<?php
/*
 * This script is executed, when a user closes the torture screen. The user will be deleted from the Game table.
 */

// Start the session
session_start();

// Connect to the database
include('db_connect.php');

// Prepare statement to prevent sql injection. Deletes the user with the specific id.
if ($stmt = $connect->prepare('DELETE FROM Game WHERE user_id = ?')) {
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
} else {
    die('An error occured when trying to update your balance.');
}

// Close statement
$stmt->close();

// Close the connection
$connect->close();
?>
