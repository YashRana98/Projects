#Name: Yash Rana
#UCID: yr83
#Section: CS356-002

import sys, time, datetime, time
import os
import os.path
import codecs
import struct
import random
from socket import *
argv=sys.argv
serverIP = argv[1]
serverPort = argv[2]
serverPort = int(serverPort)
dataLen = 1000000
serverSocket = socket(AF_INET, SOCK_STREAM)
serverSocket.bind((serverIP, serverPort))
serverSocket.listen(1)
print('The server is listening on the port: ' + str(serverPort))
def change(HTML):
    HTML = HTML.replace('&lt;','<')
    HTML = HTML.replace('&gt;','>')
    HTML = HTML.replace('<p class="p1">', '')
    HTML = HTML.replace('</p>','')
    return HTML
def getContents(FileName):
    HTML=''
    tempfile=codecs.open(FileName, 'r', encoding='utf-8')
    contents = tempfile.read()
    for Line in contents.split("\n"):
        if '<p class="p1">' in Line:
            HTML += Line
    HTML = change(HTML)
    return HTML
def getRecentChange(FileName):   
    recentChange = time.strftime("%a, %d %b %Y %H:%M:%S GMT", time.gmtime(os.path.getmtime(FileName)))
    return recentChange
lastChange = ''
while True:
    ResData=''
    connectionSocket, address = serverSocket.accept()
    ReqData = connectionSocket.recv(dataLen).decode()
    t = datetime.datetime.utcnow()
    ReqDateTime = t.strftime("%a, %d %b %Y %H:%M:%S GMT")
    print("Request has been received")    
    numberOfLines = 0
    for Line in ReqData.split("\r\n"):
        numberOfLines+=1
    if numberOfLines==5:
        for Line in ReqData.split("\r\n"):
            if "If-Modified-Since" in Line:
                lastChange = Line[19:].strip()
    else:
        lastChange=''
    print("RECEIVED: \t", lastChange, "\n Length: ", len(lastChange))
    for item in ReqData.split():
        if item[0] == "/":
            filename = item[1:]
            break

    if not(os.path.isfile(filename)):
        ResData += "HTTP/1.1 404 Not Found" + "\r\n" + "Date: " + ReqDateTime + "\r\n\r\n"
    else:
        print("Server has received it. " + lastChange);
        lastChangeNew = getRecentChange(filename)

        print(len(lastChangeNew))
        print("\n")
        print(len(lastChange))
        if lastChangeNew == lastChange:
            ResData += "HTTP/1.1 304 Not Modified\r\n" + "Date: " + ReqDateTime + "\r\n\r\n"
        else:
            ContentData = getContents(filename)
            ContentLength = str(len(ContentData))
            ResData += "HTTP/1.1 200 OK" + "\r\n" + "Date: " + ReqDateTime  + "\r\n" + "Last-Modified: " + lastChangeNew + "\r\n" + "Content-Length: " + ContentLength + "\r\n" + "Content-Type: text/html; charset=UTF-8" + "\r\n" + "\r\n" + ContentData
    connectionSocket.send(ResData.encode())
    print("Response sent!")
    connectionSocket.close()
