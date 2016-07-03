<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Commander;
use App\Http\Controllers\Filter;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function ask(Request $request)
    {
        $question = $request->input('question');
        $answer = "I do not get it.";
        $spamWord = Filter::spamCheck($question);
        if(!$spamWord) {
            $process = Commander::runProcess('./pyRun Bot.Chat.Ask "' . $question . '"');
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
