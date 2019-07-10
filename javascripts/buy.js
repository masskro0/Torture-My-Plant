window.value = 0;
        function getid(id){
           window.value = id; 
        }
        /* Function for buying an item when the buy button was clicked. Sends a xmlhttprequest to the buy.php script */
        function buy(id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "buy.php?q=" + id, true);
            xmlhttp.send();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var str = this.responseText;
                if(str.length ==0){ 
                    document.getElementById(id).style.display = "none";
                }
                if(str == "Not enough coins to buy this item!"){
                    document.getElementById('notify_screen').style.visibility = "visible";
                }
            }
            };
            
            // Update the balance dynamically
            // Wait 1 seconds to finish the script above
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
