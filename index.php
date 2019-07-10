<?php
// Start the session
session_start();

// Execute scripts when the user is logged in. Mainly to display information and add behaviour for items.
if($_SESSION['loggedin']){
    
    // Display balance
    include('balance.php');
    
    // Get all of the bought items
    include('getinfo_index.php');
    
    // Get various information of an user
    include('getinfo.php');
}

// Validate an user's cookie and keep him logged in, if a cookie is set
if ($_SESSION['loggedin'] !== TRUE){

    // Check if a cookie is set
    $cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
    if ($cookie) {
        
        // Separate the cookie into user id, token and mac
        list ($user_id, $token, $mac) = explode(':', $cookie);
        
        // Check if the cookie was manipulated by hashing it with the secret key again
        if (!hash_equals(hash_hmac('sha256', $user_id . ':' . $token, 'secret'), $mac)) {
            return false;
        }
        
        // Connect to the database
        include('db_connect.php');
        
         // Prepare MySQL code and check if the user exists or not
        if ($stmt = $connect->prepare('SELECT token FROM User WHERE user_id = ?')) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            
            // Stores the token in the variable $token_db
            $stmt->store_result();
            $stmt->bind_result($token_db);
            $stmt->fetch();
            
            // Compare both tokens and log the user in if they match
            if ($token_db == $token) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['user_id'] = $user_id;
                
                // Reload the page
                header('Location: index.php');
                die();
            }
        }
    }
}
?>

<!doctype html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <script type="text/javascript" src="javascripts/login.js"></script>
    <script type="text/javascript" src="javascripts/timer.js"></script>
    <script type="text/javascript" src="javascripts/torture_and_tools.js"></script>
    <script type="text/javascript" src="javascripts/daily_bonus.js"></script> 
    <script type="text/javascript" src="javascripts/slideshow.js"></script>  
    </head>
    
    <body>
        <!-- Black navigation bar -->
        <div class="navbar"></div>
        <nav>
            <!-- Navigation bar content -->
            <ul>
                <div id="homebutton">
                <li><a href=""><img id="homeicon" src="img/planticon.png"></a></li>
                <li><a id="frontpagetext" href="">Torture My Plant</a></li>
                </div>
                <?php if($_SESSION['loggedin'] === TRUE){ ?>
                    <li><img id="coins" src="img/coins2.png"></li>
                    <li><p id="balance" class="cointext"><?php echo number_format($coins, 0, ".", "."); ?></p></li>
                    <li><a href="profile.php">
                        <?php if($row['profile_picture'] !== NULL){
                            ?>
                            <figure>
                            <?php echo "<img src=\"$path\">"; ?>
                            </figure>
                            <?php } else{ ?>
                            <img id="profilepic" src="img/profilepic.png" >
                            <?php } ?></a>
                    </li>
                    <div id="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                    <li><a href ="shop.php"><img id="cart" src="img/carticon2.png"><p id="shoptext">Shop</p></a></li>
                    <?php } else{ ?>
                    <li class="right"><a class="links" href="#" onclick="showlogin()">Login</a></li>
                    <li class="right"><a class="links" href="signup.php">Create Account</a></li>

               <?php } ?>
            </ul>
        </nav> 
    
        <!-- Slideshow, arrows and Torture Me button -->
        <div id="content-wrapper">
            <!-- Images of plants -->
            <img class="plant animation_left" src="img/plant1.jpg" width="100%">
            <img class="plant animation_left" src="img/plant2.jpg" width="100%">

            <!-- Display locked/unlocked plants -->
            <?php if($_SESSION['loggedin'] === TRUE && (!in_array(1, $array_orders))){ ?>
            <img class="plant animation_left" src="img/plant3_lock.jpg" width="100%">
            <?php } else { ?>
            <img class="plant animation_left" src="img/plant3.jpg" width="100%">
            <?php }
            if($_SESSION['loggedin'] === TRUE && !in_array(2, $array_orders)){ ?>
            <img class="plant animation_left" src="img/plant4_lock.jpg" width="100%">
            <?php } else { ?>
            <img class="plant animation_left" src="img/plant4.jpg" width="100%">
            <?php } ?>
            <!-- Arrow left -->
            <a onclick="plusDivs(-1)">
                <img class="leftarrow" src="img/linkerpfeil.png" width=10%>
            </a>
            <!-- Arrow right -->
            <a onclick="plusDivs(1)">
                <img class="rightarrow" src="img/rechterpfeil.png" width=10%>
            </a>
        
        <!-- 4 buttons for plant selection, either send message or open login window -->
        <?php if($_SESSION['loggedin'] === TRUE){ ?>
            <button class="accept" onclick="startTorture(1)">Torture Me!</button>
            <?php } else{ ?>
            <button class="accept" onclick="document.getElementById('loginbackground').style.display='block'">Torture Me!</button>
        <?php } ?>
        <?php if($_SESSION['loggedin'] === TRUE){ ?>
            <button class="accept" onclick="startTorture(2)">Torture Me!</button>
            <?php } else{ ?>
            <button class="accept" onclick="document.getElementById('loginbackground').style.display='block'">Torture Me!</button>
        <?php } ?>
        <?php if($_SESSION['loggedin'] === TRUE){
                if(in_array(1, $array_orders)){ ?>
                    <button class="accept" onclick="startTorture(3)">Torture Me!</button>
                <?php } else { ?>
                    <a class="buttonlink" href="shop.php"><button class="accept unavailable">Buy In Store</button></a>
                <?php }
                } else{ ?>
                    <button class="accept" onclick="document.getElementById('loginbackground').style.display='block'">Torture Me!</button>
            <?php } ?>
        <?php if($_SESSION['loggedin'] === TRUE){
                if(in_array(2, $array_orders)){ ?>
                    <button class="accept" onclick="startTorture(4)">Torture Me!</button>
                <?php } else { ?>
                    <a class="buttonlink" href="shop.php"><button class="accept unavailable">Buy In Store</button></a>
                <?php }
                } else{ ?>
                    <button class="accept" onclick="document.getElementById('loginbackground').style.display='block'">Torture Me!</button>
            <?php } ?>
    </div>
    
                 
        
        
     <!--Loginscreen-->
