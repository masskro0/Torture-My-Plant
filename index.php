<?php
include('balance.php');
include('getinfo_index.php');
session_start();
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
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
                // Refresh page if there are no errors
                if(str.length ==0){ 
                    window.location.replace("index.php");
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
    
        
        /* method for starting torture, gets plant number, opens torture screen */
        function startTorture(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "clientRobot.php?q=" + str, true);
            xmlhttp.send();
            document.getElementById('id02').style.display='block';
            console.log('plant ' + str + ' selected');
        }
        
        
        


        
    </script>
      
  </head>
    <body>
    
    <div class="wrapper">
        <div class="navbar"></div>
            <nav>
                <ul>
                    <div class="Homebutton">
                    <li><a href=""><img class="Homeicon" src="img/planticon.png"></a></li>
                    <li><a class="frontpagetext" href="">Torture My Plant</a></li>
                    </div>
                    <?php if($_SESSION['loggedin'] === TRUE){ ?>
                        <li><img class="Coins" src="img/coins2.png"></li>
                        <li><p class="Cointext"><?php echo $coins; ?></p></li>
                        <li><a href="profile.php"><img class="profilepic" src="img/profilepic.png" ></a></li>
                        <div class="rectangle" style="cursor: pointer;" onclick="window.location='shop.php'"></div>
                        <li><a href ="shop.php"><img class="Cart" src="img/carticon2.png"><p class="Shoptext">Shop</p></a></li>
                        <?php } else{ ?>
                        <li class="right"><a class="linkz" href="#" onclick="document.getElementById('id01').style.display='block'">Login</a></li>
                        <li class="right"><a class="linkz" href="signup.php">Create Account</a></li>
                        
                   <?php } ?>
                </ul>
            </nav>
        </div>    
    
    <div id="livestream">
        <!--plant images, should most likely be placed inside a container-->
        <img class="pflanze" src="img/plant1.jpg" width="30%">
        <img class="pflanze" src="img/plant2.jpg" width="30%">
        
        <?php if($_SESSION['loggedin'] === TRUE && (!in_array(1, $array_orders))){ ?>
        <img class="pflanze" src="img/plant3_lock.jpg" width="30%">
        <?php } else { ?>
        <img class="pflanze" src="img/plant3.jpg" width="30%">
        <?php }
        if($_SESSION['loggedin'] === TRUE && !in_array(2, $array_orders)){ ?>
        <img class="pflanze" src="img/plant4_lock.jpg" width="30%">
        <?php } else { ?>
        <img class="pflanze" src="img/plant4.jpg" width="30%">
        <?php } ?>
        <!--arrow left-->
        <a onclick="plusDivs(-1)">
            <img class="linkerpfeil" src="img/linkerpfeil.png" width=10%>
        </a>
        <!--arrow right-->
        <a onclick="plusDivs(1)">
            <img class="rechterpfeil" src="img/rechterpfeil.png" width=10%>
        </a>
        
        <!-- 4 buttons for plant selection, either send message or open login window -->
        <?php if($_SESSION['loggedin'] === TRUE){ ?>
            <button class="accept" onclick="startTorture(1)">Torture Me!</button>
            <?php } else{ ?>
            <button class="accept" onclick="document.getElementById('id01').style.display='block'">Torture Me!</button>
        <?php } ?>
        <?php if($_SESSION['loggedin'] === TRUE){ ?>
            <button class="accept" onclick="startTorture(2)">Torture Me!</button>
            <?php } else{ ?>
            <button class="accept" onclick="document.getElementById('id01').style.display='block'">Torture Me!</button>
        <?php } ?>
        <?php if($_SESSION['loggedin'] === TRUE){
                if(in_array(1, $array_orders)){ ?>
                    <button class="accept" onclick="startTorture(3)">Torture Me!</button>
                <?php } else { ?>
                    <a class="buttonlink" href="shop.php"><button class="accept unavailable">Buy In Store</button></a>
                <?php }
                } else{ ?>
                    <button class="accept" onclick="document.getElementById('id01').style.display='block'">Torture Me!</button>
            <?php } ?>
        <?php if($_SESSION['loggedin'] === TRUE){
                if(in_array(2, $array_orders)){ ?>
                    <button class="accept" onclick="startTorture(4)">Torture Me!</button>
                <?php } else { ?>
                    <a class="buttonlink" href="shop.php"><button class="accept unavailable">Buy In Store</button></a>
                <?php }
                } else{ ?>
                    <button class="accept" onclick="document.getElementById('id01').style.display='block'">Torture Me!</button>
            <?php } ?>
        
    </div>
    
     <!--Loginscreen-->
