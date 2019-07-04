<?php
// Start the session
session_start();
// If the user is logged in, display the user's balance at the top and profile picture on the upper right corner
if($_SESSION['loggedin']){
    include('balance.php');
    include('getinfo.php');
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture My Plant - Error 404: Site was not found</title>
    <link rel="stylesheet" type="text/css" href="styles/errorpage.css">
    <script type="text/javascript" src="javascripts/login.js"></script>
  </head>
    <body>
        <!--Black bar on the top-->
        <div id="navbar"></div>
        <nav>
            <ul>
                <!--Homebutton, containing an invisible rectangle around the planticon and the website name -->
                <div style="cursor: pointer;" onclick="window.location='index.php'" id="homebutton">
                <li><a href="index.php"><img id="homeicon" src="img/planticon2.png"></a></li>
                <li><a id="frontpagetext" href="index.php">Torture My Plant</a></li>
                </div>
                <?php
                    // Change the navbar, if the user is logged in
                    if($_SESSION['loggedin'] === TRUE){ ?>
                        <li><img id="coins" src="img/coins2.png"></li>
                        <li><p id="cointext"><?php echo number_format($coins, 0, ".", "."); ?></p></li>
                        <li><a href="profile.php">
                            <?php   // If the user has a profile picture then display it, else display the generic profile picture
                                    if($row['profile_picture'] !== NULL){
                                    ?>
                                    <figure>
                                    <?php echo "<img src=\"$path\">"; ?>
                                    </figure>
                                    <?php } else{ ?>
                                    <img id="profilepic" src="img/profilepic.png" >
                            <?php   } ?></a>
                        </li>
                        <!--Shopbutton, containing an invisible rectangle around the carticon and "Shop" -->
                        <div id="shopbutton" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                        <li><a href ="shop.php"><img id="cart" src="img/carticon2.png"><p id="shoptext">Shop</p></a></li>
                    <?php } else{ ?>
                    <li class="rightelements"><a class="links" href="#" onclick="showlogin();">Login</a></li>
                    <li class="rightelements"><a class="links" href="signup.php">Create Account</a></li>

               <?php } ?>
            </ul>
        </nav>
        <!--Content of the error page-->
        <h1 id="errornumber">Error 404</h1>
        <h1 id="errormessage">Oh no! The page you was looking for doesn't exist!</h1>
        <img class="errorplant" src="img/planticon.png">
        <img class="errorplant2" src="img/planticon.png">
        <a id="goback" href="index.php"><h1 class="goback">Take me back to the homepage!</h1></a>
             
    
        <!----Loginscreen---->
        <!-- The Modal -->
        <div id="loginbackground" class="modal">
            <!--Close Button-->
            <span onclick="document.getElementById('loginbackground').style.display='none'"
            class="close animate">&times;</span>
            <!-- Modal Content -->
            <form class="modal-content animate" method="POST" action="">
                <p class="logintext">Login</p>
                <div class="container">
                    <!--Shows errors while the user tries to login-->
                    <div class ="error" id="error"></div>
                    <!--Input fields of the login form-->
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Username..." name="username" id="username" required>
                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Password..." name="password" id="password" required>
                    <label>
                    <input type="checkbox" id="remember" checked="checked" name="remember"> Keep me logged in
                    </label><br><br>
                    New here? <a href="signup.php">Create an account here</a><br>
                    <input name="submit" type="button" class="accept loginbutton" id="submitform" value="Login" onclick="validate()" >
                </div>
            </form>
        </div>
    </body>
</html>