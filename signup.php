<?php include('register.php') ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/signup.css">
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

  </head>
    
    <body>

        <div class="headleiste">
                    <a href="index.php"><img class="linkerpfeil" src="img/linkerpfeil.png"></a>
            <div class="kind">
        
        
        <p class="Header">Sign Up</p>
        </div>
        </div>
        <div class="screen">
        
        <form method="post" action="" enctype="multipart/form-data">
            <div class="container">
            <?php include('errors.php'); ?>
            <img class="profilepic" src="img/profilepic.png" width=8%>
              
            <input type="file" name="image" onchange="readURL(this);" accept="image/jpeg" style="display:none;" id="file">
            <figure>
            <img id="uploaded" src="#"/>
            </figure>
            <input type="button" class="uploadbutton accept" value="Upload Profile Picture" onclick="document.getElementById('file').click();">     
                            
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Username..." name="username" required>
            <label for="email"><b>E-Mail Adress</b></label>
            <input type="text" placeholder="E-Mail..." name="email" required>
            <label for="password1"><b>Password</b></label>
            <input type="password" placeholder="Password..." name="password1" required>
            <label for="password2"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password..." name="password2" required>
            
            <input name="submit" class="accept signupbutton" type="submit" value="Sign Up">
                
      
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