<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close animate">&times;</span>

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
<!-- would delete this piece, only quit by button -timbleman -->
<span onclick="document.getElementById('id02').style.display='none'" onclick="liveshow()"
class="closetorture" title="Close Modal">&times;</span>

  <!-- Modal Content -->
    <div class="Torturecontent">
        <div class="Torturecontainer">
            <iframe class="stream" id="stream" src="http://localhost:8081" ></iframe>
            <!-- needs functionality for passing torturedSec to Php -->
            <button class="Quittorture" onclick="quitTorture()">Quit Torture</button>
            <ul class="tortureul">
             <div id="cooldown_fire" class="cooldown_fire"></div>
                <div id="cooldown_bolt" class="cooldown_bolt"></div>
                <div id="cooldown_drill" class="cooldown_drill"></div>
                <div id="cooldown_acid" class="cooldown_acid"></div>
                <div id="cooldown_wind" class="cooldown_wind"></div>
            
            <!-- php checking orders for bought upgrades -->
            <?php 
            /* php variable for cooldown upgrade */
            $upcoold = 0;
            /* check if user bought upgrade */
            if(in_array(11, $array_orders)){
                $upcoold = 1;
            }
            /* drill uprade */
            $drillup = 0;
            if(in_array(10, $array_orders)){
                $drillup = 1;
            }
            /* acid uprade */
            $acidup = 0;
            if(in_array(9, $array_orders)){
                $acidup = 1;
            }
            /* bolt uprade */
            $boltup = 0;
            if(in_array(8, $array_orders)){
                $boltup = 1;
            }
            /* wind uprade */
            $windup = 0;
            if(in_array(7, $array_orders)){
                $windup = 1;
            }
            /* fire uprade */
            $fireup = 0;
            if(in_array(6, $array_orders)){
                $fireup = 1;
            }
            ?>
                
            <!-- list for torture tool buttons -->
            <!-- check if tools are bought -->
            <?php if(in_array(5, $array_orders)){ ?>
            <!-- start timer with click on icons, pass information: selected tool, if tool is upgraded, if cooldown is upgraded -->
            <li><img class="drill" src="img/drill.png" onclick="startTimer(5,<?php echo $drillup ?>,<?php echo $upcoold ?>)"></li>
            <?php } else { ?>
            <li><a href="shop.php"><img class="drill" src="img/drill_lock.png"></a></li>
            
            <?php } if(in_array(4, $array_orders)){ ?>
            <li><img class="acid" src="img/acid.png" onclick="startTimer(3,<?php echo $acidup ?>,<?php echo $upcoold ?>)"></li>
            <?php } else { ?>
            <li><a href="shop.php"><img class="acid" src="img/acid_lock.png"></a></li>
            
            <?php } if(in_array(3, $array_orders)){ ?>
            <li><img class="bolt" src="img/bolt.png" onclick="startTimer(2,<?php echo $boltup ?>,<?php echo $upcoold ?>)"></li>
            <?php } else{ ?>
            <li><a href="shop.php"><img class="bolt" src="img/bolt_lock.png"></a></li>
            <?php } ?>
            
            <!-- wind and fire are always available -->
            <li><img class="wind" src="img/wind.png" onclick="startTimer(4,<?php echo $windup ?>,<?php echo $upcoold ?>);"></li>
            <li><img class="fire" src="img/fire.png"  onclick="startTimer(1,<?php echo $fireup ?>,<?php echo $upcoold ?>)"></li>
            </ul>
            
            <!-- icon and container for timer -->
            <!-- timer ugly, style has to be changed -->
            <img class="Timericon" src="img/timer.png">
            <div class="Timerbox"><p class = "right" id="Countdown"></p></div>
        </div>
    </div>
</div>
        
</body>


<!--quit Torture script-->
<script>
function quitTorture(){
    modal2.style.display = "none";
}
</script>
    
    
    
