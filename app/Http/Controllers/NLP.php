<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 6/23/16
 * Time: 1:48 PM
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Console;


use Symfony\Component\HttpKernel\Tests\Controller;

class NLP extends Controller
{

    public function setTopics($text){
        // Todo: Extract one topic from the question
        return;
    }

    public static function classify($text)
    {

//        $topics = NLP::setTopics($text);

        $class = Console::runProcess('./pyRun Nlp.NLP.Classify ' . '\"' . $text . '\"');

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
