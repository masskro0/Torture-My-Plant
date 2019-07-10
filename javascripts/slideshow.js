
function plusDivs(n){
    showDivs(slideIndex += n);
}

function showDivs(n){
    var i;
    <!-- x array of plant images, y array of buttons for triggering robot-->
    var x = document.getElementsByClassName("plant")
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