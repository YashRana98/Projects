/*
 * CS 656 / Fall 2019 / Term Project
 * Group: W3 / Leader: Anthony Anderson (aa2296)
 * Group Members: Shreena Mehta (sm2327), Yash Rana (yr83)
 *
 */

#include <stdio.h>         /* import java.net.InetAddress; etc */
#include <netinet/in.h>
#include <arpa/inet.h>
#include <ctype.h>
#include <unistd.h>
#include <stdbool.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netdb.h>
#include <sys/time.h>
#include <string.h>
#include <stdlib.h>
#define SA struct sockaddr


/*--------------- end include/s and import/s --------------*/

/* GLOBALS: do not change these */
char HOST[1024]; /* HOST to connect to; byte[] in Java */
char URL[1024];  /* URL to get        ; byte[] in Java */
char HOSTIP[1024]; /* HOST IP TO B*/
char newPORT[1024]="80";
char FULLURL[1024];
char PATH[1024];
char *RESPONSECODE;
int  PORT,       /* port to listen on  */
     HPORT ;     /* port to connect to */
struct in_addr PREFERRED; /* set in dns() */
int parse()        /* you can change this signature */{
    if(!(HOST[1023]=='\0' || HOST[1023]=='0'))    {      return -1;    }   
    if(!(HOST[0]=='G' && HOST[1]=='E' && HOST[2]=='T' && HOST[3]==' ' && (HOST[4]== 'h' || HOST[4]=='H') && (HOST[5]=='t' || HOST[5]=='T') && (HOST[6]=='t' || HOST[6]=='T') && (HOST[7]=='p' || HOST[7]=='P') && HOST[8]==':' && HOST[9]=='/' && HOST[10]=='/'))    {      return -1;    }  
    strncpy(URL, HOST+11, sizeof(HOST)-11);
    char *ptr;
    ptr = strchr(URL, '\r');
    if(ptr!=NULL)    {      *ptr = '\0';    }
    if(URL[strlen(URL)-1]=='/')    {      URL[strlen(URL)-1] = '\0';    }
    char *portptr;
    portptr = strchr(URL, ':');
    int size=0;
    if(portptr!=NULL)    {
      portptr++;
      char *start=portptr; 
      for(;isdigit(*start); start++)      {        size++;      }
      strncpy(newPORT, portptr, size);
      char *fixPORT = newPORT + size;
      if(fixPORT != NULL)      {        *fixPORT = '\0';      }
      HPORT = atoi(portptr);
      if(HPORT<=1024 || HPORT >65535)      {        return -2;      }    }
    else    {      HPORT = 80;    }
    if((!strstr(URL, "/ HTTP/1.")) && (strstr(URL, " "))){
      char *up4 =  strstr(URL, " ");
      int a = (int)(up4-URL); 
      int i; 
      char test1[strlen(URL)+2];
      for(i = 0; i < a; i++){        test1[i] = URL[i];        }
      test1[a] = '/';
      test1[a+1] = '\0';
      strcat(test1, up4); 
      strcpy(URL, test1);    } 
    char *path;
    path=strchr(URL, '/');
    if(path!=NULL)    {
      size=0;
      char *pathend = path;
      pathend++;
      if(*pathend!=' ')  {
        while(*pathend!='\r' && *pathend!=' '){
            pathend++;
            size++;  }
            strncpy(PATH, path, size);
            strncpy(URL, HOST+11, sizeof(HOST)-11);  }      }
    if(portptr!=NULL)    {
      portptr--;
      *portptr='\0';     }
    else if(path!=NULL)    {      *(path+1)='\0';    }
    char localh[11]="LOCALFILE/";
    char localcheck[11];
    strncpy(localcheck, URL, 11);
    if(strcmp(localh, localcheck)==0){      return 5;    }
    if(strstr(HOST, " HTTP")){
        char *up1, *up2;
        if(URL[(int)(path-URL)] == '/'){       
          char urlcpy[strlen(URL)+1];
          urlcpy[strlen(URL)] = '\0';
          int c = 0;
          while (c < (strlen(URL))){
              urlcpy[c] = URL[c];  c++;          }
          strcpy(URL, urlcpy);        }
        up1 = strstr(HOST," HTTP/1.0");
        up2 = strstr(HOST," HTTP/1.1");
        if(up1 || up2){}
        else{    return 7;    }       }
    if(isdigit(URL[0]) != 0){    
          if((URL[strlen(URL)-1]=='/')){
          char urlcpy[strlen(URL)];
          urlcpy[strlen(URL)-1] = '\0';
          int c = 0;
          while (c < (strlen(URL)-1)){
              urlcpy[c] = URL[c];    c++;      }          
          strcpy(URL, urlcpy);    
          bzero(&urlcpy, sizeof(urlcpy));    } //--
          struct sockaddr_in sa;
          memset(&sa, 0, sizeof sa);
          sa.sin_family = AF_INET;
          inet_pton(AF_INET, URL, &sa.sin_addr);
          int res = getnameinfo((struct sockaddr*)&sa, sizeof(sa), URL, sizeof(URL),NULL, 0, NI_NAMEREQD);     
    
          if (res) {      return -3;      }
          else{     return 0;     }    }
    return 0;    }
