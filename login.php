<?php
/*
 * This script validates user input from the login form and creates a new session. It's only used on the index.php
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

// Create a new session to remember this user
session_start();

// An array that contains all errors
$errors = array();

// Connect to the database
include('db_connect.php');

// Check whether the username field is empty or not
if(empty($_POST['username']) || !isset($_POST['username'])){
    array_push($errors, 'Username is required');
    echo 'Username is required';
    die();
}

// Check whether the password field is empty or not
if(empty($_POST['password']) || !isset($_POST['password'])){
    array_push($errors, 'Username is required');
    echo 'Password is required';
    die();
}

// Sanitize user input
$_POST['username'] = test_input($_POST['username']);
$_POST['password'] = test_input($_POST['password']);

// Get the user id and password that belongs to the entered username. Prepare statement to prevent sql injection
if ($stmt = $connect->prepare('SELECT user_id, password FROM User WHERE username = ?')) {
    
    // Replace questionmark with the username (s := string)
    $stmt->bind_param('s', $_POST['username']);
    
    // Execute the query above
    $stmt->execute();
    
    // Stores the result of the condition
    $stmt->store_result();
    
    // Checks if an account with this username exists
    if ($stmt->num_rows > 0) {
        
        // Store the user id and password from the query in the same titled variables
        $stmt->bind_result($user_id, $password);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($_POST['password'], $password)) {
            
            // Assign all important informations in the $_SESSION array if there are no errors
            if(count($errors) == 0) {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['user_id'] = $user_id;
                $stmt->close();
            }
        }
        else {
            array_push($errors, 'Wrong password');
            echo 'Wrong password.';
            $stmt->close();
            die();
        }
    } else {
        array_push($errors, 'Username doesn\'t exist.');
        echo 'Username doesn\'t exist.';
        die();
    }
}

/* Function that is activated when the "keep me logged in" box is ticked. Creates a token and cookie and stores the 
 * token in the database
 */
if($_POST['remember'] === "true"){
    
    // Generates cryptographically secure pseudo-random 128 bytes long
    $token = random_bytes(128);

    // Converts the token into a hex. That way it's working flawless with the database and verifying process
    $hex = bin2hex($token);

    // Store token in the database
    if($stmt = $connect->prepare("UPDATE User SET token = ? WHERE user_id = ? ")){
    
        // Replace questionmark with the username (s := string, i := integer)
        $stmt->bind_param('si', $hex, $_SESSION['user_id']);
        $stmt->execute();
    }
       
    // Information to store in the cookie
    $cookie = $user_id . ':' . $hex;
       
    // A secret key for hashing
    $secret_key = 'secret';
       
    // Hash the cookie information
    $mac = hash_hmac('sha256', $cookie, $secret_key);
       
    // Add the hashed information to the cookie
    $cookie .= ':' . $mac;
       
    // Create a cookie
    setcookie('rememberme', $cookie, time()+(86400*30));
}

// Close the connection to the database
$connect->close();
?>
