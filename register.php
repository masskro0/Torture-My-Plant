<?php
/* 
 * This script is executed, when an user submits the form on the signup.php page. It sanitized and validates user input,
 * checks for errors and add them to an array and if everything is okay, the user will be added to the User table.
 */

// Function to sanitize "bad code" like HTML or Javascript code. Returns the sanitized input
function test_input($data) { 
    
    // Removes whitespaces
    $data = trim($data); 
    
    // Removes backslashes
    $string=implode("",explode("\\",$data));
    $data = stripslashes(trim($string));
    
    // Converts special chars in html chars
    $data = htmlspecialchars($data);
    return $data;
}

// Form has to be submitted
if(isset($_POST['submit'])) {
    
    // Start the session to add user information to the $_SESSION array and keep the information on every site
    session_start();
    
    // Array to display errors
    $errors = array(); 
    
    // Sanitize user input
    $_POST['username'] = test_input($_POST['username']);
    $_POST['email'] = test_input($_POST['email']);
    $_POST['password1'] = test_input($_POST['password1']);
    $_POST['password2'] = test_input($_POST['password2']);
    
    // Variables to display them in the form so the user doesn't have to enter them again if an error occured
    $uname = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    
    // Connect to the database
    include('db_connect.php');
    
    // Check whether the username field is empty or not
    if(empty($_POST['username']) || !isset($_POST['username'])){
        array_push($errors, "A username is required.");
    }
    
    // Check whether the e-mail field is empty or not
    if(empty($_POST['email']) || !isset($_POST['email'])){
        array_push($errors, "An e-mail-adress is required.");
    }
    
    // Check whether the first password field is empty or not
    if(empty($_POST['password1']) || !isset($_POST['password1'])){
        array_push($errors, "A password is required.");
    }
    
    // Check whether the second password field is empty or not
    if(empty($_POST['password2']) || !isset($_POST['password2'])){
        array_push($errors, "Please repeat your password.");
    }
    
    /* Validate user input */
    // Validate username
    if (!preg_match('/[A-Za-z0-9]+/', $_POST['username'])) {
        array_push($errors, "Username is invalid. Please take another one.");
    }
    
    // E-mail validation
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid e-mail adress. Please check for errors.");
    }
    
    // Check if both passwords are similar
    if($_POST['password1'] !== $_POST['password2']) {
        array_push($errors, "Passwords do not match.");
    }
    
    // Check, if passwords have the right length
    if (strlen($_POST['password1']) < 5) {
        array_push($errors, "Password must be at least 5 characters long.");
    }

    // Allow only JPEG format
    if($_FILES['image']['tmp_name'] != NULL){
        $verifyimg = getimagesize($_FILES['image']['tmp_name']);
        if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
            array_push($errors, "Only JPEG images are allowed.");
        }
    }
    
    // Prepare statement to prevent sql injection. Check if there is already an existing account with that username
    if ($stmt_username = $connect->prepare('SELECT user_id, password FROM User WHERE username = ?')) {
        
        // Replace the questionmark with the username (s := string)
        $stmt_username->bind_param('s', $_POST['username']);
        
        // Execute the statement above
        $stmt_username->execute();
        
        // Store the result
        $stmt_username->store_result();
        
        // num_rows has to be 0 if it's a non existing username
        if ($stmt_username->num_rows > 0) {
            // Username already exists
            array_push($errors, "This username is already taken. Please choose another one.");
        }
    }
    
    // Check if there is already an existing account with that e-mail adress. Same as above
    if ($stmt_email = $connect->prepare('SELECT user_id FROM User WHERE email = ?')) {
        $stmt_email->bind_param('s', $_POST['email']);
        $stmt_email->execute();
        $stmt_email->store_result();
        
        // num_rows has to be 0 if it's a non existing e-mail
        if ($stmt_email->num_rows > 0) {
            
            // E-mail already exists
            array_push($errors, "This email is already taken.");
        }
    }
    if (!isset($_POST['policy'])){
        array_push($errors, "You must accept the privacy policy.");
    }
    
    // Check for errors and proceed if there aren't any
    if($stmt_username->num_rows === 0 && $stmt_email->num_rows === 0 && count($errors) == 0) {        
        
        /* Prepare to insert the user in the User table. Profile picture will be updated later because an user doesn't
        have to select an image */
        if($stmt = $connect->prepare('INSERT INTO User (username, email, password) VALUES(?, ?, ?)')){
            
            // Hash the password
            $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $_POST['email'], $password);
            $stmt->execute();
            
            // Session information (the login process)
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            
            // Close all statements
            $stmt_username->close();
            $stmt_email->close();
            $stmt->close();
            
            if ($stmt = $connect->prepare('SELECT user_id FROM User WHERE username = ?')) {
                $stmt->bind_param('s', $_POST['username']);
                $stmt->execute();

                // Store the result of the query in the variable $lastuserid
                $stmt->store_result();
                $stmt->bind_result($lastuserid);
                $stmt->fetch();
                $stmt->close();

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

                // Upload profile picture path into the User table if a picture is selected
                if (!is_null($uploadfile)){
                    if($stmt = $connect->prepare("UPDATE User SET profile_picture = ? WHERE user_id = ?")){
                        $stmt->bind_param('si',$uploadfile, intval($lastuserid));
                        $stmt->execute();
                        $stmt->close();
                    }
                }
                $_SESSION['user_id'] = $lastuserid;
                
                // Close the database connection
                $connect->close();
                
                // Redirect user to the index.php page and end this script
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
}
?>
