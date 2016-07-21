<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 6/23/16
 * Time: 1:48 PM
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Console;

class NLP extends Controller
{
    public static function extractNouns($text){
        $nouns = Console::runProcess('./pyRun python/nlp/Nlp.py Nlp.NLP.extractNouns ' . '"' . $text . '"');
        return $nouns;
    }

    public static function classify($text)
    {

//        $topics = NLP::setTopics($text);

        $class = Console::runProcess('./pyRun Nlp.NLP.Classify ' . '"' . $text . '"');

        if ($class) {
            switch ($class) {
                case 'Chat':
                    // TODO: Send message for Chat
                    return "Chat";
                    break;

                case 'Request':
                    // TODO: Read Request and provide result
                    return "Request";

                default:
                    return "Chat";
                    break;
            }
        } else {
            return "Chat";
        }
    }
}
