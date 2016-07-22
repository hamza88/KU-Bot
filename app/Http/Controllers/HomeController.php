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

    public $errorMessages = array(
        "I'm really sorry about that but I am not able to anwer that question. Please try asking something else",
        "Oh Snap! My circuits broken. Apologies by devs. :)",
        "Here is a suggestion for you. Ask something else.",
        "404 error Answer not found!"
    );

    public $spamErrMsg = array('
        "Looks like you have used a spam word there. Its not allowed here you know!",
        "Its such a bad habit to use these words.",
        "About 0.7% of the words a person uses in the course of a day are swear words. But not here chief.",
         "Here is a fact - Some of today’s most popular swear words have been around for more than a thousand years. Please dont swear here."
        "No need for profanity",
        "This is about you not me",
        "Look, being a bot I can curse as much as you can. You see thats nothing to show off.",
        "This is wrong in so may ways. I dont even know where to begin",
        "You wanna see me swear ****. I can swear in so many ** languages you cant ever ** imagine. You better understand you ***",
    ');

    public function index()
    {
        $trending = DBase::getTrending();
        return view('index')->with('trending' , $trending);
    }

    public function master(Request $request)
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

        DB::insert('insert into questions (question) VALUE (?)',[$userResponse]);

        $spamWord = NLP::spamCheck($userResponse);
        if($spamWord){
            DBase::insertSpamWord($spamWord);
            die('');
        }else{

            // Todo: NLP classify not working
//            $response = NLP::classify($userResponse);
            $response['type'] = "Chat";
            if ($response['type'] == "Chat") {
                $answer = Chat::ask($userResponse);
                if($answer){
                    return $answer;
                }else{
                    $answer = Scrape::scrapeGoogle($userResponse);
                }
                return $answer;

                // Insert question and answer pair to db
                DBase::insertQA($userResponse, $answer);
            }
        }
        echo "well I'm sorry";
    }
}
