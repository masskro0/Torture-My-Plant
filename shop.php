<?php include('shopinfo.php');
if(!$_SESSION['loggedin']){
    header('Location: index.php');
}?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/shop.css">
    <script>
        /* Function for buying an item when the buy button was clicked. Sends a xmlhttprequest to the buy.php script */
        function buy(id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "buy.php?q=" + id, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //location.reload();
                var str = this.responseText;
                // Refresh page if there are no errors
                if(str.length ==0){ 
                    document.getElementById(id).style.display = "none";
                }
                document.getElementById("error").innerHTML = this.responseText;
            }
            };
            
        }
    </script>
  </head>
    <body>
        <div class="wrapper">
            <nav>
                <ul>
                    <div class="Homebutton">
                    <li><a href="index.html"><img class="Homeicon" src="img/planticon.png"></a></li>
                    <li><a class="frontpagetext" href="index.php">Torture My Plant</a></li>
                    </div>
                    <li><img class="Coins" src="img/coins.png"></li>
                    <li><p class="Cointext">1000</p></li>
                    <li><a href="profile.php"><img class="profilepic" src="img/profilepic.png" width=8%></a></li>
                    <div class="rectangle"></div>
                    <li><a><img class="Cart" src="img/carticon.png"></a><p class="Shoptext">Shop</p></li>
                </ul>
            </nav>
            
            
                <h1 class="Header">Shop</h1>
                <div class ="screen">
                <div class ="error" id="error"></div>
                <ul><h1 class="Categorytext">Plants</h1>
                <?php if (!in_array(1, $array_orders)){ ?>
                <li id="<?php echo $array_id[0]; ?>"><h2 class="Item"><?php echo $array_name[0]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[0], 14); ?>">
                <p class="Description"><?php echo $array_description[0]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[0]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[0]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(2, $array_orders)){ ?>
                <li id="<?php echo $array_id[1]; ?>"><h2 class="Item"><?php echo $array_name[1]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[1], 14); ?>">
                <p class="Description"><?php echo $array_description[1]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[1]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[1]; ?>)">Buy</button>
                </li>
                <?php } ?>
                </ul>
                <ul>
                <h1 class="Categorytext">Tools</h1>
                <?php if (!in_array(3, $array_orders)){ ?>
                <li id="<?php echo $array_id[2]; ?>"><h2 class="Item"><?php echo $array_name[2]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[2], 14); ?>">
                <p class="Description"><?php echo $array_description[2]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[2]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[2]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(4, $array_orders)){ ?>
                <li id="<?php echo $array_id[3]; ?>"><h2 class="Item"><?php echo $array_name[3]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[3], 14); ?>">
                <p class="Description"><?php echo $array_description[3]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[3]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[3]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(5, $array_orders)){ ?>
                <li id="<?php echo $array_id[4]; ?>"><h2 class="Item"><?php echo $array_name[4]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[4], 14); ?>">
                <p class="Description"><?php echo $array_description[4]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[4]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[4]; ?>)">Buy</button>
                </li>
                <?php } ?>
                </ul>
                <ul>
                <h1 class="Categorytext">Upgrades</h1>
                <?php if (!in_array(6, $array_orders)){ ?>
                <li id="<?php echo $array_id[5]; ?>"><h2 class="Item"><?php echo $array_name[5]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[5], 14); ?>">
                <p class="Description"><?php echo $array_description[5]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[5]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[5]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(7, $array_orders)){ ?>
                <li id="<?php echo $array_id[6]; ?>"><h2 class="Item"><?php echo $array_name[6]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[6], 14); ?>">
                <p class="Description"><?php echo $array_description[6]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[6]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[6]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(8, $array_orders)){ ?>
                <li id="<?php echo $array_id[7]; ?>"><h2 class="Item"><?php echo $array_name[7]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[7], 14); ?>">
                <p class="Description"><?php echo $array_description[7]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[7]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[7]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(9, $array_orders)){ ?>
                <li id="<?php echo $array_id[8]; ?>"><h2 class="Item"><?php echo $array_name[8]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[8], 14); ?>">
                <p class="Description"><?php echo $array_description[8]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[8]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[8]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(10, $array_orders)){ ?>
                <li id="<?php echo $array_id[9]; ?>"><h2 class="Item"><?php echo $array_name[9]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[9], 14); ?>">
                <p class="Description"><?php echo $array_description[9]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[9]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[9]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(11, $array_orders)){ ?>
                <li id="<?php echo $array_id[10]; ?>"><h2 class="Item"><?php echo $array_name[10]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[10], 14); ?>">
                <p class="Description"><?php echo $array_description[10]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[10]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[10]; ?>)">Buy</button>
                </li>
                <?php } ?>
                <?php if (!in_array(12, $array_orders)){ ?>
                <li id="<?php echo $array_id[11]; ?>"><h2 class="Item"><?php echo $array_name[11]; ?></h2>
                <img class="Itemjpg" src="<?php echo substr($array_picture[11], 14); ?>">
                <p class="Description"><?php echo $array_description[11]; ?></p>
                <img class="Coinicon" src="img/coins.png">
                <p class="Price"><?php echo $array_price[11]; ?></p>
                <button class="Buy" onclick="buy(<?php echo $array_id[11]; ?>)">Buy</button>
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
            </div>
        </div>
    </body>
</html>