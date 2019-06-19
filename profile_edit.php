<?php include('getinfo.php'); ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/profile_edit.css">
    <!-- JQuery library -->
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      
      
      
    <script>
         /* Asynchronous call of the validation script login.php to display without refreshing the page. Refreshes the pages if everything is ok. */
        function validate() {
        var text;
        var username = document.getElementById('username');
        var email = document.getElementById('email');
        var password_old = document.getElementById('password_old');
        var password_new1 = document.getElementById('password_new1');
        var password_new2 = document.getElementById('password_new2');
        
        var xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.text = this.responseText;
                document.getElementById("error").innerHTML = this.responseText;
                var str = this.responseText;
                // Go to the profile if there are no errors
                if(str.length ==0){ 
                    window.location.replace("profile.php");
                }
            }
        };
        xmlhttp.open("POST", "edit_info.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("username=" + username.value + "&email=" + email.value + "&password_old=" + password_old.value + "&password_new1=" + password_new1.value + "&password_new2=" + password_new2.value);
        }
        
      </script>
      
      
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
                    <li><p class="Cointext">1000</p></li>
                    <li><a href="profile.php"><img class="profilepic" src="img/profilepic.png" width=8%></a></li>
                    <div class="rectangle"></div>
                    <li><a><img class="Cart" src="img/carticon.png"></a><p class="Shoptext">Shop</p></li>
                </ul>
            </nav>
            
            <div class="greyscreen">
            <h1 class="EditProfile">Edit Your Profile</h1>
               
             <div class="screen"> 
                 
                 
            <form form method="post" action="" enctype="multipart/form-data">
                <div class ="error" id="error"></div>

                 <img class="Profilepicture" src="img/profilepic.png">
                <input type="file" name="image" onchange="readURL(this);" accept="image/jpeg" style="display:none;" id="file">
                <figure>
                    <?php if ($path !== NULL){
                        echo "<img class=\"figimg\" id=\"figimg\" src=\"$path\">";
                    } ?>
                    <img id="uploaded" src="">

                </figure>
                <input type="button" class="Normal" value="Change Profile Picture" onclick="document.getElementById('file').click();"> 
                            
            
            <label for="username"><b>Enter username</b></label>
            <?php echo "<input type=\"text\" placeholder=\"Enter new username...\" name=\"username\" id=\"username\" value=\"$uname\" required>";
            ?>
            <label for="email"><b>Enter E-Mail Adress</b></label>
            <?php echo "<input type=\"text\" placeholder=\"Enter your e-mail adress...\" name=\"email\" id=\"email\" value=\"$email\" required>";
            ?>
            <label for="password"><b>Old Password</b></label>
            <input type="password" placeholder="Enter your old password..." name="password_old" id="password_old" required>
            <label for="password"><b>New Password</b></label>
            <input type="password" placeholder="Enter your new password..." name="password_new1" id="password_new1" required>
            <label for="password"><b>Repeat New Password</b></label>
            <input type="password" placeholder="Repeat your new password..." name="password_new2" id="password_new2" required>
            
            <input name="submit" type="submit" class="Accept Normal" id="submitform" value="Accept Changes">
            </form>
             </div>
            
            <a href="profile.php"><button class="Cancel Normal">Cancel</button></a>
            </div>
        </div>
    </body>
    
    <script>
        /* Submit the form if the user hits the enter key */
        var input = document.getElementById("username");
        var input2 = document.getElementById("email");
        var input3 = document.getElementById("password_old");
        var input4 = document.getElementById("password_new1");
        var input5 = document.getElementById("password_new2");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("submitform").click();
            }
        });
        input2.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("submitform").click();
            }
        });
        input3.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("submitform").click();
            }
        });
        input4.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("submitform").click();
            }
        });
        input5.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("submitform").click();
            }
        });

        /* Display the userpicture if he selected a new one */
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#uploaded')
                        .attr('src', e.target.result);
                };
                
                reader.readAsDataURL(input.files[0]);
                document.getElementById("uploaded").style.display = "block"; 
                document.getElementById("figimg").style.display = "none";
            }
        }
</script>

</html>
