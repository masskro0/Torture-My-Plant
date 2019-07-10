<?php 
// Include script for the registration process
include('register.php') 
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Torture some plants - Sign Up</title>
        <link rel="stylesheet" type="text/css" href="styles/signup.css">
        <script src="javascripts/jquery.js"></script> 
        <script src="javascripts/readurl.js"></script>
    </head>
    <body>
        <!-- Head -->
        <div id="headbar">
            <a href="index.php"><img id="leftarrow" src="img/linkerpfeil.png"></a>
            <p id="header">Sign Up</p>
        </div>
        
        <!-- Page content -->
        <div class="screen">
            
            <!-- Form -->
            <form method="post" action="" enctype="multipart/form-data">
                
                <!-- Errors -->
                <?php include('errors.php'); ?>
                
                <!-- Profile picture -->
                <img id="profilepic" src="img/profilepic2.png">
                <input type="file" name="image" onchange="readURL(this);" accept="image/jpeg" style="display:none;" id="file">
                <figure>
                <img id="uploaded" src="#"/>
                </figure>
                <input type="button" class="uploadbutton button" value="Upload Profile Picture" onclick="document.getElementById('file').click();">     

                <!-- Input fields; keep information after submitting -->
                <label for="username"><b>Username</b></label>
                <?php echo"<input type=\"text\" placeholder=\"Username...\" name=\"username\" value=\"$uname\" required>"; ?>
                <label for="email"><b>E-Mail Adress</b></label>
                <?php echo "<input type=\"text\" placeholder=\"E-Mail...\" name=\"email\" value=\"$email\" required>"; ?>
                <label for="password1"><b>Password</b></label>
                <?php echo"<input type=\"password\" placeholder=\"Password...\" name=\"password1\" value=\"$password1\" required>"; ?>
                <label for="password2"><b>Repeat Password</b></label>
                <?php echo"<input type=\"password\" placeholder=\"Repeat Password...\" name=\"password2\" value=\"$password2\" required>"; ?>
                <input type="checkbox" id="policy" name="policy" required> I have read and agree to the <a href="privacy_policy.html" class="policylink">
                    Privacy Policy.</a>
                <input name="submit" class="button signupbutton" type="submit" value="Sign Up">
            </form>
        </div>
    </body>
</html>
