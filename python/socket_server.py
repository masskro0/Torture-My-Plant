#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jun  5 19:49:55 2019

@author: michael
"""

import socket
import sys
from _thread import *

HOST = '127.0.0.1'	# Localhost
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

# Function for handling connections. This will be used to create threads
def clientthread(conn):
	
    while True:
		# Receiving messages from client
        data = conn.recv(1024)  # 1024 Bytes
        data = data.decode()
        print(data)
        if not data: 
            break
	
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