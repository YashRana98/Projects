/* CS 656 / Fall 2019 / Term Project
* Group: W3 / Leader: Joseph Demcher (jpd29)
* Group Members: Calin Blauth (cb327), Shreena Mehta (sm2327), Yash Rana (yr83), Samir Peshori (sap229), Anthony Anderson (aa2296)*/
#include <stdio.h>
#include <netinet/in.h>
#include "unp.h"
#include <ctype.h>
#include <unistd.h>
#include <stdbool.h> //following 3 are for getaddrinfo()
#include <sys/types.h>
#include <sys/socket.h>
#include <netdb.h>
#include <sys/time.h>
/*--------------- end include/s --------------*/
char HOST[1024]; /* don't change this! */
int  PORT;      /* port this Apache should listen on, from cmdline, you must set this */
struct in_addr PREFERRED; /* you must set this to the preferred IP, in dns() below */

int dns(int connfd)  /* you can define the signature for dns() */{ // int sockfd;
    struct addrinfo hints, *results, *p;
    struct sockaddr_in *ip_access, *access2;
    int rv;    
    int str_size = strlen(HOST);  
    write(connfd, "REQ: ", 5);
    write(connfd, HOST, str_size);
    char *hostname = HOST;
    memset(&hints, 0, sizeof hints);
    hints.ai_family = AF_INET;
    hints.ai_socktype = SOCK_STREAM;
    hints.ai_flags = 0;    
    hints.ai_protocol = 0;         
    hints.ai_canonname = NULL;
    hints.ai_addr = NULL;
    hints.ai_next = NULL; 
    
    if ( (rv = getaddrinfo(hostname, "domain", &hints, &results)) != 0){
        printf("ERROR\n");
        write(connfd, " | ", 3);
        write(connfd, "IP: ERROR (Invalid Request)", strlen("IP: ERROR (Invalid Request)"));
        return 1;        }
    char *pref;
    struct timeval time1, time2;
    double timeElapsed;
    double fast = 100;     
    for (p = results; p !=NULL; p = p->ai_next){   
        struct sockaddr_in ping_addr; 
        int pingfd = socket(AF_INET, SOCK_STREAM, 0); 
        bzero(&ping_addr, sizeof(ping_addr));
        ping_addr.sin_family = AF_INET; 
        ping_addr.sin_port = htons(80);
        inet_pton(AF_INET, (const char *)p, &ping_addr.sin_addr);
        gettimeofday(&time1, NULL);
        connect(pingfd, (SA *) &ping_addr, sizeof(ping_addr));
        gettimeofday(&time2, NULL);
        close(pingfd);
        timeElapsed = (time2.tv_sec - time1.tv_sec) * 1000.0;
        timeElapsed += (time2.tv_usec - time1.tv_usec) / 1000.0;
        ip_access = (struct sockaddr_in *) p->ai_addr;
        if(timeElapsed < fast){
          fast = timeElapsed;
          PREFERRED = (ip_access->sin_addr);    }     }  
             
    pref = inet_ntoa(PREFERRED);
    char dst[12];
    strcpy(dst,pref);
    printf("%s\n", pref);    
    for (p = results; p !=NULL; p = p->ai_next){        
        access2 = (struct sockaddr_in *) p->ai_addr;
        char *data = inet_ntoa( access2->sin_addr);
        int dsize = strlen(data);
        write(connfd, " | ", 3);
	      write(connfd, "IP: ", 4);
        write(connfd, data, dsize);
        if( strcmp(dst,data) == 0){
            write(connfd, " (Preferred)", strlen(" (Preferred)"));
	          send(connfd, "", 0, 0);        }          }   
    freeaddrinfo(results);
    return 0;    }  
                                                                
int parse(int connfd)        /* you can change this signature */{
 		read(connfd, HOST, sizeof(HOST)); //loop to do chatting with client 
    char get[5];
    int i, j =0;
    for(i = 0 ; i<4; i++){
        get[i] = HOST[i];    }   
    get[4] = '\0';
    int same = strcmp(get, "GET ");
    while((HOST[4+j] != '\0') && (HOST[4+j]!='0')){
        if(HOST[4+j] == '\n'){
            HOST[4+j] = '\0';
            j++;    }
        else{
            HOST[j] = HOST[4+j];
            HOST[4+j] = '\0';  }
        j++;    }
    return same;    }
    
int main(int argc, char **argv){
	  if( argc != 2 ) {
      printf("Invalid amount of arguments! \n");
      exit(1);    }  
    int listenfd, connfd, opt=1;   
	  struct sockaddr_in servaddr, cliaddr;     
    if (!(atoi(argv[1]) > 1024) ||  !(atoi(argv[1]) <65535)){
        printf("Invalid port!\n"); //i didnt save this yet then you should 
        exit(1);    
    }
 	  PORT = atoi(argv[1]); //Take user-specified port from arguments
 	  printf("Apache listening on socket %d\n", PORT);
 	  listenfd = socket(AF_INET, SOCK_STREAM, 0);   
 	  if(listenfd == -1){
    		printf("socket failed");
    		exit(1);    
    }  
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
    
    for(;;){
   	    connfd = accept(listenfd, (struct sockaddr *)&cliaddr, (socklen_t*)&len);       
        getsockname(connfd, (struct sockaddr *)&servaddr, (socklen_t*)&lens);
        getpeername(connfd, (struct sockaddr *)&cliaddr, (socklen_t*)&len);
        count++;       
        inet_ntop(AF_INET, &(cliaddr.sin_addr), cstr, 100);
        inet_ntop(AF_INET, &(servaddr.sin_addr), sstr, 100);        
        printf("(%i) Incoming client connection from [%s:%d] to me [%s:%d]\n", count, cstr, (int) ntohs(cliaddr.sin_port), sstr, (int) ntohs(servaddr.sin_port));     
        int test = parse(connfd); 
        if(test == 0){	//take input & send to parse
            printf("    REQ: %s / RESP: ", HOST);
            dns(connfd);
            memset(HOST, 0, 1024);    }
        else{
            printf("    REQ: %s / RESP: ERROR\n", HOST);
            write(connfd, "ERROR (Invalid Request)", strlen("ERROR (Invalid Request)"));
            memset(HOST, 0, 1024);    }
        close(connfd); 
        bzero(&HOST, sizeof(HOST));    }
    close(listenfd);
  	return 0;    
} 