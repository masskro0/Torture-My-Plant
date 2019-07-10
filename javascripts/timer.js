

        // array for tools, 0->available, 1->running, 2->cooldown 
        // should be created with variable length
        var toolsArr = [0, 0, 0, 0, 0];
        var lastTool = 0;
        var shorterCooldowns = 0;
        var torturedSec = 0;
    
        // starts timer, parameters: selected tool, upgrade tool(0 none, 1 lvl1, etc), shorter cooldowns(0 non or 1 half) 
        function startTimer(seltool, upgrade, upcoold){
            // write to global variable if cooldowns are upgraded
            shorterCooldowns = upcoold;
            
            // write to array which tool is running
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
            
            // check if user clicked the same tool twice, or if tool is available again 
            if (seltool != lastTool || toolsArr[seltool-1] == 0){
                // stopping all physical tools
                tool(0);
                // start tool if not in cooldown phase
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
                // remember last tool 
                lastTool = seltool;
                // stop all running tools and start selected tool
                //tool(0);
                tool(seltool);
                console.log('tool ' + (seltool) + ' selected');
                
                
                // call decrement Timer in 1 sec
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
            console.log("tool " + seltool + " will be reactivated in 30s");
            
            <!-- visualize cooldown, uncomment when finished -->
            showCooldown(seltool);
            
            <!-- cooldown time defined here, add hideCooldown(seltool) when finished -->
            var cooldowntime = 30000;
            switch(shorterCooldowns){
                case 0: cooldowntime = 30000;
                        break;
                case 1: cooldowntime = 15000;
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
    
