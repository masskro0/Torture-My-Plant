<?php

// Start the session
session_start();

// Redirect user if he isn't logged in
if(!$_SESSION['loggedin']){
    header('Location: index.php');
    die();
}

// Load balance, bought items and user information
include('balance.php');
include('shopinfo.php');
include('getinfo.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Torture My Plant - Profile</title>
        <link rel="stylesheet" type="text/css" href="styles/profile.css">
        <script src="javascripts/jquery.js"></script> 
        <script src="javascripts/popup.js"></script> 
    </head>
    <body>
        <!-- Black navigation bar -->
        <div id="navbar"></div>
        <nav>
            
            <!-- Navigation bar content -->
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
                        <img id="profilepic" src="img/profilepic2.png" >
                        <?php } ?></a>
                </li>
                <div id="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                <li><a href="shop.php"><img id="cart" src="img/carticon2.png"><p id="shoptext">Shop</p></a></li>
            </ul>
        </nav>

        <!-- Profile content -->
        <div id="profileelements">
            <h1 id="myProfile">My Profile</h1>
            <?php if($row['profile_picture'] !== NULL){
            ?>
                <figure class="fig2">
                <?php echo "<img src=\"$path\">"; ?>
                </figure>
            <?php } else{ ?>
                <img id="userpicture" src="img/profilepic2.png">
            <?php } ?>
            <p class="profiletext username"><?php echo $row['username']; ?></p>
            <p class="profiletext plantstortured">Plants tortured: <?php echo number_format($row['plants_tortured'], 0, ".", "."); ?></p><br>
            <div class="buttons_profile">
                <a href="profile_edit.php"><button class="button">Edit Profile</button></a>
                <br>
                <a href="logout.php"><button class="button" href="logout.php">Logout</button></a><br>
                <a href="" class="confirmation-popup"><button class="button delete">Delete Profile</button></a>
            </div>
        </div>
            
        <!-- Display bought items -->    
        <div id ="items">
            <ul><h2>Bought Items:</h2>
                <?php if (in_array(1, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[0], 14); ?>" title="Plant: Tillandsia Caput Medusae">
                </li>
                <?php } ?>
                <?php if (in_array(2, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[1], 14); ?>" title="Plant: El Cactus">
                </li>
                <?php } ?>
                <?php if (in_array(3, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[2], 14); ?>" title="Tool: Bolt">
                </li>
                <?php } ?>
                <?php if (in_array(4, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[3], 14); ?>" title="Tool: Acid">
                </li>
                <?php } ?>
                <?php if (in_array(5, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[4], 14); ?>" title="Tool: Drill">
                </li>
                <?php } ?>
                <?php if (in_array(6, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[5], 14); ?>" title="Upgrade: Fire">
                </li>
                <?php } ?>
                <?php if (in_array(7, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[6], 14); ?>" title="Upgrade: Wind">
                </li>
                <?php } ?>
                <?php if (in_array(8, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[7], 14); ?>" title="Upgrade: Bolt">
                </li>
                <?php } ?>
                <?php if (in_array(9, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[8], 14); ?>" title="Upgrade: Acid">
                </li>
                <?php } ?>
                <?php if (in_array(10, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[9], 14); ?>" title="Upgrade: Drill">
                </li>
                <?php } ?>
                <?php if (in_array(11, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[10], 14); ?>" title="Upgrade: Less Cooldown">
                </li>
                <?php } ?>
                <?php if (in_array(12, $array_orders)){ ?>
                <li><img class="itemjpg" src="<?php echo substr($array_picture[11], 14); ?>" title="Upgrade: 50% More Coins" >
                </li>
                <?php } ?>
            </ul>
        </div>
      
        <!-- Confirmation Popup -->  
        <div class="popup" role="alert">
            <div class="popup-container">
                <p>Are you sure you want to delete your profile?</p>
                <ul class="buttons">
                    <li><a href="delete_profile.php">Yes</a></li>
                    <li><a class="popup-close" href="">No</a></li>
                </ul>
            </div> 
        </div> 
    </body>
</html>
