#Name: Yash Rana
#UCID: yr83
#Section: CS356-002

import sys
from socket import *
serverIP= ''           # any local IP address
serverPort = 12000
dataLen = 1000000
# Create a UDP socket. Notice the use of SOCK_DGRAM for UDP packets
serverSocket = socket(AF_INET, SOCK_DGRAM)
# Assign IP address and port number to socket
serverSocket.bind((serverIP, serverPort))
print('The server is ready to receive on port:  ' + str(serverPort))
# loop forever listening for incoming datagram messages
while True:   
    # Receive and print the client data from "data" socket
    data,address = serverSocket.recvfrom(dataLen)
    print("Receive data from client " + address[0] + ", " + str(address[1]) + ": " + data.decode()) 
    # Echo back to client
    print("Sending data to   client " + address[0] + ", " + str(address[1]) + ": " + data.decode())
    serverSocket.sendto(data,address)
