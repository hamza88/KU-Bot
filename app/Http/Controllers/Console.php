<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 6/15/16
 * Time: 11:55 PM
 */

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Console extends Controller
{

  public static function runProcess($command)
  {
    $process = new Process($command);
    $process->start();

    while ($process->isRunning()) {
      // waiting for process to finish
    }
    $process->clearErrorOutput();
    return $process->getOutput();
  }
}
