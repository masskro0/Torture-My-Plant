<?php
/*
 * This script is activated when the user claims his daily reward. It connects to the database, gets the user's balance,
 * increases his balance and updates both the balance as well as the date when the reward was claimed
 */

// Start the session
session_start();

// Check if the user is logged in, if not redirect him to the startpage
if(!$_SESSION['loggedin']){
    header('Location: index.php');
    die();
}

// Get the bought items of the user to know if the bought the multiplicator
include('getinfo_index.php');

// Get the user's balance
include('balance.php');

// Connect to the database
include('db_connect.php');

// Increase user's balance. Check if the user bought the 50% More Coins upgrade
if (in_array(12, $array_orders)){
    $coins = $coins + 1500;
} else {
    $coins = $coins + 1000;
}
// Set the timezone to Berlin
date_default_timezone_set("Europe/Berlin");

// Get the current date in year-month-day
$current_date = date('Y-m-d');
echo $current_date;
// Update the user's balance when he claims his daily bonus. Also update the current date. Prepare statement to prevent sql injection
if($stmt = $connect->prepare("UPDATE User SET coins = ? , last_login = ? WHERE user_id = ? ")){
    // i := integer, s := string
    $stmt->bind_param('isi', $coins, $current_date, $_SESSION['user_id']);
    
    // Execute the query above
    $stmt->execute();
    $stmt->close();
} else{
    die('An error occured when updating your balance.');
}

$connect->close();
?>