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


class Scraper:

    def scrapeGoogle(query):
        driver_path = './scraper/drivers/phantomjs'
        url = 'https://www.google.com'

        browser = webdriver.PhantomJS(executable_path = driver_path)
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
                    result_link = result.find_element_by_tag_name('a')

                    link = result_link.get_attribute("href")

                    return scrapeWikipedia(generateLink(result_link.text,link))

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

                            return (generateLink(result_link.text,link))
                    else:
                        printf("No results found")
                except TimeoutException:
                    print("Connection timed out")
        except TimeoutException:
            print("Connection timed out")
        finally:
            browser.quit()

    def generateLink(title,href):
        return "<a href=\""+href+"\">"+title+"</a>"


    def getPage(url,writeFile):
        if (url):

            res = requests.get(url)

            try:
                res.raise_for_status()
            except Exception as exc:
                error = 'There was a problem: %s' %(exc)
                return error

            # Write downloaded page in file webpage.html
            webPage = open(writeFile, 'wb+')
            for chunk in res.iter_content(100000):
                webPage.write(chunk)
            webPage.close
            return True

        else:
            return False


    def scrapeWikipedia(url):

        if getPage(url):
            soup = BeautifulSoup(open("webpage.html",'r'),"lxml")
            title = soup.title.string

            contentDiv = soup.find(id = "mw-content-text")
            return contentDiv.p.get_text()
        else:
             return false

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

    def verifyFileLink(self,link):
        # TODO: Create a regex to identify file extension in the url
        regex = re.compile('.pdf$')
        links = regex.match(url)

        for pdflink in links:
            
