#! python2.7
# scrape.py - Scrapes google and wikipedia for questions

import  sys, requests, lxml, os
from bs4 import BeautifulSoup

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.support import expected_conditions as EC

import re


class Scraper(object):

    driver_path = 'drivers/phantomjs'
    
    def scrapeGoogle(self, query):
        
        url = 'https://www.google.com'

        browser = webdriver.PhantomJS(executable_path = self.driver_path)
        browser.get(url)

        element = browser.find_element_by_name('q')
        element.send_keys(query + " site:wikipedia.com")
        element.send_keys(Keys.RETURN)

        try:
            WebDriverWait(browser,10).until(
                EC.presence_of_element_located((By.CLASS_NAME,"g"))
            )

            results = browser.find_elements_by_class_name('g')

            if(results is not None):
                for result in results:
                    wikipedia_link = browser.find_element_by_link_text('Wikipedia')
		    if(wikipedia_link is not None):
                        link = wikipedia_link.get_attribute("href")
                        return self.scrapeWikipedia(link)            
                    break
            else:
                element.send_keys(query)
                element.send_keys(Keys.RETURN)

                try:
                    WebDriverWait(browser,10).until(
                        EC.presence_of_element_located((By.CLASS_NAME,"g"))
                    )

                    results = browser.find_elements_by_class_name('g')

                    # Wikipedia Link not found. Returns Google search results
                    if(results is not None):
                        for i in range(0,3):
                            result_link = result.find_element_by_tag_name('a')

                            link = result_link.get_attribute("href")

                            return (self.generateLink(result_link.text,link))
                    else:
                        printf("No results found")
                except TimeoutException:
                    print("Connection timed out")
        except TimeoutException:
            print("Connection timed out")
        finally:
            browser.quit()

    def generateLink(self, title,href):
        return "<a href=\""+href+"\">"+title+"</a>"


    def getPage(self, url):
        if (url):
	    print url
            res = requests.get(url)

            try:
                res.raise_for_status()
            except Exception as exc:
                error = 'There was a problem: %s' %(exc)
                

            # Write downloaded page in file webpage.html
            webPage = open('site.html', 'wb+')
            for chunk in res.iter_content(100000):
                webPage.write(chunk)
            webPage.close
            return True

        else:
            return False


    def scrapeWikipedia(self, url):
    	
    	print url
    	
    	browser = webdriver.PhantomJS(executable_path = self.driver_path)
        browser.get(url)
	contentDiv = driver.find_element_by_id('mw-content-text')
        return contentDiv.text()
        
scrape = Scraper()
scrape.scrapeGoogle("kathmandu university admission")

class fileLinkScrape(object):
    #Scrapes a url to find link to file download
    def __init__(self, arg):
        super(linkScrape, self).__init__()
        self.arg = arg

    def downloadScrape(self, url):
        Scraper.getPage(url,"fileSite.html")

        soup = BeautifulSoup(open('fileSite.html','r'),'lxml')
        links = soup.find_all('a')
        for link in links:
            href = link['href']
            text = link.string
            self.verifyFileLink(href)
            
