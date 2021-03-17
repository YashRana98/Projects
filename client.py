#Name: Yash Rana
#UCID: yr83
#Section: CS356-002
import sys, time
import struct
from socket import *
argv = sys.argv
host = argv[1]
port = argv[2]
port = int(port)
print("Pinging   " + host + ", " + str(port) + ": ")
clientsocket = socket(AF_INET, SOCK_DGRAM)
clientsocket.settimeout(1)
seqNum = 1
rtt=[]
while seqNum<=10:
    send_time=time.time()
    data = struct.pack('i', seqNum)
    clientsocket.sendto(data,(host, port))
    try:
        data, address = clientsocket.recvfrom(1024)
        elapsed_time=(time.time()-send_time)
        rtt.append(elapsed_time)    
        print ("Ping message number " + str(seqNum) + " RTT: " + str(elapsed_time) + 'seconds')
    except timeout:
        print("Ping message number " + str(seqNum) + " timed out")
    seqNum+=1
    
if seqNum > 10:
    print("Number of packets sent: ", seqNum-1)
    print("Number of packets received: ", len(rtt))
    print("Packet loss rate is: " + str((10-len(rtt))*10)+ "%")
    mean=sum(rtt, 0.0)/len(rtt)
    print("Maximum RTT is: " + str(max(rtt)) + " seconds")
    print("Minimum RTT is: " + str(min(rtt)) + " seconds")
    print("Average RTT is: " + str(mean) + " seconds")    
clientsocket.close()
