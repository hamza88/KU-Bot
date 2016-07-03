<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Console;
use App\Http\Controllers\Filter;

class Chat extends Controller
{


    public function ask($question)
    {
            $process = Console::runProcess('./pyRun Bot.Chat.Ask "' . $question . '"');
            if($process){
              $process->clearErrorOutput();
              $answer = $process->getOutput();
              return $answer;
            }
        } else {
            // spam words found on the input
            // TODO: store spam to database
            return "Please do not use spam words. Be a good guy. \n" . "Remove the word " . $spamWord;
         }
    }
