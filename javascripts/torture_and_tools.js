// Turns selected tool on
function tool(str) {
    console.log('sending ' + (str) + ' in function tool');

    // New xmlhttprequest
    var xmlhttp = new XMLHttpRequest();
    
    // Executing php script, that sends a tool request to the python script
    xmlhttp.open("GET", "client.php?q=" + str, true);
    xmlhttp.send();
    
    // Global variable to count how many tools were selected for a plant
    window.value = window.value + 1;
}
        
// Method for starting torture, gets plant number, opens torture screen
function startTorture(str) {
    
    // Same variable as above
    window.value = 0;
    var xmlhttp = new XMLHttpRequest();
    
    // If only one user is playing execute
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            // Response text form clientRobotDatabase.php
            var str = this.responseText;
            
            // Check response 1-->no one is playing; 0--> so other user is playing
            if(str == "1"){ 
                
                // Start game if no one is playing
                // Set counter to zero, needed for reward
                torturedSec = 0;
                
                // Display the torture screen
                document.getElementById('torturebackground').style.display='block';
                console.log('plant ' + str + ' selected');
                
                // Check if the user is closing the tab or the browser while playing
                window.addEventListener('beforeunload', function (e) {
                    quitTorture();
                });
                
            } else {
                // Show "some other user is playing" message
                document.getElementById('notify_screen').style.visibility = "visible";
            }
        }
    };
    
    // Send request, clientRobotDatabase checks if some other user i playing
    xmlhttp.open("GET", "clientRobotDatabase.php?q=" + str, true);
    xmlhttp.send();
    
}

/* Quits the game, updates the balance, stops all the tools and timers and lets other users play
* Is called when pressing 'Quit Torture', the 'X', outside the modal or if the user closes the tab or browser*/
function quitTorture(){
    
    // Disable all the phyical tools
    tool(0);
    
    // Updates balance in database
    console.log("updating balance, seconds: " + torturedSec);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "updateBalance.php?q=" + torturedSec, true);
    xmlhttp.send();
    
    // Reset the counter needed for money
    torturedSec = 0;
    
    // Closes the torture modal
    modal2.style.display = "none";
    
    // Updates the balance in the database
    if (window.value > 0){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "plants_tortured.php?q=", true);
        xmlhttp.send();
    }
    
    // Set current user to zero
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "quitGameCurrentUser.php", true);
    xmlhttp.send();


    
    // Display the updated balance; wait 1 second to finish the script above
    setTimeout(1000);
    var xmlhttp2 = new XMLHttpRequest();
    
    // Open the balance.php script to get the newest balance of the user
    xmlhttp2.open("GET", "balance.php", true);
    
    // Set a request header so that balance.php knows that it's a xmlhttprequest
    xmlhttp2.setRequestHeader("HTTP_X_REQUESTED_WITH",'xmlhttprequest');
    xmlhttp2.send();
    xmlhttp2.onreadystatechange = function() {
        
        // Update the shown balance if the script is done
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("balance").innerHTML = this.responseText.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    };
}
