#Name: Yash Rana
#UCID: yr83
#Section: CS356-002
import sys, time
import os
import os.path
import struct
from socket import *
argv = sys.argv
keyboardInput=argv[1];
array = keyboardInput.split(":")
host=array[0]
array2 = array[1].split("/")
port=array2[0]
port = int(port)
filename = array2[1]
clientSocket = socket(AF_INET, SOCK_STREAM)
cacheCheck = os.path.isfile("cache.txt")
if(cacheCheck == False):
    clientSocket = socket(AF_INET, SOCK_STREAM)
    clientSocket.connect((host, port))
    ReqData = "GET /" + filename + " HTTP/1.1" + "\r\n"
    ReqData += host + ":" + str(port) + "\r\n\r\n"
    clientSocket.send(ReqData.encode())
    ResData = clientSocket.recv(4096)
    ResData = ResData.decode()
    if "HTTP/1.1 404" in ResData:
        print(ResData)
        clientSocket.close()
        exit(404);
    else:
        print("\nThe following is the response to the first request.")
        print(ResData+"\n")
        clientSocket.close()
        tempfile = open("cache.txt", "w+")
        tempfile.write(ResData)
        tempfile.close()
    with open("cache.txt") as tempfile:
        for line in tempfile:
            if "Last-Modified" in line:
                lastChange = line[15:];
                #print("The cache length is: ")
                #print(len(lastChange))
    ReqData = "GET /"+ filename +" HTTP/1.1" + "\r\n"
    ReqData += host+":"+str(port)+"\r\n"
    ReqData += "If-Modified-Since: " + lastChange + "\r\n\r\n"
    clientSocket = socket(AF_INET, SOCK_STREAM)
    clientSocket.connect((host, port))
    clientSocket.send(ReqData.encode())
    ResData = clientSocket.recv(4096)
    ResData = ResData.decode()
    #if "HTTP/1.1 304" in ResData:
    #    print("\nThe following is the response to the second request.")
    #    print(ResData)
    #os.remove("cache.txt")
    clientSocket.close()
if(cacheCheck == True):
    clientSocket = socket(AF_INET, SOCK_STREAM)
    clientSocket.connect((host, port))
    ReqData = "GET /" + filename + " HTTP/1.1" + "\r\n"
    ReqData += host + ":" + str(port) + "\r\n\r\n"
    clientSocket.send(ReqData.encode())
    ResData = clientSocket.recv(4096)
    ResData = ResData.decode()
    if "HTTP/1.1 404" in ResData:
        print(ResData)
        clientSocket.close()
        exit(404);
    else:
        #print("\nThe following is the response to the first request.")
       # print(ResData+"\n")
        clientSocket.close()
        tempfile = open("cache.txt", "w+")
        tempfile.write(ResData)
        tempfile.close()
        with open("cache.txt") as tempfile:
            for line in tempfile:
                if "Last-Modified" in line:
                    lastChange = line[15:];
                    #print("\nThe following is the response to the third request.")
                    #print(ResData)
        ReqData = "GET /"+ filename +" HTTP/1.1" + "\r\n"
        ReqData += host+":"+str(port)+"\r\n"
        ReqData += "If-Modified-Since: " + lastChange + "\r\n\r\n"
        clientSocket = socket(AF_INET, SOCK_STREAM)
        clientSocket.connect((host, port))
        clientSocket.send(ReqData.encode())
        ResData = clientSocket.recv(4096)
        ResData = ResData.decode()
        print("\nThe following is the response to the second request.")
        print(ResData)
    #os.remove("cache.txt")
    clientSocket.close()
