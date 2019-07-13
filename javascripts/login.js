// Function to validate user input when submitting from the login window
function validate() {
    
    // Username field
    var uname = document.getElementById('username');
    
    // Password field
    var psw = document.getElementById('password');
    
    // Keep me logged in checkbox
    var checkbox = document.getElementById('remember');
    
    // For checkbox; true = checked; false = not checked
    var bool = false;
    if(checkbox.checked){
        bool = true;
    }
    
    // New xmlhttprequest
    var xmlhttp = new XMLHttpRequest();

    // If login.php was executed and no response text was recieved, refresh the page
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("error").innerHTML = this.responseText;
            var str = this.responseText;
            
            // Refresh page if there are no errors
            if(str.length ==0){ 
                window.location.replace("index.php");
            }
        }
    };
    
    // Execute login.php
    xmlhttp.open("POST", "login.php", true);
    
    // Required for the form
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    // Pass values in POST method
    xmlhttp.send("username=" + uname.value + "&password=" + psw.value + "&remember=" + bool);
}

// Function to display the login screen
function showlogin(){
    
    // Display login screen background
    document.getElementById('loginbackground').style.display='block';
    
    // Get the login modal
    var modal = document.getElementById('loginbackground');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
    // Submit the form if the user hits the enter key on the username or password field
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
}