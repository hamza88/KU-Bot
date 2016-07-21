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
        "I'm Really sorry about that but I am not able to anwer that question. Please try asking something else",
        "Oh Snap! My circuits broken. Apologies by devs. :)",
        "Here is a suggestion for you. Ask something else.",
        "404 error Answer not found!"
    );

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

            // Todo: Fix error in spamword. Its giving 500 error
//        $spamWord = Filter::spamCheck($userResponse);
        $spamWord = false;
//
        if(!$spamWord) {

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
                echo $answer;

                // Insert question and answer pair to db
                DBase::insertQA($userResponse, $answer);
            }
        }
        echo "well I'm sorry";
    }
}
