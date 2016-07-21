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
    $process->run();
    $process->clearErrorOutput();

    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }
    return $process->getOutput();
  }
}
