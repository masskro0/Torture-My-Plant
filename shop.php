<?php 
// Start the session
session_start();

// Redirect user to the homepage if he isn't logged in
if(!$_SESSION['loggedin']){
    header('Location: index.php');
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
        <title>Torture some plants - Shop</title>
        <link rel="stylesheet" type="text/css" href="styles/shop.css">
        <script src="javascripts/jquery.js"></script> 
        <script src="javascripts/shop.js"></script> 
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
                <div class="rectangle"></div>
                <li><a><img class="Cart" src="img/carticon.png"></a><p class="Shoptext">Shop</p></li>
            </ul>
        </nav>

        <!-- Shop content -->
        <h1 class="header">Shop</h1>
        <div class ="screen">
            
            <!-- Display only items which haven't been bought yet -->
            <?php if (!(in_array(1, $array_orders) && in_array(2, $array_orders))) { ?>
                <ul><h1 class="categorytext">Plants</h1>
                <?php if (!in_array(1, $array_orders)){ ?>
                <li id="<?php echo $array_id[0]; ?>"><h2><?php echo $array_name[0]; ?></h2>
                <img class="itemjpg plant" src="<?php echo substr($array_picture[0], 14); ?>">
                <p class="description"><?php echo $array_description[0]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[0], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[0]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(2, $array_orders)){ ?>
                <li id="<?php echo $array_id[1]; ?>"><h2><?php echo $array_name[1]; ?></h2>
                <img class="itemjpg plant" src="<?php echo substr($array_picture[1], 14); ?>">
                <p class="description"><?php echo $array_description[1]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[1], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[1]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                </ul>
            <?php } ?>
            <?php if(!(in_array(3, $array_orders) && in_array(4, $array_orders) && in_array(5, $array_orders))) { ?>
                <ul>
                <h1 class="categorytext">Tools</h1>
                <?php if (!in_array(3, $array_orders)){ ?>
                <li id="<?php echo $array_id[2]; ?>"><h2><?php echo $array_name[2]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[2], 14); ?>">
                <p class="description"><?php echo $array_description[2]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[2], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[2]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(4, $array_orders)){ ?>
                <li id="<?php echo $array_id[3]; ?>"><h2><?php echo $array_name[3]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[3], 14); ?>">
                <p class="description"><?php echo $array_description[3]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[3], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[3]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(5, $array_orders)){ ?>
                <li id="<?php echo $array_id[4]; ?>"><h2><?php echo $array_name[4]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[4], 14); ?>">
                <p class="description"><?php echo $array_description[4]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[4], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[4]; ?>)">Buy</button></a>
                    </li>
                <?php } ?>
                </ul>
            <?php } ?>
            <?php if (!(in_array(6, $array_orders) && in_array(7, $array_orders) && in_array(8, $array_orders) && in_array(9, $array_orders) && in_array(10, $array_orders) && in_array(11, $array_orders) && in_array(12, $array_orders))) { ?>
                <ul>
                <h1 class="categorytext">Upgrades</h1>
                <?php if (!in_array(6, $array_orders)){ ?>
                <li id="<?php echo $array_id[5]; ?>"><h2><?php echo $array_name[5]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[5], 14); ?>">
                <p class="description"><?php echo $array_description[5]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[5], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[5]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(7, $array_orders)){ ?>
                <li id="<?php echo $array_id[6]; ?>"><h2><?php echo $array_name[6]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[6], 14); ?>">
                <p class="description"><?php echo $array_description[6]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[6], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[6]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(8, $array_orders)){ ?>
                <li id="<?php echo $array_id[7]; ?>"><h2><?php echo $array_name[7]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[7], 14); ?>">
                <p class="description"><?php echo $array_description[7]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[7], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[7]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(9, $array_orders)){ ?>
                <li id="<?php echo $array_id[8]; ?>"><h2><?php echo $array_name[8]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[8], 14); ?>">
                <p class="description"><?php echo $array_description[8]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[8], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[8]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(10, $array_orders)){ ?>
                <li id="<?php echo $array_id[9]; ?>"><h2><?php echo $array_name[9]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[9], 14); ?>">
                <p class="description"><?php echo $array_description[9]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[9], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[9]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(11, $array_orders)){ ?>
                <li id="<?php echo $array_id[10]; ?>"><h2><?php echo $array_name[10]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[10], 14); ?>">
                <p class="description"><?php echo $array_description[10]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[10], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[10]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(12, $array_orders)){ ?>
                <li id="<?php echo $array_id[11]; ?>"><h2><?php echo $array_name[11]; ?></h2>
                <img class="itemjpg" src="<?php echo substr($array_picture[11], 14); ?>">
                <p class="description"><?php echo $array_description[11]; ?></p>
                <img class="coinicon" src="img/coins.png">
                <p class="price"><?php echo number_format($array_price[11], 0, ".", "."); ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[11]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                </ul>
            <?php } ?>
        </div>
        
        <!-- Confirmation popup -->  
        <div class="popup" role="alert">
            <div class="popup-container">
                <p>Are you sure you want to buy this item?</p>
                <ul class="buttons">
                    <li><a onclick="buy(window.value)" class="popup-close" href="">Yes</a></li>
                    <li><a class="popup-close" href="">No</a></li>
                </ul>
            </div> 
        </div> 
        
        <!-- Screen for notifying a user that another user is already playing -->
        <div id="notify_screen">
            <div class="notify_content animate">
                <h1>Not enough coins to buy this item!</h1>
                <button class="Buy notifybutton" onclick="document.getElementById('notify_screen').style.visibility='hidden'">OK</button>
            </div>
        </div>  
    </body>
</html>