<?php
/* Script to validate und sanitize user input; if everything is ok, store him in the MySQL database */

// Function to sanitize "bad code" like HTML or Javascript code.
function test_input($data) { 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['submit'])) {
    session_start();
    $errors = array(); 
    // Login info for the MySQL database
    $host = 'localhost';
    $user = 'root';
    $pswd = 'password';
    $db_name = 'website';
    // Connect to the database
    $connect = mysqli_connect($host, $user, $pswd, $db_name);
    // Check if there is an error with the connection
    if (mysqli_connect_errno()) {
        die('Connection to MySQL failed: ' .    mysql_connect_error());
    }
    // Check whether the username field is empty or not
    if(empty($_POST['username']) || !isset($_POST['username'])){
        array_push($errors, "Username is required");
        #die('Please enter an username');
    }
    // Check whether the e-mail field is empty or not
    if(empty($_POST['email']) || !isset($_POST['email'])){
        array_push($errors, "E-mail is required");
        #die('Please enter an e-mail adress');
    }
    // Check whether the first password field is empty or not
    if(empty($_POST['password1']) || !isset($_POST['password1'])){
        array_push($errors, "Password is required");
        #die('Please enter a password');
    }
    // Check whether the second password field is empty or not
    if(empty($_POST['password2']) || !isset($_POST['password2'])){
        array_push($errors, "Please repeat your password");
        #die('Please repeat your password');
    }
    // Validate user input
    // E-mail validation
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid e-mail adress");
	#die('Invalid e-mail adress');
    }
    else{
        $_POST['email'] = test_input($_POST['email']);
    }
    // Validate username
    if (!preg_match('/[A-Za-z0-9]+/', $_POST['username'])) {
        array_push($errors, "Username is invalid");
        #die('Invalid username. Please enter another one.');
    }
    else{
        $_POST['username'] = test_input($_POST['username']);
    }
    //Check if both passwords are similar
    if($_POST['password1'] !== $_POST['password2']) {
        array_push($errors, "Passwords do not match");
        #die('Passwords do not match');
    }
    // Check, if passwords have the right length
    if (strlen($_POST['password1']) > 30 || strlen($_POST['password1']) < 5) {
        array_push($errors, "Password must be between 5 and 30 characters long");
	   #die('Password must be between 5 and 30 characters long!');
    }
    
    // Allow only JPEG format
    $verifyimg = getimagesize($_FILES['image']['tmp_name']);
    if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
        array_push($errors, "Only JPEG images are allowed");
    }   
    
    // todo Sanitize
    
    
    // Check if there is already an existing account with that username
    if ($stmt_username = $connect->prepare('SELECT user_id, password FROM User WHERE username = ?')) {
        $stmt_username->bind_param('s', $_POST['username']);
        $stmt_username->execute();
        $stmt_username->store_result();
        //num_rows has to be 0 if it's a non existing username
        if ($stmt_username->num_rows > 0) {
            // Username already exists
            array_push($errors, "This username is already taken. Please choose another one.");
        }
    }
    
    if ($stmt_email = $connect->prepare('SELECT user_id, password FROM User WHERE email = ?')) {
        $stmt_email->bind_param('s', $_POST['email']);
        $stmt_email->execute();
        $stmt_email->store_result();
        //num_rows has to be 0 if it's a non existing e-mail
        if ($stmt_email->num_rows > 0) {
            // E-mail already exists
            array_push($errors, "This email is already taken. Please choose another one.");
        }
    }
    
    // Insert new account
    if($stmt_username->num_rows === 0 && $stmt_email->num_rows === 0 && count($errors) == 0) {        
        //Get user id
        $sql = "SELECT user_id FROM User ORDER BY user_id DESC LIMIT 0, 1";
        $lastuserid = 0;
        $result = mysqli_query($connect, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $lastuserid = $row["user_id"]+1;
        }
    
        // Make directory for the user
        mkdir("/home/michael/Schreibtisch/new/$lastuserid");
        
        // Check if no image was chosen
        if(empty($_FILES['image']['name'])){
            $uploadfile = NULL;
        } else {
            // Choose directory
            $uploaddir = "/home/michael/Schreibtisch/new/$lastuserid/";
            $uploadfile = $uploaddir . basename($_FILES['image']['name']);
            // Upload image
            if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
            echo "Image succesfully uploaded.";
            } else {
            echo "Image uploading failed.";
                $uploadfile = NULL;
            }
        }
        
        if($stmt = $connect->prepare('INSERT INTO User (username, email, password, profile_picture) VALUES(?, ?, ?, ?)')){
            $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
            $stmt->bind_param('ssss', $_POST['username'], $_POST['email'], $password, $uploadfile);
            $stmt->execute();
            
            $stmt_username->close();
            $stmt_email->close();
            $connect->close();
            $stmt->close();
            header("Location: index.html");
            die();
        }
	
        else{

            echo 'A problem occured with registrating a new user.';
            $stmt_username->close();
            $stmt_email->close();
            $connect->close();
        }
    }
}
?>