<!-- The Modal -->
<div id="loginbackground" class="modal">
  <span onclick="document.getElementById('loginbackground').style.display='none'"
class="close animate">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" method="POST" action="" >
     
    <p class="logintext">Login</p>
    <div class="container">
      <div class ="error" id="error"></div>
      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Username..." name="username" id="username" required>
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Password..." name="password" id="password" required>
      <label>
        <input type="checkbox" id="remember" checked="checked" name="remember"> Keep me logged in
      </label><br><br>
        New here? <a href="signup.php">Create an account here</a><br>
      <input name="submit" type="button" class="accept loginbutton enter" id="submitform" value="Login" onclick="validate()" >
      
    </div>
  </form>
</div>

        
       <!-- Bonus screen -->
        <div class="Yellowbox"></div>
        <img class="Bonusjpg" src="img/bonusscreen.jpg">
        <p class="Bonustexttop">Grab your daily bonus!</p>
        <p class="Bonustextcoins">+ 750</p>
      
        <!-- Torture Screen -->
<div id="id02" class="Torture">
<!-- would delete this piece, only quit by button -timbleman -->
    <span onclick="quitTorture(); liveshow();" class="closetorture" title="Close Modal">&times;</span>

  <!-- Modal Content -->
    <div class="Torturecontent">
        <div class="Torturecontainer"><!--10.90.1.173-->
            <iframe class="stream" id="stream" src="http://localhost:8081" ></iframe>
            <!-- needs functionality for passing torturedSec to Php -->
            <button class="Quittorture" onclick="quitTorture()">Quit Torture</button>
            <ul class="tortureul">
             <div id="cooldown_fire" class="cooldown_fire"></div>
                <div id="cooldown_bolt" class="cooldown_bolt"></div>
                <div id="cooldown_drill" class="cooldown_drill"></div>
                <div id="cooldown_acid" class="cooldown_acid"></div>
                <div id="cooldown_wind" class="cooldown_wind"></div>
            
            <!-- php checking orders for bought upgrades -->
            <?php 
            /* php variable for cooldown upgrade */
            $upcoold = 0;
            /* check if user bought upgrade */
            if(in_array(11, $array_orders)){
                $upcoold = 1;
            }
            /* drill uprade */
            $drillup = 0;
            if(in_array(10, $array_orders)){
                $drillup = 1;
            }
            /* acid uprade */
            $acidup = 0;
            if(in_array(9, $array_orders)){
                $acidup = 1;
            }
            /* bolt uprade */
            $boltup = 0;
            if(in_array(8, $array_orders)){
                $boltup = 1;
            }
            /* wind uprade */
            $windup = 0;
            if(in_array(7, $array_orders)){
                $windup = 1;
            }
            /* fire uprade */
            $fireup = 0;
            if(in_array(6, $array_orders)){
                $fireup = 1;
            }
            ?>
                
            <!-- list for torture tool buttons -->
            <!-- check if tools are bought -->
            <?php if(in_array(5, $array_orders)){ ?>
            <!-- start timer with click on icons, pass information: selected tool, if tool is upgraded, if cooldown is upgraded -->
            <li><img class="drill" src="img/drill.png" onclick="startTimer(5,<?php echo $drillup ?>,<?php echo $upcoold ?>)"></li>
            <?php } else { ?>
            <li><a href="shop.php"><img class="drill" src="img/drill_lock.png"></a></li>
            
            <?php } if(in_array(4, $array_orders)){ ?>
            <li><img class="acid" src="img/acid.png" onclick="startTimer(3,<?php echo $acidup ?>,<?php echo $upcoold ?>)"></li>
            <?php } else { ?>
            <li><a href="shop.php"><img class="acid" src="img/acid_lock.png"></a></li>
            
            <?php } if(in_array(3, $array_orders)){ ?>
            <li><img class="bolt" src="img/bolt.png" onclick="startTimer(2,<?php echo $boltup ?>,<?php echo $upcoold ?>)"></li>
            <?php } else{ ?>
            <li><a href="shop.php"><img class="bolt" src="img/bolt_lock.png"></a></li>
            <?php } ?>
            
            <!-- wind and fire are always available -->
            <li><img class="wind" src="img/wind.png" onclick="startTimer(4,<?php echo $windup ?>,<?php echo $upcoold ?>);"></li>
            <li><img class="fire" src="img/fire.png"  onclick="startTimer(1,<?php echo $fireup ?>,<?php echo $upcoold ?>)"></li>
            </ul>
            
            <!-- icon and container for timer -->
            <!-- timer ugly, style has to be changed -->
            <img class="Timericon" src="img/timer.png">
            <div class="Timerbox"><p class = "right" id="Countdown"></p></div>
        </div>
    </div>
