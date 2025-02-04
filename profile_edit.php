<?php
// Start the session
session_start();

// Redirect user to the homepage if he isn't logged in
if(!$_SESSION['loggedin']){
    header('Location: index.php');
    die();
}

// Get balance, user info and embed script to update user information
include('balance.php');
include('getinfo.php');
include('edit_info.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Torture some plants - Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="styles/profile_edit.css">
        <script src="javascripts/jquery.js"></script> 
        <script src="javascripts/readurl.js"></script> 
    </head>
    <body>
        <!-- Black navigation bar on top -->
        <div id="navbar"></div>
        <nav>
            <!-- Navigation bar elements -->
            <ul>
                <div style="cursor: pointer;" onclick="window.location='index.php'" id="homebutton">
                <li><a href="index.php"><img id="homeicon" src="img/planticon2.png"></a></li>
                <li><a id="frontpagetext" href="index.php">Torture My Plant</a></li>
                </div>
                <li><img id="coins" src="img/coins2.png"></li>
                <li><p id="cointext"><?php echo number_format($coins, 0, ".", "."); ?></p></li>
                <li><a href="profile.php">
                    <?php if($row['profile_picture'] !== NULL){
                        ?>
                        <figure class="fig1">
                        <?php echo "<img src=\"$path\">"; ?>
                        </figure>
                        <?php } else{ ?>
                        <img class="profilepic" src="img/profilepic2.png" >
                        <?php } ?></a>
                </li>
                <div id="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                <li><a href="shop.php"><img id="cart" src="img/carticon2.png"><p id="shoptext">Shop</p></a></li>
            </ul>
        </nav>
        <!-- Page content -->
        <div id="screen">
            <h1 class="editProfile">Edit Your Profile</h1>
            <form method="post" action="" enctype="multipart/form-data">
                <?php include('errors.php'); ?>
                <?php if(is_null($row['profile_picture'])){
                echo "<img class=\"Userpicture\" src=\"img/profilepic2.png\">";
                } else {
                echo "<img class=\"userpic\" src=\"$path\">";
                }?>
                <input type="file" name="image" onchange="readURL(this);" accept="image/jpeg" style="display:none;" id="file">
                <figure class="fig2">
                <img id="uploaded" src="#"/>
                </figure>
                <input type="button" class="uploadbutton button" value="Change Picture" onclick="document.getElementById('file').click();">     

                <label for="username"><b>Enter username</b></label>
                <?php echo "<input type=\"text\" placeholder=\"Enter your username...\" name=\"username\" id=\"username\" value=\"$uname\">";
                ?>

                <label for="email"><b>Enter E-Mail Adress</b></label>
                <?php echo "<input type=\"text\" placeholder=\"Enter your e-mail adress...\" name=\"email\" id=\"email\" value=\"$email\">";
                ?>
                <label for="password"><b>Old Password</b></label>
                <?php echo "<input type=\"password\" placeholder=\"Enter your old password...\" name=\"password_old\" id=\"password_old\" value =\"$psw_old\">"; ?>
                <label for="password"><b>New Password</b></label>
                <?php echo "<input type=\"password\" placeholder=\"Enter your new password...\" name=\"password_new1\" id=\"password_new1\" value=\"$psw_new1\">"; ?>
                <label for="password"><b>Repeat New Password</b></label>
                <?php echo"<input type=\"password\" placeholder=\"Repeat your new password...\" name=\"password_new2\" id=\"password_new2\" value=\"$psw_new2\">"; ?>

                <input name="submit" type="submit" class="acceptbutton" id="submitform" value="Accept Changes" >
                <a class="Cancel" href="profile.php">Cancel</a>
            </form>
        </div>       
    </body>
    
    <script> 
        
    </script>
</html>
