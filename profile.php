<?php include('balance.php');
include('getinfo.php');
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/profile.css">
  </head>
    <body>
            <div class="wrapper">
            <nav>
                <ul>
                    <div class="Homebutton">
                    <li><a href="index.php"><img class="Homeicon" src="img/planticon.png"></a></li>
                    <li><a class="frontpagetext" href="index.php">Torture My Plant</a></li>
                    </div>
                    <li><img class="Coins" src="img/coins.png"></li>
                    <li><p class="Cointext"><?php echo $coins; ?></p></li>
                    <li><a><img class="profilepic" src="img/profilepic.png" width=8%></a></li>
                    <div class="rectangle"></div>
                    <li><a href="shop.php"><img class="Cart" src="img/carticon.png"><p class="Shoptext">Shop</p></a></li>
                </ul>
            </nav>
                
            <h1 class="MyProfile">My Profile</h1>
            <div class="Profileelements">
                <?php if($row['profile_picture'] !== NULL){
                ?>
                <figure>
                <?php echo "<img src=\"$path\">"; ?>
                </figure>
                <?php } else{ ?>
                <img class="Userpicture" src="img/profilepic.png">
                <?php } ?>
                
                <p class="Profiletext Username"><?php echo $row['username']; ?></p>
                <p class="Profiletext Plantstortured">Plants tortured: <?php echo $row['plants_tortured']; ?></p><br>
                <a href="profile_edit.php"><button class="Normal">Edit Profile</button></a>
                <br>
                <a href="logout.php"><button class="Normal Logout" href="logout.php">Logout</button></a><br>
                <a href="delete_profile.php"><button class="Normal Delete">Delete Profile</button></a>
                </div>
        </div>
    </body>
</html>
