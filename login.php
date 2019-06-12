<?php
/* This script validates user input from the login form and creates new sessions */

// Function to sanitize "bad code" like HTML or Javascript code.
function test_input($data) { 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
}

//if(isset($_POST['submit'])) {
    // Create a new session to remember this user
    session_start();
    // Array to display errors
    $errors2 = array(); 
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
        array_push($errors2, "Username is required");
        echo 'Username is required';
        die();
    }
    // Check whether the password field is empty or not
    if(empty($_POST['password']) || !isset($_POST['password'])){
        array_push($errors2, "Password is required");
        echo 'Password is required';
        die();
    }
    $_POST['username'] = test_input($_POST['username']);

    // Prepare MySQL code and check if the user exists or not
    if ($stmt = $connect->prepare('SELECT user_id, password FROM User WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        // Stores the result of the condition
        $stmt->store_result();
        // Checks if an account with this username exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $password);
            $stmt->fetch();
            // Verify password
            if (password_verify($_POST['password'], $password)) {
                if(count($errors2) == 0) {
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['username'];
                    $_SESSION['user_id'] = $user_id;
                    $stmt->close();
                }
            }
            else {
                array_push($errors2, 'Wrong password');
                echo 'Wrong password';
        die();
            }
        }
        else {
            array_push($errors2, 'Username does not exist.');
            echo 'Username doesnt exist';
        die();
        }
    }
        $stmt->close();
//}
//}
?>
