<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 6/15/16
 * Time: 11:53 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Console;

class Filter extends Controller
{
  /**
   * param $text
   * return true if spam is found
   */
  public static function spamCheck($text)
  {
    $console = new Console;
    $process = $console->runProcess('./pyRun spamFilter.SpamFilter.wordFilter "' . $text . '"');
    $output = $process->getOutput();
    if($output == "False"){
      return False;
    } else {
      return $output;
    }
  }

}
