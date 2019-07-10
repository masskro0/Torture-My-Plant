<?php
/* 
 * This script is activated, when an user either clicks on the accept button on the profile_edit.php page or just
 * changes his profile picture. User input will be sanitized and validated and is there are no errors, then update the
 * info into the database.
 */

// Start the session
session_start();

// Check if the user is logged in, if not redirect him to the startpage
if(!$_SESSION['loggedin']){
    header('Location: index.php');
    die();
}

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


if(isset($_POST['submit'])) {
     
    // Array that contains errors
    $errors = array();
    
    // Sanitized variables to display them in the form so the user doesn't have to enter them again if an error occured
    $uname = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $psw_old = test_input($_POST['password_old']);
    $psw_new1 = test_input($_POST['password_new1']);
    $psw_new2 = test_input($_POST['password_new2']);
   
    // Connect to database
    include('db_connect.php');
    
    // If all fields are empty or stayed untouched, then update just the new profile picture
    if((empty($_POST['username']) || !isset($_POST['username']) || $_POST['username'] == $uname) && 
       (empty($_POST['email']) || !isset($_POST['email']) || $_POST['email'] == $email) &&
       (empty($_POST['password_old']) || !isset($_POST['password_old'])) && 
       (empty($_POST['password_new1']) || !isset($_POST['password_new1'])) &&
       (empty($_POST['password_new2']) || !isset($_POST['password_new2']))){
        
        // Check if an image was selected
        if(!is_null($_FILES['image']['tmp_name'])){
            $verifyimg = getimagesize($_FILES['image']['tmp_name']);
            
            // Allow only JPEG format
            if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
                array_push($errors, "Only JPEG images are allowed.");
            }
            
            // If there are no errors, then update the information
            if(empty($errors)){
                $lastuserid = $_SESSION['user_id'];
                
                // Make directory for the user. If one is already existing then nothing will happen
                mkdir("/var/www/html/upload/$lastuserid");

                // Check if an image was chosen
                if(empty($_FILES['image']['name'])){
                    $uploadfile = NULL;
                    
                    // If not then keep the old picture
                    if(!is_null($row['profile_picture'])){
                        $uploadfile = $row['profile_picture'];
                    }
                    
                } else {
                    // Choose directory
                    $uploaddir = "/var/www/html/upload/$lastuserid/";
                    $uploadfile = $uploaddir . '1';
                    
                    // Upload image
                    if(!move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
                        echo "Image succesfully uploaded.";
                    } else {
                        echo "Image uploading failed.";
                        $uploadfile = NULL;
                    }
                }
                
                // If a new image was selected, update it in the database
                if(!is_null($uploadfile)){
                    
                    // Prepare statement to prevent sql injection
                    if($stmt = $connect->prepare("UPDATE User SET profile_picture = ? WHERE user_id = ? ")){
                        
                        // Insert variables for the questionmarks. s := string, i := integer
                        $stmt->bind_param('si', $uploadfile, $_SESSION['user_id']);
                        
                        // Execute the query above
                        $stmt->execute();
                        
                        // Update the new name
                        $_SESSION['name'] = $_POST['username'];
                        $uname = $_POST['username'];
                        
                        // Close the statement
                        $stmt->close();
                        
                        // Redirect the user back to his profile
                        header("Location: profile.php");
                        die();
                    }
                }
            }
        }
        
    // Block to handle ALL information
    } else {

        /* Check if the fields are empty */
        // Check whether the username field is empty or not     
        if(empty($_POST['username']) || !isset($_POST['username'])){
            array_push($errors, "An username is required.");
        }
        
        // Check whether the e-mail field is empty or not
        if(empty($_POST['email']) || !isset($_POST['email'])){
            array_push($errors, "An e-mail adress is required.");
        }
        
        // Check whether the old password field is empty or not
        if(empty($_POST['password_old']) || !isset($_POST['password_old'])){
            array_push($errors, "Please enter your old password.");
        }
        
        // Check whether the first new password field is empty or not
        if(empty($_POST['password_new1']) || !isset($_POST['password_new1'])){
            array_push($errors, "Please enter a new password.");
        }
        
        // Check whether the second new password field is empty or not
        if(empty($_POST['password_new2']) || !isset($_POST['password_new2'])){
            array_push($errors, "Please repeat your new password.");
        }
        
        // Sanitize user input
        $_POST['username'] = test_input($_POST['username']);
        $_POST['email'] = test_input($_POST['email']);
        $_POST['password_old'] = test_input($_POST['password_old']);
        $_POST['password_new1'] = test_input($_POST['password_new1']);
        $_POST['password_new2'] = test_input($_POST['password_new2']);

        /* Validate user input */
        
        // Validate username
        if (!preg_match('/[A-Za-z0-9]+/', $_POST['username'])) {
            array_push($errors, "Invalid username. Please take another one.");
        }
        
        // E-mail validation
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid e-mail adress. Please check for errors.");
        }

        // Check if the two new passwords are the same
        if($_POST['password_new1'] !== $_POST['password_new2']) {
                array_push($errors, "The new passwords do not match.");
        }

        // Check, if passwords have the right length
        if ((strlen($_POST['password_new1']) < 5) || (strlen($_POST['password_new2']) < 5)) {
            array_push($errors, "Password must be at least 5 characters long.");
        }

        // Check if an image was selected
        if(!is_null($_FILES['image']['tmp_name'])){
            $verifyimg = getimagesize($_FILES['image']['tmp_name']);
            
            // Allow only JPEG format
            if(($verifyimg['mime'] != 'image/jpeg') && !(empty($_FILES['image']['tmp_name']))) {
                array_push($errors, "Only JPEG images are allowed.");
            }
        }
        
        // Check if there is already an existing account with that username
        if ($stmt = $connect->prepare('SELECT user_id FROM User WHERE username = ?')) {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            
            // Get the id that belongs to the entered username and store it in the variable $str_id (type: string)
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $str_id = ''.$row['user_id'];
            
            // res has to be 0 if it's a non existing username; if it's the user's name, then proceed
            if ($res->num_rows > 0 && (intval($str_id) !== intval($_SESSION['user_id']))){
                
                // Username already exists
                array_push($errors, "This username is already taken. Please choose another one");
            }
        }
        $stmt->close();
        
        // Check if there is already an existing account with that e-mail adress
        if ($stmt = $connect->prepare('SELECT user_id FROM User WHERE email = ?')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            
            // Get the id that belongs to the entered e-mail adress and store it in the variable $str_id (type: string)
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $str_id = ''.$row['user_id'];
            
            // res has to be 0 if it's a non existing e-mail adress; if it's the own user's e-mail, then proceed
            if ($res->num_rows > 0 && (intval($str_id) !== intval($_SESSION['user_id']))){
                
                    // Username already exists
                    array_push($errors, "This e-mail adress is already taken");
            }
        }
        $stmt->close();
        
        // Check if the old password was entered correctly
        if ($stmt = $connect->prepare('SELECT username, email, password, profile_picture FROM User WHERE user_id = ?')) {
            $stmt->bind_param('s', $_SESSION['user_id']);
            $stmt->execute();
            
            // Store the result of the query in the variable $password_old
            $stmt->store_result();
            $stmt->bind_result($password_old);
            $stmt->fetch(); 
            
            // Check if the password matches with the current (old) password
            if (!password_verify($_POST['password_old'], $password_old)) {
                array_push($errors, "Please enter your current password correctly");
            }
        }
        $stmt->close();
        
        // If there are no errors, then update the information
        if(empty($errors)){
            
            // Hash password
            $password = password_hash($_POST['password_new1'], PASSWORD_DEFAULT);
            $lastuserid = $_SESSION['user_id'];
            
            // Make directory for the user
            mkdir("/var/www/html/upload/$lastuserid");

            // Check if no image was chosen
            if(empty($_FILES['image']['name'])){
                $uploadfile = NULL;
                if(!is_null($row['profile_picture'])){
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
            
            // Update information to the database, when no image was selected (without updating profile picture)
            if(is_null($uploadfile)){
                if($stmt = $connect->prepare("UPDATE User SET username = ?, email = ?, password = ? WHERE user_id = ?")){
                    $stmt->bind_param('sssi', $_POST['username'], $_POST['email'], $password, $_SESSION['user_id']);
                    $stmt->execute();
                    
                    // Update the new name in the session variable
                    $_SESSION['name'] = $_POST['username'];
                    $uname = $_POST['username'];
                    $stmt->close();
                    $connect->close();
                    header("Location: profile.php");
                    die();
                }
            }
            
            // Update information to the database, when nan image was selected
            else {
                if($stmt = $connect->prepare("UPDATE User SET username = ?, email = ?, password = ?, profile_picture = ? WHERE user_id = ?")){
                    $stmt->bind_param('ssssi', $_POST['username'], $_POST['email'], $password, $uploadfile, $_SESSION['user_id']);
                    $stmt->execute();
                    
                    // Update the new name in the session variable
                    $_SESSION['name'] = $_POST['username'];
                    $uname = $_POST['username'];
                    $stmt->close();
                    $connect->close();
                    header("Location: profile.php");
                    die();
                }
            }
        }   
    }
}
?>
