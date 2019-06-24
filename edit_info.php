<?php
/* 
 * Script to validate und sanitize user input; if everything is ok, store him in the MySQL database 
 */

// Function to sanitize "bad code" like HTML or Javascript code.
function test_input($data) { 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['submit'])) {
    
    session_start();
    // Check if the user is logged in, if not redirect him to the startpage
    if(!$_SESSION['loggedin']){
        header('Location: index.php');
    }
    // Array to display errors
    $errors = array(); 
    // Variables to display them in the form so the user doesn't have to enter them again if an error occured
    $uname = $_POST['username'];
    $email = $_POST['email'];
    $psw_old = $_POST['password_old'];
    $psw_new1 = $_POST['password_new1'];
    $psw_new2 = $_POST['password_new2'];
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
    
    /* Check if the fields are empty */
    // Check whether the username field is empty or not     
    if(empty($_POST['username']) || !isset($_POST['username'])){
        array_push($errors, "Username is required");
    }
    // Check whether the e-mail field is empty or not
    if(empty($_POST['email']) || !isset($_POST['email'])){
        array_push($errors, "E-mail adress is required");
    }
    // Check whether the old password field is empty or not
    if(empty($_POST['password_old']) || !isset($_POST['password_old'])){
        array_push($errors, "Please enter your old password");
    }
    // Check whether the new password field is empty or not
    if(empty($_POST['password_new1']) || !isset($_POST['password_new1'])){
        array_push($errors, "Please enter a new password");
    }
    // Check whether the new password field is empty or not
    if(empty($_POST['password_new2']) || !isset($_POST['password_new2'])){
        array_push($errors, "Please repeat your new password");
    }
    
    /* Validate user input */
    // Validate username
    if (!preg_match('/[A-Za-z0-9]+/', $_POST['username'])) {
        array_push($errors, "Invalid username");
    }
    else{
        $_POST['username'] = test_input($_POST['username']);
    }
    // E-mail validation
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid e-mail adress");
    }
    else{
        $_POST['email'] = test_input($_POST['email']);
    }
    // Check if the two new passwords are the same
    if($_POST['password_new1'] !== $_POST['password_new2']) {
            array_push($errors, "The new passwords do not match");
    }
    else{
        $_POST['password_new1'] = test_input($_POST['password_new1']);
        $_POST['password_new2'] = test_input($_POST['password_new2']);
    }
    // Check, if passwords have the right length
    if (strlen($_POST['password_new1']) > 30 || strlen($_POST['password_new2']) < 5) {
        array_push($errors, "Password must be between 5 and 30 characters long");
    }
    // Allow only JPEG format
    if($_FILES['image']['tmp_name'] != NULL){
        $verifyimg = getimagesize($_FILES['image']['tmp_name']);
        if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
            array_push($errors, "Only JPEG images are allowed");
        }
    }
    // Check if there is already an existing account with that username
    if ($stmt_username = $connect->prepare('SELECT user_id FROM User WHERE username = ?')) {
        $stmt_username->bind_param('s', $_POST['username']);
        $stmt_username->execute();
        $res = $stmt_username->get_result();
        $row = $res->fetch_assoc();
        $str_id = ''.$row['user_id'];
        // res has to be 0 if it's a non existing username; if it's the own user's name, then proceed
        if ($res->num_rows > 0 && (intval($str_id) !== $_SESSION['user_id'])){            
            // Username already exists
            $stmt_username->close();
            array_push($errors, "This username is already taken. Please choose another one");
        }
    }
    // Check if there is already an existing account with that e-mail adress
    $stmt_username->close();
    if ($stmt_email = $connect->prepare('SELECT user_id FROM User WHERE email = ?')) {
        $stmt_email->bind_param('s', $_POST['email']);
        $stmt_email->execute();
        $res = $stmt_email->get_result();
        $row = $res->fetch_assoc();
        $str_id = ''.$row['user_id'];
        // res has to be 0 if it's a non existing username; if it's the own user's email, then proceed
        if ($res->num_rows > 0 && (intval($str_id) !== $_SESSION['user_id'])){            
                // Username already exists
                $stmt_email->close();
                array_push($errors, "This e-mail adress is already taken");
        }
    }
    $stmt_email->close();
    // Check if the old password was entered correctly
    if ($stmt_password = $connect->prepare('SELECT username, email, password, profile_picture FROM User WHERE user_id = ?')) {
    $stmt_password->bind_param('s', $_SESSION['user_id']);
    $stmt_password->execute();
    $res = $stmt_password->get_result();
    $row = $res->fetch_assoc();   
    // Check if the password matches with the current (old) password
    if (!password_verify($_POST['password_old'], $row['password'])) {
        $stmt_password->close();
        array_push($errors, "Please enter your current password correctly");
    } else {
        $_POST['password_old'] = test_input($_POST['password_old']);
    }
}

    // Hash password
    $password = password_hash($_POST['password_new1'], PASSWORD_DEFAULT);
    // If there are no errors, then update the information
    if(empty($errors)){
        $lastuserid = $_SESSION['user_id'];
        // Make directory for the user
        mkdir("/var/www/html/upload/$lastuserid");

        // Check if no image was chosen
        if(empty($_FILES['image']['name'])){
            $uploadfile = NULL;
            if(!is_null($row['profile_picture']) || !empty($row['profile_picture'])){
                $uploadfile = $row['profile_picture'];
            }
        } else {
            // Choose directory
            $uploaddir = "/var/www/html/upload/$lastuserid/";
            $uploadfile = $uploaddir . '1';
            // Upload image
            if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
            echo "Image succesfully uploaded.";
            } else {
            echo "Image uploading failed.";
                $uploadfile = NULL;
            }
        }

        if($stmt = $connect->prepare("UPDATE User SET username = '".$_POST['username']."', email = '".$_POST['email']."', password = '".$password."', profile_picture = '".$uploadfile."' WHERE user_id = '".$_SESSION['user_id']."'")){
            $stmt->execute();
            $_SESSION['name'] = $_POST['username'];
            $uname = $_POST['username'];
            $stmt->close();
            header("Location: profile.php");
            die();
        }
    }

    $connect->close();
    }
?>
