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
                if(str.length ==0){ window.location.replace("index_torture.html");
                }
            }
        };
        xmlhttp.open("POST", "login.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("username=" + uname.value + "&password=" + psw.value);
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
                    <li class="right"><a href="#" onclick="document.getElementById('id01').style.display='block'">Login</a></li>
                    <li class="right"x><a href="signup.php">Create Account</a></li>
                </ul>
            </nav>
        </div>
    
    
    
    <div id="livestream">
        <iframe class="stream" src="http://10.90.1.247:8081" height=600 width=800></iframe>
        <img class="pflanze" src="img/pflanze.jpg" width=30%>
        <img class="linkerpfeil" src="img/linkerpfeil.png" width=10%>
        <img class="rechterpfeil" src="img/rechterpfeil.png" width=10%>
        <button class="accept" onclick="document.getElementById('id01').style.display='block'">Torture Me!</button>
    </div>
    
    
     <!--Loginscreen-->
    
   
<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
class="close" title="Close Modal">&times;</span>

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
</body>
        
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
 // Pressing enter submits the user input
var input = document.getElementById("password");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("submitform").click();
  }
});
</script>

</html>