</div>
        
    <!--Bonus screen -->
        <?php
        date_default_timezone_set("Europe/Berlin");
        $current_date = date('Y-m-d');
        if((($current_date > $last_login) || is_null($last_login)) && $_SESSION['loggedin']){ ?>
        <div id="bonus_screen">
            <div class="bonus_content">
                <img src="img/bonusscreen.jpg" class="img_bonus">
                <h1>Grab your daily bonus!</h1>
                <img class="bonus_coins" src="img/coins.png">
                <h2><?php if (in_array(12, $array_orders)){
                    echo 1500;
                } else {
                    echo 1000;
                } ?>
                </h2>
                <button class="accept bonus_button" onclick="daily_bonus(); document.getElementById('bonus_screen').style.display='none';">Thanks!</button>
            </div>
        </div>
        <?php }
        ?>    
        
        
        <!--Screen for notifying a user that another user is already playing-->
        <div id="notify_screen">
            <div class="notify_content animate">
                <h1>Another user is playing right now. Please wait a few minutes.</h1>
                <button class="accept notifybutton" onclick="document.getElementById('notify_screen').style.visibility='hidden'">OK</button>
            </div>
        </div>       

</body>
    
<!-- slidescript -->
<script>
var slideIndex = 1;
showDivs(slideIndex);
/* Get the torture screen modal */
var modal2 = document.getElementById('id02');
/* When the user clicks anywhere outside of the modal, close it */
window.onclick = function(event) {
    if (event.target == modal2) {
        quitTorture();
        modal2.style.display = "none";
    }
}
</script>
</html>
