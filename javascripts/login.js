function validate() {
    var text;
    var uname = document.getElementById('username');
    var psw = document.getElementById('password');
    var checkbox = document.getElementById('remember');
    var bool = false;
    if(checkbox.checked){
        bool = true;
    }

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
    xmlhttp.send("username=" + uname.value + "&password=" + psw.value + "&remember=" + bool);
}

function showlogin(){
    document.getElementById('loginbackground').style.display='block';
    /* Get the login modal */
    var modal = document.getElementById('loginbackground');

    /* When the user clicks anywhere outside of the modal, close it */
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
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
}