<?php include('balance.php');
include('getinfo.php');
include('edit_info.php');
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/profile_edit.css">
    <script src="javascripts/jquery.js"></script> 
    <!--  Testen ob es ohne geht
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    -->
  </head>
    
    <body>
        <div class="navigation">
            <div class="navbar"></div>
        <nav>
                <ul>
                    <div style="cursor: pointer;" onclick="window.location='index.php'" class="Homebutton">
                    <li><a href="index.php"><img class="Homeicon" src="img/planticon2.png"></a></li>
                    <li><a class="frontpagetext" href="index.php">Torture My Plant</a></li>
                    </div>
                    <li><img class="Coins" src="img/coins2.png"></li>
                    <li><p class="Cointext"><?php echo number_format($coins, 0, ".", "."); ?></p></li>
                    
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
                    
                    <div class="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                    <li><a href="shop.php"><img class="Cart" src="img/carticon2.png"><p class="Shoptext">Shop</p></a></li>
                </ul>
            </nav>
        
        </div>
        
        
        <div class="screen">
        <h1 class="EditProfile">Edit Your Profile</h1>
            
        <form method="post" action="" enctype="multipart/form-data">
            <div class="container">
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
            <input type="button" class="uploadbutton accept" value="Change Picture" onclick="document.getElementById('file').click();">     
                            
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
            
            <input name="submit" type="submit" class="Accept Normal" id="submitform" value="Accept Changes" >
            <a class="Cancel" href="profile.php">Cancel</a>
            </div>
            
        </form>
        </div>       
    </body>
    
    <script> 
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#uploaded')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
                document.getElementById("uploaded").style.display = "block"; 
            }
        }
    </script>
</html>
