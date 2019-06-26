<?php include('balance.php');
include('shopinfo.php');
include('getinfo.php');
session_start();
if(!$_SESSION['loggedin']){
    header('Location: index.php');
    
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/shop.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 

    <script>
        window.value = 0;
        function getid(id){
           window.value = id; 
        }
        /* Function for buying an item when the buy button was clicked. Sends a xmlhttprequest to the buy.php script */
        function buy(id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "buy.php?q=" + id, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var str = this.responseText;
                if(str.length ==0){ 
                    document.getElementById(id).style.display = "none";
                }
                document.getElementById("error").innerHTML = this.responseText;
            }
            };
            
            // Update the balance dynamically
            // Wait 1 seconds to finish the script above
            setTimeout(1000);
            var xmlhttp2 = new XMLHttpRequest();
            // Open the balance.php script to get the newest balance of the user
            xmlhttp2.open("GET", "balance.php", true);
            // Set a request header so that balance.php knows that it's a xmlhttprequest
            xmlhttp2.setRequestHeader("HTTP_X_REQUESTED_WITH",'xmlhttprequest');
            xmlhttp2.send();
            xmlhttp2.onreadystatechange = function() {
                // Update the balance if the script is done
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("balance").innerHTML = this.responseText;
                }
            };
            
        }
    </script>
  </head>
    <body>
        <div class="wrapper">
            <div class="navbar"></div>
            <nav>
                <ul>
                    <div style="cursor: pointer;" onclick="window.location='index.php'" class="Homebutton">
                    <li><a href="index.php"><img class="Homeicon" src="img/planticon2.png"></a></li>
                    <li><a class="frontpagetext" href="index.php">Torture My Plant</a></li>
                    </div>
                    <li><img class="Coins" src="img/coins2.png"></li>
                    <li><p id="balance" class="Cointext"><?php echo $coins; ?></p></li>
                    
                    <li><a href="profile.php">
                            <?php if($row['profile_picture'] !== NULL){
                                ?>
                                <figure>
                                <?php echo "<img src=\"$path\">"; ?>
                                </figure>
                                <?php } else{ ?>
                                <img class="profilepic" src="img/profilepic.png" >
                                <?php } ?></a>
                        </li>
                    
                    <div class="rectangle"></div>
                    <li><a><img class="Cart" src="img/carticon.png"></a><p class="Shoptext">Shop</p></li>
                </ul>
            </nav>
            
            
                <h1 class="Header">Shop</h1>
                <div class ="screen">
                <div class ="error" id="error"></div>
                <?php if (!(in_array(1, $array_orders) && in_array(2, $array_orders))) { ?>
                <ul><h1 class="Categorytext">Plants</h1>
                <?php if (!in_array(1, $array_orders)){ ?>
                <li id="<?php echo $array_id[0]; ?>"><h2 class="Item"><?php echo $array_name[0]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[0], 14); ?>">
                <p class="Description"><?php echo $array_description[0]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[0]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[0]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(2, $array_orders)){ ?>
                <li id="<?php echo $array_id[1]; ?>"><h2 class="Item"><?php echo $array_name[1]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[1], 14); ?>">
                <p class="Description"><?php echo $array_description[1]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[1]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[1]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                </ul>
                <?php } ?>
                <?php if(!(in_array(3, $array_orders) && in_array(4, $array_orders) && in_array(5, $array_orders))) { ?>
                <ul>
                <h1 class="Categorytext">Tools</h1>
                <?php if (!in_array(3, $array_orders)){ ?>
                <li id="<?php echo $array_id[2]; ?>"><h2 class="Item"><?php echo $array_name[2]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[2], 14); ?>">
                <p class="Description"><?php echo $array_description[2]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[2]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[2]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(4, $array_orders)){ ?>
                <li id="<?php echo $array_id[3]; ?>"><h2 class="Item"><?php echo $array_name[3]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[3], 14); ?>">
                <p class="Description"><?php echo $array_description[3]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[3]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[3]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(5, $array_orders)){ ?>
                <li id="<?php echo $array_id[4]; ?>"><h2 class="Item"><?php echo $array_name[4]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[4], 14); ?>">
                <p class="Description"><?php echo $array_description[4]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[4]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[4]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                </ul>
                <?php } ?>
                <?php if (!(in_array(6, $array_orders) && in_array(7, $array_orders) && in_array(8, $array_orders) && in_array(9, $array_orders) && in_array(10, $array_orders) && in_array(11, $array_orders) && in_array(12, $array_orders))) { ?>
                <ul>
                <h1 class="Categorytext">Upgrades</h1>
                <?php if (!in_array(6, $array_orders)){ ?>
                <li id="<?php echo $array_id[5]; ?>"><h2 class="Item"><?php echo $array_name[5]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[5], 14); ?>">
                <p class="Description"><?php echo $array_description[5]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[5]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[5]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(7, $array_orders)){ ?>
                <li id="<?php echo $array_id[6]; ?>"><h2 class="Item"><?php echo $array_name[6]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[6], 14); ?>">
                <p class="Description"><?php echo $array_description[6]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[6]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[6]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(8, $array_orders)){ ?>
                <li id="<?php echo $array_id[7]; ?>"><h2 class="Item"><?php echo $array_name[7]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[7], 14); ?>">
                <p class="Description"><?php echo $array_description[7]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[7]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[7]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(9, $array_orders)){ ?>
                <li id="<?php echo $array_id[8]; ?>"><h2 class="Item"><?php echo $array_name[8]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[8], 14); ?>">
                <p class="Description"><?php echo $array_description[8]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[8]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[8]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(10, $array_orders)){ ?>
                <li id="<?php echo $array_id[9]; ?>"><h2 class="Item"><?php echo $array_name[9]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[9], 14); ?>">
                <p class="Description"><?php echo $array_description[9]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[9]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[9]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(11, $array_orders)){ ?>
                <li id="<?php echo $array_id[10]; ?>"><h2 class="Item"><?php echo $array_name[10]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[10], 14); ?>">
                <p class="Description"><?php echo $array_description[10]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[10]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[10]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <?php if (!in_array(12, $array_orders)){ ?>
                <li id="<?php echo $array_id[11]; ?>"><h2 class="Item"><?php echo $array_name[11]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[11], 14); ?>">
                <p class="Description"><?php echo $array_description[11]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[11]; ?></p>
                <a href="" class="confirmation-popup"><button class="Buy" onclick="getid(<?php echo $array_id[11]; ?>)">Buy</button></a>
                </li>
                <?php } ?>
                <!--
                <li><h2 class="Item">New Item</h2>
                <img class="Itemjpg" src="img/">
                <p class="Description"></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price">1000</p>
                <button class="Buy">Buy</button>
                </li> -->
                </ul>
                <?php } ?>
            </div>
        </div>
        <!------------Confirmation Popup -------------->  
        <div class="cd-popup" role="alert">
            <div class="cd-popup-container">
                <p>Are you sure you want to buy this item?</p>
                <ul class="cd-buttons">
                    <li><a onclick="buy(window.value)" class="popup-close" href="">Yes</a></li>
                    <li><a class="popup-close" href="">No</a></li>
                </ul>
            </div> 
        </div> 
    </body>
    
    <script>
    
    /* Script for the confirmation popup */
    jQuery(document).ready(function($){
	// open popup
	$('.confirmation-popup').on('click', function(event){
		event.preventDefault();
		$('.cd-popup').addClass('is-visible');
	});
	
	// close popup
	$('.cd-popup').on('click', function(event){
		if( $(event.target).is('.popup-close') || $(event.target).is('.cd-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	// close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.cd-popup').removeClass('is-visible');
	    }
    });
    });
    </script>
</html>