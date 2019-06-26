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
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
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
                    <li><p class="Cointext"><?php echo $coins; ?></p></li>
                    <li><a><img class="profilepic" src="img/profilepic2.png" width=8%></a></li>
                    <div class="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                    <li><a href="shop.php"><img class="Cart" src="img/carticon2.png"><p class="Shoptext">Shop</p></a></li>
                </ul>
            </nav>
                
            
            <div class="Profileelements">
                <h1 class="MyProfile">My Profile</h1>
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
                <!--<a href="delete_profile.php"><button class="Normal Delete">Delete Profile</button></a>-->
                <a href="" class="confirmation-popup"><button class="Normal Delete">Delete Profile</button></a>

                </div>
                
                
        </div>
      
        <!------------Confirmation Popup -------------->  
        <div class="cd-popup" role="alert">
            <div class="cd-popup-container">
                <p>Are you sure you want to delete your profile?</p>
                <ul class="cd-buttons">
                    <li><a href="delete_profile.php">Yes</a></li>
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
