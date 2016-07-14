<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 6/15/16
 * Time: 11:53 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Commander;

class Filter extends controller
{
  /**
  * param $text
  * return true if spam is found
  */
  public static function spamCheck($text){
    $process = Commander::runProcess('./pyRun spamFilter.SpamFilter.wordFilter "' . $text . '"');
    if($process->getOutput() == "False"){
      return False;
    } else {
      return $process->getOutput();
    }
  }

}
