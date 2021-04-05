library("rvest")
library("magrittr")
library("jsonlite")
library(xml2)
library(stringr)
  
# -------------------------------------------------------------

# set working directory
FOLDER <- getwd()
setwd(FOLDER)

# -------------------------------------------------------------


# function
crawling <- function(year){
  
  year <- strtoi(year)
  # subtract input year by 2007
  
  vol <- year-2007 # save that value into variable called vol
  # vol
  
  print("Crawling Started...")
  # from vol to end
  for(i in vol:14){
    print(paste("Crawling through Vol ", vol,"...", sep=""))
    sprintf("Crawling through Volume %d",vol)
    link <- paste0("https://epigeneticsandchromatin.biomedcentral.com/articles?tab=keyword&searchType=journalSearch&sort=PubDate&volume=",vol,"&page=1")
    
    link %>%
      read_html() -> myHTML
    
    # extract number of pages of articles in i volume
    pagenum <- myHTML %>%
      html_nodes("#main-content > div > main > div:nth-child(3) > div > div > p") %>%
      html_text()
    
    res <- str_match(pagenum, "\\d+$")
    pagenum <- strtoi(res[1]) # pagenum holds number of pages as an int
    
    dirName <- paste0("Vol",vol)
    dir.create(dirName)
    
    # -----------------------------------------------------------
    # go through all pages
    # for example, volume 12 has 2 pages
    for(j in 1:pagenum){
      
      link <- paste0("https://epigeneticsandchromatin.biomedcentral.com/articles?tab=keyword&searchType=journalSearch&sort=PubDate&volume=",i,"&page=",j)
      
      link %>%
        read_html() -> myHTML
      
      # extract article link from list of articles in i volume on j page
      links_found <- myHTML %>%
        html_nodes("#main-content > div > main > div:nth-child(3) > ol") %>%
        html_nodes("h3") %>%
        html_nodes("a") %>%
        html_attr("href") 
      
      for(article in links_found){

        article_link <-  paste0("https://epigeneticsandchromatin.biomedcentral.com",article)
        article_link %>%
          read_html() -> myHTML
        
        dirName = paste0(getwd(),"/Vol",vol)
        fileName = sub("^.+/","",article)
        myHTML %>%
          write_html(paste0(dirName ,"/",fileName,".html"))
        
      }
    }
    vol=vol+1;
  }
  print("Crawling Done...")
}
  # -----------------------------------------------------------
  # Function to scrape the articles
  # -----------------------------------------------------------
scrape <- function(){
  print("Scraping Started...")
 
  dir <- list.files(getwd(),pattern = "Vol")
  articles <- data.frame(c("","","","","","",""))

  counter=0;

  for(vol in dir){
    
    #vol <- dir[1]
    article_files <- list.files(paste0(getwd(),"/",vol))
   
    
    
    for( article in article_files ){
    #  article <- article_files[1]
    counter= counter + 1;
    article_link = paste0(getwd(),"/",vol,"/",article)
    
    article_link %>%
      read_html() -> myHTML
    
    #-------------------------
    # crawl titles of articles
    title_found <- myHTML %>%
      html_nodes("#main-content > main > article > div.c-article-header > h1") %>%
      html_text()
    
    title_found <- gsub("\n"," ",title_found)
    titles=(list(title_found))
    articles[counter,1] =  paste( unlist(titles), collapse=' ')
    
    #-------------------------
    # crawl authors of articles
    author_found <- myHTML %>%
      html_nodes(xpath='//*[@id="main-content"]/main/article/div/ul[2]/li/a')%>%
      html_text()
    
    a=(list(author_found))
    articles[counter,2] =  paste( unlist(a), collapse=', ')
    #-------------------------
    # crawl author affiliations of articles
    aa_found <- myHTML %>%
      html_nodes("#author-information-content") %>%
      html_nodes(".c-article-author-affiliation__address") %>%
      html_text()
    
    aa=(list(aa_found))
    articles[counter,3] =  paste( unlist(aa), collapse='. ')
    
    #-------------------------
    # crawl correspondence authors of articles
    ca_found <- myHTML %>%
      html_nodes("#corresponding-author-list") %>%
      html_nodes("a") %>%
      html_text()
    
    #ca_list <- append(ca_list, ca_found)
    ca=(list(ca_found))
    articles[counter,4] =  paste( unlist(ca), collapse=', ')
     
    #-------------------------
    # crawl publish dates of articles
    publish_found <- myHTML %>%
      html_nodes("#main-content > main > article > div > ul.c-article-identifiers > li:nth-child(3) > a > time") %>%
      html_text()
    
    pub=(list(publish_found))
    articles[counter,5] =  paste( unlist(pub))
    
    #-------------------------
    # crawl abstract of articles
    abstract_found <- myHTML %>%
      html_nodes("#Abs1-content") %>%
      html_text()
    
    if (length(abstract_found)==0){
      abstract_found=""
    }
    abstract_found <- gsub("\n"," ",abstract_found)
    
    abs=(list(abstract_found))
    articles[counter,6] =  paste(unlist(abs))
    
    #-------------------------
    # crawl keywords of articles
    keywords_found <- myHTML %>%
      html_nodes("#main-content > main") %>%
      html_nodes("#article-info-content > div > div > ul.c-article-subject-list > li") %>%
      html_text()
    
    keywords_found <- gsub("\n"," ",keywords_found)
    key=(list(keywords_found))
    articles[counter,7] =  paste( unlist(key), collapse=', ')
    
    #-----------------------------
    #crawling full text of articles
    articles_found <- myHTML %>%
      html_nodes(xpath='//*[@id="main-content"]/main/article') %>%
      html_text()
    
    articles_found <- gsub("\n"," ", articles_found)
    artFound=(list(articles_found))
    articles[counter,8] =  paste( unlist(artFound), collapse=', ')
    
  }
 
  }
  names(articles)[1] <- "Title"
  names(articles)[2] <- "Authors"
  names(articles)[3] <- "Author_Affiliation"
  names(articles)[4] <- "Correspondence_Authors"
  names(articles)[5] <- "Date"
  names(articles)[6] <- "Abstract"
  names(articles)[7] <- "Keywords"
  names(articles)[8] <- "Full_Text"

    
  write.table(articles,"Epigenetics & Chromatin.txt",sep="\t",row.names=FALSE, quote = FALSE)
  print("Scraping Done...")
  
  return(articles)
  
}

# -----------------------------------------------------------
bool=TRUE
while(bool)
{
# user input
year <- readline(prompt="Enter year: ") #input year

#calling function
if(year>=2008 & year<=2021){
bool=FALSE;
crawling(year)
myart <- scrape()
}else{
  print("Invalid Year, please try again")
}
}