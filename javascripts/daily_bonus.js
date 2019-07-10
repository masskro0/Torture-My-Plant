function daily_bonus(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "daily_bonus.php?q=", true);
            xmlhttp.send();
            //location.reload();
            
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
                    location.reload();
                }
            };
            
        }