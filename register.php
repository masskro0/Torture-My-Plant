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
    // Array to display errors
    $errors = array(); 
    // Variables to display them in the form so the user doesn't have to enter them again if an error occured
    $uname = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
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
    // Check whether the username field is empty or not
    if(empty($_POST['username']) || !isset($_POST['username'])){
        array_push($errors, "Username is required");
    }
    // Check whether the e-mail field is empty or not
    if(empty($_POST['email']) || !isset($_POST['email'])){
        array_push($errors, "E-mail is required");
    }
    // Check whether the first password field is empty or not
    if(empty($_POST['password1']) || !isset($_POST['password1'])){
        array_push($errors, "Password is required");
    }
    // Check whether the second password field is empty or not
    if(empty($_POST['password2']) || !isset($_POST['password2'])){
        array_push($errors, "Please repeat your password");
    }
    
    /* Validate user input */
    // Validate username
    if (!preg_match('/[A-Za-z0-9]+/', $_POST['username'])) {
        array_push($errors, "Username is invalid");
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
    
    // Check if both passwords are similar
    if($_POST['password1'] !== $_POST['password2']) {
        array_push($errors, "Passwords do not match");
    }
    // Check, if passwords have the right length
    if (strlen($_POST['password1']) > 30 || strlen($_POST['password1']) < 5) {
        array_push($errors, "Password must be between 5 and 30 characters long");
    }
    $_POST['password1'] = test_input($_POST['password1']);
    $_POST['password2'] = test_input($_POST['password2']);
    // Allow only JPEG format
    if($_FILES['image']['tmp_name'] != NULL){
        $verifyimg = getimagesize($_FILES['image']['tmp_name']);
        if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
            array_push($errors, "Only JPEG images are allowed");
        }
    }
    // Check if there is already an existing account with that username
    if ($stmt_username = $connect->prepare('SELECT user_id, password FROM User WHERE username = ?')) {
        $stmt_username->bind_param('s', $_POST['username']);
        $stmt_username->execute();
        $stmt_username->store_result();
        // num_rows has to be 0 if it's a non existing username
        if ($stmt_username->num_rows > 0) {
            // Username already exists
            array_push($errors, "This username is already taken. Please choose another one");
        }
    }
    // Check if there is already an existing account with that e-mail adress
    if ($stmt_email = $connect->prepare('SELECT user_id FROM User WHERE email = ?')) {
        $stmt_email->bind_param('s', $_POST['email']);
        $stmt_email->execute();
        $stmt_email->store_result();
        // num_rows has to be 0 if it's a non existing e-mail
        if ($stmt_email->num_rows > 0) {
            // E-mail already exists
            array_push($errors, "This email is already taken");
        }
    }
    
    // Insert new account
    if($stmt_username->num_rows === 0 && $stmt_email->num_rows === 0 && count($errors) == 0) {        
        

        if($stmt = $connect->prepare('INSERT INTO User (username, email, password) VALUES(?, ?, ?)')){
            $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $_POST['email'], $password);
            $stmt->execute();
            // Session information
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            
            // Close all statements
            $stmt_username->close();
            $stmt_email->close();
            $stmt->close();
            // Get the user id and upload the image
            $sql = "SELECT user_id FROM User WHERE username = '".$_POST['username']."'";
            $lastuserid = 0;
            $result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                $lastuserid = $row["user_id"];
            }

            // Make directory for the user
            mkdir("/var/www/html/upload/$lastuserid");

            // Check if no image was chosen
            if(empty($_FILES['image']['name'])){
                $uploadfile = NULL;
            } else {
                // Choose directory
                $uploaddir = "/var/www/html/upload/$lastuserid/";
                // Rename the file to '1' so the server doesn't have to store more than 1 picture
                $uploadfile = $uploaddir . '1';
                // Upload image
                if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
                echo "Image succesfully uploaded.";
                } else {
                echo "Image uploading failed.";
                    $uploadfile = NULL;
                }
            }
            if($stmt = $connect->prepare("UPDATE User SET profile_picture = '".$uploadfile."' WHERE user_id = '".$lastuserid."'")){
                $stmt->execute();
                $stmt->close();
            }
            $_SESSION['user_id'] = $lastuserid;
            $connect->close();
            
            header("Location: index.php");
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
