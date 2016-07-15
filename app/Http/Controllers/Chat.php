<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Console;

class Chat extends Controller
{


    public static function ask($question)
    {
        $process = Console::runProcess('./pyRun python/bot/Bot.py Bot.Chat.Ask "' . $question . '"');
        if ($process) {
            $process->clearErrorOutput();
            $answer = $process->getOutput();
            return $answer;
        }
    }
}
