<?php
session_start();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torture some plants. It's up to you how.</title>
    <link rel="stylesheet" type="text/css" href="styles/index.css">
      
    <script>
         /* Asynchronous call of the validation script login.php to display without refreshing the page. Refreshes the pages if everything is ok. */
        function validate() {
        var text;
        var uname = document.getElementById('username');
        var psw = document.getElementById('password');
        var xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.text = this.responseText;
                document.getElementById("error").innerHTML = this.responseText;
                var str = this.responseText;
                if(str.length ==0){ window.location.replace("index.php");
                }
            }
        };
        xmlhttp.open("POST", "login.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("username=" + uname.value + "&password=" + psw.value);
        }
        function tool(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "client.php?q=" + str, true);
        xmlhttp.send();
        }
    </script>

      
  </head>
    <body>
    
    <div class="wrapper">
            <nav>
                <ul>
                    <div class="Homebutton">
                    <li><a href="#"><img class="Homeicon" src="img/planticon.png"></a></li>
                    <li><a class="frontpagetext" href="">Torture My Plant</a></li>
                    </div>
                    <?php if($_SESSION['loggedin'] === TRUE){ ?>
                        <li><img class="Coins" src="img/coins.png"></li>
                        <li><p class="Cointext">1000</p></li>
                        <li><a href="profile.php"><img class="profilepic" src="img/profilepic.png" ></a></li>
                        <div class="rectangle"></div>
                        <li><a><img class="Cart" src="img/carticon.png"></a><p class="Shoptext">Shop</p></li>
                        <?php } else{ ?>
                        <li class="right"><a href="#" onclick="document.getElementById('id01').style.display='block'">Login</a></li>
                        <li class="right"><a href="signup.php">Create Account</a></li>
                   <?php } ?>
                </ul>
            </nav>
        </div>    
    
    
    <!--Slideshow and Buttons-->
    <div id="livestream">
        
            <img class="pflanze" src="img/plant1.jpg" width=30%>
            <img class="pflanze" src="img/plant2.jpg" width=30%>
            <img class="pflanze" src="img/plant3.jpg" width=30%>
            <img class="pflanze" src="img/plant4.jpg" width=30%>
        <!--arrow left-->
        <a onclick="plusDivs(-1)">
            <img class="linkerpfeil" src="img/linkerpfeil.png" width=10%>
        </a>
        <!--arrow right-->
        <a onclick="plusDivs(1)">
            <img class="rechterpfeil" src="img/rechterpfeil.png" width=10%>
        </a>
        
        <?php if($_SESSION['loggedin'] === TRUE){ ?>
        <button class="accept" onclick="document.getElementById('id02').style.display='block'">Torture Me!</button>
        <?php } else{ ?>
        <button class="accept" onclick="document.getElementById('id01').style.display='block'">Torture Me!</button>
        <?php } ?>
        <!--<img class="Lock" src="img/lock.png">-->
    </div>
    <a class="logout" href="logout.php">logout</a>
    
     <!--Loginscreen-->
    
<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close">&times;</span>

  <!-- Modal Content -->
  <form class="modal-content animate" method="POST" action="" >
     
    <p class="logintext">Login</p>
    <div class="container">
      <div class ="error" id="error"></div>
      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Username..." name="username" id="username" required>
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Password..." name="password" id="password" required>
        <label>
            <input type="checkbox" checked="checked" name="remember"> Keep me logged in
        </label>
      <input name="submit" type="button" class="accept loginbutton enter" id="submitform" value="Login" onclick="validate()" >
      
    </div>
  </form>
</div>
        
        
       <!-- Bonus screen -->
        <div class="Yellowbox"></div>
        <img class="Bonusjpg" src="img/bonusscreen.jpg">
        <p class="Bonustexttop">Grab your daily bonus!</p>
        <p class="Bonustextcoins">+ 1000</p>
      
        <!-- Torture Screen -->
<div id="id02" class="Torture">
  <span onclick="document.getElementById('id02').style.display='none'" onclick="liveshow()"
class="closetorture" title="Close Modal">&times;</span>

  <!-- Modal Content -->
    <div class="Torturecontent">
        <div class="Torturecontainer">
            <iframe class="stream" id="stream" src="http://localhost:8081" ></iframe>
            <button class="Quittorture" >Quit Torture</button>
            <ul class="tortureul">
            <li><img class="drill" src="img/drill.png" onclick="tool(5)"></li>
            <li><img class="wind" src="img/wind.png" onclick="tool(4);"></li>
            <li><img class="acid" src="img/acid.png" onclick="tool(3)"></li>
            <li><img class="bolt" src="img/bolt.png" onclick="tool(2)"></li>
            <li><img class="fire" src="img/fire.png"  onclick="tool(1)"></li>
            </ul>
            <img class="Timericon" src="img/timer.png">
            <div class="Timerbox"></div>
        </div>
    </div>
</div>
        
        
    </body>


    
<!-- slidescript -->
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n){
    showDivs(slideIndex += n);
}

function showDivs(n){
    var i;
    var x = document.getElementsByClassName("pflanze")
    console.log(x.length);
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length}
    for (i = 0; i < x.length; i++){
        x[i].style.display = "none";
    }
    x[slideIndex-1].style.display = "block";
}
</script>

  
<script>
// Get the modal
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
window.onclick = function(event) {
  if (event.target == modal2) {
    modal.style.display = "none";
  }
}
var input = document.getElementById("username");
var input2 = document.getElementById("password");
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
</script>
</html>
