<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Console;
use App\Http\Controllers\Chat;
use App\Http\Controllers\Filter;
use App\Http\Controllers\NLP;
use App\Http\Controllers\LinkHelper;

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
        //Todo: Get trending topics and send to browser
        return view('index');
    }

    public function master(Request $request)
    {
        $userResponse = $request->input('question');

            // Todo: Fix error in spamword. Its giving 500 error
//        $spamWord = Filter::spamCheck($userResponse);
        $spamWord = false;
//
//        // Spam not found
        if(!$spamWord) {

            // Todo: NLP classify not working
//            $response = NLP::classify($userResponse);
            $response['type'] = "Scrape";
            $response['keyword'] = "prospectus";

            if ($response['type'] == "Chat") {
                $answer = Chat::ask($userResponse);
                if($answer == null || $answer == ""){
                        $answer = Scraper::scrapeWeb($userResponse);
                }
                return $answer;
            }

            elseif($response['type'] == "Request"){

                $requestResponse = LinkHelper::handleRequest($response['keyword']);
                if($requestResponse){
                    return $requestResponse;
                } else{
                    return "well I'm sorry";
                }
            }
        }
        return "well I'm sorry";
    }
}
