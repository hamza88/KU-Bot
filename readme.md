#  KU Bot - A Chatbot
KU Bot is a chat bot developed as a semester project for Computer Engineering 4th Sem in Kathmandu University.


KU bot can answer questions regarding admission, entrance and other general info on Kathmandu University.

## Install

Install the dependencies

```
composer install
```

```
npm install
```
Install pyAIML - aiml interpretor for python2
```
pip install aiml
```

Install NLTK
```
pip install nltk
```
Install Selenium for web scraping.
Download and copy phantomJs file to /public/python/scraper/drivers



## To Run
Install php server in your machine
```
php -S localhost:30 -t public/
```
*use any port no*

## To Contribute

You can contribute to the system itself or the knowledge base.

To contribute to the knowledge base
1. Add new aiml files in /public/python/bot/aimlFiles/
2. Load your aiml file in std-startup.xml


## Built With
* pyAIML - python interpretor for AIML
* [Lumen](https://lumen.laravel.com) - for Backend Framework
* [PureCSS](http://purecss.io) - for CSS Framework
* [Vue](http://vuejs.org) - for JS Framework
* [Vue Resource](https://github.com/vuejs/vue-resource) - for AJAX Requests from Vue files
