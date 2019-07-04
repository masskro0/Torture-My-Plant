#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jun  5 19:49:55 2019

@author: michael
"""

#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jun  5 19:49:55 2019

@author: michael
"""

import socket
import sys
from _thread import *
import time
import RPi.GPIO as GPIO
import random
from _thread import start_new_thread
from threading import Thread

GPIO.setmode(GPIO.BCM) #steuer GPIOs per Boardnummer an
drillStatus = 1
windStatus = 1
acidStatus = 1
boltStatus = 1
flameStatus = 1
#status variables for blink
boltBlinkStatus = 0
flameBlinkStatus = 0
#timer variables for bolt and flame blink
previousMillis = 0
currentMillis = 0
#period duration for blink
blinkPeriod = random.randint(50, 400)


#Blitz anschalten
def boltOn():
    toolsOff()
    global boltStatus
    boltStatus = 1
    print('bolt on')

def boltBlink():
    global boltBlinkStatus
    if(boltBlinkStatus == 0):
        GPIO.output(24, GPIO.HIGH)
        boltBlinkStatus = 1
    else:
        GPIO.output(24, GPIO.LOW)
        boltBlinkStatus = 0
       
#Blitz ausschalten
def boltOff():
    GPIO.output(24, GPIO.LOW)
    print('bolt off')
    global boltStatus
    boltStatus = 0

#Feuer anschalten
def flameOn():
    toolsOff()
    print('flame on')
    global flameStatus
    flameStatus = 1

def flameBlink():
    global flameBlinkStatus
    if(flameBlinkStatus == 0):
        GPIO.output(23, GPIO.HIGH)
        flameBlinkStatus = 1
    else:
        GPIO.output(23, GPIO.LOW)
        flameBlinkStatus = 0
    
#Feuer ausschalten
def flameOff():
    GPIO.output(23, GPIO.LOW)
    print('flame off')
    global flameStatus
    flameStatus = 0
    
#Wind anschalten
def windOn():
    toolsOff()
    GPIO.output(27, GPIO.HIGH)
    print('wind on')
    global windStatus
    windStatus = 1
    
#Wind ausschalten
def windOff():
    GPIO.output(27, GPIO.LOW)
    print('wind off')
    global windStatus
    windStatus = 0

#Säure anschalten
def acidOn():
    toolsOff()
    GPIO.output(17, GPIO.HIGH)
    print('acid on')
    global acidStatus
    acidStatus = 1
    
#Säure ausschalten
def acidOff():
    GPIO.output(17, GPIO.LOW)
    print('acid off')
    global acidStatus
    acidStatus = 0
 
#Bohrer anschalten
def drillOn():
    toolsOff()
    #fahre Bohrer an Pflanze
    p.ChangeDutyCycle(12)
    time.sleep(0.3)
    p.ChangeDutyCycle(0)
    time.sleep(0.2)
    #schalte Bohrer an
    GPIO.output(15, GPIO.HIGH)
    print('drill on')
    global drillStatus
    drillStatus = 1
        
#Bohrer ausschalten
def drillOff():
    #schalte Bohrer aus
    GPIO.output(15, GPIO.LOW)
    #fahre Bohrer auf Startposition
    p.ChangeDutyCycle(7)
    time.sleep(0.5)
    p.ChangeDutyCycle(0)
    print('drill off')
    global drillStatus
    drillStatus = 0

def toolsOff():
    #disable all tools
    if(flameStatus == 1):
        flameOff()
    if(windStatus == 1):
        windOff()
    if(acidStatus == 1):
        acidOff()
    if(boltStatus == 1):
        boltOff()
    if(drillStatus == 1):
        drillOff()
    
GPIO.setup(24, GPIO.OUT) #set PIN24 as OUTPUT for bolt
GPIO.setup(15, GPIO.OUT) #set PIN18 as OUTPUT for drill
GPIO.setup(23, GPIO.OUT) #set PIN23 as OUTPUT for flame
GPIO.setup(17, GPIO.OUT) #set PIN17 as OUTPUT for acid
GPIO.setup(27, GPIO.OUT) #set PIN27 as OUTPUT for wind
GPIO.output(15, GPIO.LOW)#disable PIN18
servoPIN = 13 #set GPIO13 as OUTPUT data for Servo
GPIO.setup(servoPIN, GPIO.OUT)
p =GPIO.PWM(servoPIN, 50) #set GPIO13 as PWM at 50Hz
p.start(7) #set initial Position of drill
time.sleep(0.5)
p.ChangeDutyCycle(0) #set Servo on Pause 

HOST = '127.0.0.1'  # Localhost
PORT = 9997 

# Create a socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
print('Socket created')

# Bind socket to local host and port
try:
    s.bind((HOST, PORT))
except socket.error as msg:
    print('Bind failed. Error Code : ' + str(msg[0]) + ' Message ' + msg[1])
    sys.exit()
    
print('Socket bind complete')

# Start listening for connecions on socket; queues maximum 10 connections
s.listen(10)
print('Socket now listening')

toolsOff()

#Auswerten data und Ansteuerung Quälwerkzeuge
options = {
        0: toolsOff,
        1: flameOn,
        6: flameOff,
        2: boltOn,
        7: boltOff,
        3: acidOn,
        8: acidOff,
        4: windOn,
        9: windOff,
        5: drillOn,
        10: drillOff
}
        
###----------------TEST----------------###
#while True:
       
    #try: eingabe = int(input('Wähle ein Werkzeug aus: '))
    #except ValueError: print('Input not a number')
    
    #try: options[eingabe]()
    #except: print('invalid input. Number betweend 0 and 10 expected')

    #currentMillis = time.time() * 1000
    #if(currentMillis - previousMillis >= blinkPeriod):
    #        previousMillis = currentMillis
    #        blinkPeriod = random.randint(50, 400)
    #        boltBlink()
    #        flameBlink()
            
            

  
###----------------TEST----------------###       

# Function for handling connections. This will be used to create threads
def clientthread(conn):
    
    while True:
        # Receiving messages from client
        data = conn.recv(1024)  # 1024 Bytes
        data = data.decode()
      
        options[int(data)]()
         
        print(data)
        if not data: 
            break

        currentMillis = time.time() * 1000
        if(boltStatus == 1 and currentMillis - previousMillis >= blinkPeriod):
            previousMillis = currentMillis
            blinkPeriod = random.randint(50, 400)
            boltBlink()
        if(flameStatus == 1 and currentMillis - previousMillis >= blinkPeriod):
            previousMillis = currentMillis
            blinkPeriod = random.randint(50, 400)
            flameBlink()
    
    #came out of loop
    conn.close()

# Check who is connected and call clientthread function
while 1:
    #wait to accept a connection - blocking call
    conn, addr = s.accept()
    print('Connected with ' + addr[0] + ':' + str(addr[1]))
    
    #start new thread takes 1st argument as a function name to be run, second is the tuple of arguments to the function.
    start_new_thread(clientthread ,(conn,))

s.close()