int dns(int connfd)  /* you can define the signature for dns() */{ // int sockfd;
    struct addrinfo hints, *results, *p;
    struct sockaddr_in *ip_access;
    int rv;    
    memset(&hints, 0, sizeof hints);
    hints.ai_family = AF_INET;
    hints.ai_socktype = SOCK_STREAM;
    hints.ai_flags = 0;    
    hints.ai_protocol = 0;         
    hints.ai_canonname = NULL;
    hints.ai_addr = NULL;
    hints.ai_next = NULL; 
    
    if((URL[strlen(URL)-1]=='/')){
      char urlcpy[strlen(URL)];
      urlcpy[strlen(URL)-1] = '\0';
      int c = 0;
      while (c < (strlen(URL)-1)){
          urlcpy[c] = URL[c];    c++;      }          
      strcpy(URL, urlcpy);    
      bzero(&urlcpy, sizeof(urlcpy));    } 
    strcpy(FULLURL, URL);
    strcat(FULLURL, PATH);
    if ( (rv = getaddrinfo(URL, "domain", &hints, &results)) != 0){        return 4;        }    
    else{    }
    char *pref;
    int incrementer = 0;     
    for (p = results; p !=NULL; p = p->ai_next){  
        ip_access = (struct sockaddr_in *) p->ai_addr;
        if(incrementer == 0){        PREFERRED = (ip_access->sin_addr);    }
        incrementer++;      }  
     pref = inet_ntoa(PREFERRED);
     if (strcmp(pref, "0.0.0.0") == 0){       return 2;       }
     else{         return 1;         }      }
int ht_fetch(int connfd, int status)   /* you can define the signature */  {
    int n;
    if(status == 5){
        char *filestart = PATH+1;
        FILE *fp;
        fp = fopen(filestart, "r");
        if(fp==NULL)      {      printf("Error opening file");         return -6;        }
        fseek(fp, 0, SEEK_END);
        n = ftell(fp);
        fclose(fp);    }
    else{
        char *pref2;
        char buffer[65535];
        pref2 = inet_ntoa(PREFERRED);  
        struct sockaddr_in ping_addr; 
        int pingfd = socket(AF_INET, SOCK_STREAM, 0); 
        bzero(&ping_addr, sizeof(ping_addr));
        ping_addr.sin_family = AF_INET; 
        ping_addr.sin_port = htons(80);
        inet_pton(AF_INET, (const char *)pref2, &ping_addr.sin_addr);
        if (connect(pingfd,(SA *) &ping_addr,sizeof(ping_addr)) < 0) printf("ERROR connecting");
        char* request = NULL;
        int argvLen = strlen(URL);
        request = malloc( strlen("GET / HTTP/1.0\r\nHost: ") + argvLen + strlen("\r\nConnection: close\r\n\r\n") + 1 ); // Add 1 for null terminator.
        strcpy( request, "GET / HTTP/1.0\r\nHost: " );
        strcat( request, URL );
        strcat( request, "\r\nConnection: close\r\n\r\n" );
        n = write(pingfd,(const char *)request,strlen((const char *)request));
        if (n < 0) printf("ERROR writing to socket");
        bzero(buffer,65535);
        n = read(pingfd,buffer,65535);
        if (n < 0) printf("ERROR reading from socket");
        close(pingfd);
        if ( n > 65535 ){ return -1; }    }
    if(status!=5)    {
        write(connfd, "HTTP/1.1 ", strlen("HTTP/1.1 "));
        write(connfd, RESPONSECODE, strlen(RESPONSECODE));
        write(connfd, "\r\n", strlen("\r\n"));
        write(connfd, "Content-Type: text/html\r\n", strlen("Content-Type: text/html\r\n"));
        write(connfd, "Connection: Closed\r\n", strlen("Connection: Closed\r\n"));
        write(connfd, "\r\n", strlen("\r\n")); }
    write(connfd, "<!DOCTYPE html>" ,strlen("<!DOCTYPE html>"));
    write(connfd, "<html><head></head><body>" ,strlen("<html><head></head><body>"));
    write(connfd, "<span style=\"white-space: pre-line\">", strlen("<span style=\"white-space: pre-line\">"));
    write(connfd, HOST, strlen(HOST));
    write(connfd, "<p style=\"color:red\">" ,strlen("<p style=\"color:red\">"));           
    write(connfd, "HOSTIP = ", strlen("HOSTIP = "));
    write(connfd, URL, strlen(URL));
    if(status!=5){
        write(connfd, " (", strlen(" ("));
        write(connfd, inet_ntoa(PREFERRED), strlen(inet_ntoa(PREFERRED)));
        write(connfd, ")", strlen("("));    
    write(connfd, "\r\nPORT = ", strlen("\r\nPORT = "));
    write(connfd, newPORT, strlen(newPORT));}
    write(connfd, "\r\nPATH = ", strlen("\r\nPATH = "));
    write(connfd, PATH, strlen(PATH));
    write(connfd, "</p>", strlen("</p>"));
    write(connfd, "</span>", strlen("</span>"));
    write(connfd, "</body></html>" ,strlen("</body></html>"));
    return n;      }

