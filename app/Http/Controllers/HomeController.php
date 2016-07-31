<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Chat;
use App\Http\Controllers\Filter;
use App\Http\Controllers\NLP;
use App\Http\Controllers\LinkHelper;
use App\Http\Controllers\Scrape;

use DB;

class HomeController extends Controller
{

    public static $errorMessages = array(
        "I'm really sorry about that but I am not able to anwer that question. Please try asking something else",
        "Oh Snap! My circuits broken. Apologies by devs. :)",
        "Here is a suggestion for you. Ask something else.",
        "404 error Answer not found!",
        "OK you've got me. I admit it I am not human",
        "There are so many mystries in this world I cannot unravel",
        "You should try asking a real human that question",
        "I'll tell my bot master to teach me the answer to that question",
        "Shall we move on to other questions",
        "What if I say I dont want to answer your question. To be true I dont know the answer.",
        "My knowledge base is not adequate to answer your question"
    );

    public static $spamErrMsg = array(
        "Looks like you have used a spam word there. Its not allowed here you know!",
        "Its such a bad habit to use these words.",
        "About 0.7% of the words a person uses in the course of a day are swear words. But not here chief.",
         "Here is a fact - Some of today’s most popular swear words have been around for more than a thousand years. Please dont swear here.",
        "No need for profanity",
        "This is about you not me",
        "Look, being a bot I can curse as much as you can. You see thats nothing to show off.",
        "This is wrong in so may ways. I dont even know where to begin",
        "You wanna see me swear ****. I can swear in so many ** languages you cant ever ** imagine. You better understand you ***",
    );

    public function index()
    {
        $trending = DBase::getTrending();
        return view('index')->with('trending' , $trending);
    }

    public static function master(Request $request)
    {
        // input from chat box
        $userResponse = $request->input('question');

        // Extract Nouns from text as topics
        $nouns = NLP::extractNouns($userResponse);
        $topics = json_decode($nouns, true);
        //Insert topics into database
        if($topics){
            foreach($topics as $key => $value){
                DBase::insertTopic($value);
            }
        }



        DBase::insertQuestion($userResponse);


        $spamWord = NLP::spamCheck($userResponse);
        if($spamWord){
            DBase::insertSpamWord($spamWord);
            return self::$spamErrMsg[rand(0, sizeof(self::$spamErrMsg))];
        }else{
            $chat = Chat::ask($userResponse);
            if($chat){
                $answer = $chat;
            }else{
                // $answer = Scrape::scrapeGoogle($userResponse);

                // Todo: Get similar question answer from database
                if(isset($topics)){
                    foreach($topics as $key => $value){
                        $similarResult = DBase::getSimilar($value);
                        if($similarResult){
                            $answer = "Did you mean - " . $similarResult->question. " \n The answer to that would be \n " . $similarResult->answer;
                            break;
                        }
                    }
                }
            }

            // Insert question and answer pair to db
            if(isset($answer) && !isset($similarResult)){
                DBase::insertQA($userResponse, $answer);
            }

            if(!isset($answer)){
                return self::$errorMessages[rand(0, sizeof(self::$errorMessages))];
            }

            return $answer;
            }
    }

}
