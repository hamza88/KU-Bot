<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 7/14/16
 * Time: 11:35 PM
 */



namespace App\Http\Controllers;
use App\Http\Controllers\Console;

class Scrape extends Controller
{

    public static function scrapeGoogle($query){
        $process = Console::runProcess('./pyRun python/scraper/webScraper.py webScraper.Scraper.scrapeGoogle "'. $query .'"');
        if ($process) {
            return $process;
        }
        else {
            return "Sorry I could not scrape the web";
        }
    }
}