/* note: you MUST use the basic while(1) loop here; you can
 * add things to it but the 3 methods MUST be called in this order */
int main(int argc, char **argv){
	  if( argc != 2 ) {
      printf("Invalid amount of arguments! \n");
      exit(1);    }  
    int listenfd, connfd, opt=1;   
	  struct sockaddr_in servaddr, cliaddr;     
    if (!(atoi(argv[1]) > 1024) ||  !(atoi(argv[1]) <65535)){
        printf("Invalid port!\n");
        exit(1);     }
 	  PORT = atoi(argv[1]); //Take user-specified port from arguments
 	  printf("Apache listening on socket %d\n", PORT);
 	  listenfd = socket(AF_INET, SOCK_STREAM, 0);   
 	  if(listenfd == -1){
    		printf("socket failed");
    		exit(1);        }  
    setsockopt(listenfd, SOL_SOCKET, SO_REUSEADDR | SO_REUSEPORT, &opt, sizeof(opt));
 	  cliaddr.sin_family = AF_INET;
 	  cliaddr.sin_addr.s_addr = htonl(INADDR_ANY);
 	  cliaddr.sin_port = htons(PORT);	  
    bind(listenfd, (struct sockaddr *) &cliaddr, sizeof(cliaddr)); //get ip for both off of the bind function here 
    listen(listenfd, 3);
 	  int len = sizeof(cliaddr);
    bzero(&HOST, sizeof(HOST));
    int lens = sizeof(servaddr);    
    char cstr[100], sstr[100]; 
    int count=0;
    while(1)    {
   	    connfd = accept(listenfd, (struct sockaddr *)&cliaddr, (socklen_t*)&len);       
        getsockname(connfd, (struct sockaddr *)&servaddr, (socklen_t*)&lens);
        getpeername(connfd, (struct sockaddr *)&cliaddr, (socklen_t*)&len);
        count++;       
        inet_ntop(AF_INET, &(cliaddr.sin_addr), cstr, 100);
        inet_ntop(AF_INET, &(servaddr.sin_addr), sstr, 100);        
        printf("(%i) Incoming client connection from [%s:%d] to me [%s:%d]\n", count, cstr, (int) ntohs(cliaddr.sin_port), sstr, (int) ntohs(servaddr.sin_port));     
        read(connfd, HOST, sizeof(HOST)); //loop to do chatting with client        
        int status = parse(connfd); 
        if(status == -1)        {
          RESPONSECODE = "400 Bad Request";
          printf("    REQ: %s / RESP: ERROR %s (Incorrect GET request)\n", URL, RESPONSECODE);    }
        if(status == -2)        {
          RESPONSECODE = "400 Bad Request";
          printf("    REQ: %s / RESP: ERROR %s (Incorrect PORT)\n", URL, RESPONSECODE);      }
        if(status == 7)        {
          RESPONSECODE = "505 HTTP Version Not Supported";
          printf("    REQ: %s / RESP: ERROR %s (Bad HTTP)\n", URL, RESPONSECODE);      }  
        if(status == 0)        {
            RESPONSECODE = "200 OK";
            status = dns(connfd);
            if(status == 2)    {
              RESPONSECODE = "404 Not Found";
              printf("    REQ: %s / RESP: ERROR %s (BAD IP)\n", FULLURL, RESPONSECODE);    }
            else if(status == 4)       {
              RESPONSECODE = "404 Not Found";
              printf("    REQ: %s / RESP: ERROR %s (Hostname Not Recognized)\n", FULLURL, RESPONSECODE);    }        }
        int bytes = ht_fetch(connfd, status);
        if(status == 1)        {
          RESPONSECODE = "200 OK";
          printf("    REQ: %s / RESP: (%d bytes transferred.)\n", FULLURL, bytes);    }
        else if(status==5)        {
          printf("    REQ: %s / RESP: (%d bytes transferred.)\n", (PATH+1), bytes);    }
        memset(HOST, 0, 1024); 
        close(connfd); 
        bzero(&HOST, sizeof(HOST));
        bzero(&URL, sizeof(URL));
        bzero(&PORT, sizeof(PORT));
        bzero(&newPORT, sizeof(newPORT));
        newPORT[0] = '8';
        newPORT[1] = '0';
        bzero(&PATH, sizeof(PATH));    }
    close(listenfd);
  	return 0;    }