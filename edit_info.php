<?php 
/*
 * This script validates und sanitizes user input, connects to the database, displays the current user information and applies user changes to the database.
 */

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start session
session_start();
// Array with errors
$errors = array();
// Check if the user is logged in, if not redirect him to the startpage
if(!$_SESSION['loggedin']){
    header('Location: index.php');
}

// Function to sanitize "bad code" like HTML or Javascript code.
function test_input($data) { 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
}

// Login info for the MySQL database
$host = 'localhost';
$user = 'user';
$pswd = 'password';
$db_name = 'website';
// Connect to the database
$connect = mysqli_connect($host, $user, $pswd, $db_name);
// Check if there is an error with the connection
if (mysqli_connect_errno()) {
    echo mysql_connect_error();
    die('Connection to MySQL failed: ' . mysql_connect_error());
}
/* Check if the fields are empty */
// Check whether the username field is empty or not
if(empty($_POST['username']) || !isset($_POST['username'])){
    array_push($errors, "Username is required");
    echo 'Username is required';
    die();
}
// Check whether the e-mail field is empty or not
if(empty($_POST['email']) || !isset($_POST['email'])){
    array_push($errors, "E-mail adress is required");
    echo 'E-mail adress is required';
    die();
}
// Check whether the old password field is empty or not
if(empty($_POST['password_old']) || !isset($_POST['password_old'])){
    array_push($errors, "Please enter your old password");
    echo 'Please enter your old password';
    die();
}
// Check whether the new password field is empty or not
if(empty($_POST['password_new1']) || !isset($_POST['password_new1'])){
    array_push($errors, "Please enter a new password");
    echo 'Please enter a new password';
    die();
}
// Check whether the new password field is empty or not
if(empty($_POST['password_new2']) || !isset($_POST['password_new2'])){
    array_push($errors, "Please repeat your new password");
    echo 'Please repeat your new password';
    die();
}

// Validate user input
// Validate username
if (!preg_match('/[A-Za-z0-9]+/', $_POST['username'])) {
    array_push($errors, "Invalid username");
    echo 'Invalid username';
    die();
}
else{
    $_POST['username'] = test_input($_POST['username']);
}
// E-mail validation
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Invalid e-mail adress");
    echo 'Invalid e-mail adress';
    die();
}
else{
    $_POST['email'] = test_input($_POST['email']);
}
// Check if the two new passwords are the same
if($_POST['password_new1'] !== $_POST['password_new2']) {
        array_push($errors, "The new passwords do not match");
        echo 'The new passwords do not match';
        die();
}
else{
    $_POST['password_new1'] = test_input($_POST['password_new1']);
    $_POST['password_new2'] = test_input($_POST['password_new2']);
}
// Check, if passwords have the right length
if (strlen($_POST['password_new1']) > 30 || strlen($_POST['password_new2']) < 5) {
    array_push($errors, "Password must be between 5 and 30 characters long");
    echo 'New password is too weak';
    die();
}

// Allow only JPEG format
if(isset($_FILES['image']['tmp_name'])){
    $verifyimg = getimagesize($_FILES['image']['tmp_name']);
    if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
        array_push($errors, "Only JPEG images are allowed");
        echo 'Only JPEG images are allowed';
        die();
    }
}
// Check if there is already an existing account with that username
if ($stmt_username = $connect->prepare('SELECT user_id FROM User WHERE username = ?')) {
    $stmt_username->bind_param('s', $_POST['username']);
    $stmt_username->execute();
    $res = $stmt_username->get_result();
    $row = $res->fetch_assoc();
    // res has to be 0 if it's a non existing username
    if ($res->num_rows > 0 && ($row['user_id'] !== $_SESSION['user_id'])){            
            // Username already exists
            $stmt_username->close();
            array_push($errors, "This username is already taken. Please choose another one");
            echo 'This username is already taken. Please choose another one';
            die();
    }
}
    
if ($stmt_password = $connect->prepare('SELECT password FROM User WHERE user_id = ?')) {
    $stmt_password->bind_param('s', $_SESSION['user_id']);
    $stmt_password->execute();
    $res = $stmt_password->get_result();
    $row = $res->fetch_assoc();    
    // Check if the password matches with the current (old) password
    if (!password_verify($_POST['password_old'], $row['password'])) {
        $stmt_password->close();
        array_push($errors, "Please enter your current password correctly");
        echo 'Please enter your current password correctly';
        die();
    } else {
        $_POST['password_old'] = test_input($_POST['password_old']);
    }
}
$stmt_username->close();
if ($stmt_email = $connect->prepare('SELECT user_id FROM User WHERE email = ?')) {
    $stmt_email->bind_param('s', $_POST['email']);
    $stmt_email->execute();
    $res = $stmt_email->get_result();
    $row = $res->fetch_assoc();
    // res has to be 0 if it's a non existing username
    if ($res->num_rows > 0 && ($row['user_id'] !== $_SESSION['user_id'])){            
            // Username already exists
            $stmt_email->close();
            array_push($errors, "This e-mail adress is already taken");
            echo 'This e-mail adress is already taken';
            die();
    }
}
$stmt_email->close();
$password = password_hash($_POST['password_new1'], PASSWORD_DEFAULT);
if($stmt = $connect->prepare("UPDATE User SET username = '".$_POST['username']."', email = '".$_POST['email']."', password = '".$password."' WHERE user_id = '".$_SESSION['user_id']."'")){
    $stmt->execute();
    $_SESSION['name'] = $_POST['username'];
    $stmt->close();
}

$connect->close();
?>