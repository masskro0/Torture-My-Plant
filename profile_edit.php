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
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

  </head>
    
    <body>
        <div class="navbar">
        <nav>
                <ul>
                    <div class="Homebutton">
                    <li><a href="index.php"><img class="Homeicon" src="img/planticon.png"></a></li>
                    <li><a class="frontpagetext" href="index.php">Torture My Plant</a></li>
                    </div>
                    <li><img class="Coins" src="img/coins.png"></li>
                    <li><p class="Cointext"><?php echo $coins; ?></p></li>
                    <li><a href="profile.php"><img class="profilepic" src="img/profilepic.png" width=8%></a></li>
                    <div class="rectangle"></div>
                    <li><a href="shop.php"><img class="Cart" src="img/carticon.png"><p class="Shoptext">Shop</p></a></li>
                </ul>
            </nav>
        
        </div>
        
        
        <div class="screen">
        <h1 class="EditProfile">Edit Your Profile</h1>
            
        <form method="post" action="" enctype="multipart/form-data">
            <div class="container">
            <?php include('errors.php'); ?>
            <?php echo "<img class=\"userpic\" src=\"$path\">"; ?>
              
            <input type="file" name="image" onchange="readURL(this);" accept="image/jpeg" style="display:none;" id="file">
            <figure>
            <img id="uploaded" src="#"/>
            </figure>
            <input type="button" class="uploadbutton accept" value="Change Picture" onclick="document.getElementById('file').click();">     
                            
            <label for="username"><b>Enter username</b></label>
            <?php echo "<input type=\"text\" placeholder=\"Enter your username...\" name=\"username\" id=\"username\" value=\"$uname\" required>";
            ?>
            
            <label for="email"><b>Enter E-Mail Adress</b></label>
            <?php echo "<input type=\"text\" placeholder=\"Enter your e-mail adress...\" name=\"email\" id=\"email\" value=\"$email\" required>";
            ?>
            <label for="password"><b>Old Password</b></label>
            <?php echo "<input type=\"password\" placeholder=\"Enter your old password...\" name=\"password_old\" id=\"password_old\" value =\"$psw_old\" required>"; ?>
            <label for="password"><b>New Password</b></label>
            <?php echo "<input type=\"password\" placeholder=\"Enter your new password...\" name=\"password_new1\" id=\"password_new1\" value=\"$psw_new1\" required>"; ?>
            <label for="password"><b>Repeat New Password</b></label>
            <?php echo"<input type=\"password\" placeholder=\"Repeat your new password...\" name=\"password_new2\" id=\"password_new2\" value=\"$psw_new2\" required>"; ?>
            
            <input name="submit" type="submit" class="Accept Normal" id="submitform" value="Accept Changes" >
            <a href="profile.php"><button class="Cancel Normal">Cancel</button></a>
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