<!--timerscript-->
<script>
        <!--array for tools, 0->available, 1->running, 2->cooldown -->
        <!--should be created with variable length-->
        var toolsArr = [0, 0, 0, 0, 0];
        var lastTool = 0;
        var shorterCooldowns = 0;
        var torturedSec = 0;
    
        <!-- starts timer, parameters: selected tool, upgrade tool(0 none, 1 lvl1, etc), shorter cooldowns(0 non or 1 half) -->
        function startTimer(seltool, upgrade, upcoold){
            // write to global variable if cooldowns are upgraded
            shorterCooldowns = upcoold;
            
            <!--write to array which tool is running-->
            for(i = 0; i < 5; i++){
                // check if tool is in cooldown phase or if new tool selected
                if (toolsArr[i] == 2){
                    <!--stay in cooldown-->
                    toolsArr[i] = 2;
                } else if (toolsArr[i] == 1){
                    // check if user selected the same tool twice
                    if (i == seltool-1){
                        <!-- if so keep running -->
                        toolsArr[i] = 1;
                    } else {
                        <!-- else put in cooldown -->
                         toolsArr[i] = 2;
                        document.getElementById('Countdown').innerHTML  = '';
                    
                        <!--timed function to stop cooldown-->
                        reenableTool(i+1);
                    }
                }
            }
            
            <!-- check if user clicked the same tool twice, or if tool is available again -->
            if (seltool != lastTool || toolsArr[seltool-1] == 0){
                <!--stopping all physical tools-->
                tool(0);
                <!-- start tool if not in cooldown phase-->
                if (toolsArr[seltool-1] != 2){
                    toolsArr[seltool-1] = 1;
                    /*timer 10 or 20 if upgraded*/
                    switch(upgrade){
                        case 0: document.getElementById('Countdown').innerHTML = "10";
                                break;
                        case 1: document.getElementById('Countdown').innerHTML = "20";
                                break;
                    }
                }
                toolsArr.forEach(function(item, index, array){
                    console.log('tool ', (index+1), item);
                });
                <!--remember last tool -->
                lastTool = seltool;
                <!--stop all running tools and start selected tool-->
                //tool(0);
                tool(seltool);
                console.log('tool ' + (seltool) + ' selected');
                
                
                <!--call decrement Timer in 1 sec-->
                /*9 or 19 if upgraded*/
                // stupid function in anonymus function call, as some browsers don't support passing arguments-->
                switch(upgrade){
                    case 0: setTimeout(function(){decrementTimer(9, seltool);}, 1000);
                            break;
                    case 1: setTimeout(function(){decrementTimer(19, seltool);}, 1000);
                            break;
                }
            }
            
        }
        
        
        <!-- recursive function, decrements TImer by 1 -->
        function decrementTimer(t, seltool){
            if (t == 0){
                torturedSec++;
                stopTimer(seltool);
            } else {
                if (toolsArr[seltool-1] == 1){
                    document.getElementById('Countdown').innerHTML  = t;
                    torturedSec++;
                    setTimeout(function(){decrementTimer(t-1, seltool)}, 1000);
                }
            }
        }
        
        
        <!-- stops Timer when reaching 0 -->
        function stopTimer(seltool){
            <!--stop running tool-->
            toolsArr[seltool-1] = 2;
            tool(0);
            reenableTool(seltool);
            console.log('stopping tool');
            
            document.getElementById('Countdown').innerHTML  = '';
        }
        
        
        <!-- deletes cooldown status -->
        function reenableTool(seltool){
            console.log("tool " + seltool + " will be reactivated in 10s");
            
            <!-- visualize cooldown, uncomment when finished -->
            showCooldown(seltool);
            
            <!-- cooldown time defined here, add hideCooldown(seltool) when finished -->
            var cooldowntime = 20000;
            switch(shorterCooldowns){
                case 0: cooldowntime = 20000;
                        break;
                case 1: cooldowntime = 10000;
                        break;
            }
            setTimeout(function(){toolsArr[seltool-1] = 0; hideCooldown(seltool)}, cooldowntime);
        }
        
        
        <!-- visualizes cooldown-->
        <!-- some css code?? css is beyond my intellect, mr Hayne -->
        function showCooldown(seltool){
            switch(seltool){
                    case 1: document.getElementById('cooldown_fire').style.display = "block";
                            break;
                    case 2: document.getElementById('cooldown_bolt').style.display = "block";
                            break;
                    case 3: document.getElementById('cooldown_acid').style.display = "block";
                            break;
                    case 4: document.getElementById('cooldown_wind').style.display = "block";
                            break;
                    case 5: document.getElementById('cooldown_drill').style.display = "block";
                            break;
            }
        }
        function hideCooldown(seltool){
            switch(seltool){
                    case 1: document.getElementById('cooldown_fire').style.display = "none";
                            break;
                    case 2: document.getElementById('cooldown_bolt').style.display = "none";
                            break;
                    case 3: document.getElementById('cooldown_acid').style.display = "none";
                            break;
                    case 4: document.getElementById('cooldown_wind').style.display = "none";
                            break;
                    case 5: document.getElementById('cooldown_drill').style.display = "none";
                            break;
            }
        }
</script>

    
<!-- slidescript -->
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n){
    showDivs(slideIndex += n);
}

function showDivs(n){
    var i;
    <!-- x array of plant images, y array of buttons for triggering robot-->
    var x = document.getElementsByClassName("pflanze")
    var y = document.getElementsByClassName("accept")
    
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length}
    <!-- hide all elements -->
    for (i = 0; i < x.length; i++){
        x[i].style.display = "none";
        y[i].style.display = "none";
    }
    <!-- display selected element -->
    x[slideIndex-1].style.display = "block";
    y[slideIndex-1].style.display = "block";
}
</script>
    
    
    
<script>
/* Get the login modal */
var modal = document.getElementById('id01');
/* Get the torture screen modal */
var modal2 = document.getElementById('id02');
/* When the user clicks anywhere outside of the modal, close it */
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
    if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
/* Submit the form if the user hits the enter key */
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
// If the ESC key is pushed it closes both modals
document.onkeydown = function(evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) {
        isEscape = (evt.key === "Escape" || evt.key === "Esc");
    } else {
        isEscape = (evt.keyCode === 27);
    }
    if (isEscape) {
        modal.style.display = "none";
        <!--could cause problems-->
        modal2.style.display = "none";
    }
};
</script>
</html>
