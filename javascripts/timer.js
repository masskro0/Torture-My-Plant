// Array for tools, 0->available, 1->running, 2->cooldown 
// Should be created with variable length
var toolsArr = [0, 0, 0, 0, 0];
var lastTool = 0;
var shorterCooldowns = 0;
var torturedSec = 0;

// Starts timer, parameters: selected tool, upgrade tool(0 none, 1 lvl1, etc), shorter cooldowns(0 non or 1 half) 
function startTimer(seltool, upgrade, upcoold){
    
    // Write to global variable if cooldowns are upgraded
    shorterCooldowns = upcoold;
    
    // Write to array which tool is running
    for(i = 0; i < 5; i++){
        
        // Check if tool is in cooldown phase or if new tool selected
        if (toolsArr[i] == 2){
            
            // Stay in cooldown
            toolsArr[i] = 2;
        } else if (toolsArr[i] == 1){
            
            // Check if user selected the same tool twice
            if (i == seltool-1){
                
                // If so keep running
                toolsArr[i] = 1;
            } else {
                
                // Else put tool in cooldown phase
                 toolsArr[i] = 2;
                document.getElementById('Countdown').innerHTML  = '';
            
                // Timed function to stop cooldown
                reenableTool(i+1);
            }
        }
    }
    
    // Check if user clicked the same tool twice, or if tool is available again 
    if (seltool != lastTool || toolsArr[seltool-1] == 0){
        
        // Stopping all physical tools
        tool(0);
        
        // Start tool if not in cooldown phase
        if (toolsArr[seltool-1] != 2){
            toolsArr[seltool-1] = 1;
            // Timer 10 or 20 if upgraded
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
        // Remember last tool 
        lastTool = seltool;
        // Stop all running tools and start selected tool
        console.log('tool ' + (seltool) + ' selected');
        tool(seltool);
        
        
        // Call decrement Timer in 1 sec
        // 9 or 19 if upgraded
        switch(upgrade){
            case 0: setTimeout(function(){decrementTimer(9, seltool);}, 1000);
                    break;
            case 1: setTimeout(function(){decrementTimer(19, seltool);}, 1000);
                    break;
        }
    }
    
}


// Recursive function, decrements TImer by 1, icreses the tortured seconds
function decrementTimer(t, seltool){
    if (t == 0){
        
        // Stop timer when reaching 0
        torturedSec++;
        stopTimer(seltool);
    } else {
        
        //Update the displayed countdown, if the tool is currently running
        if (toolsArr[seltool-1] == 1){
            document.getElementById('Countdown').innerHTML  = t;
            torturedSec++;
            setTimeout(function(){decrementTimer(t-1, seltool)}, 1000);
        }
    }
}


// Stops Timer when reaching 0
function stopTimer(seltool){
    // Activate cooldown state
    toolsArr[seltool-1] = 2;
    // Stop running tool
    tool(0);
    // Reenables tool after the cooldown
    reenableTool(seltool);
    console.log('stopping tool');
    document.getElementById('Countdown').innerHTML  = '';
}


// Deletes cooldown status for the selected tool
function reenableTool(seltool){
    console.log("tool " + seltool + " will be reactivated in 30s");
    
    // Visualizes cooldown
    showCooldown(seltool);
    
    // Cooldown time defined here, check if cooldown is upgraded
    var cooldowntime = 30000;
    switch(shorterCooldowns){
        case 0: cooldowntime = 30000;
                break;
        case 1: cooldowntime = 15000;
                break;
    }
    
    // Hide the cooldown, when the tool can be used again
    setTimeout(function(){toolsArr[seltool-1] = 0; hideCooldown(seltool)}, cooldowntime);
}


/* Visualizes cooldown
* Shows and a translucent red box for the selected tool*/
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
// Hides the cooldown box
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
    
