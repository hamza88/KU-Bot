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

    public function classify($text){

        $topics = NLP::setTopics($text);

        $class = Console::runProcess('./pyRun Nlp.NLP.CLassify '.'\"' . $text. '\"');

        switch ($class) {
            case 'Chat':
                // TODO: Send message for Chat
                return "Chat";
                break;

            case 'Request':
                // TODO: Read Request and provide result
                return "Request";

            default:
                return $class;
                break;
        }
    }


    public function setTopics($text) {
        $topics =
    }

}
