function tool(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "client.php?q=" + str, true);
        xmlhttp.send();
        window.value = window.value + 1;
        }
    
        
        /* method for starting torture, gets plant number, opens torture screen */
        function startTorture(str) {
            window.value = 0;
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var str = this.responseText;
                    // Refresh page if there are no errors
                    if(str == "1"){ 
                        torturedSec = 0;
                        document.getElementById('id02').style.display='block';
                        console.log('plant ' + str + ' selected');
                    } else {
                        document.getElementById('notify_screen').style.visibility = "visible";
                    }
                }
            };
            
            xmlhttp.open("GET", "clientRobotDatabase.php?q=" + str, true);
            xmlhttp.send();
            
        }
        
        function quitTorture(){
    //updates balance in database
    console.log("updating balance, seconds: " + torturedSec);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "updateBalance.php?q=" + torturedSec, true);
    xmlhttp.send();
    torturedSec = 0;
    modal2.style.display = "none";
    if (window.value > 0){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "plants_tortured.php?q=", true);
        xmlhttp.send();
    }
    
    //set current user to zero
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "quitGameCurrentUser.php", true);
    xmlhttp.send();


    
    // Display the updated balance
    // Wait 1 second to finish the script above
    setTimeout(1000);
    var xmlhttp2 = new XMLHttpRequest();
    // Open the balance.php script to get the newest balance of the user
    xmlhttp2.open("GET", "balance.php", true);
    // Set a request header so that balance.php knows that it's a xmlhttprequest
    xmlhttp2.setRequestHeader("HTTP_X_REQUESTED_WITH",'xmlhttprequest');
    xmlhttp2.send();
    xmlhttp2.onreadystatechange = function() {
        // Update the balance if the script is done
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("balance").innerHTML = this.responseText.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    };
}