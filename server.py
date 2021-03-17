#Name: Yash Rana
#UCID: yr83
#Section: CS356-002

import sys, time
import struct
import random
from socket import *
argv = sys.argv
host = argv[1]
port = argv[2]
port = int(port)
dataLen = 1000000
serverSocket = socket(AF_INET, SOCK_DGRAM)
serverSocket.bind((host, port))
print("The server is ready to receive on port: " + str(port))
while True:
    rand = random.randint(0, 10)
    data,address = serverSocket.recvfrom(dataLen)
    if rand < 4:
        print("Message with sequence number " + " ".join(map(str,struct.unpack('i',data))) + " dropped")
        continue
    else:
        print("Responding to ping request with sequence number " + " ".join(map(str,struct.unpack('i',data))))
        serverSocket.sendto(data,address)
