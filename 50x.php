<?php
session_start();
include('balance.php');
if($_SESSION['loggedin']){
    include('getinfo.php');
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/errorpage.css">
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
                    <?php if($_SESSION['loggedin'] === TRUE){ ?>
                        <li><img class="Coins" src="img/coins2.png"></li>
                        <li><p class="Cointext"><?php echo number_format($coins, 0, ".", "."); ?></p></li>
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
                        
                    
                        <!--<li><a href="profile.php"><img class="profilepic" src="img/profilepic.png" ></a></li>
                    -->
                        <div class="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                        <li><a href ="shop.php"><img class="Cart" src="img/carticon2.png"><p class="Shoptext">Shop</p></a></li>
                        <?php } else{ ?>
                        <li class="right"><a class="linkz" href="#" onclick="document.getElementById('id01').style.display='block'">Login</a></li>
                        <li class="right"><a class="linkz" href="signup.php">Create Account</a></li>
                    
                   <?php } ?>
                </ul>
            </nav>
        </div>
        <h1 class="errornumber">Error 50x</h1>
        <h1 class="errormessage">Something went wrong... We are trying to fix this problem!</h1>
        <img class="errorplant" src="img/planticon.png">
        <img class="errorplant2" src="img/planticon.png">
        <a class="goback" href="index.php"><h1 class="goback">Take me back to the homepage!</h1></a>
             
    
    
    
    
    </body>
</html>