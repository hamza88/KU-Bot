<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Console;
use App\Http\Controllers\Chat;
use App\Http\Controllers\Filter;
use App\Http\Controllers\NLP;

class HomeController extends Controller
{

    public $errorMessages = array(
        "I'm Really sorry about that but I am not able to anwer that question. Please try asking something else",
        "Oh Snap! My circuits broken. Apologies by devs. :)",
        "Here is a suggestion for you. Ask something else.",
        "404 error Answer not found!"
    );

    public function index()
    {
        //Todo: Get trending topics and send to browser
        return view('index');
    }

    public function master(Request $request){
        $userResponse = $request->input('question');
        echo "question got";

        $spamWord = Filter::spamCheck($userResponse);

        // Spam not found
        if(!$spamWord)
            $NLP = new NLP;
            $response = NLP::classify($userResponse);

            if($response == "Chat"){
                $answer = Chat::ask($userResponse);
                if($answer == null || $answer == ""){
                        $answer = Scraper::scrapeWeb($userResponse);
                }
                return $answer;
            }
            elseif($response == 'Request'){
                $requestResponse = Request::handleRequest($response);
                if($requestResponse){
                    return $requestResponse;
                } else{
                    return $this->message->Random();
                }
            }
        }
    }
