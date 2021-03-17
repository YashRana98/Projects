#Name: Yash Rana
#UCID: yr83
#Section: CS356-002

import sys, time
from socket import *
# Get the server hostname, port and data length as command line arguments
argv = sys.argv
host = argv[1]
port = argv[2]
count = argv[3]
# Command line argument is a string, change the port and count into integer
port = int(port)
count = int(count)
data = 'X' * count # Initialize data to be sent
# Create UDP client socket. Note the use of SOCK_DGRAM
clientsocket = socket(AF_INET, SOCK_DGRAM)
# Sending data to server
clientsocket.settimeout(1)
for i in range (0,3):
    try:
        # Receive the server response
        # Sending data to server
        print("Sending data to   " + host + ", " + str(port) + ": " + data + " ("+ str(count) + " characters)")
        clientsocket.sendto(data.encode(),(host, port))
        dataEcho, address = clientsocket.recvfrom(1024)
    except timeout:        
        print("Message timed out")
        continue
    if dataEcho != '':
        # Display the server response as an output
        print("Receive data from " + address[0] + ", " + str(address[1]) + ": " + dataEcho.decode())
        break
#Close the client socket
clientsocket.close() 
